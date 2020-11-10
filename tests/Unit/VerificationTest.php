<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use Phelix\Flutterwave\Verification;
use PHPUnit\Framework\TestCase;

class VerificationTest extends TestCase {


    /**
     * @var Verification $verification
     */
    protected $verification;

    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->useSandbox()->init();

            $this->verification = new Verification($flutterwave);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }
    }

    public function testSuccessfulPaymentVerification() {

        // sampe repsonse https://link.com/flutterwave-ipn?status=successful&tx_ref=1234&transaction_id=1686665

        $response = $this->verification->verify("1686665", "1234", "KES", "10");

        print_r($response);

        $this->assertEquals($response['data']['id'], "1686665");
    }
}