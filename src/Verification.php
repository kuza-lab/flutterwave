<?php


/**
 * Transaction Verification
 *
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;



final class Verification {

    /**
     * @var Flutterwave
     */
    protected $flutterwave;

    /**
     * Verification constructor.
     * @param Flutterwave $flutterwave
     */
    public function __construct(Flutterwave $flutterwave) {
        $this->flutterwave = $flutterwave;
    }

    /**
     * Verify  a transaction
     * Uses transaction reference, currency and amount to verify the transaction
     *
     * @param $transactionId
     * @param $transactionReference
     * @param $currency
     * @param $amount
     * @return array
     */
    public function verify($transactionId, $transactionReference, $currency, $amount) {

        $response = [
            'verified'  => false,
            'message'   => "",
            'data'      => null
        ];

        // Check transaction status in Flutterwave
        $request = $this->flutterwave->request->request("get", "transactions/$transactionId/verify", $this->flutterwave->token);

        // Get the response message and data
        $response['message'] = $request->responseMessage;
        $response['data'] = $request->responseData;

        // Validate the transaction by confirming reference, currency and amount
        if ($request->success !== false) {
            if (
                isset($request->responseData['tx_ref']) && $request->responseData['tx_ref'] == $transactionReference &&
                isset($request->responseData['currency']) && $request->responseData['currency'] == $currency &&
                isset($request->responseData['charged_amount']) && $request->responseData['charged_amount'] == $amount &&
                isset($request->responseData['status']) && $request->responseData['status'] == "successful"
            ) {
                $response['verified'] = true;
            }
        }
        return $response;
    }

    /**
     * Query a transaction
     * @param $transactionId
     * @return bool
     */
    public function queryTransaction($transactionId) {

        $request = $this->flutterwave->request->request("get", "transactions/$transactionId/verify", $this->flutterwave->token);

        if ($request->success !== false) {
            return $request->responseData;
        }
        return false;
    }

}