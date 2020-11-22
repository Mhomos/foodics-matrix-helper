<?php

namespace Tests\Unit;

use Tests\TestCase;

class MatrixOperationsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMultiplyOperationTest()
    {
        $data = [
            'operation' => 'multiply',
            'matrices' => [
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9],
                ],
                [
                    [1, 2, 3],
                    [4, 5, 6],
                    [7, 8, 9],
                ],
            ],
        ];

        $result = [
            "1" => ["A" => 30, "B" => 36, "C" => 42],
            "2" => ["A" => 66, "B" => 81, "C" => 96],
            "3" => ["A" => 102, "B" => 126, "C" => 150],
        ];

        $this->post(route('matrix.calculate'), $data)->assertStatus(200)->assertJson($result);
    }
}
