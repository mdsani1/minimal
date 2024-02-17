@props(['name'])
<label for="{{ $name }}">{{ ucwords(str_replace("_"," ",$name)) }}</label>
<textarea name="{{ $name }}" class="form-control" placeholder="{{ ucwords(str_replace("_"," ",$name)) }}" id="{{ $name }}">
{{ $slot ?? old($name) }}
</textarea>
@error($name)
<span class="small text-danger">{{ $message }}</span>
@enderror