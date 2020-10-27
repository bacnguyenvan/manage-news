<?php
	$text = !empty($text)?$text:'';
	$id = !empty($id)?$id:'';
?>
<div class="d-flex align-items-center added-author">
	<span class="title">{{$text}}</span>
	<a href="javascript:void(0)" class="remove-author ml-1 text-dark">
		<i class="fas fa-backspace"></i>
	</a>
	<input type="hidden" name="author_id[]" value="{{$id}}">
</div>