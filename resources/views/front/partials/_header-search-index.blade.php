<form method="get" class="form" action="{{route('front-index')}}">
	<input type="hidden" name="form-type" value="header">
	<div class="row">
		<div class="col-12 col-lg-5">
			<input class="form-control" name="keyword" type="text" placeholder="検索キーワードを入力してください">
		</div>
		<div class="col-12 col-lg-3">
			<?php 
				$types = AppData::indexSearchTypes;
			?>
			<select class="form-control" name="type">
				@foreach($types as $value => $name)
					<option value="{{$value}}">
						{{$name}}
					</option>
				@endforeach
			</select>
		</div>
		<div class="col-12 col-lg-4">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group">
						<?php 
							$fields = AppData::indexSearchFields;
						?>
						<select class="form-control" name="field">
							@foreach($fields as $value => $name)
								<option value="{{$value}}">
									{{$name}}
								</option>
							@endforeach
						</select>
					</div>
				</div>
				<input type="submit" class="form-control" value="検　索">
			</div>
		</div>
	</div>
</form>