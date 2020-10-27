<?php 
	if(!empty(old())) {
		$inputs = old();
	}
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
@extends("admin.layouts.app", [
	'topbarTitle' => '検索データ管理'
])
@section("content")
	@include('admin.articles._search-mgt-form', [
		'inputs' => $inputs,
		'errors' => !empty($errorMessages)?$errorMessages:null
	])
	<div class="d-flex justify-content-between align-items-center">
		<div class="mt-2 mb-2">
			<a href="{{route('admin-articles-create')}}" class="btn btn-secondary rounded-0 mr-2">
				新規作成
			</a>
			<a href="javascript:void(0)" 
				class="btn btn-secondary rounded-0 delete-checked-box "
				error-message="検索データが選択されていません。"
				confirm-message="データを削除しますか？<br>※削除したデータは戻せません。"
				link="{{route('admin-articles-ajax-delete')}}"
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
				<th>タイトル</th>
				<th>発行年月日</th>
				<th>掲載頁</th>
				<th>著者</th>
				<th>論稿種別</th>
			</tr>
		</thead>
		<tbody>
			<?php $index = 1; ?>
			@foreach($list as $key => $item)
				<tr>
					<td>{{$list->firstItem() + $key}}</td>
					<td>
						<div class="align-items-center">
							<input type="checkbox" 
								value="{{$item->article_id}}" 
								class="table-checkbox">
							<a href="{{route('admin-articles-edit', [
									'pk' => $item->article_id
								])}}" 
								class="btn btn-sm btn-secondary rounded-0">
								編集
							</a>
						</div>
					</td>
					<td>{{$item->title}}</td>
					<td>{{$item->issue_date}}</td>
					<td>{{$item->page}}</td>
					<?php 
						$authors = '';

						foreach($item->authors as $author) {
							$authors .= $author->author_name." ／ ";
						}
						$authors = trim($authors, '／ ');
					?>
					<td>{{$authors}}</td>
					<?php 
						$articleClasses = '';
						foreach($item->articleClasses as $articleClass) {
							$articleClasses .= $articleClass->article_class_name.' ／ ';
						}
						$articleClasses = substr($articleClasses, 0, strrpos($articleClasses, "／"));
					?>
					<td >{{$articleClasses}}</td>
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