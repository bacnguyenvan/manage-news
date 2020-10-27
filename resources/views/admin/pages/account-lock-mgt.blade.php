<?php 
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
@extends('admin.layouts.app', [
	'topbarTitle' => 'アカウントロック管理'
])
@section('content')
<div class="col-12">
	<form method="post" action="{{route('admin-account-lock-mgt')}}">
		@csrf
		<span>アカウソトロックの回数を設定してください。</span>
		<div class="row">
			<span class="col-2">ログインエラー上限回数</span>
			<?php
				$value = !empty($data['error_max_count'])?$data['error_max_count']:'';
				if(!empty(old())) {
					$value = old('error_max_count');
				}
			?>
			<input type="text" 
				name="error_max_count" 
				class="col-1 form-control
				{{!empty($errorMessages['error_max_count'])?'border-danger':''}}" 
				value="{{$value}}">
		</div>
		<div class="row col-12">
			<button type="submit" class="btn btn-admin-color">
				設定
			</button>
		</div>
	</form>
</div>
@stop