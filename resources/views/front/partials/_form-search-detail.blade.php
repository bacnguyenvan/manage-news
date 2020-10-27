<section class="card card-success rounded-0">
	<div class="card-body">
		<h3 data-toggle="collapse" href="#search-detail" role="button" aria-expanded="false" aria-controls="search-detail" class="accordion-btn">詳細検索<span class="float-right">＋</span><span class="float-right d-none">－</span><!--<span class="float-right small pt-1 ion-chevron-down"></span>--></h3>
		<div id="search-detail" class="mt-3 collapse">
			<form class="form" action="./search.html">
				<div class="row px-0 mb-1">
					<div class="col-12 col-lg-2 mb-2">キーワード</div>
					<div class="col-4 col-lg-2">
						<select class="form-control form-control-sm">
							<option selected="selected">全て</option>
							<option>タイトル</option>
							<option>著者名</option>
						</select>
					</div>
					<div class="col-8 col-lg-6">
						<input type="text" placeholder="検索キーワードを入力してください" class="form-control form-control-sm">
					</div>
					<div class="col-8 col-lg-2 offset-4 offset-lg-0">
					</div>
				</div>
				<div class="row px-0 mb-1">
					<div class="col-12 col-lg-2"></div>
					<div class="col-4 col-lg-2">
						<select class="form-control form-control-sm">
							<option>全て</option>
							<option selected="selected">タイトル</option>
							<option>著者名</option>
						</select>
					</div>
					<div class="col-8 col-lg-6">
						<input type="text" placeholder="検索キーワードを入力してください" class="form-control form-control-sm">
					</div>
					<div class="col-8 col-lg-2 offset-4 offset-lg-0">
						<select class="form-control form-control-sm">
							<option>かつ</option>
							<option selected="selected">でない</option>
							<option>または</option>
						</select>
					</div>
				</div>
				<div class="row px-0 mb-1">
					<div class="col-12 col-lg-2"></div>
					<div class="col-4 col-lg-2">
						<select class="form-control form-control-sm">
							<option>全て</option>
							<option>タイトル</option>
							<option selected="selected">著者名</option>
						</select>
					</div>
					<div class="col-8 col-lg-6">
						<input type="text" placeholder="検索キーワードを入力してください" class="form-control form-control-sm">
					</div>
					<div class="col-8 col-lg-2 offset-4 offset-lg-0">
						<select class="form-control form-control-sm">
							<option>かつ</option>
							<option>でない</option>
							<option selected="selected">または</option>
						</select>
					</div>
				</div>
				<div class="row px-0 mb-1">
					<div class="col-12 col-lg-2"></div>
					<div class="col-4 col-lg-2">
						<select class="form-control form-control-sm">
							<option selected="selected">全て</option>
							<option>タイトル</option>
							<option>著者名</option>
						</select>
					</div>
					<div class="col-8 col-lg-6">
						<input type="text" placeholder="検索キーワードを入力してください" class="form-control form-control-sm">
					</div>
					<div class="col-8 col-lg-2 offset-4 offset-lg-0">
						<select class="form-control form-control-sm">
							<option>かつ</option>
							<option>でない</option>
							<option>または</option>
						</select>
					</div>
				</div>
				<div class="row px-0 mb-1">
					<div class="col-12 col-lg-2"></div>
					<div class="col-4 col-lg-2">
						<select class="form-control form-control-sm">
							<option selected="selected">全て</option>
							<option>タイトル</option>
							<option>著者名</option>
						</select>
					</div>
					<div class="col-8 col-lg-6">
						<input type="text" placeholder="検索キーワードを入力してください" class="form-control form-control-sm">
					</div>
					<div class="col-8 col-lg-2 offset-4 offset-lg-0">
						<select class="form-control form-control-sm">
							<option>かつ</option>
							<option>でない</option>
							<option selected="selected">または</option>
						</select>                  
					</div>
				</div>
				<hr />
				<div class="row px-0 mb-1">
					<div class="col-12 col-lg-2 mb-2">発行年月日</div>
					<div class="col-10 col-lg-4">
						<input type="date" name="from_date" class="form-control form-control-sm">
					</div>
					<div class="col-2 col-lg-1 text-center p-0 small">
						<p class="m-0 pt-2">から</p>
					</div>                
					<div class="col-10 col-lg-4">
						<input type="date" name="to_date" class="form-control form-control-sm">
					</div>
					<div class="col-2 col-lg-1 text-center p-0 small">
						<p class="m-0 pt-2">まで</p>
					</div>                
				</div>
				<hr />
				<div class="row px-0 mb-1">
					<div class="col-12 col-lg-6 offset-0 offset-lg-3">
						<input type="submit" value="この条件で検索" class="btn btn-block btn-sm btn-success">
					</div>
				</div>
			</form>
		</div>
	</div>
</section>