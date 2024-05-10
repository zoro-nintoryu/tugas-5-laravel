<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            
            'image'=> 'required|image|mimes:png,jpg|max:2048',
            'nama'=>'required|string',
            'berat'=>'required|integer',
            'harga'=>'required|integer',
            'stok'=>'required|integer',
            'kondisi'=>'required',
            'deskripsi'=>'required|string|max:2000',
        ];
    }
    public function messages()
    {
        return [
            'image.required' => 'kolom image wajib di isi.',
            'nama.required' => 'kolom nama wajib di isi.',
            'berat.required' => 'kolom berat wajib di isi.',
            'harga.required' => 'kolom harga wajib di isi.',
            'stok.required' => 'kolom stok wajib di isi.',
            'kondisi.required' => 'kolom kondisi wajib di isi.',
            'deskripsi.required' => 'kolom deskripsi wajib di isi.',
            
            
        ];
    }
}

