<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Account;
use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase {


    /**
     * @var Account $verification
     */
    protected $account;

    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->useSandbox()->init();

            $this->account = new Account($flutterwave);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }
    }

    /**
     * Test for all balances
     */
    public function testAllBalances() {

        $response = $this->account->getAllBalances();

        print_r($response);

        $this->assertEquals($response['status'], 'success');
    }

    /**
     * Test KES balance
     */
    public function testKESBalances() {

        $response = $this->account->getAccountBalance("KES");

        print_r($response);

        $this->assertEquals($response['status'], 'success');
    }
}