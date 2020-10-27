<?php 
	$items = $gssData['items'];
	$facets = $gssData['facets'];
	$banner = $gssData['banner'];
	$related_words = $gssData['related_words'];
	$facetConfigs = AppData::indexFacetConfigs;
?>

<aside class="col-12 d-lg-none order-1 mb-4"><!--モバイル用ランキング-->
	@include('front.partials._top-ranking-articles', [
		'data' => $topRankingArticlesData,
	])
</aside>
<aside id="widget-area" class="col-12 col-lg-3 order-3 order-lg-1 mb-4">
	@include('front.partials._top-ranking-articles', [
		'data' => $topRankingArticlesData,
	])
	<div class="card card-primary rounded-0">
		<div class="widget-header widget-primary">
			<h3>論稿を絞り込む</h3>
		</div>
		<div class="widget-body">
			<form action="./search.html">
				@if(!empty($facets))
					@foreach($facetConfigs as $config)
						@if($config['key'] != 'facet_publish_date')
							@include('front.partials._sidebar-facet', [
								'config' => $config,
								'data' => $facets[$config['key']]
							])
						@else
							@include('front.partials._sidebar-facet-date', [
								'config' => $config,
								'data' => $facets[$config['key']]
							])
						@endif
						<br>
					@endforeach
					<div class="px-3 my-4">
						<input type="submit" value="絞り込み実行" class="btn btn-sm btn-block btn-primary" />
					</div> 
				@endif	
			</form>
		</div>
	</div>
</aside>