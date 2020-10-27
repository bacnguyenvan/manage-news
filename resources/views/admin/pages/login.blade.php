@extends('admin.layouts.app')
@section('login-container')

<div class="login-page admin-container">
	<div class="login-container">
		<h3 class="login-title">証券アナリストジャーナル​新検索システム</h3>
		<div class="login-box">
			<div class="login-box-body">
				@if(!empty($errors))
					@foreach($errors as $key => $messages)
						<p class="text-danger">{{$messages[0]}}</p>
					@endforeach
				@endif
				<form action="{{route('admin-login')}}" method="post" id="loginForm">
					<div class="input-group mb-3 rounded
						{{
							!empty($errors['admin_user_id'])
							? 'input-error'
							: ''
						}}
					">
						<div class="input-group-prepend">
							<span class="input-group-text">ID</span>
						</div>
						<input name="admin_user_id" type="text" class="form-control" placeholder="ユーザーID" value="{{$inputs['admin_user_id']}}">	
					</div>
					<div class="input-group mb-3 rounded
						{{
							!empty($errors['password'])
							? 'input-error'
							: ''
						}}
					">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fas fa-lock"></i>
							</span>
						</div>
						<input name="password" type="password" class="form-control" placeholder="パスワード">
					</div>
					{!! csrf_field() !!}
					<div class="row">
						<!-- /.col -->
						<div class="col-12 text-center">
							<button type="submit" class="">ログイン</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

