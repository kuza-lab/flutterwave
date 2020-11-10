<?php


/**
 * Payment Plans
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


final class PaymentPlan {

    /**
     * @var Flutterwave
     */
    protected $flutterwave;

    /**
     * Standard constructor.
     * @param Flutterwave $flutterwave
     */
    public function __construct(Flutterwave $flutterwave) {
        $this->flutterwave = $flutterwave;
    }

    /**
     * Create a new plan
     *
     * @param string $currency Currency for the plan
     * @param string $name This is the name of the payment plan, it will appear on the subscription reminder emails
     * @param float $amount This is the amount to charge all customers subscribed to this plan
     * @param string $interval This will determine the frequency of the charges for this plan. Could be yearly, quarterly, monthly, weekly, daily, etc.
     * @param int $duration This is the frequency, it is numeric, e.g. if set to 5 and intervals is set to monthly you would be charged 5 months, and then the subscription stops
     * @return mixed
     */
    public function createPlan(string $currency, string $name, float $amount, string $interval, int $duration) {

        $data = [
            'currency'  => $currency,
            'name'      => $name,
            'amount'    => $amount,
            'interval'  => $interval,
            'duration'  => intval($duration)
        ];

        $response = $this->flutterwave->request->request("post", "payment-plans", $this->flutterwave->token, $data);

        return $response->responseBody;
    }

    /**
     * Get list of payment plans
     *
     * @param string $from This is the specified date to start the list from. YYYY-MM-DD
     * @param string $to The is the specified end period for the search. YYYY-MM-DD
     * @param int $page This is the page number to retrieve e.g. setting 1 retrieves the first page
     * @param int $amount This is the exact amount set when creating the payment plan
     * @param string $currency This is the currency the payment plan amount is charged in
     * @param string $interval This is how often the payment plan is set to execute
     * @param string $status This is the status of the payment plan
     * @return mixed
     */
    public function getPlans($from = null, $to= null, $page= null, $amount=null, $currency=null, $interval=null, $status=null) {

        $query_params = [];

        if (!is_null($from)) {
            $query_params['from'] = $from;
        }
        if (!is_null($to)) {
            $query_params['to'] = $to;
        }
        if (!is_null($page)) {
            $query_params['page'] = $page;
        }
        if (!is_null($amount)) {
            $query_params['amount'] = $amount;
        }
        if (!is_null($currency)) {
            $query_params['currency'] = $currency;
        }
        if (!is_null($interval)) {
            $query_params['interval'] = $interval;
        }
        if (!is_null($status)) {
            $query_params['status'] = $status;
        }

        $response = $this->flutterwave->request->request("get", "payment-plans", $this->flutterwave->token, null, $query_params);

        return $response->responseBody;
    }

    /**
     * Get details of a single plan
     *
     * @param int $id This is the unique id of the payment plan you want to fetch. It is returned in the call to create a payment plan
     * @return mixed
     */
    public function getOnePlan($id) {

        $response = $this->flutterwave->request->request("get", "payment-plans/$id", $this->flutterwave->token);

        return $response->responseBody;

    }

    /**
     * Update a plan
     *
     * @param int $id This is the unique id of the payment plan you want to fetch. It is returned in the call to create a payment plan
     * @param string $name The new name of the payment plan
     * @param string $status The new status of the payment plan
     * @return mixed
     */
    public function updatePlan($id, $name=null, $status = null) {

        $data = [];

        if (!is_null($name)) {
            $data['name'] = $name;
        }
        if (!is_null($status)) {
            $data['status'] = $status;
        }

        $response = $this->flutterwave->request->request("put", "payment-plans/$id", $this->flutterwave->token, $data);

        return $response->responseBody;

    }

    /**
     * Cancel an existing payment plan
     *
     * @param int $id This is the unique id of the payment plan you want to fetch. It is returned in the call to create a payment plan
     * @return mixed
     */
    public function cancelPlan($id) {

        $response = $this->flutterwave->request->request("put", "payment-plans/$id/cancel", $this->flutterwave->token);

        return $response->responseBody;

    }

}