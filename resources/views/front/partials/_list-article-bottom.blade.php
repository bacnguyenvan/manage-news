<section class="row">
	<div class="col-12 col-lg-6 order-1 order-lg-2 mb-3">
		<input type="submit" class="btn btn-sm btn-outline-danger mt-1 float-right article-export-csv" value="選択した論稿一覧をダウンロード（CSV）" error-message="論稿が選択されていません。"/>
	</div>
	<div class="pager-area col-12 col-lg-6 order-2 order-lg-1 mt-1">
		<nav aria-label="Page navigation example">
			<div class="d-flex align-items-center">
				@include('front.shared._pagination', [
					'paginator' => $list,
					'paginate' => $inputs['page_size'],
					'bigSize' => true
				])
			</div>
		</nav>
	</div>
</section>