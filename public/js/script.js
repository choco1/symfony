// Startup Scripts
$(document).ready(function()
{
    $('.hero').css('height', ($(window).height() - $('header').outerHeight()) + 'px'); // Set hero to fill page height

    $('#scroll-hero').click(function()
    {
        $('html,body').animate({scrollTop: $("#hero-bloc").height()}, 'slow');
    });
});

// Window resize
$(window).resize(function()
{
    $('.hero').css('height', ($(window).height() - $('header').outerHeight()) + 'px'); // Refresh hero height
});


/*--------------------------------------------------------carts home page-----------------------------------------------------------------*/

var main = function () {
    $('.push-bar').on('click', function(event){
        if (!isClicked){
            event.preventDefault();
            $('.arrow').trigger('click');
            isClicked = true;
        }
    });

    $('.arrow').css({
        'animation': 'bounce 2s infinite'
    });
    $('.arrow').on("mouseenter", function(){
        $('.arrow').css({
            'animation': '',
            'transform': 'rotate(180deg)',
            'background-color': 'black'
        });
    });
    $('.arrow').on("mouseleave", function(){
        if (!isClicked){
            $('.arrow').css({
                'transform': 'rotate(0deg)',
                'background-color': 'black'
            });
        }
    });

    var isClicked = false;

    $('.arrow').on("click", function(){
        if (!isClicked){
            isClicked = true;
            $('.arrow').css({
                'transform': 'rotate(180deg)',
                'background-color': 'black',
            });

            $('.bar-cont').animate({
                top: "-15px"
            }, 300);
            $('.main-cont').animate({
                top: "0px"
            }, 300);
            // $('.news-block').css({'border': '0'});
            // $('.underlay').slideDown(1000);

        }
        else if (isClicked){
            isClicked = false;
            $('.arrow').css({
                'transform': 'rotate(0deg)',       'background-color': 'black'
            });

            $('.bar-cont').animate({
                top: "-215px"
            }, 300);
            $('.main-cont').animate({
                top: "-215px"
            }, 300);
        }
        console.log('isClicked= '+isClicked);
    });

    $('.cards').on('mouseenter', function() {
        $(this).find('.card-text').slideDown(300);
    });

    $('.cards').on('mouseleave', function(event) {
        $(this).find('.card-text').css({
            'display': 'none'
        });
    });
};

$(document).ready(main);

/*--------------------------------------------------------------------------------------------*/

/*---------------------------------------Carousel----------------------------------------*/

$(".carousel").owlCarousel({
    margin: 10,
    loop: true,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1,
            nav: false
        },
        600: {
            items: 2,
            nav: false
        },
        1000: {
            items: 3,
            nav: false
        }
    }
});


/*---------------------------------------filtre barre ----------------------------------------*/


//
// $('.buttonSavoir').click(function(){
//
//     if($(".box-plus").find(".d-none").length){
//         $(".box-plus").find(".d-none").addClass("d-block").removeClass("d-none")
//     }
//
//     else if($(".box-plus").find(".d-block").length){
//         $(".box-plus").find(".d-block").addClass("d-none").removeClass("d-block")
//     }
//
// });

    $('.buttonSavoir').click(function(){
        var value = $(this).attr('data-filter');

        if($('.'+value).find(".d-none").length){
         $('.'+value).find(".d-none").addClass("d-block").removeClass("d-none")
     }
        else if($('.'+value).find(".d-block").length){
         $('.'+value).find(".d-block").addClass("d-none").removeClass("d-block")
    }
    });



$('.buttonConnex').click(function(){
    var value = $(this).attr('data-filter');

    if($('.'+value).find(".d-none").length){
        $('.'+value).find(".d-none").addClass("d-block").removeClass("d-none")
    }
    else if($('.'+value).find(".d-block").length){
        $('.'+value).find(".d-block").addClass("d-none").removeClass("d-block")
    }
});


/*--------------------------signe module page mode connex-------------------------------*/

$(".function a:first-child").click(function (){
    var value = $(this).attr('data-filter');

        $('.'+value).css({
                color: '#d3d3d3',
                'background-color': '#4AFF33',
                'box-shadow': '10px 5px 5px #4AFF33',

        });
    $('.cardModules').css('box-shadow', '10px 5px 5px #4AFF33');
});

$(".noFunction a:first-child").click(function (){
    var value = $(this).attr('data-filter');
    $('.'+value).css({
        color: '#d3d3d3',
        'background-color': '#F11A1A',
        'box-shadow': '10px 5px 5px #F11A1A ',

    });

    $('.cardModules').css('box-shadow', '10px 5px 5px #F11A1A');
});
/*--------------------------------------------------------------------------*/
/*---------------------------------list module-----------------------------------------*/

$('.allModules').click(function(){
    var value = $(this).attr('data-filter');

    if($('.'+value).find(".d-block").length){
        $('.'+value).find(".d-block").addClass("d-none").removeClass("d-block")
    }
    else if($('.'+value).find(".d-none").length){
        $('.'+value).find(".d-none").addClass("d-block").removeClass("d-none")
    }
});