$(document).ready(function() {
	$(document).on('click', '.delete-checked-box', function() {
		let _this = $(this);
		let link = _this.attr('link');
		let list = $('.table-checkbox:checked');
		let confirmMessage = _this.attr('confirm-message');
		if(list.length > 0) {
			$.confirm({
				columnClass: '',
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
		} else {
			let errorMessage = _this.attr('error-message');
			let contentClass = "text-danger";
			$('.date-of-issue').addClass('input-error');
			$.confirm({
				columnClass: 'small',
				title: '',
				content: '<div class="">' + errorMessage + '</div>',
				onOpenBefore: function () {
					$(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
					$('.jconfirm-box').addClass('background-light-blue border-dark');
				},	
				buttons: {
					Cancel: {
						text: "戻る",
						btnClass: 'btn btn-admin-color',
						action : function()
						{
							if(!$('.table-checkbox').first().hasClass('outline-danger')) {
								$('.table-checkbox').first().addClass('outline-danger');
							}
						}
					}
				}
			});
		}
	})
});






















