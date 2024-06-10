<?php

namespace App\Http\Services;

use App\Models\Business;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class BusinessService
{
    public function create(array $data)
    {
        $business = Business::query()->create($data);

        if (!$business) {
            throw new HttpResponseException(response([
                "errors" => 'Internal Server Error',
            ], 500));
        }

        foreach ($data['categories'] as $categoryData) {
            $category = Category::query()->create([
                'alias' => $categoryData['alias'],
                'title' => $categoryData['title']
            ]);

            if (!$category) {
                $business->delete();
                Log::error("Unable to create category", [
                    'category' => $categoryData,
                    'err' => $category
                ]);

                throw new HttpResponseException(response([
                    "errors" => 'Internal Server Error'
                ], 500));
            }

            $business->categories()->attach($category->id);
        }

        $locationData = $data['location'];
        $locationData['business_id'] = $business->id;

        $createLocation = Location::query()->create($locationData);

        if (!$createLocation) {
            $business->delete();
            Log::error("Unable to create location", [
                'location' => $locationData,
                'err' => $createLocation
            ]);

            throw new HttpResponseException(response([
                "errors" => 'Internal Server Error'
            ], 500));
        }

        return $business->toArray();
    }
}
