<?php 
	if(!empty(old())) {
		$data = array_merge($data, old());
	}
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
<div class="col-12">
	<form action="{{$route}}" class="" method="post">
		@csrf
		
		
		<div class="form-group row">
			<label class="col-2">ユーザーID</label>
			<div class="col-4 p-0">
				<input type="text" name="committee_member_id" value="{{$data['committee_member_id']}}" class="form-control {{!empty($errorMessages['committee_member_id'])?'border-danger':''}}">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-2">ユーザー名</label>
			<div class="col-4 p-0">
				<input type="text" name="committee_member_name" value="{{$data['committee_member_name']}}" class="form-control {{!empty($errorMessages['committee_member_name'])?'border-danger':''}}">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-2">パスワード</label>
			<div class="col-4 p-0">
				<input type="hidden" name="password" class="passwordToSave" >
				<input type="text" id="passwd" placeholder="{{($formType == 'edit')?'＊＊＊＊':''}}" value="" class="form-control {{!empty($errorMessages['password'])?'border-danger':''}}">
			</div>
		</div>

		<div class="form-group row">
			<label class="col-2">連絡先</label>
			<div class="col-4 p-0">
				<input type="text" name="contact_information" value="{{$data['contact_information']}}" class="form-control {{!empty($errorMessages['contact_information'])?'border-danger':''}}">
			</div>
		</div>

		@if($formType =='edit')
		<div class="form-group row">
			<label class="col-2">アカウントロック</label>
			<div class="col-4 p-0">
				<input type="checkbox" {{!empty($data['acount_status'])?"checked":""}} class="acount_status_cb" name="acount_status" value="{{!empty($data['acount_status'])?'1':'0'}}">ロック中
			</div>
		</div>
		@endif

		<div class="form-group row">
			<a href="{{route('admin-committee-member-list')}}" class="btn btn-default mr-2">
				キャンセル
			</a>
			<?php
				$typeText = $formType =='edit'?'更新':'登録'
			?>
			<button type="submit" class="btn btn-admin-color need-confirm"
				confirm-content="データを{{$typeText}}しますか？"
				confirm-type="form-submit"
				confirm-btn-text="{{$typeText}}"
			>
				{{$typeText}}
			</button>
		</div>
	</form>
	
</div>
@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		$(".acount_status_cb").click(function(){
			if($(this).is(":checked")){
				$(this).val(1);
			}else{
				$(this).val(0);
			}
		})
	})

</script>
@stop








