<div class="{{ $colSpan ?: '' }}">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 inline mr-1"></i>
        @endif
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if($type === 'textarea')
        <textarea 
            id="{{ $name }}" 
            name="{{ $name }}" 
            rows="{{ $rows }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($name) border-red-500 @enderror">{{ old($name, $value) }}</textarea>
    
    @elseif($type === 'select')
        <select 
            name="{{ $name }}" 
            id="{{ $name }}" 
            @if($required) required @endif
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($name) border-red-500 @enderror">
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    
    @elseif($type === 'checkbox')
        <div class="flex items-center mt-2">
            <input 
                type="checkbox" 
                id="{{ $name }}" 
                name="{{ $name }}" 
                value="1"
                {{ old($name, $value) ? 'checked' : '' }}
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <label for="{{ $name }}" class="ml-2 text-sm text-gray-700">
                {{ $placeholder ?: 'Check this option' }}
            </label>
        </div>
    
    @elseif($type === 'file')
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    @if($accept && str_contains($accept, 'image'))
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    @else
                        <path d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m-16-8l4 4m0 0l4-4m-4 4V14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    @endif
                </svg>
                <div class="flex text-sm text-gray-600">
                    <label for="{{ $name }}" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                        <span>{{ $placeholder ?: 'Upload a file' }}</span>
                        <input 
                            id="{{ $name }}" 
                            name="{{ $multiple ? $name . '[]' : $name }}" 
                            type="file" 
                            @if($accept) accept="{{ $accept }}" @endif
                            @if($multiple) multiple @endif
                            @if($required) required @endif
                            class="sr-only">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                @if($help)
                    <p class="text-xs text-gray-500">{{ $help }}</p>
                @endif
            </div>
        </div>
    
    @else
        <input 
            type="{{ $type }}" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ old($name, $value) }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($accept) accept="{{ $accept }}" @endif
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error($name) border-red-500 @enderror">
    @endif

    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
    
    @if($help && $type !== 'file' && $type !== 'checkbox')
        <p class="mt-1 text-xs text-gray-500">{{ $help }}</p>
    @endif
</div>