<?php
defined( 'ABSPATH' ) || exit;

/**
* Class to check if WordPress and PHP versions meet the requirements.
*
* @since 0.1
* @author Damion Voshall
*/

class WP_Swapper_Requirements_Check {
    /**
    * Plugin Name
    *
    * @var string
    */
    private string $plugin_name;

	/**
	 * Plugin filepath
	 *
	 * @var string
	 */
	private string $plugin_file;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	private string $plugin_version;

	/**
	 * Plugin previous version
	 *
	 * @var string
	 */
	private string $plugin_last_version;

	/**
	 * Required WordPress version
	 *
	 * @var string
	 */
	private string $wp_version;

	/**
	 * Required PHP version
	 *
	 * @var string
	 */
	private string $php_version;

	/**
	 * WP Rocket options
	 *
	 * @var array
	 */
	private $options;

	/**
	 * Constructor
	 *
	 * @since 0.1
	 * @author Damion Voshall
	 *
	 * @param array $args {
	 *     Arguments to populate the class properties.
	 *
	 *     @type string $plugin_name Plugin name.
	 *     @type string $wp_version  Required WordPress version.
	 *     @type string $php_version Required PHP version.
	 *     @type string $plugin_file Plugin filepath.
	 * }
	 */
	public function __construct( array $args ) {
		foreach ( [ 'plugin_name', 'plugin_file', 'plugin_version', 'plugin_last_version', 'wp_version', 'php_version' ] as $setting ) {
			if ( isset( $args[ $setting ] ) ) {
				$this->$setting = $args[ $setting ];
			}
		}

		$this->plugin_last_version = version_compare( PHP_VERSION, '5.3' ) >= 0 ? $this->plugin_last_version : '0.1.0';
		$this->options             = get_option( 'wp_swapper_settings' );
	}

	/**
	 * Checks if all requirements are ok, if not, display a notice and the rollback
	 *
	 * @since 0.1
	 * @author Damion Voshall
	 *
	 * @return bool
	 */
	public function check(): bool {
		if ( ! $this->php_passes() || ! $this->wp_passes() ) {

			add_action( 'admin_notices', [ $this, 'notice' ] );
			add_action( 'admin_post_swapper_rollback', [ $this, 'rollback' ] );
			add_filter( 'http_request_args', [ $this, 'add_own_ua' ], 10, 2 );

			return false;
		}

		return true;
	}

	/**
	 * Checks if the current PHP version is equal or superior to the required PHP version
	 *
	 * @since 0.1
	 * @author Damion Voshall
	 *
	 * @return bool
	 */
	private function php_passes(): bool {
		return version_compare( PHP_VERSION, $this->php_version ) >= 0;
	}

	/**
	 * Checks if the current WordPress version is equal or superior to the required PHP version
	 *
	 * @since 0.1
	 * @author Damion Voshall
	 *
	 * @return bool
	 */
	private function wp_passes(): bool {
		global $wp_version;

		return version_compare( $wp_version, $this->wp_version ) >= 0;
	}

	/**
	 * Warns if PHP or WP version are less than the defined values and offer rollback.
	 *
	 * @since 0.1
	 * @author Damion Voshall
	 */
	public function notice(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Translators: %1$s = Plugin name, %2$s = Plugin version.
		$message = '<p>' . sprintf( __( 'To function properly, %1$s %2$s requires at least:', 'swapper' ), $this->plugin_name, $this->plugin_version ) . '</p><ul>';

		if ( ! $this->php_passes() ) {
			// Translators: %1$s = PHP version required.
			$message .= '<li>' . sprintf( __( 'PHP %1$s. To use this WP Swapper version, please ask your web host how to upgrade your server to PHP %1$s or higher.', 'swapper' ), $this->php_version ) . '</li>';
		}

		if ( ! $this->wp_passes() ) {
			// Translators: %1$s = WordPress version required.
			$message .= '<li>' . sprintf( __( 'WordPress %1$s. To use this WP Swapper version, please upgrade WordPress to version %1$s or higher.', 'swapper' ), $this->wp_version ) . '</li>';
		}

		$message .= '</ul><p>' . __( 'If you are not able to upgrade, you can rollback to the previous version by using the button below.', 'swapper' ) . '</p><p><a href="' . wp_nonce_url( admin_url( 'admin-post.php?action=swapper_rollback' ), 'swapper_rollback' ) . '" class="button">' .
		// Translators: %s = Previous plugin version.
		sprintf( __( 'Re-install version %s', 'swapper' ), $this->plugin_last_version )
		. '</a></p>';

		echo '<div class="notice notice-error">' . wp_kses_post( $message ) . '</div>';
	}

