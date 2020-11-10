<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use Phelix\Flutterwave\PaymentPlan;
use PHPUnit\Framework\TestCase;

class PaymentPlanTest extends TestCase {


    /**
     * @var PaymentPlan
     */
    protected $paymentPlan;

    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->useSandbox()->init();

            $this->paymentPlan = new PaymentPlan($flutterwave);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }
    }

    /**
     * Test sending OTP
     */
    public function testCreatingPlan() {

        $response = $this->paymentPlan->createPlan('KES', "Phelix Juma Donation Plan", 10, 'monthly', 12);

        print_r($response);

        $this->assertEquals($response['status'], 'success');
    }

    /**
     * Test getting all plans
     */
    public function testGetAllPlans() {

        $response = $this->paymentPlan->getPlans();

        print_r($response);

        $this->assertEquals($response['status'], 'success');
    }

    /**
     * Test getting one plan
     */
    public function testGetOnePlans() {

        $response = $this->paymentPlan->getOnePlan(8020);

        print_r($response);

        $this->assertEquals($response['status'], 'success');
    }

    /**
     * Test updating a plan
     */
    public function testUpdatingPlan() {

        $response = $this->paymentPlan->updatePlan(8020, "JP Donations");

        print_r($response);

        $this->assertEquals($response['status'], 'success');

    }

    /**
     * Test cancelling a plan
     */
    public function testCancellingPlan() {

        $response = $this->paymentPlan->cancelPlan(8020);

        print_r($response);

        $this->assertEquals($response['status'], 'success');

    }




}