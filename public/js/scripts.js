
var wow = new WOW({
    boxClass:     'animated',      
    animateClass: 'on',
    offset:       0,
    mobile:       true,   
    live:         true,    
    callback:     function(box) {
    },
    scrollContainer: null 
});
wow.init();
window.addEventListener('scroll', () => {
    if(window.scrollY) {
        document.querySelector('.header').classList.add('_scroll')
    }else {
        document.querySelector('.header').classList.remove('_scroll')
    }
})
$.masked = function () {
    var $masked = $('.js-mask');
    $masked.mask("+7 (999) 999-99-99");
}
$.masked()

//popup
$(document).on('click', '[data-modal="text"]', function(e){

    e.preventDefault();
    var src = $(this).attr('href'), 
        bt = $(this);
    $.fancybox.open({
        src: src,
        type: 'inline',
        hash: false,
        opts: {
            smallBtn: true,
            btnTpl: {
               smallBtn: '<button data-fancybox-close class="fancybox-close-small close" title="{{CLOSE}}">' +
                    '<svg>' +
                        '<use  xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/img/sprite.svg#icon-close"></use>' +
                    '</svg>' +
                '</button>',                
                arrowLeft: '',
                arrowRight: '',
            },
            lang: "ru",
            i18n: {
                ru: {
                  CLOSE: "Закрыть",
                  NEXT: "Вперёд",
                  PREV: "Назад",
                  ERROR: "Запрашиваемый контент не был загружен <br/> Пожалуйста, попробуйте позднее.",
                  PLAY_START: "Запустить слайдшоу",
                  PLAY_STOP: "Остановить слайдшоу",
                  FULL_SCREEN: "На весь экран",
                  THUMBS: "Миниатюры",
                  DOWNLOAD: "Скачать",
                  SHARE: "Поделиться",
                  ZOOM: "Увеличить"
                }
            },
            infobar: false,
            arrows: false,
            zoom: false,
            buttons: [
                "zoom",
                "close"
            ],
            thumbs : {
                autoStart : true
            },
            touch: false,
            clickContent: false,    
            youtube : {
                controls : 0,
                showinfo : 0
            },
            beforeLoad: function(instance, current) {
                if (current.src == '#popup__search-main') {
                    $('.fancybox-container').addClass('fancybox__dark')
                }
                if (current.src == '#remove-account') {
                    $('.fancybox-container').addClass('fancybox__white-little')
                }
                if (current.src == '#card__question') {
                    $('.fancybox-container').addClass('fancybox__white-little')
                }
                if (current.src == '#reservation') {
                    $('.fancybox-container').addClass('fancybox__white-little')
                }
                if (current.src == '#popup__search-main') {
                    $('.fancybox-slide').addClass('event-no')
                }
            },
            afterShow: function(instance, current) {
                $('.Valid').each(function(){
                    $.Valid($(this));
                });  
                $('.phone-masked').each(function(){
                    $.masked();
                }); 
                if($('.datepicker-input').length){
                    $.datepickerOp();
                };  
                if (current.src == '#popup__search-main') {
                    if(!$(current.src).find('select').hasClass('complide')){
                        $('.select').each(function(){
                            $.select($(this));
                        });
                        $('.multiple').each(function(){
                            $.selectMulte($(this));
                        });
                        $(current.src).find('select').addClass('complide')
                    }
                    if($('.datepicker__check').length != 2){
                        console.log($('.datepicker__check').length)
                        $('.datepicker:eq(1)').find('.datepicker--content').after('<div class="datepicker__check"><label><input type="checkbox"><span>Гибкие даты (+/-10 дн.)</span></label></div>'); 
                    }
                    $('body').addClass('_fixed');
                }
                
            },
            afterLoad: function(instance, current) {
                current.$content.closest('.fancybox-inner').addClass('fancy-text');
            },
            afterClose: function(instance, current) {
                $('body').removeClass('_fixed');
                if (current.src == '#popup__search-main') {
                  
                }
            },
        }
    });    
});

