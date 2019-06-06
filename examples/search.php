<?php

require_once __DIR__ . '/../vendor/autoload.php';

/** @noinspection PhpUnhandledExceptionInspection*/
(new \Cherryred5959\InstagramTagScraper\Instagram(new \GuzzleHttp\Client()))->search('iphone');