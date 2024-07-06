<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,10000',
            'description' => 'required|string|max:120',
            'seasons' => 'required|array',
            'seasons.*' => 'exists:seasons,id',
            'image' => 'image|mimes:jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'name.string' => '商品名は文字列である必要があります。',
            'name.max' => '商品名は最大255文字までです。',

            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0~10000円以内で入力してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',

            'seasons.required' => '季節を選択してください',
            'seasons.array' => '季節の選択は配列形式でなければなりません。',
            'seasons.*.exists' => '選択した季節は存在しません。',

            'image.image' => 'アップロードされたファイルは画像でなければなりません。',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'image.max' => '画像のサイズは2MB以内でなければなりません。',
        ];
    }
}
