@extends('front.layouts.app')
@section('title','論稿アクセスランキング｜証券アナリストジャーナル検索')
@section('content')
	
<div class="container">
	<div class="row">
		<main id="main-area" class="col-12 col-lg-12 mb-4">
			@include('front.partials._search-result-title-ranking')
			<section id="search-result" class="rounded-0 mb-2">
				<div class="py-2">
					@foreach($list as $key => $item)
						@include('front.partials._article-item', [
							'data' => $item
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

@endsection








