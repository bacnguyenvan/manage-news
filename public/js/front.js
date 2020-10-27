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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/front.js":
/*!*******************************!*\
  !*** ./resources/js/front.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

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
        btnClass: 'btn btn-primary'
      }
    }
  });
};

$(document).ready(function () {
  $(".article-export-csv").click(function (e) {
    var _this = $(this);

    e.preventDefault();
    var list = $('.table-checkbox:checked');

    if (list.length > 0) {
      var form = $('#form-article-export');
      var _data = [];
      $.each(list, function () {
        // data.push($(this).val());
        $('<input />').attr('type', 'hidden').attr('name', 'chk[]').attr('value', $(this).val()).appendTo(form);
      });
      form.submit();
    } else {
      var errorMessage = _this.attr('error-message');

      var contentClass = "text-danger";
      showMessage(errorMessage, contentClass);
    }
  });
  $('select[name=page_size]').on('change', function () {
    var form = $('.form-search-articles');
    var value = $(this).val();
    form.find('input[name=page_size]').val(value);
    form.submit();
  });
  $('.update-status-favourite-topic').on('click', function () {
    var _this = $(this).siblings('input[name=topicFavourite]');

    var status = 0;

    var link = _this.attr('link');

    if (_this.is(':checked')) {
      _this.attr('checked', false);

      status = 0;
    } else {
      _this.attr('checked', true);

      status = 1;
    }

    var topicId = _this.attr('topics-id');

    data = {
      'topicId': topicId,
      'status': status
    };
    $.ajax({
      url: link,
      method: 'post',
      data: JSON.stringify(data),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'content-type': "application/json"
      },
      success: function success(response) {// location.reload();
      },
      error: function error(XMLHttpRequest, textStatus, errorThrown) {}
    });
  });
  $('.load-articles').on('click', function (e) {
    e.preventDefault();

    var _this = $(this);

    var link = _this.attr('href');

    var countArticles = _this.attr('count-articles');

    if (countArticles == 0) {
      var errorMessage = _this.attr('error-message');

      var contentClass = "text-danger";

      _this.addClass('active');

      showMessage(errorMessage, contentClass);
    } else {
      window.location.href = link;
    }
  });
});

/***/ }),

/***/ 2:
/*!*************************************!*\
  !*** multi ./resources/js/front.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\projects\pull\ntt_resonant\resources\js\front.js */"./resources/js/front.js");


/***/ })

/******/ });