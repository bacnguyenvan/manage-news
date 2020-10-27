<?php
	$select2Class = 'select2';
	if(count($list) >= 40) {
		$select2Class = 'select2-ajax';
	}
	$list = !empty($list)?$list:[];
	$id = !empty($id)?$id:null;
	$name = !empty($name)?$name:'';
	$link = !empty($link)?$link:'';
	$textType = !empty($textType)?$textType:'';
	$class = !empty($class)?$class:'';
?>
<select name="{{$name}}" 
	class="form-control {{$select2Class}} {{$class}}"
	link="{{$link}}"
	data-placeholder=" "
	data-allow-clear="true">
	<option></option>
	@foreach($list as $key => $value)
		<option value="{{$key}}" 
			@if($key == $id)
				selected
			@endif
		>
		@if($textType != '')
			{{$key.$textType.$value}}
		@else
			{{$value}}
		@endif
		</option>
	@endforeach
</select>