@extends("admin.layouts.app", [
	'topbarTitle' => '委員会ユーザー管理'
])
@section("content")
	
	<div class="d-flex justify-content-between align-items-center">
		<div class="mt-2 mb-2">
			<a href="{{route("admin-committee-member-create")}}" class="btn btn-secondary rounded-0 mr-2">
				新規作成
			</a>
			<a href="javascript:void(0)" 
				class="btn btn-secondary rounded-0 delete-checked-box"
				error-message="削除するユーザーを選択してください。"
				link="{{route('admin-ajax-committee-member-delete')}}"
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
	<table class="table custom-table table-bordered">
		<thead>
			<tr>
				<th></th>
				<th><input type="checkbox" class="table-check-all" value=""></th>
				<th>委員会ユーザーID</th>
				<th>委員会ユーザー名</th>
				<th>連絡先</th>
				<th>アカウント状態</th>
				<th>ユーザー登録日</th>
				<th>最終更新日</th>
			</tr>
		</thead>
		<tbody> 
			@foreach($list as $key => $item)
				<tr>
					<td>{{$list->firstItem() + $key}}</td>
					<td>
						<div class="align-items-center">
							<input type="checkbox" 
								value="{{$item->committee_member_id}}" 
								class="table-checkbox">
							<a href="{{route('admin-committee-member-edit', [
									'pk' => $item->committee_member_id
								])}}" 
								class="btn-sm btn btn-secondary rounded-0">
								編集
							</a>
						</div>
					</td>
					<td >{{$item->committee_member_id}}</td>
					<td >{{$item->committee_member_name}}</td>
					<td >{{$item->contact_information}}</td>
					<td>{{($item->acount_status == "1")?"アカウントロック":""}}</td>
					<td >{{$item->created_at}}</td>
					<td >{{$item->updated_at}}</td>
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