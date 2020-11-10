<?php


/**
 * Standard
 *
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;



final class Standard {

    /**
     * @var string $transaction_reference Your transaction reference. This MUST be unique for every transaction (Required)
     */
    private $transaction_reference;

    /**
     * @var float $amount Amount to charge the customer. (Required)
     */
    private $amount;

    /**
     * @var string $currency (Required)
     */
    private $currency;

    /**
     * @var string $payment_options This specifies the payment options to be displayed e.g - card, mobilemoney, ussd and so on. (Required)
     */
    private $payment_options;

    /**
     * @var string $redirect_url URL to redirect to when a transaction is completed. This is useful for 3DSecure
     * payments so we can redirect your customer back to a custom page you want to show them. (Required)
     */
    private $redirect_url;

    /**
     * @var array $customer This is an object that can contains your customer details (Required)
     */
    private $customer;

    /**
     * @var array $customizations This is an object that contains title, logo, and description you want to display on the modal (Required)
     */
    private $customizations;

    /**
     * @var string $integrity_hash This is a sha256 hash of your FlutterwaveCheckout values, it is used for passing secured values to the payment gateway
     */
    private $integrity_hash;

    /**
     * @var string $payment_plan This is the payment plan ID used for Recurring billing
     */
    private $payment_plan;

    /**
     * @var array $subaccounts This is an array of objects containing the subaccount IDs to split the payment into (used in split payments only
     */
    private $subaccounts;

    /**
     * @var array $meta This is an object that helps you include additional payment information to your request
     */
    private $meta;

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
     * Set transaction reference
     *
     * @param $transaction_reference
     * @return $this
     */
    public function setTransactionReference($transaction_reference) {

        $this->transaction_reference = $transaction_reference;

        return $this;
    }

    /**
     * Set transaction amount
     *
     * @param $amount
     * @return $this
     */
    public function setAmount($amount) {

        $this->amount = $amount;

        return $this;
    }

    /**
     * Set currency
     *
     * @param $currency
     * @return $this
     */
    public function setCurrency($currency) {

        $this->currency = $currency;

        return $this;
    }

    /**
     * Sets payment option
     * @param $payment_option
     * @return $this
     */
    private function setPaymentOption($payment_option) {

        $this->payment_options = $payment_option;

        return $this;
    }

    /**
     * Pay via card
     */
    public function payViaCard() {
        $this->setPaymentOption(PaymentOption::CARD);

        return $this;
    }

    /**
     * Pay via account
     * @return $this
     */
    public function payViaAccount() {
        $this->setPaymentOption(PaymentOption::ACCOUNT);

        return $this;
    }

    /**
     * Pay via Bank
     * @return $this
     */
    public function payViaBank() {

        $this->setPaymentOption(PaymentOption::BANK_TRANSFER);

        return $this;
    }

    /**
     * Pay via M-PESA
     * @return $this
     */
    public function payViaMpesa() {
        $this->setPaymentOption(PaymentOption::MPESA);

        return $this;
    }

    /**
     * Pay via mobile money Franco
     * @return $this
     */
    public function payViaMobileMoneyFranco() {
        $this->setPaymentOption(PaymentOption::MOBILE_MONEY_FRANCO);

        return $this;
    }

    /**
     * Pay via Mobile money Ghana
     * @return $this
     */
    public function payViaMobileMoneyGhana() {
        $this->setPaymentOption(PaymentOption::MOBILE_MONEY_GHANA);

        return $this;
    }

    /**
     * Pay via Mobile money Rwanda
     * @return $this
     */
    public function payViaMobileMoneyRwanda() {
        $this->setPaymentOption(PaymentOption::MOBILE_MONEY_RWANDA);

        return $this;
    }

    /**
     * Pay via Mobile Money Tanzania
     * @return $this
     */
    public function payViaMobileMoneyTanzania() {
        $this->setPaymentOption(PaymentOption::MOBILE_MONEY_TANZANIA);

        return $this;
    }

    /**
     * Pay via Mobile Money Uganda
     * @return $this
     */
    public function payViaMobileMoneyUganda() {
        $this->setPaymentOption(PaymentOption::MOBILE_MONEY_UGANDA);

        return $this;
    }

    /**
     * Pay via Mobile money Zambia
     * @return $this
     */
    public function payViaMobileMoneyZambia() {
        $this->setPaymentOption(PaymentOption::MOBILE_MONEY_ZAMBIA);

        return $this;
    }

    /**
     * Pay via QR
     * @return $this
     */
    public function payViaQr() {
        $this->setPaymentOption(PaymentOption::QR);

        return $this;
    }

    /**
     * Pay via USSD
     * @return $this
     */
    public function payViaUssd() {
        $this->setPaymentOption(PaymentOption::USSD);

        return $this;
    }

    /**
     * Pay via credit
     * @return $this
     */
    public function payViaCredit() {
        $this->setPaymentOption(PaymentOption::CREDIT);

        return $this;
    }

    /**
     * Pay via barter
     *
     * @return $this
     */
    public function payViaBarter() {
        $this->setPaymentOption(PaymentOption::BARTER);

        return $this;
    }

    /**
     * Pay via PAGA
     * @return $this
     */
    public function payViaPaga() {
        $this->setPaymentOption(PaymentOption::PAGA);

        return $this;
    }

    /**
     * Pay via Voucher
     * @return $this
     */
    public function payViaVoucher() {
        $this->setPaymentOption(PaymentOption::VOUCHER);

        return $this;
    }

    /**
     * Pay via Pay Attitude
     * @return $this
     */
    public function payViaPayAttitude() {
        $this->setPaymentOption(PaymentOption::PAY_ATTITUDE);

        return $this;
    }

    /**
     * Set redirect url
     *
     * @param $url
     * @return $this
     */
    public function setRedirectURL($url) {
        $this->redirect_url = $url;

        return $this;
    }

    /**
     * Set customer details
     *
     * @param $name
     * @param $email
     * @param $phone
     * @param mixed ...$args
     * @return $this
     */
    public function setCustomer($name, $email, $phone, ...$args) {

        $this->customer = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];

        if (isset($args) && sizeof($args) > 0) {
            $this->customer = array_merge($this->customer, $args);
        }

        return $this;
    }

    /**
     * Set customizations
     *
     * @param $title
     * @param $description
     * @param $logo
     * @param mixed ...$args
     * @return $this
     */
    public function setCustomizations($title, $description, $logo, ...$args) {
        $this->customizations = [
            'title' => $title,
            'description' => $description,
            'logo' => $logo
        ];

        if (isset($args) && sizeof($args) > 0) {
            $this->customizations = array_merge($this->customizations, $args);
        }

        return $this;
    }

    /**
     * Set the integrity hash
     *
     * @param $hash
     */
    public function setIntegrityHash($hash) {
        $this->integrity_hash = $hash;
    }

    /**
     * Set the payment plan id for recurrent payments
     *
     * @param $planId
     * @return $this
     */
    public function setPaymentPlan($planId) {
        $this->payment_plan = $planId;

        return $this;
    }

    /**
     * Set sub accounts
     *
     * @param $accounts
     * @return $this
     */
    public function setSubAccounts($accounts) {
        $this->subaccounts = $accounts;

        return $this;
    }


    public function setMetaData(array $data) {
        $this->meta = $data;

        return $this;
    }

    /**
     * Initiate a one time payment
     *
     * @return Request
     */
    public function initiateOneTimePayment() {

        $body = [
            "tx_ref" => $this->transaction_reference,
            "amount" => $this->amount,
            "currency"  => $this->currency,
            "redirect_url" => $this->redirect_url,
            "payment_options" => $this->payment_options,
            "meta"  => $this->meta,
            "customer" => $this->customer,
            "customizations" => $this->customizations
        ];

        return $this->flutterwave->request->request("post", "payments", $this->flutterwave->token, $body);
    }

    /**
     * Initiate recurrent/subscription time payment
     *
     * @param $planId
     * @return Request
     */
    public function initiateRecurrentPayment() {

        $body = [
            "tx_ref" => $this->transaction_reference,
            "amount" => $this->amount,
            "currency"  => $this->currency,
            "redirect_url" => $this->redirect_url,
            "payment_options" => $this->payment_options,
            "meta"  => $this->meta,
            "customer" => $this->customer,
            "customizations" => $this->customizations,
            "payment_plan" => $this->payment_plan
        ];

        return $this->flutterwave->request->request("post", "payments", $this->flutterwave->token, $body);
    }

}