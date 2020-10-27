<?php 
	// 目次区分資料.xlsx
	$header = $contents->where('contents_classification', 'HD')->first();
	$heading_2 = $contents->where('contents_classification', 'C2')->first();
	$article_2 = $contents->where('contents_classification', 'A2')->first();
	$heading_1 = $contents->where('contents_classification', 'C1')->first();
	
	$article_1 = $contents->where('contents_classification', 'A1')
?>
<section class="card rounded-0">
	<div class="card-header card-success">
		<h3>
			<?php 
				// HD
				$headerYear = $header->publish_year;
				$headerMonth = $header->publish_month;
				$headerVolume = $header->publish_volume;
				$headerIssue = $header->publish_issue;
				$headerCaption = $header->caption;

				// C2
				$caption_C2 = '';
				if(!empty($heading_2)){
					$caption_C2 = $heading_2->caption;
				}
				// A2
				$caption_A2 = '';
				$A2Page = '';
				if(!empty($article_2)){
					$caption_A2 = $article_2->caption;
					$A2Page = $article_2->page;
				}

				$authors = [];
				$authorName = '';

				if(!empty($article->authors)) {
					$authors = $article->authors;
				}

				foreach($authors as $author) {
					$authorName .= $author->author_name .' ／ ';
				}
				$authorName = substr($authorName, 0, strrpos($authorName, "／"));

				// C1
				$caption_C1 = '';
				if(!empty($heading_1)){
					$caption_C1 = $heading_1->caption;
				}
			
			?>
			<i class="font-weight-normal small">
				{{$headerYear}}年
				&nbsp;
				{{$headerMonth}}月号
				（第{{$headerVolume}}巻
				&nbsp;
				第{{$headerIssue}}号）
			</i>
			<br class="d-lg-none">
			特集：{{$headerCaption}}
		</h3>
	</div>
	<div id="mokuji2020-02" class="mokuji-result card-body">
		<p class="mokuji-midashi-mini">{{$caption_C2}}</p>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">{{$caption_A2}}</a></h2>
				<p class="m-0">{{$authorName}}</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">{{$A2Page}}</span></div>
		</article>
		<p class="mokuji-midashi">{{$caption_C1}}</p>
		<div class="tokushu bg-tokushu p-4">
			@foreach($article_1 as $item)
				<article class="row no-gutters">
						<div class="col-lg-11 col-12 search-result-text">
							<h2><a href="">{{$item->caption}}</a></h2>
							<p class="m-0">{{$item->author_name}}</p>
						</div>
						<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">{{$item->page}}</span></div>
				</article>
			@endforeach

		</div>
		<p class="mokuji-midashi-mini">展望</p>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<p class="mokuji-midashi-mini">経済・産業・実務シリーズ</p>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<p class="mokuji-midashi-mini">視点</p>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<p class="mokuji-midashi-mini">論文</p>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<p class="mokuji-midashi-mini">研究ノート</p>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<p class="mokuji-midashi-mini">読書室</p>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">解題「8年目を迎えた異次元緩和の論点整理」</a></h2>
				<p class="m-0">内田　稔</p>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>
		<hr class="shinkan"/>
		<article class="row no-gutters">
				<div class="col-lg-11 col-12 search-result-text">
				<h2><a href="">新刊紹介</a></h2>
			</div>
			<div class="col-lg-1 d-none d-lg-table-cell text-center"><span class="small">7</span></div>
		</article>          
	</div>
</section>