
window.showLoadingScreen = function(show) {
	var loadingScreen = $('.loading-screen');
	if(show) {
		if(loadingScreen.hasClass('d-none')) {
			loadingScreen.removeClass('d-none')
		}
	} else {
		if(!loadingScreen.hasClass('d-none')) {
			loadingScreen.addClass('d-none')
		}
	}
};

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
				btnClass: 'btn btn-admin-color'
			}
		}
	});
}

$('.datepicker').datepicker({
	format: 'yyyy/mm/dd'
});

$('.datepicker-month').datepicker({
    format: "yyyy/mm",
    viewMode: "months", 
    minViewMode: "months",
    language: 'ja'
});

$('.select2').select2({
	theme: "bootstrap",
});

$('.select2-ajax').select2({
	theme: "bootstrap",
	cacheDataSource: [],
  	ajax: {
	    url: function() {
	    	let link = $(this).attr('link');
	    	return link;
	    },
	    delay: 250,
	    dataType: 'json',
	    cache: true,
	    data: function (params) {
	    	var defaultList = [];
	    	let loadType = [];
	    	//when first load or not input keyword
			if(params.term == undefined || params.term == '') {
	    		let options = $(this).find('option');
	    		loadType = 'default';
	    		options.each(function(object, index) {
	    			defaultList.push({
	    				id: $(this).val(),
	    				text: $.trim($(this).text())
	    			});
	    		});
	    	}

	    	let query = {
	    		keyword: params.term,
	    		loadType: loadType,
	    		defaultList: defaultList
	    	}
			
	    	return query;
	    },
	    processResults: function (data, params) {
			return {
				results: data
			};
		},
		
		transport: function (params, success, failure) {
			let keyword = params.data.keyword;
			let loadType = params.data.loadType;
			if(loadType == 'default') {
				success(params.data.defaultList);
				return {
                    abort: function () {
                    }
                }
			} else {
				var $request = $.ajax(params);
			    $request.then(success);
			    $request.fail(failure);
			    return $request;
			}
		},
	},
});

let allSelect2 = $('.select2');
let allSelect2Ajax = $('.select2-ajax');
addErrorBorder(allSelect2);
addErrorBorder(allSelect2Ajax);
function addErrorBorder(list) {
	list.each(function() {
		let _this = $(this);
		if(_this.hasClass('border-danger')) {
			_this.select2({
				containerCssClass: 'border-danger'
			});
		}
	});
}

