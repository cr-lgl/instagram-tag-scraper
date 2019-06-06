# Instagram Tag Scraper
Instagram tag search for top recently list 

## Installing
```
composer require cherryred5959/instagram-tag-scraper
```

## Usage
``` php
$client = new \GuzzleHttp\Client();
$instagram = new \Cherryred5959\InstagramTagScraper\Instagram($client);
$responses = $instagram->search('something');
```

## Development
```
composer install
```

## Example
```
php examples/search.php
```
