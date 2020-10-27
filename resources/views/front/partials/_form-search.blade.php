<?php 
	$items = $gssData['items'];
	$facets = $gssData['facets'];
	$banner = $gssData['banner'];
	$related_words = $gssData['related_words'];
	$facetConfigs = AppData::indexFacetConfigs;
?>
	
	<aside id="widget-area2" class="my-4 d-lg-none"><!--モバイルのみの表示-->
		<div class="card card-primary rounded-0">
			<div class="widget-header widget-primary">
				<h3 data-toggle="collapse" href="#shiborikomi" role="button" aria-expanded="false" aria-controls="shiborikomi" class="accordion-btn d-lg-none pr-1">検索結果を絞り込む<span class="float-right">＋</span><span class="float-right d-none">－</span></h3>
				<h3 class="d-none d-lg-block text-center">論稿を絞り込む</h3>
			</div>
			<div id="shiborikomi" class="widget-body collapse">
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
