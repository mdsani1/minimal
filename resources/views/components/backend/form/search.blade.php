@props(['name'])
<div class="d-flex justify-content-end">
<input name="{{ $name }}" class="form-control" id="{{ $name }}" {{ $attributes }}>
@error($name)
<span class="small text-danger">{{ $message }}</span>
@enderror
</div>