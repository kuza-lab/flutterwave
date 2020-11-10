<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use Phelix\Flutterwave\Settlement;
use PHPUnit\Framework\TestCase;

class SettlementTest extends TestCase {


    /**
     * @var Settlement
     */
    protected $settlement;

    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->useSandbox()->init();

            $this->settlement = new Settlement($flutterwave);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }
    }

    /**
     * Test getting all settlements
     */
    public function testGettingAllSettlements() {

        $response = $this->settlement->getSettlements();

        print_r($response);

        $this->assertEquals($response['data']['id'], "1686665");
    }

    /**
     * Test getting one settlement
     */
    public function testGettingOneSettlements() {

        $response = $this->settlement->getOneSettlement(98058);

        print_r($response);

        $this->assertEquals($response['data']['id'], "1686665");
    }
}