/* /////////////////////////////////////////////////////////
  script.js
///////////////////////////////////////////////////////// */
(function($){
  $(function(){
    
    // ヘッダー背景
    var headerCL = new ScrollMagic.Controller();
    var scene = new ScrollMagic.Scene({
        triggerElement: '.mainvisual', // トリガーとなる要素
        duration: $('.mainvisual').outerHeight(), // .mainvisualの高さ
        triggerHook: 0, // ページの上端でトリガー
    })
    .on('leave', function () {
        // .headerに.currentクラスを追加
        $('.header').addClass('current');
    })
    .on('enter', function () {
        // .headerから.currentクラスを削除
        $('.header').removeClass('current');
    })
    // コントローラーにシーンを追加
    .addTo(headerCL);


    // スクロールイベントの監視を追加
    $(window).scroll(function() {
      var $pagetop = $('.footer__pagetop');
      if ($(this).scrollTop() > 200) {
        $pagetop.addClass('scrolled');
      } else {
        $pagetop.removeClass('scrolled');
      }
    });


    // マウスホバーで子メニューを表示する
    $('.header__nav .child').hover(function() {
      // マウスが要素に入った時の処理
      $(this).find('ol').velocity("slideDown", {
          duration: 300 // アニメーションの速度をミリ秒単位で指定
      });
    }, function() {
      // マウスが要素から出た時の処理
      $(this).find('ol').velocity("slideUp", {
          duration: 300 // アニメーションの速度をミリ秒単位で指定
      });
    });

    // ハンバーガーメニュー
    $(".header__hamburger-bars").click(function () {
      var $mobileMenu = $(".header__mobile");
      var $mobileContent = $(".header__mobile-content");
      var $mobileWrap = $(".header__mobile-wrap");
      $(this).toggleClass('active');

      if ($mobileMenu.css('display') === 'none') {
        $mobileMenu.css('display', 'block');
        $mobileWrap.velocity({opacity: 1});
        $mobileContent.css({
          display: 'block',
          right: '-100%'
        }).velocity({
          right: "0%"
        }, {
          duration: 300,
          complete: function() {
            $mobileContent.velocity({ opacity: 1 }, { duration: 300 });
          }
        });
      } else {
        $mobileWrap.velocity({opacity: 0});
        $mobileContent.velocity({
          opacity: 0,
          right: "-100%"
        }, {
          duration: 300,
          complete: function() {
            $mobileMenu.css('display', 'none');
            $mobileContent.css('opacity', '1');
          }
        });
      }
    });
    $(".header__mobile-nav-close").click(function () {
      var $mobileMenu = $(".header__mobile");
      var $mobileContent = $(".header__mobile-content");
      var $mobileWrap = $(".header__mobile-wrap");
      $mobileWrap.velocity({opacity: 0});
      $mobileContent.velocity({
        opacity: 0,
        right: "-100%"
      }, {
        duration: 300,
        complete: function() {
          $mobileMenu.css('display', 'none');
          $mobileContent.css('opacity', '1');
        }
      });
    });

    // アニメーションさせたい要素をすべて選択
    var ScrollCL = new ScrollMagic.Controller();
    $('.js-fadeUp').each(function() {
        // この要素のためのシーンを作成
        var scene = new ScrollMagic.Scene({
            triggerElement: this, // この要素がトリガー
            triggerHook: 0.9, // ビューポートの90%でトリガー
            reverse: false // アニメーションを1回だけ実行
        })
        .on('enter', () => {
            // Velocity.js を使用してアニメーション (jQueryメソッドを使用)
            $(this).velocity({ opacity: 1, translateY: 0 }, { duration: 500 });
        })
        // コントローラーにシーンを追加
        .addTo(ScrollCL);
    });
    $('.js-fadeIn').each(function() {
      // この要素のためのシーンを作成
      var scene = new ScrollMagic.Scene({
          triggerElement: this, // この要素がトリガー
          triggerHook: 0.7, // ビューポートの90%でトリガー
          reverse: false // アニメーションを1回だけ実行
      })
      .on('enter', () => {
          // Velocity.js を使用してアニメーション (jQueryメソッドを使用)
          $(this).velocity({ opacity: 1 }, { duration: 500 });
      })
      // コントローラーにシーンを追加
      .addTo(ScrollCL);
    });


    //アンカーリンク
    $('.anker a[href^="#"]').on('click', function(e) {
      e.preventDefault();
      var target = $($(this).attr('href'));
      if (target.length) {
          var headerHeight = $('.header').outerHeight(); // ヘッダーの高さを取得
          $("html, body").css('overflow-x', 'hidden'); // スクロール前にoverflow-xをhiddenに設定
          $("html, body").velocity("scroll", {
              duration: 800,
              // ヘッダーの高さを考慮したオフセット値
              offset: target.offset().top - headerHeight,
              // offset: target.offset().top,
              easing: "ease-in-out",
              complete: function() {
                  var $header = $(".header");
                  var $headerWrap = $(".header__wrap");
                  var $mobileMenu = $(".header__mobile");
                  var $body = $("body");
                  $(".header__hamburger-bars").removeClass('active');
                  $mobileMenu.find('.header__mobile-content').velocity({ opacity: 0 }, { duration: 0 });
                  $mobileMenu.velocity("slideUp", {
                    duration: 200,
                    complete: function(elements) {
                      $(elements).css('display', 'none');
                      $body.css('overflow', '');
                    }
                  });
              }
          });
      }
    });

    // ページ読み込み時にハッシュがあるか確認
    if (window.location.hash) {
      var headerHeight = $('.header').outerHeight(); // ヘッダーの高さを取得
      var target = $(window.location.hash);
      if (target.length) {
        $("html, body").css('overflow-x', 'hidden'); // スクロール前にoverflow-xをhiddenに設定
        $("html, body").scrollTop(target.offset().top - headerHeight); // アニメーションなしでスクロール
        $("html, body").css('overflow-x', ''); // スクロール後にoverflow-xを元に戻す
      }
    }


  });
})(jQuery);



/* /////////////////////////////
  Cookieを取得するための関数
///////////////////////////// */
function getCookie(cookieName) {
  var cookieValue = null;
  var cookies = document.cookie.split(';');
  for (var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i].trim();
      if (cookie.indexOf(cookieName) == 0) {
          cookieValue = cookie.substring(cookieName.length + 1, cookie.length);
          break;
      }
  }

  //Cookieが保存されていない場合はnullを返す
  if (!cookieValue) {
      cookieValue = null;
  }

  return cookieValue;
}
/* /////////////////////////////
  Cookieを保存する関数
///////////////////////////// */
function setCookie(cookieName, cookieValue, days) {
  var d = new Date();
  d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
}


/* /////////////////////////////
  Cookieをリセットする関数
///////////////////////////// */
//resetCookie関数
function resetCookie(cookieName) {
  var date = new Date();
  date.setTime(date.getTime() - 1);
  var expires = "expires=" + date.toGMTString();
  document.cookie = cookieName + "=" + "" + "; " + expires + "; path=/";
}

//URLパラメーターの取得
var urlParams = new URLSearchParams(window.location.search);

//Cookieのリセット
if (urlParams.has("resetCookie")) {
  var cookieName = urlParams.get("resetCookie");
  resetCookie(cookieName);
}