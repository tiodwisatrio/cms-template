# Generic CRUD Form Components

Sistem ini menyediakan komponen form yang dapat digunakan kembali untuk berbagai fitur CRUD.

## Komponen Utama

### 1. `<x-forms.crud-form>`

Wrapper utama untuk form dengan header, error handling, dan action buttons.

**Props:**

-   `title` - Judul form
-   `action` - URL action form
-   `method` - HTTP method (POST, PUT, etc.)
-   `submit-text` - Text tombol submit
-   `cancel-url` - URL untuk tombol cancel
-   `enctype` - Encoding type (opsional, untuk file upload)
-   `model` - Model untuk edit form (opsional)

### 2. `<x-forms.form-section>`

Membuat section form dengan border dan judul.

**Props:**

-   `title` - Judul section
-   `description` - Deskripsi section (opsional)

### 3. `<x-forms.form-input>`

Input field yang mendukung berbagai tipe input.

**Props:**

-   `name` - Nama field
-   `label` - Label field
-   `type` - Tipe input (text, textarea, select, checkbox, file, dll)
-   `value` - Value default
-   `placeholder` - Placeholder text
-   `required` - Apakah wajib diisi (boolean)
-   `icon` - Icon Lucide
-   `help` - Teks bantuan
-   `options` - Array options untuk select
-   `rows` - Jumlah baris untuk textarea
-   `accept` - File types untuk input file
-   `multiple` - Multiple files (boolean)
-   `col-span` - CSS class untuk column span

## Contoh Penggunaan

### Form Posts

```blade
<x-forms.crud-form
    title="Create New Post"
    :action="route('posts.store')"
    method="POST"
    submit-text="Save Post"
    :cancel-url="route('posts.index')"
    enctype="multipart/form-data">

    <x-forms.form-section title="Basic Information">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-forms.form-input
                name="title"
                label="Post Title"
                icon="type"
                placeholder="Enter post title"
                :required="true"
                col-span="lg:col-span-2" />

            <x-forms.form-input
                name="category_id"
                label="Category"
                type="select"
                icon="folder"
                :options="$categories->pluck('name', 'id')"
                :required="true" />
        </div>
    </x-forms.form-section>

    <x-forms.form-section title="Media">
        <x-forms.form-input
            name="featured_image"
            label="Featured Image"
            type="file"
            icon="image"
            accept="image/*" />
    </x-forms.form-section>

</x-forms.crud-form>
```

### Form Products

```blade
<x-forms.crud-form
    title="Create New Product"
    :action="route('products.store')"
    submit-text="Save Product"
    :cancel-url="route('products.index')">

    <x-forms.form-section title="Product Information">
        <x-forms.form-input
            name="name"
            label="Product Name"
            icon="package"
            :required="true" />

        <x-forms.form-input
            name="price"
            label="Price"
            type="number"
            icon="dollar-sign"
            :required="true" />
    </x-forms.form-section>

</x-forms.crud-form>
```

## Keuntungan

1. **Reusable** - Satu template untuk semua form CRUD
2. **Consistent** - Desain dan behavior yang konsisten
3. **Maintainable** - Update di satu tempat, berlaku untuk semua
4. **Flexible** - Bisa disesuaikan untuk berbagai kebutuhan
5. **Clean Code** - Kode lebih bersih dan mudah dibaca

## Tipe Input yang Didukung

-   `text` - Input text biasa
-   `textarea` - Text area
-   `select` - Dropdown select
-   `checkbox` - Checkbox
-   `file` - File upload
-   `date` - Date picker
-   `number` - Number input
-   `email` - Email input
-   `password` - Password input

## Customization

Anda bisa menambahkan tipe input baru atau memodifikasi yang ada di file:

-   `app/View/Components/Forms/FormInput.php`
-   `resources/views/components/forms/form-input.blade.php`
