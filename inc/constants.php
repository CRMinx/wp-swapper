<?php

defined( 'ABSPATH' ) || exit;

/**
* Checks if the constant is defined.
*
* Allows mocking constants when testing
*
* @since 0.1
*
* @param string $constant_name Name of the constant to check.
*
* @return bool true when constant is defined; else, false.
*/
function swapper_has_constant( string $constant_name ): bool {
    return defined( $constant_name );
}

/**
* Gets the constant is defined.
*
* NOTE: This function allows mocking constants when testing
*
* @since 0.1
*
* @param string $constant_name Name of the constant to check.
* @param mixed|null $default Optional. Default value to return if constant is not defined.
*
* @return mixed
*/
function swapper_get_constant( string $constant_name, mixed $default = null ): mixed {
    if ( ! swapper_has_constant( $constant_name ) ) {
        return $default;
    }

    return constant( $constant_name );
}
