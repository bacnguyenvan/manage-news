<section id="search-result-title" class="mb-3">
	<div class="pt-3">
		<div class="row no-gutters">
			<div class="col-lg-4 col-8 order-4 offset-2 offset-lg-0 order-lg-2 pr-3 mb-0 mt-2">
				<p class="small m-0">現在の検索条件：{{$topicName}}</p>
			</div>
			<div class="col-lg-2 col-12 offset-0 offset-lg-3 order-2 order-lg-4 pr-3 mb-2">
				@include('front.partials._select-page-size', [
					'inputs' => $inputs
				])
			</div>
			<div class="col-lg-2 col-12 order-1 order-lg-5 paginator-small">
				@include('front.shared._pagination', [
					'paginator' => $list,
					'paginate' => $inputs['page_size']
				])
			</div>
		</div>
	</div>
</section>