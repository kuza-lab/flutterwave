<?php


/**
 * OTP
 *
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


final class OTP {

    /**
     * @var Flutterwave
     */
    protected $flutterwave;

    /**
     * OTP constructor.
     * @param Flutterwave $flutterwave
     */
    public function __construct(Flutterwave $flutterwave) {
        $this->flutterwave = $flutterwave;
    }

    /**
     * Create an OTP
     *
     * @param string $customerName Name of the customer
     * @param string $customerEmail Email of the customer
     * @param string $customerPhone Phone of the customer
     * @param string $merchantName This is your merchant/business name. It would display when the OTP is sent
     * @param int $length This is Integer length you want for the OTP.
     * @param array $medium the medium you want your customers to receive the OTP on. Possible values are sms, email and whatsapp. You can pass more than one medium in the array"
     * @param int $ttl Pass an integer value represented in minutes for how long you want the OTP to live for before expiring
     * @param bool $sendToCustomer Set to true to send otp to customer
     * @return mixed
     */
    public function createOTP($customerName, $customerEmail, $customerPhone, $merchantName, $length, $medium, $ttl= null, $sendToCustomer = true) {

        $data = [
            'customer'   => [
                'name'      => $customerName,
                'email'     => $customerEmail,
                'phone'     => $customerPhone
            ],
            'sender'    => $merchantName,
            'length'    => $length,
            'medium'    => $medium,
            'send'      => $sendToCustomer
        ];

        if (!is_null($ttl)) {
            $data['expiry'] = $ttl;
        }

        $response = $this->flutterwave->request->request("post", "otps", $this->flutterwave->token, $data);

        return $response->responseBody;
    }

    /**
     * Validate OTP
     *
     * @param string $reference This is the reference that was returned in the create OTP response
     * @param int $otp This is the One time Pin sent to the user. You are meant to collect this from the user for validation
     * @return mixed
     */
    public function validateOTP($reference, $otp) {

        $data['otp'] = $otp;

        $response = $this->flutterwave->request->request("post", "otps/$reference/validate", $this->flutterwave->token, $data);

        return $response->responseBody;

    }


}