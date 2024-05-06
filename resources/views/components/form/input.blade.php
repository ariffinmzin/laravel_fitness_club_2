<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input
        name="{{ $name }}"
        type="{{ $type }}"
        class="form-control @if(!empty($error)) is-invalid @endif"
        id="{{ $id }}"
        value="{{ $value }}"
        @if(isset($readonly)) readonly @endif
        @if(isset($disabled)) disabled @endif
    />
    @if (! empty($error))
        <div class="invalid-feedback">{{ $error }}</div>
    @endif
</div>
