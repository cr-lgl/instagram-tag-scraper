<?php

namespace InstagramTagScraper;

use Exception\HttpException;
use GuzzleHttp\ClientInterface;
use InstagramTagScraper\Http\Method;
use InstagramTagScraper\Http\Status;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Instagram
 * @package InstagramTagScraper
 */
class Instagram
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * Instagram constructor.
     * @param ClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param string $tag
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search($tag)
    {
        $response = $this->client->request(Method::GET, Endpoints::tagUrl($tag));

        $json = $this->responseToJson($response, $tag);
        $mediaList = !empty($json['graphql']['hashtag']['edge_hashtag_to_media']['edges'])
            ? $json['graphql']['hashtag']['edge_hashtag_to_media']['edges']
            : [];

        $list = [];
        foreach ($mediaList as $media) {
            $shortCode = $media['node']['shortcode'];
            $response = $this->client->request(Method::GET, Endpoints::mediaUrl($shortCode));
            $list[] = $this->responseToJson($response,$shortCode );
        }

        return $list;
    }

    /**
     * @param ResponseInterface $response
     * @param string $name
     * @return array
     */
    public function responseToJson($response, $name = '')
    {
        if ($response->getStatusCode() !== Status::OK) {
            throw new HttpException($response, "{$name} request failed.");
        }

        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}