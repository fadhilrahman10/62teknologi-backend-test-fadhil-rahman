<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBusinessRequest;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;

class UpdateBusinessController extends Controller
{
    public function __invoke(UpdateBusinessRequest $request, $id)
    {
        $validatedData = $request->all();

        $business = Business::query()->findOrFail($id);

        $business->update();

        $categoriesIds = [];

        foreach ($validatedData['categories'] as $categoryData) {
            $category = Category::firstOrCreate(
                ['alias' => $categoryData['alias']],
                ['title' => $categoryData['title']]
            );
            $categoriesIds[] = $category->id;
        }

        $business->categories()->sync($categoriesIds);

        $locationData = $validatedData['location'];
        $business->location()->update($locationData);

        $response = toResponseApi(true, "Success to Update Business", $business->toArray());

        return response()->json($response);
    }
}
