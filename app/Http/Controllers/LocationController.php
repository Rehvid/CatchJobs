<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\Location\GetRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function get(GetRequest $request): JsonResponse
    {
        return response()->json(
            Location::find($request->validated())->first()
        );
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
