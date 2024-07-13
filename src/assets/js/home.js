/* /////////////////////////////////////////////////////////
    home.js
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


        // カルーセル
        $('.mod__slider__carousel').slick(
            {
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 4,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            }
        );

    });
})(jQuery);