<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class SupplierCreatePost extends FormRequest
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
            'bank'=>'required',
            'account'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'供应商名称不能为空！',
            'bank.required'=>'收款银行不能为空！',
            'account.required'=>'收款账号不能为空！'
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
