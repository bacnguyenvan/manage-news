@extends("admin.layouts.app", [
	'topbarTitle' => '検索データ登録' 
])
@section('content')
	@include('admin.articles._form', [
		'route' => route('admin-articles-create'),
		'data' => $data,
		'formType' => 'create',
	])
@stop












