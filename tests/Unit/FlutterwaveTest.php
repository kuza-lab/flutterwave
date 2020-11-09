<?php

namespace Phelix\Flutterwave\Tests\Unit;


use Phelix\Flutterwave\Exceptions\FlutterwaveException;
use Phelix\Flutterwave\Flutterwave;
use PHPUnit\Framework\TestCase;

class FlutterwaveTest extends TestCase {


    /**
     * Set up the test case.
     */
    public function setUp(): void {

        require_once dirname(__DIR__) .DIRECTORY_SEPARATOR. "LoadEnv.php";

    }

    /**
     *
     */
    public function testInitializingFlutterwave() {

        try {

            $flutterwave = new Flutterwave($_ENV["FLUTTER_WAVE_SECRET_KEY"], $_ENV["FLUTTER_WAVE_ENCRYPTION_KEY"], $_ENV["FLUTTER_WAVE_PUBLIC_KEY"]);

            $flutterwave->useSandbox()->init();

            print $flutterwave->token;

            $this->assertNotEmpty($flutterwave->token);

        } catch (FlutterwaveException $exception) {

            print $exception->getMessage();

            $this->assertEmpty($exception->getMessage());
        }

    }
}