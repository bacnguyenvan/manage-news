<section id="search-result-title" class="mb-3">
	<div class="pt-3">
		<div class="row no-gutters">
			<div class="col-lg-1 col-2 order-3 order-lg-1">
				<span class="small ml-2">順位</span>
				<input type="checkbox" id="all" name="allChecked" class="float-right mr-3 mt-2">
			</div>
			<div class="col-lg-1 col-2 order-4 order-lg-2 d-none d-lg-table-cell">
				<span class="small">
					全
					<span class="d-none d-lg-inline">
						て
					</span>
					選択
				</span>
			</div>
			<div class="col-lg-3 col-10 order-5 offset-0 offset-lg-3 order-lg-2 pr-3 mb-0 mt-2">
				<p class="small m-0">集計期間：
					<span>{{date('Y/m/d', strtotime($inputs['from_date']))}}</span>
					〜
					<span>{{date('Y/m/d', strtotime($inputs['to_date']))}}</span>
				</p>
			</div>
			
			<div class="col-lg-2 col-12 order-2 order-lg-4 pr-3 mb-2">
				@include('front.partials._select-page-size')
			</div>
			
			<div class="col-lg-2 col-12 order-1 order-lg-5">
				<nav aria-label="Page navigation example">
					<div class="d-flex justify-content-center align-items-center">
						@include('front.shared._pagination', [
							'paginator' => $list,
							'paginate' => $inputs['page_size']
						])
					</div>
				</nav> 
			</div>
		</div>
	</div>
</section>