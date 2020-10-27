@extends("admin.layouts.app", [
	'topbarTitle' => '検索データ編集'
])
@section('content')
	@include('admin.articles._form', [
		'route' => route('admin-articles-edit', ['pk'=>$data['article_id']]),
		'data' => $data,
		'formType' => 'edit',
	])
@stop












