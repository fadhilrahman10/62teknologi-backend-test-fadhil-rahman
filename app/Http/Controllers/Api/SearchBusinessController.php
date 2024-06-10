<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class SearchBusinessController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Business::query()->with(['categories' => function ($query) {
            $query->select('alias', 'title');
        }, 'location']);

        if ($request->has('term')) {
            $query->where('name', 'like', '%' . $request->input('term') . '%')
                ->orWhere('alias', 'like', '%' . $request->input('term') . '%');
        }

        if ($request->has('location')) {
            $query->whereHas('location', function ($q) use ($request) {
                $q->where('city', 'like', '%' . $request->input('location') . '%');
            });
        }

        if ($request->has('categories')) {
            $categories = explode(',', $request->input('categories'));
            $query->whereHas('categories', function ($q) use ($categories) {
                $q->whereIn('alias', $categories);
            });
        }

        if ($request->has('price')) {
            $query->where('price', $request->input('price'));
        }

        if ($request->has('open_now')) {
            $query->where('is_closed', '!=', $request->input('open_now'));
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->input('sort_by'), 'asc');
        }

        $limit = $request->input('limit', 20);
        $offset = $request->input('offset', 0);

        $businesses = $query->skip($offset)->take($limit)->get();

        $response = $businesses->map(function ($business) {
            $categories = $business->categories->map(function ($category) {
                return [
                    'alias' => $category->alias,
                    'title' => $category->title,
                ];
            });

            return [
                'id' => $business->id,
                'alias' => $business->alias,
                'name' => $business->name,
                'image_url' => $business->image_url,
                'is_closed' => $business->is_closed,
                'url' => $business->url,
                'review_count' => $business->review_count,
                'rating' => $business->rating,
                'price' => $business->price,
                'latitude' => $business->latitude,
                'longitude' => $business->longitude,
                'phone' => $business->phone,
                'display_phone' => $business->display_phone,
                'distance' => $business->distance,
                'categories' => $categories,
                'location' => [
                    'address1' => $business->location?->address1,
                    'address2' => $business->location?->address2,
                    'address3' => $business->location?->address3,
                    'city' => $business->location?->city,
                    'zip_code' => $business->location?->zip_code,
                    'country' => $business->location?->country,
                    'state' => $business->location?->state,
                    'display_address' => $business?->location?->display_address,
                ],
            ];
        });

        return response()->json(toResponseApi(true, 'Success get businesses', $response->toArray()));
    }
}
