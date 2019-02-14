<?php

declare(strict_types = 1);

require_once __DIR__ . '/../vendor/autoload.php';

try {
    dump((new \InstagramTagScraper\Instagram(new \GuzzleHttp\Client()))->search('iphone'));
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    dump($e);
}