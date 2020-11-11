Flutterwave SDK by Phelix Juma
================================================

This is a PHP SDK wrapper for Flutterwave.

1. [Get started](https://developer.flutterwave.com/docs/getting-started-1)
2. [API Reference](https://developer.flutterwave.com/reference)


Included Services 
=======================
- Account
   - Get balances for all your accounts
   - Get balance for a specific account
- OTP
   - Create (and optionally send) an OTP 
   - Validate an OTP
- Payment Plan
    - Create a payment plan 
    - Get all your plans 
    - Get a specific plan
    - Update a plan
    - Cancel a plan 
- Settlement
    - Get all settlement records
    - Get a specific settlement record
- Standard Payment Integration
    - Initiate a one time payment
    - Initiate a recurring payment (involves subscribing the payer to a payment plan)
- Subscriptions
    - Get list of all subscriptions
    - Get all subscriptions for a plan
    - Get all subscriptions by a user
    - Get a user's subscription in a plan
    - Get a specific subscription 
    - Cancel a subscription 
    - Activate a subscription 
- Verification
    - Verifying a transaction

Requirements
============

* PHP >= 7.1
* ext-json
* ext-openssl
* ext-mbstring
* ext-openssl
* ext-iconv
* ext-curl
* guzzlehttp/guzzle: "^7.1"
    

Installation
============

    composer require phelix/flutterwave

How To test
===========

To test the package, copy the file "LoadEnv.php.example" in src/tests directory to "LoadEnv.php" and fill in the
configuration values required and then run the following command

    vendor/bin/phpunit test


# Documentation

The docs folder has the technical documentation of each of the classes,methods, properties, namespaces et al. In 
order for you to make references to know what a class does or what a function does or what each of the method 
parameters mean, then the docs have an elaborate description for each of them. 

This being a wrapper for the Flutterwave APIs, you can get more details especially of the expected data structure from [Flutterwave API Reference page](https://developer.flutterwave.com/reference)

This SDK version does not include the services not listed in the "Included Services" section.


## 1. Accounts

Handling account balances

```php

<?php 

    use Phelix\Flutterwave\Flutterwave;
    use Phelix\Flutterwave\Account;
    use Phelix\Flutterwave\Exceptions\FlutterwaveException;

    try {
    
        // We initialize Flutterwave. Only the secret key is compulsory. The rest are optional.
        $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);
        
        $flutterwave->init();

        $account = new Account($flutterwave);
        
        //1. Get balances for all accounts
        $balances = $account->getAllBalances();
        
        // 2. Get balance for a specific account (identified by currency)
        $kes_account_balance = $account->getAccountBalance("KES");

    } catch (FlutterwaveException $exception) {
        print $exception->getMessage();
        // log and/or handle exceptions here
    }
        
```

## 1. One Time PIN (OTPs)

Use this where you're using flutterwave to generate and validate your OTPs

```php

<?php 

    use Phelix\Flutterwave\Flutterwave;
    use Phelix\Flutterwave\OTP;
    use Phelix\Flutterwave\Exceptions\FlutterwaveException;

    try {
    
        // We initialize Flutterwave. Only the secret key is compulsory. The rest are optional.
        $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);
        
        $flutterwave->init();

        $otp = new OTP($flutterwave);
        
        //1. Use this to generate and send an OTP to a customer
        $otp_response = $otp->createOTP("Joehn Doe","john.doe@example.com" ,"0112345678", "JP Enterprises", 5, ['whatsapp', 'sms'], 60, true);
        
        // 2. Use this to verify/validate an OTP
        $otp_val = $otp->validateOTP("otp_reference", 12345);

    } catch (FlutterwaveException $exception) {
        print $exception->getMessage();
        // log and/or handle exceptions here
    }
```

## 3. Payment Plan

Use this to handle payment plans

```php

<?php 

    use Phelix\Flutterwave\Flutterwave;
    use Phelix\Flutterwave\PaymentPlan;
    use Phelix\Flutterwave\Exceptions\FlutterwaveException;

    try {
    
        // We initialize Flutterwave. Only the secret key is compulsory. The rest are optional.
        $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);
        
        $flutterwave->init();

        $plan = new PaymentPlan($flutterwave);
        
        //1. Use this to create a plan. (This creates a plan named "Test Plan" for KES 1000 to be deducted monthly for 12 months
        $response = $plan->createPlan("KES", "Test Plan", 1000, "monthly", 12);
        
        // 2. Use this to list all your plans
        $plans = $plan->getPlans();
        
        // 3. Use this to get a specific plan
        $plan = $plan->getOnePlan(1);
        
        // 4. Use this to update name of a plan
        $update = $plan->updatePlan(1, "New Name");
        
        // 5. Use this to cancel a plan
        $cancelled = $plan->cancelPlan(1);
        
    } catch (FlutterwaveException $exception) {
        print $exception->getMessage();
        // log and/or handle exceptions here
    }
```

## 4. Settlement

This is used when handling settlements between the merchant and dlutterwave

```php

<?php 

    use Phelix\Flutterwave\Flutterwave;
    use Phelix\Flutterwave\Settlement;
    use Phelix\Flutterwave\Exceptions\FlutterwaveException;

    try {
    
        // We initialize Flutterwave. Only the secret key is compulsory. The rest are optional.
        $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);
        
        $flutterwave->init();

        $settlement = new Settlement($flutterwave);
        
        //1. Use this to get the list of all settlements
        $response = $settlement->getSettlements();
        
        // 2. Use this to get one settlement
        $response = $settlement->getOneSettlement(1);
        
    } catch (FlutterwaveException $exception) {
        print $exception->getMessage();
        // log and/or handle exceptions here
    }
```

## 5. Standard Integration

Use this for Flutterwave standard integration. Use this in the section where you initiate payment.
Check [here](https://developer.flutterwave.com/docs/flutterwave-standard) for more details.

```php

<?php 
    
    use Phelix\Flutterwave\Flutterwave;
    use Phelix\Flutterwave\Standard;
    use Phelix\Flutterwave\Exceptions\FlutterwaveException;

    try {
    
        // We initialize Flutterwave. Only the secret key is compulsory. The rest are optional.
        $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);
        
        $flutterwave->init();

        $standard = new Standard($flutterwave);
        
        //1. Use this to initiate a one time payment
        $response = $standard
                    ->setCustomizations("JP Enterprises", "Subsidiary of JP Holdings", "https://helixjuma.com.com/avatar.png")
                    ->setCustomer("Jane Doe", "jane.doe@doedom.com", "+254701234456")
                    ->setTransactionReference("1234REFJANEDOE")
                    ->setCurrency("KES")
                    ->setAmount(1000)
                    ->setMetaData(["category_id" => 1, 'transaction_type' => "payment_for_doedom"])
                    ->setRedirectURL("https://phelixjuma.com/flutterwave-ipn")
                    ->payViaCard() // Use this to pay via card. To use other payment options, check docs for all the other options
                    ->initiateOneTimePayment();
        
        // 2. Use this to initiate a recurrent payment (ie user is subscribed to a payment plan)
        $response = $standard
                    ->setCustomizations("JP Enterprises", "Subsidiary of JP Holdings", "https://helixjuma.com.com/avatar.png")
                    ->setCustomer("Jane Doe", "jane.doe@doedom.com", "+254701234456")
                    ->setTransactionReference("1234REFJANEDOE")
                    ->setCurrency("KES")
                    ->setAmount(1000)
                    ->setMetaData(["category_id" => 1, 'transaction_type' => "payment_for_doedom"])
                    ->setRedirectURL("https://phelixjuma.com/flutterwave-ipn")
                    ->setPaymentPlan(8021) // this is where we set the payment plan id
                    ->payViaCard() // Use this to pay via card. To use other payment options, check docs for all the other options
                    ->initiateRecurrentPayment();
        
        /**
         * After a transaction is initiated above, you get a link that you are supposed to redirect the user to. 
         * Redirect the user to the link where they will do the payments afterwhich Flutterwave redirects them to your redirect url set above
         * Sample redirect from Flutterwave looks like: https://phelixjuma.com/flutterwave-ipn?status=successful&tx_ref=1234&transaction_id=1686665
         * Check section below on how to handle and complete transaction in the IPN page.   
         */
    } catch (FlutterwaveException $exception) {
        print $exception->getMessage();
        // log and/or handle exceptions here
    }
```

## 6. IPN (Payment Verification)

Use this in your IPN (the redirect url set when initiating payment)

```php

<?php 
        
    use Phelix\Flutterwave\Flutterwave;
    use Phelix\Flutterwave\Verification;
    use Phelix\Flutterwave\Exceptions\FlutterwaveException;
    
    try {
        
        // We initialize Flutterwave. Only the secret key is compulsory. The rest are optional.
        $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);
        
        $flutterwave->init();

        $verification = new Verification($flutterwave);
        
        // Your IPN will have query parameters added by Flutterwave. An example is as shown:
        //  https://phelixjuma.com/flutterwave-ipn?status=successful&tx_ref=1234&transaction_id=1686665
        
        // At this stage, you must verify the transaction before confirming that it is successful. Don't just assume it is successful
        // due to the status parameter in the url
        
        $transactionId = sanitize($_GET['transaction_id']); // sanitize() is an arbitrary function. Use your implementation
        $transactionReference = sanitize($_GET['tx_ref']); // sanitize() is an arbitrary function. Use your implementation
        
         // Get the transaction you had initiated by doing a query to your database. getTransaction() is an arbitrary function. 
        $transaction = getTransaction($transactionReference);
        
        if ($transaction) {
            
            $response = $verification->verify($transactionId, $transactionReference, $transaction['currency'], $transaction['amount']);
            
            // Response is an array of the format $response = ['verified' => true|false,'message' => "response message", 'data'=> <response data>];
            
            if ($response['verified'] !== false) {
                // Verified transaction. Update transaction as successful
            } else {
                // Transaction not verified. Get actual status from $response['data']['status']. Check Flutterwave docs for more details.
            }
            
        } else {
            // transaction does not exist. Possibly a modified IPN. Log the attempt.
        }
    } catch (FlutterwaveException $exception) {
        print $exception->getMessage();
        // log and/or handle exceptions here
    }
```

## 7. Subscription

Use this for subscriptions

```php

<?php 
        
    use Phelix\Flutterwave\Flutterwave;
    use Phelix\Flutterwave\Subscription;
    use Phelix\Flutterwave\Exceptions\FlutterwaveException;
    
    try {
    
        // We initialize Flutterwave. Only the secret key is compulsory. The rest are optional.
        $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);
        
        $flutterwave->init();

        $subscription = new Subscription($flutterwave);
            
        // 1. Use this to get subscriptions
        $response = $subscription->getSubscriptions();
        
        // 2. Use this to get subscriptions for a plan. Check docs for the other parameters eg pagination
        $response = $subscription->getPlanSubscriptions(1020);
        
        // 3. Use this to get a user's plan subscription. Check docs for the other parameters eg pagination
        $response = $subscription->getUserPlanSubscriptions(8021, "janedoe@doedom.com");
        
        // 4. Get all subscriptions for a user. Check docs for the other parameters eg pagination
        $response = $subscription->getUserSubscriptions("janedoe@doedom.com");
        
        // 5. Get a specific subscription
        $response = $subscription->getOneSubscription(1);
        
        // 6. Cancel a subscription
        $response = $subscription->cancelSubscription(1);
        
        // 7. Activate a subscription
        $response = $subscription->activateSubscription(1);
        
    } catch (FlutterwaveException $exception) {
        print $exception->getMessage();
        // log and/or handle exceptions here
    }
```

## 6. Responses and Error codes

All responses and error codes are similar to the ones from Flutterwave. Check [here](https://developer.flutterwave.com/docs/flutterwave-errors)
for details on error codes

Generally, all/most responses follow the standard stucture shown below

```php

    $response = [
        "success" => true|false,
        "message" => "",
        "data" => []
    ];
```

In some cases, meta details are also included eg when getting list of items as shown below:
```php

    $response = [
        "status" => 'success',
        "message" => "",
        "data" => [],
        "meta  => [
            "page_info" => [
                "total" => 44,
                "current_page" => 1,
                "total_pages" => 5
             ]
    ];
```

Credits
=======

- Phelix Juma from Kuza Lab Ltd (jumaphelix@kuzalab.com)
