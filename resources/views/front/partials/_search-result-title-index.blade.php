<section id="search-result-title" class="mb-3">
	<div class="pt-3">
		<p class="small text-dark text-lg-center px-3 mt-2">
            現在の検索条件：　金融恐慌 not コロナor 山口 and 株価暴落 and 特集 or 座談会 from 2019/11/1 to 2020/06/30
        </p>
		<div class="row no-gutters">
			<div class="col-lg-1 col-2 order-2 order-lg-1">
				<span class="ml-2 small">
					全
					<span class="d-none d-lg-inline">て</span>
					選択
				</span>
				<input type="checkbox" 
					id="all" 
					name="allChecked" 
					class="float-right mr-3">
			</div>
			<div class="col-lg-2 col-4 order-3 offset-2 offset-lg-3 order-lg-2 pr-3 mb-0 mt-2">
				<select class="form-control form-control-sm">
					<option>日付順</option>
				</select>
			</div>
			<div class="col-lg-3 col-4 order-4 order-lg-4 pr-3 mb-0 mt-2">
				@include('front.partials._select-page-size')
			</div>
			<div class="col-lg-3 col-12 order-1 order-lg-5">
				@include('front.shared._pagination', [
					'paginator' => $list,
					'paginate' => $inputs['page_size']
				])
			</div>
		</div>
	</div>
</section>