<div class="search-container">
	<p class="mb-2">絞り込み条件</p>
	<div class="search-form border-gray w-100 border p-2">
		<form action="{{route('admin-articles-list')}}" method="get">
			{{-- @csrf --}}
			<div class="row mb-2">
				<div class="col-4 row align-items-center">
					<span class="col-4">タイトル</span>
					<input type="text" 
						name="title" 
						value="{{$inputs['title']}}"
						autocomplete="off" 
						class="form-control rounded-0 col-8"/>
				</div>
				<div class="col-3 row align-items-center">
					<span class="col-4">著者</span>
					<div class="col-8 p-0">
						@include('admin.partials._select2', [
							'list' => $authors,
							'id' => $inputs['author_id'],
							'name' => 'author_id',
							'link' => route('admin-authors-ajax-search'),
							'textType' => ' ',
						])
					</div>
					
				</div>
				<div class="col-3 row align-items-center">
					<span class="col-5">論稿種別</span>
					<div class="col-7 p-0">
						@include('admin.partials._select2', [
							'list' => $articleClasses,
							'id' => $inputs['article_class_id'],
							'name' => 'article_class_id',
							'textType' => ' ',
							'link' => route('admin-article-classes-ajax-search'),
						])
					</div>
				</div>
				<div class="col-2 text-center align-items-center">
					<button type="submit" class="btn btn-secondary">絞り込み</button>
				</div>
			</div>
			<div class="row">
				<div class="col-4 row align-items-center">
					<span class="col-4">発行年月</span>
					<input type="text" 
						autocomplete="off"
						name="from" 
						placeholder="YYYY/MM" 
						value="{{$inputs['from']}}"
						class="form-control rounded-0 col-3 date-of-issue datepicker-month
						{{!empty($errors['from'])?'input-error':''}}
						"/>
					<span class="col-2 text-center">～</span>
					<input type="text" 
						autocomplete="off"
						name="to" 
						placeholder="YYYY/MM"
						value="{{$inputs['to']}}"
						class="form-control rounded-0 col-3 date-of-issue datepicker-month
						{{!empty($errors['to'])?'input-error':''}}
						"/>
				</div>
				
				<div class="col-3 row align-items-center">
					<span class="col-4 ">検索可</span>
					<input type="hidden" name="search_target_flag" value="0"/>
					<input type="checkbox" name="search_target_flag" value="1"
						@if(!empty($inputs['search_target_flag']))
							checked='checked'
						@endif
					/>
					<span class="col-4 align-self-center">閲覧不可</span>	
					<input type="hidden" name="not_viewable_flag" value="0"/>
					<input type="checkbox" name="not_viewable_flag" value="1"
						@if(!empty($inputs['not_viewable_flag']))
							checked='checked'
						@endif
					/>
				</div>

			</div>
		</form>
	</div>
</div>




