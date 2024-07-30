<?php

namespace WP_Swapper\Traits;

/**
* Trait to handle caching
*
* @since 0.1
*/
trait Cache_Handler {
    /**
    * Cache component in session
    *
    * @since 0.1
    *
    * @param string $key
    * @param string $content
    */
    public function cacheComponent($key, $content) {
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
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
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
    public function hasComponentChanged($key, $newContent) {
        $cachedContent = self::getCachedComponent($key);

        if ($cachedContent) {
            return $this->normalizeContent($newContent) !== $this->normalizeContent($cachedContent);
        }

        return true;
    }

    abstract protected function normalizeContent($content);
}
