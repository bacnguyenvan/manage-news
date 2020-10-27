<?php
	$errorMessages = [];
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>

@extends("admin.layouts.app", [
	'topbarTitle' => '関連キーワード編集'
])
@section("content")
	<div class="col-12">
	<form action="{{route('admin-topics-keywords', ['pk' => $data['topics_id']])}}" class="" method="post" autocomplete="off">
		@csrf
		<div class="form-group row">
			<label class="col-2">トピックス名</label>
			<span>{{$data['topics_name']}}</span>
		</div>
		<div class="form-group row">
			<label class="col-2">現在の表示順</label>
			<span>{{$data['display_order']}}</span>
		</div>
		<div class="form-group row">
			<label class="col-2">カットライン</label>
			<span>{{$data['cutline']}}</span>
		</div>
		<div class="form-group row">
			<label class="col-2">関連キーワード</label>
			<div class="col-4 p-0 row">
				<input type="text" 
				name="" 
				class="form-control col-6 keyword-input
				{{!empty($errorMessages['keywords'])?'border-danger':''}}"
				value="">
				<div class="col-6">
					<a href="javascript:void(0)" 
						class="btn btn-admin-color add-keyword"
						link="{{route('admin-topics-ajax-validate-keyword')}}">
						追加
					</a>
				</div>
				<div class="col-12 list-keywords p-0 mt-1">
					@if(!empty($data['keywords']))
						@foreach($data['keywords'] as $keyword)
							@include('admin.topics._keyword-item', [
								'data' => $keyword
							])
						@endforeach
					@endif
					
				</div>
			</div>
		</div>
		<div class="form-group row">
			<a href="{{route('admin-topics-list')}}" class="btn btn-default mr-2">
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
	<div class="d-none needed-html">
		@include('admin.topics._keyword-item', [
			'data' => []
		])
	</div>
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		$('.add-keyword').on('click', function() {
			let html = $('.needed-html').find('.keyword-item').clone();
			let input = $('.keyword-input');
			let link = $(this).attr('link');
			let value = input.val();
			$.ajax({
				url: link,
				method: "post",
				data: JSON.stringify({keyword: value}),
				headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			        'content-type': "application/json"
			    },
			    success: function() {
			    	html.find('.title').text(value);
					html.find("input[type=hidden]").val(value);
					html.find("input[type=hidden]").attr('name', 'new[]');
					$('.list-keywords').append(html);
					input.val('');
					if(input.hasClass('border-danger')) {
						input.removeClass('border-danger');
					}
			    },
			    error: function(response) {
			    	let json = response.responseJSON;
			    	if(json.errorMessage != '') {
			    		window.showMessage(json.errorMessage, 'text-danger');
			    		if(!input.hasClass('border-danger')) {
							input.addClass('border-danger');
						}
			    	}
			    }
			})
		})

		$(document).on('click', '.remove-keyword', function() {
			let _this = $(this);
			let parent = _this.parents('.keyword-item');
			let id = parent.data('id');
			if(id != '') {
				$('.list-keywords').append($('<input>', {
				    value: id,
				    type: 'hidden',
				    name: 'remove[]'
				}));
			}
			parent.remove();
		})
	})
</script>
@stop








