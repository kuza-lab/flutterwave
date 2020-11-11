<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use Phelix\Flutterwave\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase {


    /**
     * @var Subscription
     */
    protected $subscription;

    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->init();

            $this->subscription = new Subscription($flutterwave);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }
    }

    /**
     * Test getting all subscriptions
     */
    public function testGettingAllSubscriptions() {

        $response = $this->subscription->getSubscriptions();

        print_r($response);

        $this->assertEquals($response['status'], "success");
    }

    /**
     * Test getting plan subscriptions
     */
    public function testGettingPlanSubscriptions() {

        $response = $this->subscription->getPlanSubscriptions(8021);

        print_r($response);

        $this->assertEquals($response['status'], "success");
    }

    /**
     * Test getting user's subscription to a plan.
     */
    public function testGettingUserPlanSubscriptions() {

        $response = $this->subscription->getUserPlanSubscriptions(8021, "jumaphelix@gmail.com");

        print_r($response);

        $this->assertEquals($response['status'], "success");
    }

    /**
     * Test getting a user's subscriptions
     */
    public function testGettingUserSubscriptions() {

        $response = $this->subscription->getUserSubscriptions( "jumaphelix@gmail.com");

        print_r($response);

        $this->assertEquals($response['status'], "success");
    }

    /**
     * Test getting one subscription
     */
    public function testGettingOneSubscriptions() {

        $response = $this->subscription->getOneSubscription( 7835);

        print_r($response);

        $this->assertEquals($response['status'], "success");
    }

    /**
     * Test cancelling subscription
     */
    public function testCancellingSubscriptions() {

        $response = $this->subscription->cancelSubscription( 7835);

        print_r($response);

        $this->assertEquals($response['status'], "success");
    }

    /**
     * Test activating a subscription
     */
    public function testActivatingSubscriptions() {

        $response = $this->subscription->activateSubscription( 7835);

        print_r($response);

        $this->assertEquals($response['status'], "success");
    }
}