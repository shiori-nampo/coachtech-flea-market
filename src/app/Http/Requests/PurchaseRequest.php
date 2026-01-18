<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;


class PurchaseRequest extends FormRequest
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
        return [];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = auth()->user();
            $product = Product::find($this->route('item_id'));


            if (!session()->has("payment_method_{$product->id}")) {
                $validator->errors()->add(
                    'payment_method',
                    '支払い方法を選択してください'
                );
            }

            $hasSessionAddress =
                session()->has("postal_code_{$product->id}") &&
                session()->has("address_{$product->id}");

            $hasUserAddress =
            !empty($user->postal_code) &&
            !empty($user->address);

            if (
                !($hasSessionAddress || $hasUserAddress)) {
                    $validator->errors()->add(
                        'address',
                        '配送先を選択してください',
                );
            }
        });
    }

    protected function getRedirectUrl()
    {
        return route('purchase.show',$this->route('item_id'));
    }
}
