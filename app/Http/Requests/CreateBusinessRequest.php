<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'alias' => 'required|string|unique:businesses,alias|max:255',
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:255',
            'is_closed' => 'required|boolean',
            'url' => 'required|string|max:255',
            'review_count' => 'required|integer',
            'rating' => 'required|numeric',
            'price' => 'nullable|string|max:10',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phone' => 'required|string|max:20',
            'display_phone' => 'required|string|max:20',
            'distance' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*.alias' => 'required|string|unique:categories,alias|max:255',
            'categories.*.title' => 'required|string|max:255',
            'location' => 'required|array',
            'location.address1' => 'required|string|max:255',
            'location.address2' => 'nullable|string|max:255',
            'location.address3' => 'nullable|string|max:255',
            'location.city' => 'required|string|max:100',
            'location.zip_code' => 'required|string|max:20',
            'location.country' => 'required|string|max:10',
            'location.state' => 'required|string|max:10',
            'location.display_address' => 'nullable|array|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
