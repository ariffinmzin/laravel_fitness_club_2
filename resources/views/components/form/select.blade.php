<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        class="form-select @if(!empty($error)) is-invalid @endif"
    >
        <!-- <option value="1 day">1 day</option>
        <option value="1 week">1 week</option>
        <option value="1 month">1 month</option>
        <option value="3 months">3 months</option>
        <option value="6 months">6 months</option>
        <option value="1 year">1 year</option> -->

        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @if($value == $key) selected @endif>
                {{ $option }}
            </option>
        @endforeach
    </select>

    @if (! empty($error))
        <div class="invalid-feedback">{{ $error }}</div>
    @endif
</div>
