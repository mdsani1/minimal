@props(['name','label','select'])
<input class="form-check-input" type="checkbox" id="{{ $name }}" name="{{ $name }}" {{ $select ?? '' }} {{ $attributes }}>
<label class="form-check-label" for="gridCheck">{{ $label ??'' }}</label>
@error($name)
    <span class="sm text-danger">{{ $message }}</span>
@enderror