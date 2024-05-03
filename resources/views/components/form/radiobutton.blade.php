<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <div class="@if(!empty($error)) is-invalid @endif">
        @foreach ($options as $key => $option)
            <label
                class="form-check @if($inline == true) form-check-inline @endif"
            >
                <input
                    type="radio"
                    class="form-check-input"
                    name="{{ $name }}"
                    id="{{ $id }}"
                    value="{{ $key }}"
                    @if($key == $value) checked="checked" @endif
                />
                <span class="form-check-label">{{ $option }}</span>
            </label>
        @endforeach
    </div>

    @if (! empty($error))
        <div class="invalid-feedback">{{ $error }}</div>
    @endif
</div>
