<?php 
	$relatedKeywords = $gssData['related_words'];
?>
@extends('front.layouts.app')
@section('content')
<div class="container">
	<div class="row">
		@include('front.shared._sidebar', [
			'gssData' => $gssData
		])
		<main id="main-area" class="col-12 col-lg-9 order-2 order-lg-2 mb-4">
			@include('front.partials._form-search-detail')
			<form>
				<section class="card card-primary rounded-0 my-2">
					<div class="card-body py-2">
						<p class="small m-0">関連キーワード：　
							@foreach($relatedKeywords as $keyword)
								<a href="javascript:void(0)">{{$keyword}}</a>
								&nbsp;
							@endforeach
					</div>
				</section>
				@include('front.partials._form-search',[
					'gssData' => $gssData
				])
			</form>
			@include('front.partials._search-result-title-index')
			<section id="search-result" class="card rounded-0 mb-2">
				<div class="py-2">
					@foreach($list as $key => $item)
						@include('front.partials._article-item', [
							'data' => $item,
						])
						<hr />
					@endforeach
				</div>
			</section>
			<!-- btn export csv and big size pagination -->
			@include('front.partials._list-article-bottom')
		</main>
	</div>
</div>
@stop








