console.log("top.js loaded");
/*==================================================
スライダーのためのjs
===================================*/
$(document).ready(function() {
    $('.slider').slick({
        autoplay: true,//自動的に動き出すか
        infinite: true,//スライドをループさせるかどうか
        slidesToShow: 3,//スライドを画面に3枚見せる
        slidesToScroll: 3,//1回のスクロールで3枚の写真を移動して見せる
        prevArrow: '<div class="slick-prev"></div>',//矢印部分PreviewのHTMLを変更
        nextArrow: '<div class="slick-next"></div>',//矢印部分NextのHTMLを変更
        dots: true,//下部ドットナビゲーションの表示
    });
});
