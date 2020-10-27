/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/action.js":
/*!********************************!*\
  !*** ./resources/js/action.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $(document).on('click', '.delete-checked-box', function () {
    var _this = $(this);

    var link = _this.attr('link');

    var list = $('.table-checkbox:checked');

    var confirmMessage = _this.attr('confirm-message');

    if (list.length > 0) {
      $.confirm({
        columnClass: '',
        title: '',
        content: '<div class="">' + confirmMessage + '</div>',
        onOpenBefore: function onOpenBefore() {
          $(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
          $('.jconfirm-box').addClass('background-light-blue border-dark');
        },
        buttons: {
          Cancel: {
            text: 'キャンセル',
            btnClass: 'btn btn-cancel'
          },
          OK: {
            text: '削除',
            btnClass: 'btn btn-admin-color',
            action: function action() {
              var data = [];
              $.each(list, function () {
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
                success: function success(response) {
                  location.reload();
                },
                error: function error(XMLHttpRequest, textStatus, errorThrown) {}
              });
            }
          }
        }
      });
    } else {
      var errorMessage = _this.attr('error-message');

      var contentClass = "text-danger";
      $('.date-of-issue').addClass('input-error');
      $.confirm({
        columnClass: 'small',
        title: '',
        content: '<div class="">' + errorMessage + '</div>',
        onOpenBefore: function onOpenBefore() {
          $(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
          $('.jconfirm-box').addClass('background-light-blue border-dark');
        },
        buttons: {
          Cancel: {
            text: "戻る",
            btnClass: 'btn btn-admin-color',
            action: function action() {
              if (!$('.table-checkbox').first().hasClass('outline-danger')) {
                $('.table-checkbox').first().addClass('outline-danger');
              }
            }
          }
        }
      });
    }
  });
});

/***/ }),

