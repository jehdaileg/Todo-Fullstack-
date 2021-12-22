<?php

namespace App\Http\Requests;

<<<<<<< HEAD
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
=======
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
>>>>>>> 273c76e723f3073e492d79aa6870cea8e058b769

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
<<<<<<< HEAD
        return true;
=======
        return false;
>>>>>>> 273c76e723f3073e492d79aa6870cea8e058b769
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
<<<<<<< HEAD
=======
            //

>>>>>>> 273c76e723f3073e492d79aa6870cea8e058b769
            'title' => ['required', 'string'],
            'category_id' => ['filled', 'integer', Rule::exists('categories', 'id')]
        ];
    }
}
