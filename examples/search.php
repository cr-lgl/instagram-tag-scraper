<?php

require_once __DIR__ . '/../vendor/autoload.php';

/** @noinspection PhpUnhandledExceptionInspection*/
(new \InstagramTagScraper\Instagram(new \GuzzleHttp\Client()))->search('iphone');