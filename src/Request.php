<?php


/**
 * Handle requests
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

final class Request {

    public $client;

    private $headers = [
        'Content-Type' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest'
    ];

    public $success = false;

    public $statusCode;

    public $statusText;

    private $responseBody;

    public $responseMessage;

    public $responseData;

    public $debugRequestTrace;
    public $debugResponseTrace;

    /**
     * Request constructor.
     * @param $baseURI
     */
    public function __construct($baseURI) {
        $this->client = new Client(['base_uri' => $baseURI]);
    }

    /**
     * Make a http request
     *
     * @param $method
     * @param $uri
     * @param null $token
     * @param null $body
     * @param null $query_params
     * @return $this
     */
    public function request($method, $uri, $token=null, $body=null, $query_params=null) {

        try {

            if (!is_null($token)) {
                $this->headers['X-Authorization'] = "Bearer $token";
            }

            $options['headers'] = $this->headers;
            $options['verify'] = false;

            if (!is_null($body)) {
                $options['json'] = $body;
            }
            if (!is_null($query_params)) {
                $options['query'] = $query_params;
            }

            $response = $this->client->request($method, $uri, $options);

            $this->statusCode = $response->getStatusCode();
            $this->statusText = $response->getReasonPhrase();

            $this->responseBody = json_decode($response->getBody()->getContents(), JSON_FORCE_OBJECT);

            $this->success = isset($this->responseBody['status']) && $this->responseBody['status'] == "success";

        } catch (RequestException $e) {

            $this->success = false;

            $this->debugRequestTrace = $e->getRequest();
            $this->debugResponseTrace = $e->getResponse();

            if ($e->hasResponse()) {

                // we set the response
                $response = $e->getResponse();

                $this->statusCode = $response->getStatusCode();
                $this->statusText = $response->getReasonPhrase();

                $this->responseBody = json_decode($response->getBody()->getContents(), JSON_FORCE_OBJECT);

            } else {

                $this->statusCode = 500;
                $this->statusText = "Internal Server Error";

                $this->errorCode = $e->getCode();
                $this->errorMessage = $e->getMessage();

            }

        } catch (GuzzleException $e) {

            $this->success = false;

            $this->debugRequestTrace = $e->getTrace();

            $this->statusCode = 500;
            $this->statusText = "Internal Server Error";

            $this->responseMessage = "Internal Server Error";
        }

        $this->responseMessage = isset($this->responseBody['message']) ? $this->responseBody['message'] : null;
        $this->responseData = isset($this->responseBody['data']) ? $this->responseBody['data'] : null;

        return $this;
    }
}