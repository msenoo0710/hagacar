/* /////////////////////////////////////////////////////////
    home.js
///////////////////////////////////////////////////////// */
(function($){
    $(function(){

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