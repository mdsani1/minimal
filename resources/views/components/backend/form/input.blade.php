@props(['name','icon'])
<div class="input-group">
    <input name="{{ $name }}" class="form-control" id="{{ $name }}" placeholder="{{ ucwords(str_replace("_"," ",$name)) }}" {{ $attributes }}>
    <span class="input-group-append">
    <span class="input-group-text right"><i class="{{ $icon ?? '' }}"></i></span>
    </span>
</div>
@error($name)
    <span class="sm text-danger">{{ $message }}</span>
@enderror
