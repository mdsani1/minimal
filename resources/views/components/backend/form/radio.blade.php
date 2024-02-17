@props(['name', 'value'])
<input id="{{ $value }}" type="radio" value="{{ $value }}"  name="{{ $name }}" {{ old($name, $attributes) == $value ?'checked':'' }}>
<label for="{{ $value }}">{{ ucwords($value) }}</label>
@error($name)
<span class="sm text-danger">{{ $message }}</span>
@enderror