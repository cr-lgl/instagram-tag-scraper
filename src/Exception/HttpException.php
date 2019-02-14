<?php

declare(strict_types = 1);

namespace Exception;

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
    public function __construct(ResponseInterface $response, string $message, int $code = 0)
    {
        $this->response = $response;
        parent::__construct("[{$this->convertMessage()}] {$message}", $code);
    }

    /**
     * @return string
     */
    protected function convertMessage(): string
    {
        return "{$this->response->getStatusCode()}, {$this->response->getReasonPhrase()}";
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}