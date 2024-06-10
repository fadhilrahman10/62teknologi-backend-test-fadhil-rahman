<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBusinessRequest;
use App\Http\Services\BusinessService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CreateBusinessController extends Controller
{
    public  BusinessService $service;
    public function __construct(BusinessService $service)
    {
        $this->service = $service;
    }

    public function __invoke(CreateBusinessRequest $request)
    {
        try {
            $validatedData = $request->all();

            $business = $this->service->create($validatedData);

            $response = toResponseApi(true,
                'Success create Business',
                $business,
            );

            return response()->json($response, 201);

        } catch (\Exception $e) {
            Log::error("An unexpected error occurred: {$e->getMessage()}");
            return response()->json(
                toResponseApi(false, "An unexpected error occurred."),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
