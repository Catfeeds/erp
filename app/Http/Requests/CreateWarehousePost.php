<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class CreateWarehousePost extends FormRequest
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
    public function rules()
    {
        return [
            //
            'name'=>'required',
            'address'=>'required',
            'admin'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'名称不能为空！',
            'address.required'=>'地址不能为空！',
            'admin.required'=>'管理员不能为空！'
        ];
    }

    public function formatErrors(Validator $validator)
    {
        $message = $validator->errors()->first();
        return [$message];
    }
    public function response(array $errors)
    {
        return new JsonResponse([
            'return_msg'=>$errors[0],
            'return_code'=>'FAIL']);
    }
}
