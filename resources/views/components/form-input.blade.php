@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'help' => null,
    'error' => null,
    'options' => [],
    'accept' => null,
    'rows' => 3,
])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)<span class="text-danger">*</span>@endif
        </label>
    @endif

    @if(in_array($type, ['select']))
        <select 
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-control{{ $error ? ' is-invalid' : '' }}"
            {{ $required ? 'required' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }}
        >
            <option value="" disabled {{ old($name, $value) == '' ? 'selected' : '' }}>{{ $placeholder ?: 'Pilih...' }}</option>
            @foreach($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" {{ old($name, $value) == $optValue ? 'selected' : '' }}>
                    {{ $optLabel }}
                </option>
            @endforeach
        </select>
    @elseif(in_array($type, ['textarea']))
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-control{{ $error ? ' is-invalid' : '' }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            rows="{{ $rows }}"
        >{{ old($name, $value) }}</textarea>
    @elseif(in_array($type, ['file']))
        <div class="file-upload-wrapper">
            <input 
                type="{{ $type }}"
                id="{{ $name }}"
                name="{{ $name }}"
                class="form-control file-input{{ $error ? ' is-invalid' : '' }}"
                accept="{{ $accept }}"
                {{ $required ? 'required' : '' }}
                {{ $disabled ? 'disabled' : '' }}
            >
        </div>
    @else
        <input 
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $type !== 'password' ? old($name, $value) : '' }}"
            class="form-control{{ $error ? ' is-invalid' : '' }}"
            placeholder="{{ $placeholder }}"
            autocomplete="{{ $type === 'password' ? 'current-password' : ($type === 'email' ? 'email' : 'on') }}"
            {{ $required ? 'required' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $disabled ? 'disabled' : '' }}
        >
    @endif

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
