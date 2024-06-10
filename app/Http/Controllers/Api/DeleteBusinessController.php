<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class DeleteBusinessController extends Controller
{
    public function __invoke($id)
    {
        $business = Business::query()->findOrFail($id);

        $business->categories()->detach();

        $business->location()->delete();

        $business->delete();

        return response()->json(toResponseApi(true, "Business deleted successfully"));
    }
}
