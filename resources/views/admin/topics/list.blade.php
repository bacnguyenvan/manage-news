<?php 
	if(!empty(old())) {
		$inputs = old();
	}
	if(Session::has('errors')) {
		$errorMessages = Session::get('errors');
	}
	//set index for list item
	$index = 1;
?>
@extends("admin.layouts.app", [
	'topbarTitle' => 'トピックスワード管理'
])
@section("content")
	<div class="d-flex justify-content-between align-items-center">
		<div class="mt-2 mb-2">
			<button class="btn btn-secondary rounded-0 mr-1 add-topics-item">
				新規作成
			</button>
			<a href="javascript:void(0)" 
				class="btn btn-secondary rounded-0 topics-delete-checked-box mr-1"
				error-message="トピックスが選択されていません。"
				link="{{route('admin-topics-ajax-delete')}}"
				confirm-message="選択行のトピックスを削除します。よろしいですか？"
				new-exist-message="追加されたトピックスが存在しますが登録されません。よろしいですか？"
				edited-exist-message="編集されたトピックスが存在しますが更新されません。よろしいですか？"
				cancel-callback="cancelDelete"
			>
				削除
			</a>
			<a href="javascript:void(0)" 
				class="btn btn-secondary rounded-0 update-checked-box"
				error-message="検索データが選択されていません。"
				link="{{route('admin-topics-ajax-update')}}"
			>
				設定
			</a>
		</div>
	</div>
	<table class="table custom-table table-bordered table-sm border-0">
		<thead>
			<tr>
				<th></th>
				<th><input type="checkbox" class="table-check-all" value=""></th>
				<th>現在のトピックス名</th>
				<th>現在の読みがな</th>
				<th>現在の表示順</th>
				<th>カットライン</th>
				<th>修正後のトピックス名</th>
				<th>修正後の読みがな</th>
				<th>修正後の表示順</th>
				<th>修正後のカットライン</th>

			</tr>
		</thead>
		<tbody class="list-topics">
			@foreach($list as $item)
				@include('admin.topics._list-item', [
					'index' => $index,
					'data' => $item->toArray()
				])
				<?php $index++; ?>
			@endforeach
		</tbody>
	</table>
	<div class="d-none needed-html" next-index="{{$index}}">
		<table>
			@include("admin.topics._list-item", [
				'data' => []
			])
		</table>
	</div> 
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '.add-keywords', function() {
			checkBeforeAction($(this), 'add-keywords');
		});

		$('.add-topics-item').on('click', function() {
			disableAddTopic();
			let topicItem = $('.needed-html').find('.topics-item').clone();
			let nextIndex = $('.needed-html').attr('next-index');
			topicItem.find('.topics-index', nextIndex);
			topicItem.addClass('new-topics-item');
			topicItem.find('input[type=checkbox]').prop('checked', true);
			$('.list-topics').append(topicItem);
			$('.needed-html').attr('next-index', nextIndex + 1);
		});

		function disableAddTopic(disable) {
			//fix ie browser
			if(disable === undefined) {
		      disable = true;
		    }
			$('.add-topics-item').prop('disabled', disable);
		};

		$(document).on('change', 
			'input[name=topics_name],input[name=display_order],input[name=cutline]',
			function() {
			let _this = $(this);
			let parent = $(this).parents('.topics-item');
			if(_this.val() != '') {
				// parent.find('input[type=checkbox]').prop('checked', true);
				editedTopicItem(parent);
			} else {
				//check topics_name
				let name = parent.find('input[name=topics_name]').val();
				//check display_order
				let order = parent.find('input[name=display_order]').val();
				//check cutline
				let cutline = parent.find('input[name=cutline]').val();
				if(	name == '' 
					&& order == '' 
					&& cutline == '' 
					&& !parent.hasClass('new-topics-item')) 
				{
					// parent.find('input[type=checkbox]').prop('checked', false);
					editedTopicItem(parent, false);
				}
			}
		});

		function editedTopicItem(item, isEdited) {
			//fix ie browser
			if(isEdited === undefined) {
		      isEdited = true;
		    }
			if(isEdited) {
				if(!item.hasClass('edited-topics-item')) {
					item.addClass('edited-topics-item')
				}
			} else {
				if(item.hasClass('edited-topics-item')) {
					item.removeClass('edited-topics-item');
				}
			}
		};

		//update all topics items has .new-topics-item or .edited-topics-item
		$('.update-checked-box').on('click', function() {
			let link = $(this).attr('link');
			let list = $('.list-topics').find('.edited-topics-item, .new-topics-item');
			resetTable();
			let data = [];
			list.each(function() {
				let inputs = new Object();
				let _this = $(this);
				let id = _this.data('topics-id');
				let name = _this.find('input[name=topics_name]').val();
				let displayOrder = _this.find('input[name=display_order]').val();
				let cutline = _this.find('input[name=cutline]').val();
				let topics_phonetic = _this.find('input[name=topics_phonetic]').val();
				inputs = {
					topics_id: id,
					topics_name: name!=''?name:_this.data('topics-name'),
					display_order: displayOrder!=''?displayOrder:_this.data('display-order'),
					cutline: cutline!=''?cutline:_this.data('cutline'),
					topics_phonetic: topics_phonetic!=''?topics_phonetic:_this.data('topics_phonetic')
				};
				if(_this.hasClass('new-topics-item')) {
					inputs.type = 'create';
				} else {
					inputs.type = 'edit';
				}
				data.push(inputs);
			});

			if(data.length > 0) {
				$.ajax({
					url: link,
					method: 'post',
					data: JSON.stringify(data),
					headers: {
				        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				        'content-type': "application/json"
				    },
				    success: function(response) {
				    	window.location.href = response.redirect;
				    },
				    error: function(response) {
				    	let list = response.responseJSON;
				    	window.showMessage(list.errorMessage, 'text-danger');
				    	$.each(list, function(id, object) {
				    		let item = null;
				    		if(object.id == 'new') {
				    			item = $('.topics-item.new-topics-item');
				    		} else {
				    			item = $('.topics-item[data-topics-id="'+object.id+'"]');
				    		}

				    		if(item != null) {
				    			let errors = object.errors;
				    			let errorKeys = Object.keys(errors);
				    			let errorMessage = errors.message;
				    			
				    			if(errorKeys != []) {
				    				$.each(errorKeys, function(index, key) {
				    					let inputError = item.find('input[name='+key+']');
				    					if(!inputError.hasClass('border-danger')) {
				    						inputError.addClass('border-danger');
				    					}
				    				})
				    			}
				    		}
				    	})
				    }
				})
			}
		})

		function resetTable() {
			let items = $('.list-topics').find('.topics-item:has(.border-danger)');
			let errorInputs = items.find('.border-danger');
			errorInputs.each(function() {
				$(this).removeClass('border-danger');
			});
		}

		function checkBeforeAction(_this, type) {
			let parent = _this.parents('.topics-item');
			//if add keywords for parent is new item
			if(parent.hasClass('new-topics-item')) {
				let errorMessage = _this.attr('is-new-message');
				window.showMessage(errorMessage, 'text-danger');
				if(type == 'add-keywords')
				{
					parent.find('input').addClass('border-danger');
				}
			} else {
				
				let confirmMessage = '';
				let newTopics = $('.new-topics-item');
				let editedTopics = $('.edited-topics-item');
				//if add keywords when exists new item
				if(newTopics.length > 0) {
					confirmMessage += _this.attr('new-exist-message');
				}
				//if add keywords when exists edited item
				if(editedTopics.length > 0) {
					let breakContent = '';
					if(confirmMessage != '') {
						breakContent = '<br>';
					}
					confirmMessage += breakContent + _this.attr('edited-exist-message');
				}
				if(confirmMessage != '') {
					$.confirm({
						columnClass: 'small',
						title: '',
						content: '<div class="">'+confirmMessage+'</div>',
						onOpenBefore: function () {
							$(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
							$('.jconfirm-box').addClass('background-light-blue border-dark');
						},	
						buttons: {
							Cancel: {
								text: 'いいえ',
								btnClass: 'btn btn-cancel'
							},
							OK: {
								text: 'はい',
								btnClass: 'btn btn-admin-color',
								action: function action() {
									if(type == 'add-keywords') {
										let link = _this.attr('link');
										window.location.href = link;
									} else if(type == 'topics-delete') {
										topicsDelete();
									}
									
								}
							}
						}
					});	
				} else {
					if(type == 'add-keywords') {
						let link = _this.attr('link');
						window.location.href = link;
					} else if(type == 'topics-delete') {
						topicsDelete();
					}
				}
			}
		}

		$('.topics-delete-checked-box').on('click', function() {
			let _this = $(this);
			let link = _this.attr('link');
			let list = $('.table-checkbox:checked');
			
			let confirmMessage = '';
			if(list.length > 0) {
				checkBeforeAction(_this, 'topics-delete');
			} else {
				let errorMessage = _this.attr('error-message');
				let contentClass = "text-danger";
				if(!$('.table-checkbox').first().hasClass('outline-danger')) {
					$('.table-checkbox').first().addClass('outline-danger');
				}
				showMessage(errorMessage, contentClass);
			}
		})

		function topicsDelete() {
			let _this = $('.topics-delete-checked-box');
			let link = _this.attr('link');
			let list = $('.table-checkbox:checked');
			let confirmMessage = _this.attr('confirm-message');
			$.confirm({
				columnClass: 'small',
				title: '',
				content: '<div class="">' + confirmMessage + '</div>',
				onOpenBefore: function () {
					$(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
					$('.jconfirm-box').addClass('background-light-blue border-dark');
				},	
				buttons: {
					Cancel: {
						text: 'キャンセル',
						btnClass: 'btn btn-cancel',
					},
					OK: {
						text: '削除',
						btnClass: 'btn btn-admin-color',
						action: function action() {
							let data = [];
							$.each(list, function() {
								data.push($(this).val());
							});
							$.ajax({
								url: link,
								method: 'post',
								data: JSON.stringify(data),
								headers: {
							        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
							        'content-type': "application/json"
							    },
								success: function(response) {
									location.reload();
								},
								error: function(XMLHttpRequest, textStatus, errorThrown) {
								}
							});
						}
					}
				}
			});
		}
	})
</script>
@stop


















