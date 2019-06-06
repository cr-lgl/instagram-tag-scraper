<?php

use Cherryred5959\InstagramTagScraper\Instagram;
use GuzzleHttp\Client;

require_once __DIR__ . '/../vendor/autoload.php';

/** @noinspection PhpUnhandledExceptionInspection*/
dump((new Instagram(new Client()))->search('hello'));