<?php

declare(strict_types = 1);

namespace InstagramTagScraper;

/**
 * Class Endpoints
 * @package InstagramTagScraper
 */
class Endpoints
{
    protected const BASE_URL = 'https://www.instagram.com/';

    protected const SEARCH_TAG_URL = self::BASE_URL . 'explore/tags/';

    protected const MEDEA_URL = self::BASE_URL . 'p/';
    /**
     * @param string $tag
     * @return string
     */
    public static function tagUrl(string $tag): string
    {
        return static::SEARCH_TAG_URL . urlencode($tag) . '?' . static::queryString();
    }

    /**
     * @param string $shortCode
     * @return string
     */
    public static function mediaUrl(string $shortCode): string
    {
        return static::MEDEA_URL . $shortCode . '?' . static::queryString();
    }

    /**
     * @param array $queries
     * @return string
     */
    protected static function queryString(array $queries = []): string
    {
        $queries['__a'] = 1;

        return http_build_query($queries);
    }
}