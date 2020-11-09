<?php


/**
 * This is main app class file
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Request;

/**
 * Main application class.
 */
final class Flutterwave {

    /**
     * Base url for the production environment
     * @var string $live_base_url
     */
    private $liveBaseUrl = "https://api.flutterwave.com/v3/";
    /**
     * Base url for the testing environment
     * @var string $sandbox_base_url
     */
    private $sandboxBaseUrl = "https://api.flutterwave.com/v3/";

    /**
     * Actual base url to be used. Set depending on environment of use
     * @var string $baseURL
     */
    private $baseURL;

    /**
     * Public Key from Flutterwave account account
     * @var string $publicKey
     */
    private $publicKey;

    /**
     * Secret key from Flutterwave account
     * @var string $secretKey
     */
    private $secretKey;

    /**
     * Encryption key from fullterwave account
     * @var integer $encryptionKey
     */
    public $encryptionKey;

    /**
     * Holds the debug level
     * @var $debugLevel
     */
    public $debugLevel;

    /**
     * Bearer token to use for all requests
     * @var string $token
     */
    public $token;

    /**
     * @var Request $request
     */
    public $request;


    /**
     * Flutterwave constructor.
     * @param $secretKey
     * @param null $encryptionKey
     * @param null $publicKey
     * @param null $debugLevel
     */
    public function __construct($secretKey, $encryptionKey = null, $publicKey=null, $debugLevel = null) {

        $this->secretKey = $secretKey;
        $this->encryptionKey = $encryptionKey;
        $this->publicKey = $publicKey;
        $this->debugLevel = $debugLevel;

        $this->baseURL = $this->sandboxBaseUrl; // by default we use the testing environment
    }

    /**
     * Switch to using live
     * @return $this
     */
    public function useLive() {
        $this->baseURL = $this->liveBaseUrl;

        return $this;
    }

    /**
     * Switch to using sandbox
     * @return $this
     */
    public function useSandbox() {
        $this->baseURL = $this->sandboxBaseUrl;

        return $this;
    }

    /**
     * @return $this
     */
    public function init() {

        $this->request = new Request($this->baseURL);

        $this->token = $this->secretKey;

        return $this;
    }

}