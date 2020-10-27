<?php
	$isFavourite = $data->isFavourite;
	$index = (!empty($list))?$list->firstItem() + $key : 0;
 ?>
<article class="row no-gutters {{$isFavourite?'topics-favorite':''}} ">
	@if(empty($hideListCheckBoxIndex))
	<div class="col-lg-1 col-2 order-4 order-lg-1">
		<span class="ml-2">{{$index}}</span>
		<input type="checkbox" 
			name="chk[]" 
			class="float-right mr-3 mt-1 table-checkbox" 
			value="{{$data->article_id}}">
	</div>
	@endif
	<div class="col-lg-8 col-10 order-5 order-lg-2 search-result-text">
		<p class="mb-1 ml-0">
			<?php
				$articleClasses = $data->articleClasses;
			?>
			@foreach($articleClasses as $articleClass)
				<?php $color = Helper::setColorOfArticleClassName($articleClass->article_class_name); ?>
				<span class="category-label category-label0{{$color}}">
					{{$articleClass->article_class_name}}
				</span>
			@endforeach
		</p>
		<h2>
			@if(!$data->not_viewable_flag)
				@include('front.partials._viewable-title', [
					'link' => config('app.wisebook_url')."html/saaj_journal/".$data->wb_book_seq,
					'wrapUp' => $data->wrap_up,
					'title' => $data->title,
					'index' => $index
				])
			@else
				{{$data->title}}
				<span class="badge badge-secondary ml-1">閲覧不可</span>
			@endif
			<?php 
				$isNew = true;
				$readFlag = $data->isRead; 

				$compareTime = strtotime(date('Y-m-d 00:00:00', strtotime('-1 month + 1 day')));
				if( strtotime($data->issue_date) < $compareTime || $readFlag) {
					$isNew = false;
				}
			?>
			@if($isNew)
				<span class="badge badge-danger ml-1">NEW</span>
			@endif
		</h2>
		<p class="m-0">
			<span class="float-left">著者：</span>
			<?php 
				$authors = [];
				$authorName = '';

				if(!empty($data->authors)) {
					$authors = $data->authors;
				}

				foreach($authors as $author) {
					$authorName .= $author->author_name .' ／ ';
				}

			?>
			{{substr($authorName, 0, strrpos($authorName, "／"))}}
			
		</p>
	</div>
	<div class="col-lg-1 col-4 order-1 order-lg-3 offset-2 offset-lg-0 text-lg-center">
		<span class="small">{{date('Y.m.d', strtotime($data->issue_date)) }}</span>
	</div>
	<div class="col-lg-2 col-6 order-2 order-lg-4 text-lg-center">
		<span class="small">
			<?php 
				$bookletClass = $data->bookletClass;
				$bookletClassName = !empty($bookletClass)?$bookletClass->booklet_class_name:'';
			?>
			{{$bookletClassName}}
		</span>
	</div>
</article>