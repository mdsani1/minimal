@props(['name','label','option','select'])
<label for="{{ $name }}" class="form-label">{{ ucwords($label ?? '') }}</label><br>
<select name="{{ $name }}"  class="form-select" style="height: 38px; border:1px solid 	#DCDCDC; border-radius:5px; width:100%;">
    <option value="">Choose... </option>
    @foreach ($option as $key=>$value)
        <option value="{{ $key }}"{{ old($name,$select ?? '')== $key ?'selected':'' }}>{{ $value }}</option>
    @endforeach
    @error($name)
    <span class="sm text-danger">{{ $message }}</span>
    @enderror
</select>
