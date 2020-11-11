<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use Phelix\Flutterwave\Standard;
use PHPUnit\Framework\TestCase;

class StandardTest extends TestCase {


    /**
     * @var Standard $standard
     */
    protected $standard;

    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->init();

            $this->standard = new Standard($flutterwave);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }
    }

    /**
     * Test subscription
     */
    public function testInitializingOneTimePayment() {

        $response = $this
            ->standard
            ->setCustomizations("G-Money", "Group Lending Platform", "https://group-money.com/wp-content/uploads/2020/08/G-Money-site-logo-e1598441322151.png")
            ->setCustomer("Phelix Juma", "jumaphelix@gmail.com", "+254729941254")
            ->setTransactionReference("1234")
            ->setCurrency("KES")
            ->setAmount(10)
            ->setMetaData(["group_id" => 1, 'transaction_type' => "deposit_to_group"])
            ->setRedirectURL("https://api-groups.group-money.com/flutterwave-ipn")
            ->payViaCard()
            ->initiateOneTimePayment();

        print($response['data']['link']);

        $this->assertNotEmpty($response['data']['link']);
    }

    /**
     * Test recurring payment
     */
    public function testInitializingRecurrentPayment() {

        $response = $this
            ->standard
            ->setCustomizations("G-Money", "Group Lending Platform", "https://group-money.com/wp-content/uploads/2020/08/G-Money-site-logo-e1598441322151.png")
            ->setCustomer("Phelix Juma", "jumaphelix@gmail.com", "+254729941254")
            ->setTransactionReference("1234")
            ->setCurrency("KES")
            ->setAmount(10)
            ->setMetaData(["group_id" => 1, 'transaction_type' => "deposit_to_group"])
            ->setRedirectURL("https://api-groups.group-money.com/flutterwave-ipn")
            ->setPaymentPlan(8021)
            ->payViaCard()
            ->initiateRecurrentPayment();

        print "recurring payment link: ";
        print($response['data']['link']);

        $this->assertNotEmpty($response['data']['link']);
    }
}