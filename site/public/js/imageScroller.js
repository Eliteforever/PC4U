$(document).ready(function() {
    $("#lightSlider").lightSlider({
        item: 1,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 40,

        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////

        speed: 400, //ms'
        auto: true,
        pauseOnHover: false,
        loop: true,
        slideEndAnimation: true,
        pause: 2000,

        keyPress: true,
        controls: true,
        prevHtml: '<div class="imageScrollerButton"><i class="material-icons">keyboard_arrow_left</i></div>',
        nextHtml: '<div class="imageScrollerButton"><i class="material-icons">keyboard_arrow_right</i></div',

        rtl:false,
        adaptiveHeight:false,

        vertical:false,
        verticalHeight:500,
        vThumbWidth:100,

        thumbItem:1,
        pager: true,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',

        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,

        responsive : [],

        onBeforeStart: function (el) {},
        onSliderLoad: function (el) {},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {}
    });

    $('.saleProducts').lightSlider({
        item: 2,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 40,

        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////

        speed: 400, //ms'
        auto: true,
        pauseOnHover: false,
        loop: false,
        slideEndAnimation: true,
        pause: 2000,

        keyPress: true,
        controls: true,
        prevHtml: '<div class="imageScrollerButton"><i class="material-icons">keyboard_arrow_left</i></div>',
        nextHtml: '<div class="imageScrollerButton"><i class="material-icons">keyboard_arrow_right</i></div',

        rtl:false,
        adaptiveHeight:false,

        vertical:false,
        verticalHeight:500,
        vThumbWidth:100,

        thumbItem:1,
        pager: true,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',

        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,

        responsive : [
            {
                breakpoint:800,
                settings: {
                    item:1,
                    slideMove:1,
                    slideMargin:6,
                }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                }
            }
        ],

        onBeforeStart: function (el) {},
        onSliderLoad: function (el) {},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {}
    });

    $('.recentsList').lightSlider({
        item: 2,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 40,

        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////

        speed: 400, //ms'
        auto: true,
        pauseOnHover: false,
        loop: false,
        slideEndAnimation: true,
        pause: 2000,

        keyPress: true,
        controls: true,
        prevHtml: '<div class="imageScrollerButton"><i class="material-icons">keyboard_arrow_left</i></div>',
        nextHtml: '<div class="imageScrollerButton"><i class="material-icons">keyboard_arrow_right</i></div',

        rtl:false,
        adaptiveHeight:false,

        vertical:false,
        verticalHeight:500,
        vThumbWidth:100,

        thumbItem:1,
        pager: true,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',

        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,

        responsive : [
            {
                breakpoint:800,
                settings: {
                    item:1,
                    slideMove:1,
                    slideMargin:6,
                }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                }
            }
        ],

        onBeforeStart: function (el) {},
        onSliderLoad: function (el) {},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {}
    });
});



