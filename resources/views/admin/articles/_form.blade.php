<?php 
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
?>
<div class="col-12">
	<form action="{{$route}}" class="" method="post" autocomplete="off">
		@csrf
		<div class="form-group row">
			<label class="col-2">タイトル</label>
			<input type="text" 
				name="title" 
				class="form-control col-8 
				{{!empty($errorMessages['title'])?'border-danger':''}}" 
				value="{{$data['title']}}">
		</div>
		<div class="form-group row">
			<label class="col-2">要約</label>
			<textarea rows="5"
				name="wrap_up" 
				class="form-control col-8 
				{{!empty($errorMessages['wrap_up'])?'border-danger':''}}" 
			>{{$data['wrap_up']}}</textarea>
		</div>
		<div class="form-group row">
			<label class="col-2">本文</label>
			<textarea rows="5" 
				name="letter_body" 
				class="form-control col-8 
				{{!empty($errorMessages['letter_body'])?'border-danger':''}}"
			>{{$data['letter_body']}}</textarea>
		</div>

		{{-- 変換元ファイル名 --}}
		<div class="form-group row">
			<label class="col-2">変換元ファイル名</label>
			<input type="text" 
				name="src_basename" 
				class="form-control col-8 
				{{!empty($errorMessages['src_basename'])?'border-danger':''}}" 
				value="{{$data['src_basename']}}">
		</div>

		<div class="form-group row">
			<?php
				$issueDate = '';
				if(!empty($data['issue_date'])) {
					$issueDate = date('Y/m/d', strtotime($data['issue_date']));
				}
			?>
			<label class="col-2">発行年月日</label>
			<input type="text" 
				name="issue_date" 
				class="form-control col-4 datepicker 
				{{!empty($errorMessages['issue_date'])?'border-danger':''}}"
				value="{{$issueDate}}">
		</div>
		<div class="form-group row">
			<label class="col-2">掲載頁</label>
			<input type="text" 
				name="page" 
				class="form-control col-4 
				{{!empty($errorMessages['page'])?'border-danger':''}}"
				value="{{$data['page']}}">
		</div>
		<div class="form-group row">
			<label class="col-2">著者</label>
			<div class="col-4 p-0">
				<?php 
					$class = "select-author";
					if(!empty($errorMessages['author_id'])) {
						$class .= ' border-danger';
					}
				?>
				@include('admin.partials._select2', [
					'list' => $authors,
					'id' => null,
					'name' => '',
					'link' => route('admin-authors-ajax-search'),
					'textType' => ' ',
					'class' => $class
				])
				<div class="col-12 p-0 added-authors mt-1">
					@if(!empty($data['author_id']))
					@foreach($data['author_id'] as $authorId)
						@include('admin.partials._added-author', [
							'id' => $authorId,
							'text' => $authorId.' '. $authors[$authorId]
						])
					@endforeach
					@endif
				</div>
			</div>
			<div class="col-2">
				<a href="javascript:void(0)" 
				class="btn btn-sm btn-admin-color add-author"
				error-message="著者を入力してください。">
					追加
				</a>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-2">論稿種別</label>
			<div class="d-flex col-6 p-0 flex-wrap justify-content-between">
				
				@for($i=0;$i<=5;$i++)
					<?php 
						$class = '';
						if($i == 0) {
							$class = !empty($errorMessages['article_class_id'])?'border-danger':'';
						}
						$articleClassId = null;
						if(!empty($data['article_class_id'][$i])) {
							$articleClassId = $data['article_class_id'][$i];
						}
					?>
					<div class="col-4 p-0 {{$i<=2?'mb-1':''}}">
						@include('admin.partials._select2', [
							'list' => $articleClasses,
							'id' => $articleClassId,
							'name' => 'article_class_id[]',
							'textType' => ' ',
							'link' => route('admin-article-classes-ajax-search'),
							'class' => $class
						])
					</div>
				@endfor
			</div>
		</div>
		<div class="form-group row">
			<label class="col-2">冊子種別</label>
			<div class="col-4 p-0">
				@include('admin.partials._select2', [
					'list' => $bookletClasses,
					'id' => $data['booklet_class_id'],
					'name' => 'booklet_class_id',
					'textType' => ' ',
					'link' => route('admin-booklet-classes-ajax-search'),
					'class' => !empty($errorMessages['booklet_class_id'])?'border-danger':''
				])
			</div>
		</div>

		<div class="form-group row">
			<label class="col-2">トピックス</label>
			<div class="d-flex col-6 p-0 flex-wrap justify-content-between">
				@for($i=0;$i<=5;$i++)
				<?php 
					$class = '';
					if($i == 0) {
						$class = !empty($errorMessages['topics_id'])?'border-danger':'';
					}
					$topicId = null;
					if(!empty($data['topics_id'][$i])) {
						$topicId = $data['topics_id'][$i];
					}
				?>
					<div class="col-4 p-0 {{$i<=2?'mb-1':''}}">
						@include('admin.partials._select2', [
							'list' => $topics,
							'id' => $topicId,
							'name' => 'topics_id[]',
							'textType' => ' ',
							'link' => route('admin-topics-ajax-search'),
							'class' => $class
						])
					</div>
				@endfor
			</div>
		</div>

		<div class="form-group row">
			<label class="col-2">論稿区分</label>
			<div class="d-flex col-6 p-0 flex-wrap justify-content-between">
				<div class="col-4 p-0">
					<select class="form-control" name="article_type">
						<option {{(!$data['article_type'])?"selected":""}} value="0">個別の論稿</option>
						<option {{($data['article_type'])?"selected":""}} value="1">1冊のブック</option>
					</select>
				</div>
			</div>
		</div>


		<div class="form-group row">
			<label class="col-2">検索対象</label>
			<div class="col-1 p-0">
				<input type="hidden" name="search_target_flag" value="0">
				<input type="checkbox"
					class= "{{!empty($errorMessages['article_type_and_search_target_flag'])?'outline-danger':''}}"
					name="search_target_flag"
					value="1"
					{{$data['search_target_flag'] == 1?'checked':''}}>
				<span class="">検索可</span>
			</div>
			<div class="col-1 p-0">
				<input type="hidden" name="not_viewable_flag" value="0">
				<input type="checkbox" 
					name="not_viewable_flag" 
					class="" 
					value="1"
					{{$data['not_viewable_flag'] == 1?'checked':''}}>
				<span class="">閲覧不可</span>
				
			</div>

			<div class="col-1 p-0">
				<input type="hidden" name="release_flag" value="0">
				<input type="checkbox"
					name="release_flag"
					value="1"
					{{$data['release_flag'] == 1?'checked':''}}>
				<span class="">公開可</span>
			</div>

		</div>
		<div class="form-group row">
			<label class="col-2">ブックSEQ</label>
			<div class="col-4 p-0">
				<input type="text" 
				class="form-control
				{{!empty($errorMessages['wb_book_seq'])?'border-danger':''}}" 
				value="{{$data['wb_book_seq']}}" 
				name="wb_book_seq">
			</div>
		</div>
		<div class="form-group row">
			<a href="{{route('admin-articles-list')}}" class="btn btn-default mr-2">
				キャンセル
			</a>
			<?php
				$typeText = $formType =='edit'?'更新':'登録'
			?>
			<button type="submit" class="btn btn-admin-color need-confirm"
				confirm-content="データを{{$typeText}}しますか？"
				confirm-type="form-submit"
				confirm-btn-text="{{$typeText}}"
			>
				{{$typeText}}
			</button>
		</div>
	</form>
	<div class="d-none needed-html">
		@include('admin.partials._added-author')
	</div>