$(document).ready(function() {
	showLoadingScreen(false);
	let errorMsg = $('input[name=error-message]');

	if(errorMsg.length != 0 && errorMsg.val() != '') {
		let contentClass = "text-danger";
		showMessage(errorMsg.val(), contentClass);
	}

	let msg = $('input[name=message]');

	if(msg.length != 0 && msg.val() != '') {
		showMessage(msg.val(), 'text-center');
	}

	//list sort column
	$('.sort').on('click', function() {
		let url = new URL(window.location.href);
		let type = $(this).attr('sort-type');
		let column = $(this).attr('sort-column');
		let search = url.search.substr(1);
		if(search != '') {
			let params = JSON.parse('{"'+decodeURI(search.replace(/&/g, "\",\"").replace(/=/g,"\":\""))+'"}');
			let keys = Object.keys(params);
			let sortRegexp = new RegExp("sort");
			keys.map(function(key, index) {
				let test = sortRegexp.test(key);
				if(test) {
					url.searchParams.delete(key);
				}
			})
		}
		
		let newType = setSortType(type);
		$(this).attr('sort-type', newType);
		let sort = {}
		sort[column] = newType;
		url.searchParams.set('sort['+column+']', newType);
		window.location.href = url.href;
	})

	function setSortType(type) {
		let newType = "desc";
		if(type == "desc") {
			newType = "asc";
		}
		return newType;
	}

	//Need confirm
	$('.need-confirm').on('click', function(e){
		e.preventDefault();
		confirmModal($(this));
	});

	//form create confirm
	function confirmModal(_this) {
		let type = _this.attr('confirm-type');
		//default is btn-success
		let btnClass = _this.attr('confirm-btn-class');
		if(btnClass == undefined || btnClass == '') {
			btnClass = 'btn-success';
		}
		let title = _this.attr('confirm-title');
		if(title == undefined || title == '') {
			title = '';
		}
		let content = _this.attr('confirm-content');
		//default is はい
		let confirmBtnText = _this.attr('confirm-btn-text');
		if(confirmBtnText == undefined || confirmBtnText == '') {
			confirmBtnText = 'Yes';
		}
		//default is いいえ
		let cancelBtnText = _this.attr('confirm-cancel-btn-text');
		if(cancelBtnText == undefined || cancelBtnText == '') {
			cancelBtnText = 'キャンセル';
		}
		//hide button cancel
		let cancelBtnClass = _this.attr('confirm-cancel-btn-class');
		if(cancelBtnClass == undefined) {
			cancelBtnClass = '';
		}
		$.confirm({
			columnClass: 'modal-sm',
			title: title,
			content: '<div>'+content+'</div>',
			onOpenBefore: function () {
				$(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
					$('.jconfirm-box').addClass('background-light-blue border-dark');
			},	
			buttons: {
				No: {
					text: cancelBtnText,
					btnClass: 'btn btn-cancel',
				},
				Yes: {
					text: confirmBtnText,
					btnClass: 'btn btn-admin-color',
					action: function action() {
						if(type == 'form-submit') {
							let form = _this.parents('form');
							form.submit();
						} else if(type == 'link') {
							let href = _this.attr('href');
							window.location.href = href
						} else if(type == 'execute-function') {
							let functionName = _this.attr('confirm-function');
							var param = _this;
							//execute function by string name
							window[functionName](param);
						} else if(type == 'delete') {
							let route = _this.attr('href');
							deleteData(route);
						}
					}
				},
			}
		});
	}

	$('.move-to-top').on('click', function() {
		var body = $("html, body");
		body.stop().animate({scrollTop:0}, 500, 'swing');
	});

	$('body').on('keyup change', '.number-only', function() {
		$(this).val($(this).val().replace(/[^(\d|.)]/g,''));
	});
	
	$('.table-check-all').on('click', function() {
		let isCheckAll = $(this).prop('checked');
		if(isCheckAll) {
			$('.table-checkbox').prop('checked', true);
		} else {
			$('.table-checkbox').prop('checked', false);
		}
	});

	$('.table-checkbox').on('click', function() {
		let isChecked = $(this).prop('checked');
		if(isChecked) {
			let uncheckedBox = $('.table-checkbox:not(:checked)');
			if(uncheckedBox.length > 0) {
				$('.table-check-all').prop('checked', false);
			} else {
				$('.table-check-all').prop('checked', true);
			}
		} else {
			$('.table-check-all').prop('checked', false);
		}
	});
	
	
	//change password symbol
	(function(){
	    // debounce
	    var delay = {
	        execute: function(cb, arg) {
	            cb(arg);
	            delete this.timeoutID;
	        },
	        start: function(cb, arg, delay) {
	            this.cancel();
	            var self = this;
	            this.timeoutID = window.setTimeout(function() { self.execute(cb, arg); }, delay);
	        },
	        cancel: function() {
	            if (typeof this.timeoutID == "number") {
	                window.clearTimeout(this.timeoutID);
	                delete this.timeoutID;
	            }
	        }
	    };

	    function YouShallPass(pattern, delay) {
	        // set pattern
	        if(typeof pattern === "string"){
	            this.pattern = pattern;
	        }else{
	            console.warn("pattern is not string");
	        }

	        // set delay
	        if(typeof delay === "number" && delay > 0){
	            this.delay = delay;
	        }else if(delay ){
	            console.warn("delay is not positive number");
	        }
	    }

	    YouShallPass.prototype = {
	        // password input real value
	        realText: "",
	        // fix ie oninput 'delete' key fire bug
	        fixIE: function() {
	            (function(d) {
	                if (navigator.userAgent.indexOf('MSIE 9') === -1) return;

	                d.addEventListener('selectionchange', function() {
	                    var el = d.activeElement;

	                    if (el.tagName === 'TEXTAREA' || (el.tagName === 'INPUT' && el.type === 'text')) {
	                        var ev = d.createEvent('CustomEvent');
	                        ev.initCustomEvent('input', true, true, {});
	                        el.dispatchEvent(ev);
	                    }
	                });
	            })(document);
	        },
	        // password mask pattern generator
	        pointGen: function(pattern, num) {
	            return Array.apply(null, Array(num)).map(function() { return pattern }).join("")
	        },

	        delayEffect: function(arg) {
	            arg.value = this.pointGen(this.pattern, arg.value.length);
	        },
	        // oninput handle
	        keyboardInputHandle: function(e) {
	            var preVal = this.realText;
	            // insert cursor location
	            var index = e.target.selectionStart;
	            var nowVal = e.target.value;
	            // increase length of input's value
	            var incre = nowVal.length - preVal.length;  

	            // increase text
	            if (incre > 0) {
	                var newStr = nowVal.slice(index - incre, index);
	                this.realText = preVal.slice(0, index - incre) + newStr + preVal.slice(index - incre)
	            // delete text
	            } else if (incre < 0) {
	                this.realText = preVal.slice(0, index) + preVal.slice(index - incre);
	            }

	            // render mask effect
	            if (nowVal.length > 0) {
	                e.target.value = this.pointGen(this.pattern, nowVal.length - 1) + nowVal.charAt(nowVal.length - 1);
	                delay.start(this.delayEffect.bind(this), e.target, this.delay);
	            }
	            // reset insert cursor location
	            e.target.setSelectionRange(index, index);
	            // console.log(this.realText);
	        }
	    }
	    window.YouShallPass = YouShallPass;
	})();

	var ysp = new YouShallPass("＊", 5); // speed change = 5ms
    ysp.fixIE();

    document.querySelector("#passwd").addEventListener('input', ysp.keyboardInputHandle.bind(ysp));
    document.querySelector("#passwd").addEventListener('input', function() {
        $(".passwordToSave").val(ysp.realText);
    });


	function getSelectedText(){ 
	    if(window.getSelection){ 
	        return window.getSelection().toString(); 
	    } 
	    else if(document.getSelection){ 
	        return document.getSelection(); 
	    } 
	    else if(document.selection){ 
	        return document.selection.createRange().text; 
	    } 
	} 


});

//delete
require('./action');











