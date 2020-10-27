<?php 
	if(!empty(old())) {
		$inputs = old();
	}
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
@extends("admin.layouts.app", [
	'topbarTitle' => '著者マスタ'
])
@section("content")
	<div class="search-container">
	<p class="mb-2">絞り込み条件</p>
	<div class="search-form border-gray w-100 border p-2">
		<form action="{{route('admin-authors-list')}}" method="post">
			@csrf
			<div class="row mb-2">
				<div class="col-4 row align-items-center">
					<span class="col-4">著者名</span>
					<input type="text" 
						name="author_name" 
						value="{{$inputs['author_name']}}"
						autocomplete="off" 
						class="form-control rounded-0 col-8 
						@if(!empty($errorMessages['author_name']))
							border-danger
						@endif"/>
				</div>
				<div class="col-2">
					<button type="submit" class="btn btn-secondary">絞り込み</button>
				</div>
			</div>
		</form>
	</div>
	<div class="d-flex justify-content-between align-items-center">
		<div class="mt-2 mb-2">
			<a href="{{route('admin-authors-create')}}" class="btn btn-secondary rounded-0 mr-2">
				新規作成
			</a>
			<a href="javascript:void(0)" 
				class="btn btn-secondary rounded-0 delete-checked-box"
				error-message="削除する著者を選択してください。"
				link="{{route('admin-authors-ajax-delete')}}"
				confirm-message="データを削除しますか？<br>※削除したデータは戻せません。"
			>
				削除
			</a>
		</div>
		@include('admin.shared._pagination', [
			'paginator' => $list,
			'paginate' => AppData::defaultPaginate
		])
	</div>
	<table class="table custom-table table-bordered table-responsive-xl">
		<thead>
			<tr>
				<th></th>
				<th><input type="checkbox" class="table-check-all" value=""></th>
				<th>著者名</th>
				<th>著者読みがな</th>
				<th>登録日</th>
				<th>更新日</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($list as $key => $item)
				<tr>
					<td>{{$list->firstItem() + $key}}</td>
					<td>
						<div class="align-items-center">
							<input type="checkbox" 
								value="{{$item->author_id}}" 
								class="table-checkbox">
							<a href="{{route('admin-authors-edit', [
									'pk' => $item->author_id
								])}}" 
								class="btn btn-sm btn-secondary rounded-0">
								編集
							</a>
						</div>
					</td>
					<td>{{$item->author_name}}</td>
					<td>{{$item->author_phonetic}}</td>
					<td>{{date('Y/m/d', strtotime($item->created_at))}}</td>
					<td>{{date('Y/m/d', strtotime($item->updated_at))}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
	
	<div class="d-flex justify-content-end align-items-center">
		@include('admin.shared._pagination', [
			'paginator' => $list,
			'paginate' => AppData::defaultPaginate
		])
	</div>
@stop