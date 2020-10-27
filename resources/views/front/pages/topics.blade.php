@extends('front.layouts.app')
@section('title','トピックス検索｜証券アナリストジャーナル検索')
@section('content')
<?php 
	$topicId = (!empty($topic)?$topic->topics_id:'');
?>
<div class="container">
	<div class="row">
		<main id="main-area" class="col-12 col-lg-12 mb-4">
			<section class="card card-success rounded-0">
				<div class="card-body">
					<h3 class="mb-1">
						トピックス・マーク設定について
					</h3>
					<p>
						下記のトピックス一覧からチェック設定したトピックスは、新着論文がある場合、お知らせマークがつきます。
						<br>
					</p>
					<img src="{{ asset('img/favorite-sample-pc.png')}}" class="w-100 d-none d-lg-inline">
					<img src="{{ asset('img/favorite-sample-sp.png')}}" class="w-100 d-lg-none">
					<p class="mt-3">
						トピックスをクリックすると、検索結果が一覧に表示されます。
					</p>
				</div>
			</section> 
			<form method="get" action="{{route('front-topics')}}" class="form-search-articles">
				<input type="hidden" name="page_size" value="{{$inputs['page_size']}}">
				<input type="hidden" name="topics_id" value="{{$topicId}}">
				<div class="row mt-3">
				</div>
				<section id="topics-area" class="row collapse show">
					@foreach($listFavoriteTopics as $item)
						<article class="col-12 col-lg-4 topics-menu">
							<input type="checkbox" 
							name="topicFavourite"
							{{!empty($item->isFavourite)?'checked':''}}
							value="{{$item->topics_id}}"
							class="float-right float-lg-left" 
							topics-id="{{$item->topics_id}}" 
							link = {{route('front-ajax-update-status-topic')}}
							/>
							<label for="" class="update-status-favourite-topic"></label>
							<a href="{{route('front-topics').'?topics_id='.$item->topics_id."#search-result"}}" 
							topics-id="{{$item->topics_id}}" 
							class="topics-menu-name load-articles {{$item->topics_id == $topicId?'active':''}} "
							count-articles = "{{$item->articles}}"
							error-message = "対象データがありません。"
							>
								{{$item->topics_name}}
								<span class="small ml-2">({{$item->articles}})</span>
							</a>
						</article>
					@endforeach
					<div class="col-12 col-lg-12 mt-5 mb-2">           
					</div>
				</section>
			</form>
			@if(!empty($inputs['topics_id']))
			<div class="topics-search-result">
				<form>
					<div class="topics-search-result-title"></div>
					@include('front.partials._search-result-title-topics',[
							'topicName' => !(empty($topic))?$topic->topics_name:''
					])
					<section id="search-result" class="card rounded-0 mb-2">
						<div class="py-2 topics-search-result-article">
							@foreach($list as $key => $item)
								@include('front.partials._article-item', [
									'data' => $item,
									'hideListCheckBoxIndex' => true
								])
								@if(!($list->last() == $item)) <hr /> @endif
							@endforeach
						</div>
					</section>
					<section class="row">
						<div class="pager-area col-12 col-lg-6 order-2 order-lg-1 mt-1 paginator-big">
							@include('front.shared._pagination', [
								'paginator' => $list,
								'paginate' => $inputs['page_size'],
								'bigSize' => true
							])
						</div>
					</section> 
				</form>
			</div>
			@endif
		</main>
	</div>
</div>

@endsection







