<?php
// app/Http/Requests/StoreProductRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|max:100|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,out_of_stock',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'required_with:specifications|string|max:100',
            'specifications.*.value' => 'required_with:specifications|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'track_stock' => 'boolean',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('type', 'product')->where('is_active', true);
                }),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama produk',
            'price' => 'harga',
            'sale_price' => 'harga diskon',
            'sku' => 'kode produk',
            'stock' => 'stok',
            'min_stock' => 'minimum stok',
            'category_id' => 'kategori',
            'featured_image' => 'gambar utama',
            'gallery_images' => 'galeri gambar',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => 'The selected category must be a valid product category.',
        ];
    }
}