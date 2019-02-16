<?php

namespace InstagramTagScraper;

use Exception\HttpException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Pool;
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
     * @param int $concurrency
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws HttpException
     */
    public function search($tag, $concurrency = 30)
    {
        $response = $this->client->request(Method::GET, Endpoints::tagUrl($tag));

        if ($response->getStatusCode() !== Status::OK) {
            throw new HttpException($response, "{$tag} request failed.");
        }

        $json = $this->responseToJson($response);

        $mediaList = !empty($json['graphql']['hashtag']['edge_hashtag_to_media']['edges'])
            ? $json['graphql']['hashtag']['edge_hashtag_to_media']['edges']
            : [];

        $mediaRequests = function () use ($mediaList) {
            foreach ($mediaList as $media) {
                $shortCode = $media['node']['shortcode'];
                yield function ($opts) use ($shortCode) {
                    return $this->client->requestAsync(Method::GET, Endpoints::mediaUrl($shortCode), $opts);
                };
            }
        };

        $mediaResponses = [];

        (new Pool($this->client, $mediaRequests(), [
            'concurrency' => $concurrency,
            'fulfilled' => function ($response, $index) use (&$mediaResponses) {
                $mediaResponses[$index] = $this->responseToJson($response);
            },
            'rejected' => function ($reason, $index) {
                throw new HttpException($reason, "{$index} request failed");
            },
        ]))->promise()->wait();

        return $mediaResponses;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function responseToJson($response)
    {
        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}