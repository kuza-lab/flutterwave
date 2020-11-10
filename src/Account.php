<?php


/**
 * Account
 *
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


final class Account {

    /**
     * @var Flutterwave
     */
    protected $flutterwave;

    /**
     * Account constructor.
     * @param Flutterwave $flutterwave
     */
    public function __construct(Flutterwave $flutterwave) {
        $this->flutterwave = $flutterwave;
    }

    /**
     * Get all balances
     * Gets all balances for each of the currencies
     *
     * @return mixed
     */
    public function getAllBalances() {

        $response = $this->flutterwave->request->request("get", "balances", $this->flutterwave->token);

        return $response->responseBody;
    }

    /**
     * Get balance of a specific account identified by the specified currency
     *
     * @param $currency
     * @return mixed
     */
    public function getAccountBalance($currency) {
        $response = $this->flutterwave->request->request("get", "balances/$currency", $this->flutterwave->token);

        return $response->responseBody;
    }




}