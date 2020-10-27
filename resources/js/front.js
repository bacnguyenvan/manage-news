window.showMessage = function(message, contentClass = "") {
	$.confirm({
		columnClass: 'small',
		title: '',
		content: '<div class="">' + message + '</div>',
		onOpenBefore: function () {
			$(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
			$('.jconfirm-box').addClass('background-light-blue border-dark');
		},	
		buttons: {
			Cancel: {
				text: "戻る",
				btnClass: 'btn btn-primary'
			}
		}
	});
}

$(document).ready(function(){

	$(".article-export-csv").click(function(e){
		let _this = $(this);
		e.preventDefault();
		let list = $('.table-checkbox:checked');

		if(list.length > 0){
			let form = $('#form-article-export');

			let data = [];
			$.each(list, function() {
			// data.push($(this).val());

			$('<input />').attr('type', 'hidden')
			.attr('name', 'chk[]')
			.attr('value', $(this).val())
			.appendTo(form);
			});

			form.submit();

		}else{
			let errorMessage = _this.attr('error-message');
			let contentClass = "text-danger";
			showMessage(errorMessage, contentClass);
		}

	});

	$('select[name=page_size]').on('change', function() {
		let form = $('.form-search-articles');
		let value = $(this).val();
		form.find('input[name=page_size]').val(value);
		form.submit();
	});

	$('.update-status-favourite-topic').on('click',function(){
		var _this = $(this).siblings('input[name=topicFavourite]');
		let status = 0;
		let link = _this.attr('link')
		if(_this.is(':checked')){
			_this.attr('checked',false);
			status = 0;
		}else{
			_this.attr('checked',true);
			status = 1;
		}
		let topicId = _this.attr('topics-id');

		data = {
			'topicId' :  topicId,
			'status' : status
		};
		$.ajax({
			url: link,
			method: 'post',
			data: JSON.stringify(data),
			headers: { 
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		        'content-type': "application/json"
		    },
			success: function(response) {
				// location.reload();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
			}
		});
	})

	$('.load-articles').on('click',function(e){
		e.preventDefault();

		var _this = $(this);
		let link = _this.attr('href');
		var countArticles = _this.attr('count-articles');
		if(countArticles == 0){
			let errorMessage = _this.attr('error-message');
			let contentClass = "text-danger";
			_this.addClass('active');
			showMessage(errorMessage, contentClass);
		}else{
			window.location.href = link;
		}
	})

});



