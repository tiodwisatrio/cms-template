@extends('layouts.dashboard')

@section('header')
    Create About Page
@endsection

@section('content')
<x-forms.crud-form 
    title="Create About Page"
    :action="route('abouts.store')"
    method="POST"
    submit-text="Save About"
    :cancel-url="route('abouts.index')"
    enctype="multipart/form-data">

    <!-- Basic Information Section -->
    <x-forms.form-section title="About Information">
        <div class="grid grid-cols-1 gap-6">
            <x-forms.form-input 
                name="title"
                label="Title"
                icon="type"
                placeholder="Enter about title"
                :required="true" />

            <x-forms.form-input 
                name="content"
                label="Content"
                type="textarea"
                icon="file-text"
                placeholder="Write about page content..."
                :rows="6"
                :required="true"
                help="You can use basic formatting or a WYSIWYG editor if integrated." />
        </div>
    </x-forms.form-section>

    <!-- Image Upload Section -->
    <x-forms.form-section title="Featured Image (Optional)">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <x-forms.form-input 
                    name="image"
                    label="Featured Image"
                    type="file"
                    icon="image"
                    accept="image/*"
                    placeholder="Upload an image for the About page"
                    help="PNG, JPG, or GIF up to 2MB" />

                <!-- Image Preview -->
                <div class="mt-4 hidden relative" id="image-preview-container">
                    <p class="text-sm text-gray-600 mb-2 font-medium">Image Preview:</p>
                    <button type="button" id="remove-preview" class="absolute top-0 right-0 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">
                        ×
                    </button>
                    <img id="image-preview" src="#" alt="Preview" class="max-h-48 rounded-lg border border-gray-200 shadow-sm">
                </div>
            </div>
        </div>
    </x-forms.form-section>

</x-forms.crud-form>
@endsection

@push('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Image Preview Functionality
    document.addEventListener("DOMContentLoaded", function () {
        const imageInput = document.querySelector('input[name="image"]');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        const removeBtn = document.getElementById('remove-preview');

        if (imageInput) {
            // Show preview when file selected
            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImage.src = event.target.result;
                        previewContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = '#';
                    previewContainer.classList.add('hidden');
                }
            });

            // Remove preview & reset file input
            removeBtn.addEventListener('click', function () {
                imageInput.value = '';
                previewImage.src = '#';
                previewContainer.classList.add('hidden');
            });
        }
    });
</script>
@endpush
