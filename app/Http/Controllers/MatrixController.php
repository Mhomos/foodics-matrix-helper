<?php

namespace App\Http\Controllers;

use App\Http\Services\MatrixCalculatorService;
use Illuminate\Http\Request;

class MatrixController extends Controller
{
    /**
     * @var MatrixCalculatorService
     */
    private $matrixService;

    public function __construct(MatrixCalculatorService $matrixService)
    {
        $this->matrixService = $matrixService;
    }

    /**
     * Calculate Matrices Operation
     * Apply operation on matrices and return the result data structured as Excel Sheet
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculate(Request $request)
    {
        $result = $this->matrixService
            ->validateRequest()
            ->initOperation()
            ->getResult();

        return response()->json($result);
    }
}
