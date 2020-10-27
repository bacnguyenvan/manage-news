<?php
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
@extends("admin.layouts.app", [
	'topbarTitle' => '著者マスタ作成'
])
@section('content')
<div class="col-6">
	<form method="post" 
		action="{{route('admin-authors-create')}}" 
		autocomplete="off" 
		is-checked="false">
		@csrf
		<div class="row ">
	      <div class="col-4 ">
	        著者名
	      </div>
	      <div class="col-4 ">
	        著者読みがな
	      </div>
	    </div>

	    @for($i=0;$i<10;$i++)
			<?php
				$authorName = '';
				$authorPhonetic = '';
				$authors = $inputs['authors'];
				if(!empty($authors[$i])) {
					if(!empty($authors[$i]['author_name'])) {
						$authorName = $authors[$i]['author_name'];
					}
					if(!empty($authors[$i]['author_phonetic'])) {
						$authorPhonetic = $authors[$i]['author_phonetic'];
					}
				}
			?>

			<div class="row  author-inputs pb-2">
		      <div class="col-4 ">
		        <input type="text" 
						name="authors[{{$i}}][author_name]" 
						class="form-control author-name
						@if(!empty($errorMessages[$i]['author_name'])||
							(!empty($errorMessages['authors']) && $i == 0))
							border-danger
						@endif
						"
						value="{{$authorName}}">
		      </div>
		      <div class="col-4 ">
		        <input type="text" 
						name="authors[{{$i}}][author_phonetic]" 
						class="form-control author-phonetic
						@if(!empty($errorMessages[$i]['author_phonetic']))
							border-danger
						@endif
						"
						value="{{$authorPhonetic}}">
		      </div>
		    </div>

		@endfor

	   <div class="row col-12 mt-2">
			<a href="{{route('admin-authors-list')}}" class="btn btn-default mr-2">
				キャンセル
			</a>
			<button type="submit" class="btn btn-admin-color need-confirm"
				confirm-content="データを登録しますか？"
				confirm-type="form-submit"
				confirm-btn-text="登録"
			>
				登録
			</button>
		</div> 

	</form>
</div>
@stop
@section('js')
<script type="text/javascript">
	// $(document).ready(function() {
	// 	$('form').submit(function(e) {
	// 		let form = $(this);
	// 		if(form.attr('is-checked') != 'true') {
	// 			e.preventDefault();
	// 			let list = [];
	// 			let authors = form.find('.author-inputs');
	// 			$.each(authors, function(index, object) {
	// 				let name = $(this).find('.author-name').val();
	// 				let phonetic = $(this).find('.author-phonetic').val();
	// 				if(name != '' || phonetic != '') {
	// 					list.push({
	// 						index: index,
	// 						author_name: name,
	// 						author_phonetic: phonetic
	// 					});
	// 				}
	// 			});
	// 			let data = {authors: list};
	// 			form.append($('<input>').attr({
	// 				type: 'hidden',
	// 				name: 'authors',
	// 				value: JSON.stringify(list)
	// 			}));
	// 			form.attr('is-checked', true);
	// 			form.submit();
	// 			// $.ajax({
	// 			// 	url: form.attr('link'),
	// 			// 	data: JSON.stringify(data),
	// 			// 	method: 'post',
	// 			// 	headers: {
	// 			//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
	// 			//         'content-type': "application/json"
	// 			//     },
	// 			// 	success: function(response) {
	// 			// 		console.log(response);
	// 			// 	},
	// 			// 	error: function(XMLHttpRequest, textStatus, errorThrown) {
	// 			// 	}
	// 			// })
	// 		}
	// 	})
	// })
</script>
@stop