</div>
@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		$('.add-author').on('click', function() {
			let _this = $(this);
			let errorMessage = _this.attr('error-message');
			let selectAuthor = $('.select-author');
			let authorData = selectAuthor.find(':selected');
			if(authorData.val() != '' && authorData != undefined) {
				let addedAuthorHtml = $('.needed-html').find('.added-author').clone();
				addedAuthorHtml.find("input[name='author_id[]']").val(authorData.val());
				addedAuthorHtml.find('.title').text(authorData.text());
				$('.added-authors').append(addedAuthorHtml);
				select2InputError(selectAuthor.parent(), false);
				selectAuthor.val(null).trigger('change');
			} else {
				select2InputError(selectAuthor.parent());
				window.showMessage(errorMessage, 'text-danger');
			}
		});

		$(document).on('click', '.remove-author', function() {
			let _this = $(this);
			let addedAuthor = _this.parent('.added-author');
			addedAuthor.remove();
		});

		function select2InputError(parent, isError) {
			// fix ie browser
			if(isError === undefined){
				isError = true;
			}
			
			if(!isError) {
				if(parent.find('.select2-selection').hasClass('border-danger')) {
					parent.find('.select2-selection').removeClass('border-danger');
				}
			} else {
				if(!parent.find('.select2-selection').hasClass('border-danger')) {
					parent.find('.select2-selection').addClass('border-danger');
				}
			}
		}
	})
</script>
@stop








