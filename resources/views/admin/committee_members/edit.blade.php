@extends("admin.layouts.app", [
	'topbarTitle' => '委員会ユーザー編集'									
])
@section('content')
	@include('admin.committee_members._form', [
		'route' => '',//route('admin-committee-member-edit', ['pk'=>$data['committee_member_id']]),
		'data' => $data,
		'formType' => 'edit',
	])
@stop