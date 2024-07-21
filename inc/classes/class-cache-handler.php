<?php
defined('ABSPATH') || exit;

/**
* Class to handle caching
*
* @since 0.1
*/
class CacheHandler {
    /**
    * Cache component in session
    *
    * @since 0.1
    *
    * @param string $key
    * @param string $content
    */
    public static function cacheComponent($key, $content) {
        $_SESSION[$key] = $content;
    }

    /**
    * Get cached content of a component from session
    *
    * @since 0.1
    *
    * @param string $key
    * @returns string|null
    */
    public static function getCachedComponent($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    /**
    * Check if a component has changed
    *
    * @since 0.1
    *
    * @param string $key
    * @param string $newContent
    * @returns bool
    */
    public static function hasComponentChanged($key, $newContent) {
        $cachedContent = self::getCachedComponent($key);

        if ($cachedContent) {
            return $newContent !== $cachedContent;
        }

        return true;
    }

    private static function normalizeContent($content) {
        return preg_replace('/\s+/', ' ', trim($content));
    }
}
