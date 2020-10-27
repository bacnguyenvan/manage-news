<?php
	$id = !empty($data['id'])?$data['id']:'';
	$keyword = !empty($data['keyword'])?$data['keyword']:'';
?>
<div class="keyword-item" data-id="{{$id}}">
	<span class="title">{{$keyword}}</span>
	<input type="hidden" name="" value="">
	<a href="javascript:void(0)" class="remove-keyword ml-1 text-dark">
		<i class="fas fa-backspace"></i>
	</a>
</div>