$.fancyOptions = {
    type: 'image',
    buttons: [
        "smallBtn"
    ],
    thumbs: {
        autoStart: true,
        axis: 'x',
        hideOnClose: true,    
        parentEl: '.fancybox-container',  
    },
    afterShow: function() {
        $('.Valid').each(function(){
            $.Valid($(this));
        });
    },
    hash: false,
    loop: true,
    btnTpl: {
       smallBtn: '<button data-fancybox-close class="fancybox-close-small-img" title="{{CLOSE}}">' +
                    '<span>Закрыть</span>' +
                    '<svg>' +
                        '<use  xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/img/sprite.svg#icon-close"></use>' +
                    '</svg>' +
                '</button>',
        arrowLeft:
          '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left">' +
                 '<svg style="width: 1.19rem; height: 0.81rem; transform: rotate(180deg);">' +
                    '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/img/sprite.svg#icon-arrow"></use>' +
                 '</svg>' +
              '</button>',

        arrowRight:
          '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right">' +
                 '<svg style="width: 1.19rem; height: 0.81rem;">' +
                    '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/img/sprite.svg#icon-arrow"></use>' +
                 '</svg>' +
            '</button>'
    },
    lang: "ru",
    i18n: {
        ru: {
          CLOSE: "Закрыть",
          NEXT: "Вперёд",
          PREV: "Назад",
          ERROR: "Запрашиваемый контент не был загружен <br/> Пожалуйста, попробуйте позднее.",
          PLAY_START: "Запустить слайдшоу",
          PLAY_STOP: "Остановить слайдшоу",
          FULL_SCREEN: "На весь экран",
          THUMBS: "Миниатюры",
          DOWNLOAD: "Скачать",
          SHARE: "Поделиться",
          ZOOM: "Увеличить"
        }
    },
    afterLoad: function(instance, current) {

        current.$content.closest('.fancybox-container').addClass('photo');
    }
}
$.fancy = function (el) {

    var $el = el;

    if (!$el.length) return;

    $el.attr('data-init', 'true');

    $el.fancybox($.fancyOptions);

};
$.Valid = function (el) {

    var $el = el;

    if (!$el.length) return;
    var validator = $el.validate({
        rules: {
            name: {
                required: true
            },
            first_name: {
                required: true
            },
            surname: {
                required: true
            },
            password: {
                required: true,
                minlength: 4,
                pwcheck: true
            },
            password1: {
                required: true,
                minlength: 4,
                pwcheck: true
            },
            password_confirmation: {
                required: true,
                minlength: 4,
                equalTo: '[name="password"]'
            },
            tel: {
                required: true,
                checkMask: true
            },
            phone: {
                required: true,
                checkMask: true
            },
            phone: {
                required: true,
                checkMask: true
            },
            check: {
                required: true
            },
            textarea: {
                required: true
            },
            message: {
                required: true
            },
            date: {
                required: true
            },
            from: {
                required: true,
                minlength: 16 
            },
            'c[]': {
                required: true
            },
            code1: {
                required: false
            },
            'code[]': {
                required: true
            },
            submitHandler: function (form) {
            }
        },
        messages:{
			from:{
				required: " ",
				minlength: " ",
			},
		},
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.Valid').addClass('error');
            $(element).addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.Valid').removeClass('error');
            $(element).removeClass('error');
        },
    })
    $.validator.addMethod("pwcheck", function(value) {
       return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) 
        //    && /[a-z]/.test(value) 
        //    && /\d/.test(value) 
    }, "Incorrect Password!");
    $.validator.addMethod("mailVal", function(value) {
       return /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value) 
    }, "Incorrect Password!");
    $.validator.addMethod("checkMask", function(value) {
         return $('.phone-masked.ok').length;
    });
};
// $('.Valid').each(function(){
//     var $this = $(this);
//     if($this.attr('method') != 'get'){
//         $this.append('<input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response" value="">');
//         grecaptcha.ready(function() {
//             grecaptcha.execute(recaptcha_key, {action:'validate_captcha'})
//             .then(function(token) {
//                 $this.find('.g-recaptcha-response').val(token);
//             });
//         });       
//     }
// })

