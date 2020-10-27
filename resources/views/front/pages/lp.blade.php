@extends('front.layouts.app', [
	'title' => '',
	'isLp' => true
])
@section('title', '検索機能が大幅にリニューアル!｜証券アナリストジャーナル検索')
@section('content')
<!-- HEADER -->
<header class="header mb-4">
	<div class="bg-primary py-2">
		<div class="container">
			<form class="form">
				<div class="row">
					<!--<div class="col-12 col-lg-4 offset-lg-4 text-center my-4">
						<img src="./assets/img/lp-headerimg-01.png" class="w-50" width="auto" height="auto" alt="" />
					</div>-->
					<div class="col-12 col-lg-12 mt-5"></div>
					<div class="col-4 col-lg-2 offset-0 offset-lg-1 text-center">
						<img src="{{asset('img/lp-headerimg-02.png')}}" class="w-100 mb-1" width="auto" height="auto" alt="" />
					</div>
					<div class="col-4 col-lg-2 text-center">
						<img src="{{asset('img/lp-headerimg-03.png')}}" class="w-100 mb-1" width="auto" height="auto" alt="" />
					</div>
					<div class="col-4 col-lg-2 text-center">
						<img src="{{asset('img/lp-headerimg-04.png')}}" class="w-100 mb-1" width="auto" height="auto" alt="" />
					</div>
					<div class="col-4 col-lg-2 offset-2 offset-lg-0 text-center">
						<img src="{{asset('img/lp-headerimg-05.png')}}" class="w-100 mb-1" width="auto" height="auto" alt="" />
					</div>
					<div class="col-4 col-lg-2 text-center">
						<img src="{{asset('img/lp-headerimg-06.png')}}" class="w-100 mb-1" width="auto" height="auto" alt="" />
					</div>
					<div class="col-12 col-lg-12 text-center mt-5">
						<h1 class="h2 my-1 text-white font-weight-bold">
							検索機能が大幅にリニューアル!
						</h1>
					</div>
					<div class="col-12 col-lg-12 text-center my-3">
						<a href="{{route('front-index')}}" class="btn btn-block btn-lg btn-warning">
							早速検索する
							<span class="float-right">></span>
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</header>

<div class="container">
	<div class="row">
		<aside id="widget-area" class="col-12 col-lg-3 order-1 order-lg-1 mb-4">
			<a href="{{config('app.wisebook_url').'html/saaj_journal/'.$article->wb_book_seq.'/'}}">
				{{-- <img src="{{asset('img/nophoto.png')}}" alt="" width="auto" height="auto" class="w-100 mb-2" /> --}}
				<img src="{{config('app.wisebook_url').'vars/v2store/saaj_journal/'.$article->wb_book_seq.'/stream/1/thumb.jpg'}}" alt="" width="auto" height="auto" class="w-100 mb-2" />
				<p class="btn btn-block btn-outline-primary">全文表示</p>
			</a>
		</aside>
		<main id="main-area" class="col-12 col-lg-9 order-2 order-lg-2 mb-4">
			<form>
				@include('front.partials._card-contents', [
					'contents' => $article->contents,
					'article' => $article
				])
			</form>
		</main>
	</div>
</div>
<section id="backnumber-area" class="bg-tokushu">
	<h2 class="h3 text-center text-success pt-5 mb-3">直近のバックナンバー</h2>
	<div class="container nav-scroller pb-5">
		<div id="backnumber-scroll-area" class="nav d-flex justify-content-between">
			@foreach($articlesNearest as $item)

				<article class="">
					<a href="{{config('app.wisebook_url').'html/saaj_journal/'.$item->wb_book_seq.'/'}}">
						<img src="{{config('app.wisebook_url').'vars/v2store/saaj_journal/'.$item->wb_book_seq.'/stream/1/thumb.jpg'}}" alt="" width="auto" height="auto" class="w-100 mb-2" />
					</a>
				</article>
			@endforeach
		</div>
	</div>
</section>
<section class="search-btn-area container py-5">
	<a href="{{route('front-index')}}" class="btn btn-block btn-lg btn-primary">
		早速検索する<span class="float-right">></span>
	</a>
</section>
@stop