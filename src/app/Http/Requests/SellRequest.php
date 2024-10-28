<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
        $rules = [
            'img_url' => 'required|image',
            'category_id' => 'required',
            'condition_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|regex:/^\d{1,3}(,\d{3})*$/',
        ];

        if ($this->route('item_id')) {
            $rules['img_url'] = 'image';
        }

        return $rules;
    }
    
    public function messages()
    {
        return [
            'img_url.required' => '画像を選択してください',
            'img_url.image' => '画像を選択してください',
            'category_id.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'price.required' => '販売価格を半角数字で入力してください',
            'price.regex' => '販売価格を半角数字で入力してください',
        ];
    }        
}
