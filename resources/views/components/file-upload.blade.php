@props([
    'name',
    'label' => null,
    'accept' => 'application/pdf',
    'required' => false,
    'help' => null,
    'error' => null,
    'multiple' => false,
])

<div class="form-group">
    @if($label)
        <label class="form-label">
            {{ $label }}
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif
    
    <div class="file-upload-area{{ $error ? ' is-invalid' : '' }}">
        <input 
            type="file"
            id="{{ $name }}"
            name="{{ $multiple ? $name . '[]' : $name }}"
            class="file-input"
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            {{ $multiple ? 'multiple' : '' }}
        >
        <div class="file-upload-content">
            <div class="file-upload-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
            </div>
            <p class="file-upload-text">Klik untuk upload atau drag & drop</p>
            <p class="file-upload-hint">PDF maksimal 2MB</p>
        </div>
    </div>

    @if($help)
        <small class="form-help">{{ $help }}</small>
    @endif

    @if($error)
        <div class="form-error">{{ $error }}</div>
    @endif

    @error($name)
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
