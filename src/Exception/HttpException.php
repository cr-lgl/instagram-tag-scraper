<?php

namespace Cherryred5959\InstagramTagScraper\Exception;

use Psr\Http\Message\ResponseInterface;

/**
 * Class HttpException
 * @package Exceptions
 */
class HttpException extends \RuntimeException
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * HttpException constructor.
     * @param ResponseInterface $response
     * @param string $message
     * @param int $code
     */
    public function __construct($response, $message, $code = 0)
    {
        $this->response = $response;
        parent::__construct("[{$this->convertMessage()}] {$message}", $code);
    }

    /**
     * @return string
     */
    protected function convertMessage()
    {
        return "{$this->response->getStatusCode()}, {$this->response->getReasonPhrase()}";
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}