/***/ "./resources/js/custom.js":
/*!********************************!*\
  !*** ./resources/js/custom.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window.showLoadingScreen = function (show) {
  var loadingScreen = $('.loading-screen');

  if (show) {
    if (loadingScreen.hasClass('d-none')) {
      loadingScreen.removeClass('d-none');
    }
  } else {
    if (!loadingScreen.hasClass('d-none')) {
      loadingScreen.addClass('d-none');
    }
  }
};

window.showMessage = function (message) {
  var contentClass = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
  $.confirm({
    columnClass: 'small',
    title: '',
    content: '<div class="">' + message + '</div>',
    onOpenBefore: function onOpenBefore() {
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
};

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
  theme: "bootstrap"
});
$('.select2-ajax').select2({
  theme: "bootstrap",
  cacheDataSource: [],
  ajax: {
    url: function url() {
      var link = $(this).attr('link');
      return link;
    },
    delay: 250,
    dataType: 'json',
    cache: true,
    data: function data(params) {
      var defaultList = [];
      var loadType = []; //when first load or not input keyword

      if (params.term == undefined || params.term == '') {
        var options = $(this).find('option');
        loadType = 'default';
        options.each(function (object, index) {
          defaultList.push({
            id: $(this).val(),
            text: $.trim($(this).text())
          });
        });
      }

      var query = {
        keyword: params.term,
        loadType: loadType,
        defaultList: defaultList
      };
      return query;
    },
    processResults: function processResults(data, params) {
      return {
        results: data
      };
    },
    transport: function transport(params, success, failure) {
      var keyword = params.data.keyword;
      var loadType = params.data.loadType;

      if (loadType == 'default') {
        success(params.data.defaultList);
        return {
          abort: function abort() {}
        };
      } else {
        var $request = $.ajax(params);
        $request.then(success);
        $request.fail(failure);
        return $request;
      }
    }
  }
});
var allSelect2 = $('.select2');
var allSelect2Ajax = $('.select2-ajax');
addErrorBorder(allSelect2);
addErrorBorder(allSelect2Ajax);

function addErrorBorder(list) {
  list.each(function () {
    var _this = $(this);

    if (_this.hasClass('border-danger')) {
      _this.select2({
        containerCssClass: 'border-danger'
      });
    }
  });
}

$(document).ready(function () {
  showLoadingScreen(false);
  var errorMsg = $('input[name=error-message]');

  if (errorMsg.length != 0 && errorMsg.val() != '') {
    var contentClass = "text-danger";
    showMessage(errorMsg.val(), contentClass);
  }

  var msg = $('input[name=message]');

  if (msg.length != 0 && msg.val() != '') {
    showMessage(msg.val(), 'text-center');
  } //list sort column


  $('.sort').on('click', function () {
    var url = new URL(window.location.href);
    var type = $(this).attr('sort-type');
    var column = $(this).attr('sort-column');
    var search = url.search.substr(1);

    if (search != '') {
      var params = JSON.parse('{"' + decodeURI(search.replace(/&/g, "\",\"").replace(/=/g, "\":\"")) + '"}');
      var keys = Object.keys(params);
      var sortRegexp = new RegExp("sort");
      keys.map(function (key, index) {
        var test = sortRegexp.test(key);

        if (test) {
          url.searchParams["delete"](key);
        }
      });
    }

    var newType = setSortType(type);
    $(this).attr('sort-type', newType);
    var sort = {};
    sort[column] = newType;
    url.searchParams.set('sort[' + column + ']', newType);
    window.location.href = url.href;
  });

  function setSortType(type) {
    var newType = "desc";

    if (type == "desc") {
      newType = "asc";
    }

    return newType;
  } //Need confirm


  $('.need-confirm').on('click', function (e) {
    e.preventDefault();
    confirmModal($(this));
  }); //form create confirm

  function confirmModal(_this) {
    var type = _this.attr('confirm-type'); //default is btn-success


    var btnClass = _this.attr('confirm-btn-class');

    if (btnClass == undefined || btnClass == '') {
      btnClass = 'btn-success';
    }

    var title = _this.attr('confirm-title');

    if (title == undefined || title == '') {
      title = '';
    }

    var content = _this.attr('confirm-content'); //default is はい


    var confirmBtnText = _this.attr('confirm-btn-text');

    if (confirmBtnText == undefined || confirmBtnText == '') {
      confirmBtnText = 'Yes';
    } //default is いいえ


    var cancelBtnText = _this.attr('confirm-cancel-btn-text');

    if (cancelBtnText == undefined || cancelBtnText == '') {
      cancelBtnText = 'キャンセル';
    } //hide button cancel


    var cancelBtnClass = _this.attr('confirm-cancel-btn-class');

    if (cancelBtnClass == undefined) {
      cancelBtnClass = '';
    }

    $.confirm({
      columnClass: 'modal-sm',
      title: title,
      content: '<div>' + content + '</div>',
      onOpenBefore: function onOpenBefore() {
        $(".jconfirm-buttons").addClass("d-flex justify-content-end m-auto w-100");
        $('.jconfirm-box').addClass('background-light-blue border-dark');
      },
      buttons: {
        No: {
          text: cancelBtnText,
          btnClass: 'btn btn-cancel'
        },
        Yes: {
          text: confirmBtnText,
          btnClass: 'btn btn-admin-color',
          action: function action() {
            if (type == 'form-submit') {
              var form = _this.parents('form');

              form.submit();
            } else if (type == 'link') {
              var href = _this.attr('href');

              window.location.href = href;
            } else if (type == 'execute-function') {
              var functionName = _this.attr('confirm-function');

              var param = _this; //execute function by string name

              window[functionName](param);
            } else if (type == 'delete') {
              var route = _this.attr('href');

              deleteData(route);
            }
          }
        }
      }
    });
  }

  $('.move-to-top').on('click', function () {
    var body = $("html, body");
    body.stop().animate({
      scrollTop: 0
    }, 500, 'swing');
  });
  $('body').on('keyup change', '.number-only', function () {
    $(this).val($(this).val().replace(/[^(\d|.)]/g, ''));
  });
  $('.table-check-all').on('click', function () {
    var isCheckAll = $(this).prop('checked');

    if (isCheckAll) {
      $('.table-checkbox').prop('checked', true);
    } else {
      $('.table-checkbox').prop('checked', false);
    }
  });
  $('.table-checkbox').on('click', function () {
    var isChecked = $(this).prop('checked');

    if (isChecked) {
      var uncheckedBox = $('.table-checkbox:not(:checked)');

      if (uncheckedBox.length > 0) {
        $('.table-check-all').prop('checked', false);
      } else {
        $('.table-check-all').prop('checked', true);
      }
    } else {
      $('.table-check-all').prop('checked', false);
    }
  }); //change password symbol

  (function () {
    // debounce
    var delay = {
      execute: function execute(cb, arg) {
        cb(arg);
        delete this.timeoutID;
      },
      start: function start(cb, arg, delay) {
        this.cancel();
        var self = this;
        this.timeoutID = window.setTimeout(function () {
          self.execute(cb, arg);
        }, delay);
      },
      cancel: function cancel() {
        if (typeof this.timeoutID == "number") {
          window.clearTimeout(this.timeoutID);
          delete this.timeoutID;
        }
      }
    };

    function YouShallPass(pattern, delay) {
      // set pattern
      if (typeof pattern === "string") {
        this.pattern = pattern;
      } else {
        console.warn("pattern is not string");
      } // set delay


      if (typeof delay === "number" && delay > 0) {
        this.delay = delay;
      } else if (delay) {
        console.warn("delay is not positive number");
      }
    }

    YouShallPass.prototype = {
      // password input real value
      realText: "",
      // fix ie oninput 'delete' key fire bug
      fixIE: function fixIE() {
        (function (d) {
          if (navigator.userAgent.indexOf('MSIE 9') === -1) return;
          d.addEventListener('selectionchange', function () {
            var el = d.activeElement;

            if (el.tagName === 'TEXTAREA' || el.tagName === 'INPUT' && el.type === 'text') {
              var ev = d.createEvent('CustomEvent');
              ev.initCustomEvent('input', true, true, {});
              el.dispatchEvent(ev);
            }
          });
        })(document);
      },
      // password mask pattern generator
      pointGen: function pointGen(pattern, num) {
        return Array.apply(null, Array(num)).map(function () {
          return pattern;
        }).join("");
      },
      delayEffect: function delayEffect(arg) {
        arg.value = this.pointGen(this.pattern, arg.value.length);
      },
      // oninput handle
      keyboardInputHandle: function keyboardInputHandle(e) {
        var preVal = this.realText; // insert cursor location

        var index = e.target.selectionStart;
        var nowVal = e.target.value; // increase length of input's value

        var incre = nowVal.length - preVal.length; // increase text

        if (incre > 0) {
          var newStr = nowVal.slice(index - incre, index);
          this.realText = preVal.slice(0, index - incre) + newStr + preVal.slice(index - incre); // delete text
        } else if (incre < 0) {
          this.realText = preVal.slice(0, index) + preVal.slice(index - incre);
        } // render mask effect


        if (nowVal.length > 0) {
          e.target.value = this.pointGen(this.pattern, nowVal.length - 1) + nowVal.charAt(nowVal.length - 1);
          delay.start(this.delayEffect.bind(this), e.target, this.delay);
        } // reset insert cursor location


        e.target.setSelectionRange(index, index); // console.log(this.realText);
      }
    };
    window.YouShallPass = YouShallPass;
  })();

  var ysp = new YouShallPass("＊", 5); // speed change = 5ms

  ysp.fixIE();
  document.querySelector("#passwd").addEventListener('input', ysp.keyboardInputHandle.bind(ysp));
  document.querySelector("#passwd").addEventListener('input', function () {
    $(".passwordToSave").val(ysp.realText);
  });

  function getSelectedText() {
    if (window.getSelection) {
      return window.getSelection().toString();
    } else if (document.getSelection) {
      return document.getSelection();
    } else if (document.selection) {
      return document.selection.createRange().text;
    }
  }
}); //delete

__webpack_require__(/*! ./action */ "./resources/js/action.js");

/***/ }),

/***/ 1:
/*!**************************************!*\
  !*** multi ./resources/js/custom.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\projects\pull\ntt_resonant\resources\js\custom.js */"./resources/js/custom.js");


/***/ })

/******/ });