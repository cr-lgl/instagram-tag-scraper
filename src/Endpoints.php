<?php

namespace Cherryred5959\InstagramTagScraper;

/**
 * Class Endpoints
 * @package Cherryred5959\InstagramTagScraper
 */
class Endpoints
{
    const BASE_URL = 'https://www.instagram.com/';

    const SEARCH_TAG_URL = self::BASE_URL . 'explore/tags/';

    const MEDEA_URL = self::BASE_URL . 'p/';

    /**
     * @param string $tag
     * @return string
     */
    public static function tagUrl($tag)
    {
        return static::SEARCH_TAG_URL . urlencode($tag) . '?' . static::queryString();
    }

    /**
     * @param string $shortCode
     * @return string
     */
    public static function mediaUrl($shortCode)
    {
        return static::MEDEA_URL . $shortCode . '?' . static::queryString();
    }

    /**
     * @param array $queries
     * @return string
     */
    protected static function queryString($queries = [])
    {
        $queries['__a'] = 1;

        return http_build_query($queries);
    }
}