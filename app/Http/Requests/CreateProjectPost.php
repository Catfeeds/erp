<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class CreateProjectPost extends FormRequest
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
//            'project'=>'required|array',
//            'project.*'=>'required',
//            'project.name'=>'required|string',
//            'project.createTime'=>'required|string',
//            'project.partyA'=>'required|string',
//            'project.price'=>'required|numeric',
//            'project.condition'=>'required|string',
//            'project.pm'=>'required|string',
//            'project.finishTime'=>'required|string',
//            'mainContracts'=>'required|array',
//            'mainContracts.*'=>'required',
//            'mainContracts.*.unit'=>'required|distinct|string',
//            'mainContracts.*.price'=>'required|numeric',
//            'mainContracts.*.remark'=>'string',
//            'outContracts'=>'required|array',
//            'outContracts.*'=>'required',
//            'outContracts.*.unit'=>'required|distinct|string',
//            'outContracts.*.price'=>'required|numeric',
//            'outContracts.*.remark'=>'string',
            'situations'=>'required|array',
            'situations.*'=>'required',
            'situations.*.price'=>'required|numeric',
            'situations.*.type'=>'required|numeric',
            'situations.*.is_main'=>'required|numeric',
            'situations.*.lists'=>'required|array',
            'situations.*.lists.*'=>'required',
            'situations.*.lists.*.name'=>'required|string',
            'situations.*.lists.*.tax'=>'required|string',
            'situations.*.lists.*.price'=>'required|numeric',
            'situations.*.lists.*.remark'=>'string',
            'bails'=>'required|array',
            'bails.*'=>'required',
            'bails.*.unit'=>'required|string',
            'bails.*.price'=>'required',
            'bails.*.lists.*'
        ];
    }
    public function messages()
    {
        return [
//            'project.required'=>'项目信息不能为空！',
//            'project.name.required'=>'项目名称不能为空！',
//            'project.createTime.required'=>'项目立项时间不能为空！',
//            'project.partyA.required'=>'项目甲方不能为空！',
//            'project.price.required'=>'项目金额不能为空！',
//            'project.price.numeric'=>'项目金额必须为数字！',
//            'project.condition.required'=>'项目维护条件不能为空！',
//            'project.pm.required'=>'项目经理不能为空！',
//            'project.finishTime.required'=>'项目预计完工时间不能为空！',
//            'mainContracts.required'=>'合同中标情况不能为空！',
//            'mainContracts.*.unit.required'=>'发包单位不能为空！',
//            'mainContracts.*.unit.distinct'=>'发包单位不能重复！',
//            'mainContracts.*.price.required'=>'发包金额不能为空！',
//            'outContracts.required'=>'分包合同不能为空',
//            'outContracts.*.unit.required'=>'分包单位不能为空！',
//            'outContracts.*.unit.distinct'=>'分包单位不能重复！',
//            'outContracts.*.price.required'=>'分包金额不能为空！',
            'situations.required'=>'项目实际情况不能为空！',
            'situations.*.price.required'=>'项目金额不能为空',
            'situations.*.price.numeric'=>'项目金额必须为数字！',
            'situations.*.type.required'=>'项目类型不能为空！',
            'situations.*.type.numeric'=>'项目类型必须为数字！',
            'situations.*.lists.required'=>'项目实际情况内容不能为空',
            'situations.*.lists.*.name.required'=>'项目实际情况内容名称不能为空',
            'situations.*.lists.*.name.string'=>'项目实际情况内容名称格式错误',
            'situations.*.lists.*.tax.required'=>'项目实际情况内容税率不能为空',
            'situations.*.lists.*.tax.string'=>'项目实际情况内容税率格式错误',
            'situations.*.lists.*.price.required'=>'项目实际情况内容价格不能为空',
            'situations.*.lists.*.price.numeric'=>'项目实际情况内容价格格式错误',
            'situations.*.lists.*.remark.string'=>'项目实际情况内容备注格式错误',
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
