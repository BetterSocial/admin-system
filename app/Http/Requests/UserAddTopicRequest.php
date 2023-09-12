<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use JsonException;
use RealRashid\SweetAlert\Facades\Alert;

class UserAddTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'not_regex:/[&\s]/',
            ],
            'sort' => 'required|integer',
            'category' => '',
            'file' => [
                'nullable',
                'image',
                'dimensions:ratio=1/1,min_width=400,min_height=400,max_width=1500,max_height=1500',
            ],


        ];
    }
}
