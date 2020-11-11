<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use Phelix\Flutterwave\OTP;
use PHPUnit\Framework\TestCase;

class OTPTest extends TestCase {


    /**
     * @var OTP $otp
     */
    protected $otp;

    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->init();

            $this->otp = new OTP($flutterwave);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }
    }

    /**
     * Test sending OTP
     */
    public function testSendingOTP() {

        $response = $this->otp->createOTP("Phelix Juma", "jumaphelix@gmail.com", "+254729941254", "JP Devs", 5, ['whatsapp', 'sms'], 10, true);

        print_r($response);

        $this->assertEquals($response['status'], 'success');
    }

    /**
     * Test OTP validation
     */
    public function testValidatingOTP() {

        $response = $this->otp->validateOTP("PPL", 12345);

        print_r($response);

        $this->assertEquals($response['status'], 'error');
    }
}