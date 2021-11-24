<?php

namespace App\Tests\Command;

use App\Command\GetTemperatureDataCommand;
use PHPUnit\Framework\TestCase;

class GetTemperatureDataCommandTest extends TestCase {

    /**
     * @test
     * @dataProvider getCelsiusFromBodyDataProvider
     *
     * @param array $testBody
     * @param float $expected
     */
    public function getCelsiusFromBody(array $testBody, float $expected) {
        $actual = GetTemperatureDataCommand::getCelsiusFromBody($testBody);
        $this->assertEquals($expected, $actual);

    }

    /**
     * @test
     * @dataProvider getRelativeHumidityFromBodyDataProvider
     * @param array $testBody
     * @param float $expected
     */
    public function getRelativeHumidityFromBody(array $testBody, float $expected) {
        $actual = GetTemperatureDataCommand::getRelativeHumidityFromBody($testBody);
        $this->assertEquals($expected, $actual);
    }

    public static function getCelsiusFromBodyDataProvider(): array {
        return [
            'missing path'    => [['humidity'=>'blahblah'], 0.0],
            'valid path'      => [['temperature'=>['celsius'=>['value'=> 5.1]]], 5.1],
            'sample response' => [
                [
                    "temperature" => [
                        "celsius"    => [
                            "value"  => 8.0839501953125,
                            "symbol" => "°C",
                        ],
                        "fahrenheit" => [
                            "value"  => 46.551110351562,
                            "symbol" => "°F",
                        ],
                        "rankine"    => [
                            "value"  => 506.22111035156,
                            "symbol" => "°R",
                        ],
                        "kelvin"     => [
                            "value"  => 281.23395019531,
                            "symbol" => "K",
                        ],
                    ],
                    "humidity"    => [
                        "relative" => [
                            "value"  => 44.083160400391,
                            "symbol" => "%RH",
                        ],
                        "dewPoint" => [
                            "celsius"    => [
                                "value"  => -3.3454992943311,
                                "symbol" => "°C",
                            ],
                            "fahrenheit" => [
                                "value"  => 25.978101270204,
                                "symbol" => "°F",
                            ],
                            "rankine"    => [
                                "value"  => 485.6481012702,
                                "symbol" => "°R",
                            ],
                            "kelvin"     => [
                                "value"  => 269.80450070567,
                                "symbol" => "K",
                            ],
                        ],
                    ],
                ], 8.0839501953125
            ]
        ];
    }

    public static function getRelativeHumidityFromBodyDataProvider(): array {
        return [
            'missing path'    => [['temperature'=>'blahblah'], 0.0],
            'valid path'      => [['humidity'=>['relative'=>['value'=> 5.1]]], 5.1],
            'sample response' => [
                [
                    "temperature" => [
                        "celsius"    => [
                            "value"  => 8.0839501953125,
                            "symbol" => "°C",
                        ],
                        "fahrenheit" => [
                            "value"  => 46.551110351562,
                            "symbol" => "°F",
                        ],
                        "rankine"    => [
                            "value"  => 506.22111035156,
                            "symbol" => "°R",
                        ],
                        "kelvin"     => [
                            "value"  => 281.23395019531,
                            "symbol" => "K",
                        ],
                    ],
                    "humidity"    => [
                        "relative" => [
                            "value"  => 44.083160400391,
                            "symbol" => "%RH",
                        ],
                        "dewPoint" => [
                            "celsius"    => [
                                "value"  => -3.3454992943311,
                                "symbol" => "°C",
                            ],
                            "fahrenheit" => [
                                "value"  => 25.978101270204,
                                "symbol" => "°F",
                            ],
                            "rankine"    => [
                                "value"  => 485.6481012702,
                                "symbol" => "°R",
                            ],
                            "kelvin"     => [
                                "value"  => 269.80450070567,
                                "symbol" => "K",
                            ],
                        ],
                    ],
                ], 44.083160400391
            ]
        ];
    }

}
