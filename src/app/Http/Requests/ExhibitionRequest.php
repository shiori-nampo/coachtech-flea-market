<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required','max:255'],
            'image' => ['required','image','mimes:jpeg,png'],
            'condition_id' => ['required','exists:conditions,id'],
            'category_ids' => ['required','array'],
            'category_ids.*' => ['exists:categories,id'],
            'price' => ['required','numeric','min:0'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'image.required' => '商品の画像を選択してください',
            'image.mimes' => 'アップロードできる画像は jpeg または png 形式です',
            'condition_id.required' => '商品の状態を選択してください',
            'category_ids.required' => 'カテゴリーを選択してください',
            'price.required' => '販売価格を入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
            'price.numeric' => '販売価格は数値で入力してください',
        ];
    }
}
