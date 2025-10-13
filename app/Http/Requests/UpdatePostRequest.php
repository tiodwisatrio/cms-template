<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postId = $this->route('post')->id ?? $this->route('post');
        
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $postId,
            'content' => 'required|string|min:10',
            'description' => 'nullable|string|max:1000',
            
            // Category harus post category yang aktif
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where(function ($query) {
                    $query->where('type', 'post')->where('is_active', true);
                }),
            ],
            
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'document_files.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            
            'price' => 'nullable|numeric|min:0|max:999999999.99',
            'status' => 'required|in:active,inactive',
            
            'publish_date' => 'nullable|date',
            'event_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            
            'is_featured' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'content.required' => 'Konten artikel wajib diisi.',
            'content.min' => 'Konten minimal 10 karakter.',
            'category_id.required' => 'Kategori artikel wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih harus kategori artikel yang aktif.',
            'slug.unique' => 'Slug sudah digunakan, pilih yang lain.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            
            'featured_image.image' => 'File gambar harus berformat jpeg, png, jpg, gif, atau webp.',
            'featured_image.max' => 'Ukuran gambar maksimal 2MB.',
            'featured_image.mimes' => 'Format gambar yang diizinkan: JPEG, PNG, JPG, GIF, WebP.',
            
            'document_files.*.file' => 'File dokumen tidak valid.',
            'document_files.*.mimes' => 'Format dokumen yang diizinkan: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX.',
            'document_files.*.max' => 'Ukuran file dokumen maksimal 10MB.',
            
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            'price.max' => 'Harga terlalu besar.',
            
            'status.required' => 'Status artikel wajib dipilih.',
            'status.in' => 'Status harus aktif atau tidak aktif.',
            
            'publish_date.date' => 'Format tanggal publikasi tidak valid.',
            'event_date.date' => 'Format tanggal event tidak valid.',
            'deadline.date' => 'Format tanggal deadline tidak valid.',
            'deadline.after' => 'Deadline harus setelah waktu sekarang.',
        ];
    }
}