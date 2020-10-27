<?php 
	$listPeriod = AppData::listPeriod;
?>
<form method="get" action="{{route('front-ranking')}}" class="form-search-articles">
	<div class="row">
		<div class="col-12 col-lg-4">
			<h1 class="h4 my-1 text-white font-weight-bold">
				論稿アクセスランキング
			</h1>
		</div>
		<div class="col-12 col-lg-5">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group">
						<select class="form-control" name="period">
							@foreach($listPeriod as $item)
							<option value="{{$item['value']}}" 
							{{$inputs['period'] == $item['value']?"selected":""}}>
								{{$item['title']}}
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<input type="hidden" name="page_size" value="{{$inputs['page_size']}}">

				<input type="submit" class="form-control" value="検索">
			</div>
		</div>
	</div>
</form>