$('.Valid:not(.noval)').each(function(){
    $.Valid($(this));
});

$(document).on('click', '.js-send', function(){
    $(this).closest('form').validate().form();
    var form = $(this).closest('form')
    var msg = $(form).serialize(),
    url = $(form).attr('action');
    if(form.validate().form()){
        // $.ajax({
        //     type: 'POST',
        //     url: url,
        //     data: msg,
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     success: function(data) {
        //         form.addClass('hidd').siblings('.application__title').text(data.message)
        //     },
        //     error:  function(data){
        //         form.addClass('hidd').siblings('.application__title').text(data.message)
        //     }
        // });
    }
    return false
}) 
$('.line-box').append('<div class="line"><i/><i/><i/><i/><i/><i/><i/><i/></div>')
document.querySelector('.header').insertAdjacentHTML('afterend', `<div class="header__menu">
        <a href="#" class="header__menu-bt"><i class="header__menu-bt-line"></i></a>
        <div class="header__menu-container">
            <a href="#" class="header__menu-bt-close"><i class="header__menu-bt-close-line"></i></a>
        </div>
    </div>`)

document.querySelector('.header__menu-container').appendChild(document.querySelector('.header__menu-list').cloneNode(true));

let menu = document.querySelector('.header__menu');
let menuBtn = document.querySelector('.header__menu-bt');
let menuBtnClose = document.querySelector('.header__menu-bt-close');
menuBtn.addEventListener('click', (e) => {
    e.preventDefault()
    menu.classList.toggle('_active')
});
menuBtnClose.addEventListener('click', (e) => {
    e.preventDefault()
    menu.classList.remove('_active')
});
document.addEventListener('click', e => {
    let target = e.target;
    let its_menu = target == menu || menu.contains(target);
    let menu_is_active = menu.classList.contains('_active');
    if (!its_menu  && menu_is_active) {
        menuBtn.classList.remove('_active')
    }
})

function moveCursor($cursor, coordX, coordY, time) {
    $cursor.addClass('is-moving');

    gsap.to($cursor, time, {
        left: coordX,
        top: coordY,
        ease: Power4.easOut
    });
}

$(document).on('mousemove', function(e){
    moveCursor($('.mouse'), e.clientX, e.clientY, 0)
});

$('.button').on('mousemove', function(e){
    moveCursor($('.button__hover'), e.offsetX, e.offsetY, .5)
});
$(document).on('mousemove', '.swiper-slide-active .first-screen__slider-trmb-img-box', function(e){
    moveCursor($('.js-position '), e.offsetX, e.offsetY, .5)
    $('.mouse').addClass('_hidd')
});
$(document).on('mouseout', '.swiper-slide-active .first-screen__slider-trmb-img-box', function(e){
    $('.mouse').removeClass('_hidd')
})
$(document).on('mousemove', '.first-screen__slider-trmb-slide:not(.swiper-slide-active) .first-screen__slider-trmb-img-box, .project__slider-button-nav-next, .team__slider_slide.swiper-slide-next, .worth__slider-slide.swiper-slide-next', function(e){
    $('.mouse').addClass('hover--2')
});
$(document).on('mouseout', '.first-screen__slider-trmb-slide:not(.swiper-slide-active) .first-screen__slider-trmb-img-box, .project__slider-button-nav-next, .team__slider_slide.swiper-slide-next, .worth__slider-slide.swiper-slide-next', function(e){
    $('.mouse').removeClass('hover--2')
})

$(document).on('mousemove', '.project__slider-button-nav-prev, .worth__slider-slide.swiper-slide-prev', function(e){
    $('.mouse').addClass('hover--3')
});
$(document).on('mouseout', '.project__slider-button-nav-prev, .worth__slider-slide.swiper-slide-prev', function(e){
    $('.mouse').removeClass('hover--3')
})
// $().hover(function () {
// }, function () {
// });
if($('.objects').length) {
    let numberLoad = 0
    $(document).on('scroll', function(){
        if($(window).scrollTop() + $(window).height() >= $('.objects__body').height() && !$('.objects__body').hasClass('stop')) {
            var listResult
            var jsonResult = new XMLHttpRequest();
            var requestSrc =  $('.objects__body').attr('data-json');
            jsonResult.open("GET", requestSrc);
            jsonResult.responseType = 'json';
            jsonResult.send();
            jsonResult.onload = function(e) {
                listResult = jsonResult.response
                var list = listResult.objects
                if(list.length < numberLoad){
                    $('.objects__body').addClass('stop')
                }
                numberLoad += 3
                $.each(list, function(key, val) {
                    if(key < numberLoad && key >= numberLoad - 3) {
                        $('.objects__item').last().after(`
                        <div class="objects__item animated animated--bottom" style="visibility: visible;">
                            <a href="#" class="objects__item_img_box">
                                <img src="${val.objectsImg}" alt="" class="objects__item_img">
                            </a>
                            <div class="objects__item_info">
                                <div class="objects__info">								
                                    <p class="objects__info_number">${val.objectsNumb}</p>
                                    <div class="objects__info_box">
                                        <p class="objects__info_name">${val.objectsName}</p>
                                        <div class="objects__info_box_wrapp">
                                            <dl class="objects__info_dl">
                                                <dt class="objects__info_dt">Город</dt>
                                                <dd class="objects__info_dd">${val.objectsCity}</dd>
                                            </dl>
                                            <dl class="objects__info_dl">
                                                <dt class="objects__info_dt">Тип объекта</dt>
                                                <dd class="objects__info_dd">${val.objectsType}</dd>
                                            </dl>
                                            <dl class="objects__info_dl">
                                                <dt class="objects__info_dt">Начало работ</dt>
                                                <dd class="objects__info_dd">${val.objectsStart}</dd>
                                            </dl>
                                            <dl class="objects__info_dl">
                                                <dt class="objects__info_dt">Окончание работ</dt>
                                                <dd class="objects__info_dd">${val.objectsEnd}</dd>
                                            </dl>
                                        </div>
                                        <a href="${val.objectsLink}" class="objects__info_link link link--type2">
                                            Подробнее											
                                            <svg class="objects__info_link_arrow link_arrow">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/img/sprite.svg#icon-arrow"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `)
                    }
                })
            } 
        }
    })
}
function mainSlider() {
    let mainSlideTrmb = new Swiper('.first-screen__slider-trmb', {
        slidesPerView: 'auto',
        speed: 700,
        loop: true,
        centeredSlides: false,
        slideToClickedSlide: true,
        allowTouchMove: false,
        breakpoints: {
            1025: {
            },
            0: {
            }
        }
    });
    mainSlideTrmb.on('slideChange', function(e) {
        $('.first-screen__slider-trmb-box').addClass('_active') 
    }); 
    let mainSlide = new Swiper('.first-screen__slider', {
        pagination: {
            el: '.first-screen__slider-pagination',
            clickable: true,
        },
        effect: 'fade',
        loop: true,
        loopedSlides: 3,
        speed: 500,
        lazy: {
            loadPrevNext: true,
        },        
    });
    mainSlideTrmb.on('slideChange', function(e) {
        mainSlide.slideTo(mainSlideTrmb.activeIndex, 1000, false); 
    }); 
}

$(document).ready(function(){
    mainSlider()
})

function aboutSlider(el) {
    let aboutSlide = new Swiper(el, {
        slidesPerView: 1,
        speed: 700,
        loop: true,
        effect: 'fade',
        loopedSlides: 1,
        lazy: {
            loadPrevNext: true,
        },                
        navigation: {
            nextEl: '.about__slider-button-nav-next',
            prevEl: '.about__slider-button-nav-prev',
        },
    });
}
aboutSlider('.about__slider')

function worthSlider(el) {
    let worthSlide = new Swiper(el, {
        slidesPerView: 'auto',
        speed: 700,
        loopedSlides: 1,
        spaceBetween: 20,
        slideToClickedSlide: true,
        lazy: {
            loadPrevNext: true,
        },                
        scrollbar: {
            el: '.worth__slider-scrollbar',
            hide: false,
        },           
    });
}
worthSlider('.worth__slider')

function projectSlider(el) {
    let projectSlide = new Swiper(el, {
        speed: 700,               
        scrollbar: {
            el: '.project__slider-scrollbar',
            hide: false,
        },            
        navigation: {
            nextEl: '.project__slider-button-nav-next',
            prevEl: '.project__slider-button-nav-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
            590: {
                slidesPerView: 2,
                spaceBetween: 25,
            },
            1024: {
                slidesPerView: 'auto',
                spaceBetween: 60,
            }
        }
    });
}
projectSlider('.project__slider-container')

function teamSlider(el) {
    let teamSlide = new Swiper(el, {
        slidesPerView: 'auto',
        speed: 700,
        centeredSlides: true,
        slideToClickedSlide: true,
        lazy: {
            loadPrevNext: true,
        },   
        breakpoints: {
            0: {
                spaceBetween: 30,
                centeredSlides: false,
            },
            590: {
                spaceBetween: 20,
                centeredSlides: false,
            },
            1024: {
                spaceBetween: 70,
                centeredSlides: true,
            },
        }     
    });
    teamSlide.on('slideChange', function(e) {
        let i = this.activeIndex
        $('.team__sliderTrmb_name').removeClass('_current')
        $('.team__sliderTrmb_li').eq(i).find('.team__sliderTrmb_name').addClass('_current')
    }); 
    $(document).on('click', '.team__sliderTrmb_name', function(){
        let i = $(this).closest('.team__sliderTrmb_li').index();
        teamSlide.slideTo(i, 1000, false);
        return false
    })
}

teamSlider('.team__slider_container')

function reviewsSlider(el) {
    let reviewsSlider = new Swiper(el, {
        speed: 700,
        centeredSlides: false,
        slideToClickedSlide: true,
        slidesPerView: 'auto',
        lazy: {
            loadPrevNext: true,
        },   
        breakpoints: {
            0: {
                spaceBetween: 20,
            },
            590: {
                spaceBetween: 30,
            },
            1024: {
                spaceBetween: 70,
            }
        }     
    });
    
}
reviewsSlider('.reviews__slider_container')

function certificateSlider(el) {
    let certificateSlider = new Swiper(el, {
        slidesPerView: 'auto',
        speed: 700,
        centeredSlides: true,
        slideToClickedSlide: true,
        breakpoints: {
            0: {
                spaceBetween: 20,
            },
            590: {
                spaceBetween: 30,
            },
            1024: {
                spaceBetween: 40,
            }
        }     
    });    
}


$(document).ready(function(){
    certificateSlider('.certificate__slider_container')
})


$(document).on('click', '.button-js-load', function(){
    let $this = $(this)
    var listResult
    var jsonResult = new XMLHttpRequest();
    var requestSrc =  $this.attr('data-json');
    jsonResult.open("GET", requestSrc);
    jsonResult.responseType = 'json';
    jsonResult.send();
    jsonResult.onload = function(e) {
        listResult = jsonResult.response
        var list = jsonResult.response.tender
        $.each(list, function(key, val) {
            $('.tender__item').last().after(`
                    <div class="tender__item  animated animated--bottom">
                    <div class="tender__item_col">
                        <p class="tender__item_name">${val.tenderNumb}</p>
                        <p class="tender__item_text">${val.tenderName}</p>
                    </div>
                    <div class="tender__item_col">
                        <p class="tender__item_text">${val.tenderTopic}</p>
                    </div>
                    <div class="tender__item_col">${val.tenderStatus}</div>
                </div>
            `)
        })
    } 
    $this.addClass('_hide')
    return false
})