	/**
	 * Do the rollback
	 *
	 * @since 0.1
	 * @author Damion Voshall
	 */
	public function rollback(): void {
		check_ajax_referer( 'swapper_rollback' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die();
		}

		$consumer_key = isset( $this->options['consumer_key'] ) ? $this->options['consumer_key'] : false;

		if ( ! $consumer_key && defined( 'WP_SWAPPER_KEY' ) ) {
			$consumer_key = WP_SWAPPER_KEY;
		}

		$plugin_transient = get_site_transient( 'update_plugins' );
		$plugin_folder    = plugin_basename( dirname( $this->plugin_file ) );
		$plugin_file      = basename( $this->plugin_file );
		$url              = sprintf( 'https://wpswapper.com/%s/wpswapper_%s.zip', $consumer_key, $this->plugin_last_version );
		$temp_array       = [
			'slug'        => $plugin_folder,
			'new_version' => $this->plugin_last_version,
			'url'         => 'https://wpswapper.com',
			'package'     => $url,
		];

		$temp_object = (object) $temp_array;
		$plugin_transient->response[ $plugin_folder . '/' . $plugin_file ] = $temp_object;
		set_site_transient( 'update_plugins', $plugin_transient );

		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		// translators: %s is the plugin name.
		$title         = sprintf( __( '%s Update Rollback', 'swapper' ), $this->plugin_name );
		$plugin        = 'wpswapper/wp-swapper.php';
		$nonce         = 'upgrade-plugin_' . $plugin;
		$url           = 'update.php?action=upgrade-plugin&plugin=' . rawurlencode( $plugin );
		$upgrader_skin = new Plugin_Upgrader_Skin( compact( 'title', 'nonce', 'url', 'plugin' ) );
		$upgrader      = new Plugin_Upgrader( $upgrader_skin );
		remove_filter( 'site_transient_update_plugins', 'swapper_check_update', 1 );
		$upgrader->upgrade( $plugin );
		wp_die(
			'',
			// translators: %s is the plugin name.
			sprintf( esc_html__( '%s Update Rollback', 'swapper' ), esc_html( $this->plugin_name ) ),
			[
				'response' => 200,
			]
		);
	}

	/**
	 * Filters the User Agent when doing a request to WP Rocket server
	 *
	 * @since 0.1
	 * @author Damion Voshall
	 *
	 * @param array  $request   Array of arguments associated with the request.
	 * @param string $url       URL requested.
	 */
	public function add_own_ua( array $request, string $url ): array {
		if ( strpos( $url, 'wpswapper.com' ) === false ) {
			return $request;
		}

		$consumer_key = isset( $this->options['consumer_key'] ) ? $this->options['consumer_key'] : false;

		if ( ! $consumer_key && defined( 'WP_SWAPPER_KEY' ) ) {
			$consumer_key = WP_SWAPPER_KEY;
		}

		$consumer_email = isset( $this->options['consumer_email'] ) ? $this->options['consumer_email'] : false;

		if ( ! $consumer_email && defined( 'WP_SWAPPER_EMAIL' ) ) {
			$consumer_email = WP_SWAPPER_EMAIL;
		}

		$request['user-agent'] = sprintf( '%s;WP-Swapper|%s%s|%s|%s|%s|;', $request['user-agent'], $this->plugin_version, '', $consumer_key, $consumer_email, esc_url( home_url() ) );

		return $request;
	}
}
