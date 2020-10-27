<?php
	$list = AppData::listPageSize;
?>
<select class="form-control form-control-sm select-paginate" name="page_size">
	@foreach($list as $item)
		<option 
		{{$inputs['page_size'] == $item['value']?"selected":""}} 
		value="{{$item['value']}}">
			{{$item['title']}}
		</option>
	@endforeach
</select>
