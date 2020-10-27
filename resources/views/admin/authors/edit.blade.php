<?php 
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
@extends("admin.layouts.app", [
	'topbarTitle' => '著者マスタ編集'
])
@section('content')
<div class="col-12">
	<form method="post" 
		action="{{route('admin-authors-edit', ['pk' => $data['author_id']])}}"  
		autocomplete="off">
		@csrf
		<div class="form-group row">
			<label class="col-2">著者名</label>
			<input type="text" 
				name="author_name" 
				class="form-control col-4 
				{{!empty($errorMessages['author_name'])?'border-danger':''}}" 
				value="{{$data['author_name']}}">
		</div>
		<div class="form-group row">
			<label class="col-2">著者読みがな</label>
			<input type="text" 
				name="author_phonetic" 
				class="form-control col-4
				{{!empty($errorMessages['author_phonetic'])?'border-danger':''}}" 
				value="{{$data['author_phonetic']}}">
		</div>
		<div class="row col-12 mt-2">
			<a href="{{route('admin-authors-list')}}" class="btn btn-default mr-2">
				キャンセル
			</a>
			<button type="submit" class="btn btn-admin-color need-confirm"
				confirm-content="データを更新しますか？"
				confirm-type="form-submit"
				confirm-btn-text="更新"
			>
				更新
			</button>
		</div>
	</form>
</div>
@stop












