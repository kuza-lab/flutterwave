<?php


/**
 * Subscription
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


final class Subscription {

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
     * Get all subscriptions
     *
     * @param string $email This is the email of the subscribers
     * @param int $transactionId This is the id of the transaction. It is returned in the call to verify a transaction as data.id
     * @param int $planId This is the ID of the payment plan. It is returned in the call to create a payment plan as data.id
     * @param string $subscribedFrom This is the params to filter from the start date of the subscriptions
     * @param string $subscribedTo This is the params to filter to the end date of the subscriptions
     * @param string $nextDueFrom This is the params to filter from the start date of the next due subscriptions
     * @param string $nextDueTo This is the params to filter to the end date of the next due subscriptions
     * @param int $page This is the page number to retrieve e.g. setting 1 retrieves the first page
     * @param string $status This is the params used to filter the list of subscription based on the status which can be either active or cancelled
     * @return mixed
     */
    public function getSubscriptions($email=null, $transactionId=null, $planId=null, $subscribedFrom = null, $subscribedTo = null,
                                     $nextDueFrom = null, $nextDueTo = null, $page = null, $status = null) {

        $query_params = [];

        if (!is_null($email)) {
            $query_params['email'] = $email;
        }
        if (!is_null($transactionId)) {
            $query_params['transaction_id'] = $transactionId;
        }
        if (!is_null($planId)) {
            $query_params['plan'] = $planId;
        }
        if (!is_null($subscribedFrom)) {
            $query_params['subscribed_from'] = $subscribedFrom;
        }
        if (!is_null($subscribedTo)) {
            $query_params['subscribed_to'] = $subscribedTo;
        }
        if (!is_null($nextDueFrom)) {
            $query_params['next_due_from'] = $nextDueFrom;
        }
        if (!is_null($nextDueTo)) {
            $query_params['next_due_to'] = $nextDueTo;
        }
        if (!is_null($page)) {
            $query_params['page'] = $page;
        }
        if (!is_null($status)) {
            $query_params['status'] = $status;
        }

        $response = $this->flutterwave->request->request("get", "subscriptions", $this->flutterwave->token, null, $query_params);

        return $response->responseBody;
    }

    /**
     * Get subscriptions to a specific plan
     *
     * @param int $planId This is the ID of the payment plan. It is returned in the call to create a payment plan as data.id
     * @param string $email This is the email of the subscribers
     * @param int $transactionId This is the id of the transaction. It is returned in the call to verify a transaction as data.id
     * @param string $subscribedFrom This is the params to filter from the start date of the subscriptions
     * @param string $subscribedTo This is the params to filter to the end date of the subscriptions
     * @param string $nextDueFrom This is the params to filter from the start date of the next due subscriptions
     * @param string $nextDueTo This is the params to filter to the end date of the next due subscriptions
     * @param int $page This is the page number to retrieve e.g. setting 1 retrieves the first page
     * @param string $status This is the params used to filter the list of subscription based on the status which can be either active or cancelled
     * @return mixed
     */
    public function getPlanSubscriptions($planId, $transactionId=null, $subscribedFrom = null, $subscribedTo = null,
                                         $nextDueFrom = null, $nextDueTo = null, $page = null, $status = null) {

        return $this->getSubscriptions(null, $transactionId, $planId, $subscribedFrom, $subscribedTo, $nextDueFrom, $nextDueTo, $page, $status);

    }

    /**
     * Get a user's subscription to a plan
     *
     * @param int $planId This is the ID of the payment plan. It is returned in the call to create a payment plan as data.id
     * @param string $email This is the email of the subscribers
     * @param int $transactionId This is the id of the transaction. It is returned in the call to verify a transaction as data.id
     * @param string $subscribedFrom This is the params to filter from the start date of the subscriptions
     * @param string $subscribedTo This is the params to filter to the end date of the subscriptions
     * @param string $nextDueFrom This is the params to filter from the start date of the next due subscriptions
     * @param string $nextDueTo This is the params to filter to the end date of the next due subscriptions
     * @param int $page This is the page number to retrieve e.g. setting 1 retrieves the first page
     * @param string $status This is the params used to filter the list of subscription based on the status which can be either active or cancelled
     * @return mixed
     */
    public function getUserPlanSubscriptions($planId, $email, $transactionId=null, $subscribedFrom = null, $subscribedTo = null,
                                         $nextDueFrom = null, $nextDueTo = null, $page = null, $status = null) {

        return $this->getSubscriptions($email, $transactionId, $planId, $subscribedFrom, $subscribedTo, $nextDueFrom, $nextDueTo, $page, $status);

    }

    /**
     * Get all subscriptions by  a user
     *
     * @param string $email This is the email of the subscribers
     * @param int $transactionId This is the id of the transaction. It is returned in the call to verify a transaction as data.id
     * @param string $subscribedFrom This is the params to filter from the start date of the subscriptions
     * @param string $subscribedTo This is the params to filter to the end date of the subscriptions
     * @param string $nextDueFrom This is the params to filter from the start date of the next due subscriptions
     * @param string $nextDueTo This is the params to filter to the end date of the next due subscriptions
     * @param int $page This is the page number to retrieve e.g. setting 1 retrieves the first page
     * @param string $status This is the params used to filter the list of subscription based on the status which can be either active or cancelled
     * @return mixed
     */
    public function getUserSubscriptions($email, $transactionId=null, $subscribedFrom = null, $subscribedTo = null,
                                             $nextDueFrom = null, $nextDueTo = null, $page = null, $status = null) {

        return $this->getSubscriptions($email, $transactionId, null, $subscribedFrom, $subscribedTo, $nextDueFrom, $nextDueTo, $page, $status);

    }

    /**
     * Get a single subscription
     *
     * @param $id
     * @return mixed
     */
    public function getOneSubscription($id) {

        $response = $this->flutterwave->request->request("get", "subscriptions/$id", $this->flutterwave->token);

        return $response->responseBody;
    }

    /**
     * Cancel a subscription
     *
     * @param int $id This is the unique id of the subscription you want to cancel. It is returned in the Get a subscription call as data.id
     * @return mixed
     */
    public function cancelSubscription($id) {

        $response = $this->flutterwave->request->request("put", "subscriptions/$id/cancel", $this->flutterwave->token);

        return $response->responseBody;
    }

    /**
     * Activate a subscription
     *
     * @param int $id This is the unique id of the subscription you want to activate. It is returned in the Get a subscription call as data.id
     * @return mixed
     */
    public function activateSubscription($id) {

        $response = $this->flutterwave->request->request("put", "subscriptions/$id/activate", $this->flutterwave->token);

        return $response->responseBody;

    }

}