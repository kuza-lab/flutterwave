<?php


/**
 * Payment Options
 * @author Phelix Juma <jumaphelix@kuzalab.com>
 * @copyright (c) 2020, Kuza Lab
 * @package Kuzalab
 */

namespace Phelix\Flutterwave;


final class PaymentOption {

    public const ACCOUNT = 'account';
    public const CARD = 'card';
    public const BANK_TRANSFER = 'banktransfer';
    public const MPESA = 'mpesa';
    public const MOBILE_MONEY_RWANDA = 'mobilemoneyrwanda';
    public const MOBILE_MONEY_ZAMBIA = 'mobilemoneyzambia';
    public const MOBILE_MONEY_UGANDA = 'mobilemoneyuganda';
    public const MOBILE_MONEY_GHANA = 'mobilemoneyghana';
    public const MOBILE_MONEY_FRANCO = 'mobilemoneyfranco';
    public const MOBILE_MONEY_TANZANIA = 'mobilemoneytanzania';
    public const QR = 'qr';
    public const USSD = 'ussd';
    public const CREDIT = 'credit';
    public const BARTER = 'barter';
    public const PAGA = 'paga';
    public const VOUCHER = '1voucher';
    public const PAY_ATTITUDE = 'payattitude';

}