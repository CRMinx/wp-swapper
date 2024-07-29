<?php

namespace WP_Swapper;

/**
* Class to detect search engine bots
*
* @since 0.1
*/
class BotDetector {
    /**
    * List of known bot user agents
    *
    * @since 0.0.1
    *
    * @var array
    */
    protected $bot_agents = [
        'Googlebot',
        'Bingbot',
        'Slurp',
        'DuckDuckBot',
        'Baiduspider',
        'YandexBot',
        'Sogou',
        'Exabot',
        'facebot',
        'ia_archiver',
        'AhrefsBot',
        'MJ12bot',
        'SemrushBot',
        'DotBot',
        'SeznamBot',
        'PiplBot',
        'Mail.RU_Bot',
        'SiteExplorer',
        'Screaming Frog',
        'LinkpadBot',
        'SerpstatBot',
        'MegaIndex',
        'BLEXBot',
        'Uptimebot',
        'TurnitinBot',
        'trendictionbot',
        'VoilaBot',
        'CommonCrawler',
        'Lipperhey',
        'Hatena',
        'MegaIndex',
        'WBSearchBot',
        'ZoominfoBot',
        'SentiBot',
    ];

    /**
    * Detects if a search engine bot is visiting the site.
    *
    * @since 0.0.1
    *
    * @return bool true if a search bot is visiting the site.
    */
    public function is_bot() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        foreach ($this->bot_agents as $bot_agent) {
            if ( stripos($user_agent, $bot_agent) !== false ) {
                return true;
            }
        }

        return false;
    }
}
