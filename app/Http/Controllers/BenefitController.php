<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(Benefit::all()->pluck('name'));
    }
}
