/* 絞り込み検索表示制御
==================================*/
if (window.matchMedia('(max-width: 1199px)').matches) {
    //スマホ処理
} else if (window.matchMedia('(min-width:1200px)').matches) {
    $("#shiborikomi").addClass("show"); //PC処理
}

window.addEventListener( 'resize', function() {　//ウィンドウリサイズへの対応
  if (window.matchMedia('(max-width: 1199px)').matches) {
    $("#shiborikomi").removeClass("show"); //スマホ処理
  } else if (window.matchMedia('(min-width:992px)').matches) {
    $("#shiborikomi").addClass("show"); //PC処理
  }
}, false );

/* モバイル用ナビゲーションメニューボタン
======================================*/
$(function() {
 $('.drbtn').on('click', function () {
  $(this).toggleClass('action');
  $('.drawer').toggleClass('action');
 });
});


/* アコーディオンボタンの開閉表示
======================================*/
$(function() {
 $('.accordion-btn').on('click', function () {
  $(this).find("span").toggleClass('d-none');
 });
});

/* チェックボックス全選択
======================================*/
$(function() {
    // 「全選択」する
    $('#all').on('click', function() {
      $("input[name='chk[]']").prop('checked', this.checked);
    });

    // 「全選択」以外のチェックボックスがクリックされたら、
    $("input[name='chk[]']").on('click', function() {
      if ($('#search-result-area :checked').length == $('#search-result-area :input').length) {
        // 全てのチェックボックスにチェックが入っていたら、「全選択」 = checked
        $('#all').prop('checked', true);
      } else {
        // 1つでもチェックが入っていたら、「全選択」 = checked
        $('#all').prop('checked', false);
      }
    });
  });

/* フォントサイズ保持＆変更
======================================*/
$(function(){
if ($.cookie('style01')){
switch($.cookie('style01')){
case 'txt_small':
$('.txt_small').addClass('active');
$('.txt_normal').removeClass('active');
$('.txt_big').removeClass('active');
$('body').addClass('small');
break;
case 'txt_normal':
$('.txt_normal').addClass('active');
$('.txt_big').removeClass('active');
$('.txt_small').removeClass('active');
$('body').removeClass('big');
$('body').removeClass('small');
break;
case 'txt_big':
$('.txt_big').addClass('active');
$('.txt_normal').removeClass('active');
$('.txt_small').removeClass('active');
$('body').addClass('big');
break;
}
}

$('.txt_big').on('click',function(){
$('.txt_big').addClass('active');
$('.txt_normal').removeClass('active');
$('.txt_small').removeClass('active');
$('body').removeClass('small');
$('body').addClass('big');
});
$('.txt_normal').on('click',function(){
$('.txt_normal').addClass('active');
$('.txt_big').removeClass('active');
$('.txt_small').removeClass('active');
$('body').removeClass('big');
$('body').removeClass('small');
});
$('.txt_small').on('click',function(){
$('.txt_small').addClass('active');
$('.txt_normal').removeClass('active');
$('.txt_big').removeClass('active');
$('body').removeClass('big');
$('body').addClass('small');
});
});

function switchTxtsize(cssname){
  $.cookie('style01',cssname,{expires:30,path:'/'});
}