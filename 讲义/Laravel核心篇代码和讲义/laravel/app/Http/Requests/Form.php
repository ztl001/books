<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class Form extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //授权
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
            //规则
            'username'      =>  'required|min:2|max:10',
            'password'      =>  'required|min:6'
        ];
    }

    public function messages()
    {
        return parent::messages(); // TODO: Change the autogenerated stub
//        return [
//            'username.required'     => '用户名不得为空~',
//            'username.min'          => '用户名不得小于 2 位~',
//            'username.max'          => '用户名不得大于 10 位~',
//            'password.required'     => '密码不得为空~',
//            'password.min'          => '密码不得小于 6 位~',
//        ];
    }

    public function attributes()
    {
        //return parent::attributes(); // TODO: Change the autogenerated stub
        return [
            'username'      =>  '用户名'
        ];
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'username'  =>  'Mr.Lee'
        ]);
    }
}
