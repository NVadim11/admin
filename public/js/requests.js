$.ajaxSetup({
	headers: {
		"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
	},
});

if($('.js-article-load').length) {
	let numberLoad = 0;
	var loading = false;

	$(document).on('scroll', function(){
		$loadbox('.js-click-load-article', loadArticle)
	})
	$(document).on('click', '.js-click-load-article', function(){
		loadArticle()
		return false
	})
	function loadArticle(){
		if($(window).scrollTop() + $(window).height() >= $('.js-article-load').height() && !$('.js-article-load').hasClass('stop')) {
			if (loading == false) {
				loading = true;
				var action = $(".interview__list").data('json');
				var all_items = $(".all-articles-count").val();
				var current_items = $(".interview__item").length;
				var filter = $(".filter a._current").data('val');
				var locale = $("html").attr('lang');

				if (current_items < all_items) {
					$(".load-box").show();
					setTimeout(function () {
						$.post(action, { items: current_items, _token: $('meta[name="csrf-token"]').attr('content'), filter: filter, locale: locale }, function (list) {

							$.each(list, function(key, val) {
								var filterHide;
								// if(filter != 'all' && val.articleFilter != filter){
								// 	filterHide = '_hide'
								// }

								if(val.articleImg != undefined ){
									$('.interview__item').last().after(`
									   <article class="interview__item  animated animated--type-2 ${filterHide}" data-filter="${val.articleFilter}">
										   <a href="${val.articleLink}" class="interview__img-box">
											   <img class="interview__img" src="${val.articleImg}">
										   </a>
										   <div class="interview__desc">
											   <div class="interview__time">
												   <span>${val.articleTime}</span>
												   <span>${val.articleDate}</span>
											   </div>
											   <a href="${val.articleLink}">${val.articleTitle}</a>
											   <p>${val.articleText}</p>
										   </div>
									   </article>
								   `)
								}else {
									$('.interview__item').last().after(`
									   <article class="interview__item interview__item--big  animated animated--type-2 ${filterHide}" data-filter="${val.articleFilter}">
										   <div class="interview__desc">
											   <div class="interview__time">
												   <span>${val.articleTime}</span>
												   <span>${val.articleDate}</span>
											   </div>
											   <a href="${val.articleLink}">${val.articleTitle}</a>
											   <p>${val.articleText}</p>
										   </div>
									   </article>
								   `)
								}
							})



							// $(".loader").removeClass("_open");
							loading = false;
						});
					}, 500);
				} else {
					$(".load-box").hide();
				}
			}
		}
	}
}

if($('.js-events-load').length) {
	let numberLoad = 0
	var loading = false;
	$(document).on('scroll', function(){
		$loadbox('.js-click-load-event', loadEvents)
	})
	$(document).on('click', '.js-click-load-event', function(){
		loadEvents()
		return false
	})
	function loadEvents(){

		if($(window).scrollTop() + $(window).height() >= $('.js-events-load').height() && !$('.js-events-load').hasClass('stop')) {

			if (loading == false) {
				loading = true;
				var action = $(".interview__list").data('json');
				var all_items = $(".all-events-count").val();
				var current_items = $(".interview__item").length;
				var locale = $("html").attr('lang');

				if (current_items < all_items) {
					$(".load-box").show();
					setTimeout(function () {
						$.post(action, { items: current_items, _token: $('meta[name="csrf-token"]').attr('content'), locale: locale }, function (list) {

							$.each(list, function(key, val) {

								$('.interview__item').last().after(`
									<article class="interview__item  animated animated--type-2">
										<a href="${val.eventsLink}" class="interview__img-box">
											<img class="interview__img" src="${val.eventsImg}">
										</a>
										<div class="interview__desc">
											<div class="interview__time">
												<span>${val.eventsTime}</span>
												<span>${val.eventsDate}</span>
											</div>
											<a href="${val.eventsLink}">${val.eventsTitle}</a>
											<p>${val.eventsText}</p>
										</div>
									</article>
								`);

							})

							loading = false;
						});
					}, 500);
				} else {
					$(".load-box").hide();$(".load-box").hide();
				}
			}
		}
	}
}

if($('.js-interview-load').length) {
	let numberLoad = 0;
	var loading = false;

	$(document).on('scroll', function(){
		$loadbox('.js-click-load-interview', loadInterview)
	})
	$(document).on('click', '.js-click-load-interview', function(){
		loadInterview()
		return false
	})
	function loadInterview(){
		if($(window).scrollTop() + $(window).height() >= $('.js-interview-load').height() && !$('.js-interview-load').hasClass('stop')) {

			if (loading == false) {
				loading = true;
				var action = $(".interview__list").data('json');
				var all_items = $(".all-interviews-count").val();
				var current_items = $(".interview__item").length;
				var locale = $("html").attr('lang');

				if (current_items < all_items) {
					$(".load-box").show();
					setTimeout(function () {
						$.post(action, { items: current_items, _token: $('meta[name="csrf-token"]').attr('content'), locale: locale }, function (list) {

							$.each(list, function(key, val) {

								$('.interview__item').last().after(`
									<article class="interview__item  animated animated--type-2">
										<a href="${val.interviewLink}" class="interview__img-box">
											<img class="interview__img" src="${val.interviewImg}">
										</a>
										<div class="interview__desc">
											<div class="interview__time">
												<span>${val.interviewTime}</span>
												<span>${val.interviewDate}</span>
											</div>
											<a href="${val.interviewLink}">${val.interviewTitle}</a>
											<p>${val.interviewText}</p>
										</div>
									</article>
								`);
							})

							loading = false;
						});
					}, 500);
				} else {
					$(".load-box").hide();
				}
			}
		}
	}
}

if($('.js-books-page-load').length) {
	let numberLoad = 0;
	var loading = false;
	$(document).on('scroll', function(){
		$loadbox('.js-click-load-books-page', loadBook)
	})
	$(document).on('click', '.js-click-load-books-page', function(){
		loadBook()
		return false
	})
	function loadBook(){
		if($(window).scrollTop() + $(window).height() >= $('.js-books-page-load').height() && !$('.js-books-page-load').hasClass('stop')) {

			if (loading == false) {
				loading = true;
				var action = $(".books-page__list").data('json');
				var all_items = $(".all-books-count").val();
				var current_items = $(".books-page__item").length;
				var filter = $(".filter a._current").data('val');
				var locale = $("html").attr('lang');

				if (current_items < all_items) {
					$(".load-box").show();
					setTimeout(function () {
						$.post(action, { items: current_items, _token: $('meta[name="csrf-token"]').attr('content'), filter: filter, locale: locale}, function (list) {

							$.each(list, function(key, val) {
								$('.books-page__item').last().after(`
								   <div class="books-page__item  books-page__item--type-2 animated animated--type-2" data-filter="${val.booksTags}">
									   <a href="${val.booksLink}" class="books-page__item_img-box js-parallax js-parallax-no">
										   <img src="${val.booksImg}" alt="">
									   </a>
									   <div class="books-page__item_text">
										   <div class="books-page__item_text_container">
											   <div class="books-page__item_info">
												   <span>${val.booksDate}</span>
												   <span>${val.booksAuthorship}</span>
											   </div>
											   <a href="${val.booksLink}">${val.booksTitle}</a>
											   <p>${val.booksText}</p>
											   <a href="${val.booksLinkShop}" class="books-page__item_shop" target="_blank">
												   <span>В магазин</span>
												   <svg>
													   <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/html/img/sprite.svg#icon-arrow-bt"></use>
												   </svg>
											   </a>
										   </div>
									   </div>
								   </div>
							   `);
							});

							loading = false;
						});
					}, 500);
				} else {
					$(".load-box").hide();
				}
			}
		}
	}
}

if($('.js-gallery-page-load').length) {
	let numberLoad = 0;
	var loading = false;

	$(document).on('scroll', function(){
		$loadbox('.js-gallery-page-load', loadEvents)
	})
	$(document).on('click', '.js-gallery-page-load', function(){
		loadEvents()
		return false
	})
	function loadEvents(){
		if($(window).scrollTop() + $(window).height() >= $('.js-gallery-page-load').height() && !$('.js-gallery-page-load').hasClass('stop')) {

			if (loading == false) {
				loading = true;
				var action = $(".js-gallery-page-load").data('json');
				var all_items = $(".all-gallery-count").val();
				var hidden_items = $(".gallery-page__item._hide").length;
				var current_items = ($(".gallery-page__item").length) - 1;
				var filter = $(".filter a._current").data('val');
				var locale = $("html").attr('lang');
				if (current_items < all_items) {
					$(".load-box").show();
					setTimeout(function () {
						$.post(action, { items: current_items, _token: $('meta[name="csrf-token"]').attr('content'), filter: filter, locale: locale}, function (list) {
							var typeClass,
								sizeClass,
								desc,
								descTitle
							$.each(list, function(key, val) {
								if(val.galleryType == "photo"){
									typeClass = 'gallery-page__item--photo'
								}else {
									typeClass = 'gallery-page__item--video'
								}
								if(val.gallerySize == "w2"){
									sizeClass = 'gallery-page__item--w2'
								}else {
									sizeClass = ""
								}
								if(val.galleryDesc != undefined) {
									desc = `<p class="gallery-page__desc">${val.galleryDesc}</p>`
									descTitle = val.galleryDesc
								}else {
									desc = ""
									descTitle = ""
								}
								$('.gallery-page__item').last().after(`
								   <a href="#" class="gallery-page__item ${typeClass} ${sizeClass}" data-title="${descTitle}" data-src="${val.galleryLink}" data-fancybox="group-1" data-filter="${val.galleryFilter}">
									   <img src="${val.galleryImg}" alt="">      
									   ${desc}                          
								   </a>
							   `)
							});

							loading = false;
							$('.filter__link._current').each(function(){
								let link = $(this).data('link');
								if(link != 'all'){
									$('[data-filter]').each(function(){
										var tags = $(this).attr('data-filter');
										if(!tags.includes(link)) {
											$(this).removeClass('_hide')
										}else {
											$(this).removeClass('_hide')
										}
									})
								}
							});
							if(list.length !=0) {
								if($('.js-massonry').length){
									$('.js-massonry').each(function () {
										$(this).masonry();
									});
									// $('[data-fancybox]').fancybox().update();
								}
							}
						});


					}, 500);
				} else {
					$(".load-box").hide();
				}
			}
		}
	}
	$('.filter__link').on("click", function(){
		$('.gallery-page__item').remove();
		$(".gallery-page__container").append('<a href="#" class="gallery-page__item animated animated--type-2" data-fancybox="group-1"></a>');
		if (loading == false) {
			loading = true;
			var action = $(".js-gallery-page-load").data('json');
			var hidden_items = $(".gallery-page__item._hide").length;
			var current_items = ($(".gallery-page__item").length - hidden_items)-1;
			var filter = $(this).data('val');
			var locale = $("html").attr('lang');

			$(".load-box").show();
			setTimeout(function () {
				$.post(action, { items: current_items, _token: $('meta[name="csrf-token"]').attr('content'), filter: filter, locale: locale}, function (list) {
					var typeClass,
						sizeClass,
						desc,
						descTitle
					$.each(list, function(key, val) {
						if(val.galleryType == "photo"){
							typeClass = 'gallery-page__item--photo'
						}else {
							typeClass = 'gallery-page__item--video'
						}
						if(val.gallerySize == "w2"){
							sizeClass = 'gallery-page__item--w2'
						}else {
							sizeClass = ""
						}
						if(val.galleryDesc != undefined) {
							desc = `<p class="gallery-page__desc">${val.galleryDesc}</p>`
							descTitle = val.galleryDesc
						}else {
							desc = ""
							descTitle = ""
						}
						$('.gallery-page__item').last().after(`
						   <a href="#" class="gallery-page__item" data-title="${descTitle}" data-src="${val.galleryLink}" data-fancybox="group-1" data-filter="${val.galleryFilter}">
							   <img src="${val.galleryImg}" alt="">      
							   ${desc}                          
						   </a>
					   `)
					});

					loading = false;
					$('.filter__link._current').each(function(){
						let link = $(this).data('link')
						if(link != 'all'){
							$('[data-filter]').each(function(){
								var tags = $(this).attr('data-filter');
								if(!tags.includes(link)) {
									$(this).removeClass('_hide')
								}else {
									$(this).removeClass('_hide')
								}
							})
						}
					});
					if(list.length !=0) {
						if($('.js-massonry').length){
							$('.js-massonry').each(function () {
								$(this).masonry();
							});
							// $('[data-fancybox]').fancybox().update();
						}
					}
				});

			}, 500);
		}
	});
}

if($('.search').length) {
	let linkPage = window.location.href;

	if(linkPage.indexOf('tag=')!=-1){
		linkPage = linkPage.split('?')[1].replace(/tag=/g, '')
		linkPage=linkPage.split('&')
		loadSearch(linkPage)
		let tagList = linkPage
		for (let i = 0; i < tagList.length; i++) {
			$('[data-teg="'+tagList[i]+'"]').addClass('_active')
		}
	}else {
		let tags = []
		loadSearch(tags)
	}
	let numberLoad = 0
	function loadSearch(tags){
		var loading = false;
		if($(window).scrollTop() + $(window).height() >= $('.search').height() && !$('.search').hasClass('stop')) {

			if (loading == false) {
				loading = true;
				var action = $(".search").data('json');
				var locale = $("html").attr('lang');

					setTimeout(function () {
						$.post(action, { _token: $('meta[name="csrf-token"]').attr('content'), locale: locale, tags: tags}, function (list) {

							// arrayFilterTagId
							$.each(list, function(key, val) {
								if(tags.length > 0){
									let arr = val.searchFilter.split(',')
									for (let i = 0; i < arr.length; i++) {
											$('.search').append(`
											<div class="search__item" data-teg="${val.searchFilter}">
											<div class="search__tags-list"></div>
											<a href="${val.searchLink}" class="search__name">${val.searchTitle}</div>
											</div>
										`)
										let arr = val.searchTags.split(',')
											for (let i = 0; i < arr.length; i++) {
												$('.search__item').last().find('.search__tags-list').append(
													`<div class="search__tag">${arr[i]}</div>`
												)
											}

									}
								}else {
									$('.search').append(`
										<div class="search__item" data-teg="${val.searchFilter}">
										<div class="search__tags-list"></div>
										<a href="${val.searchLink}" class="search__name">${val.searchTitle}</div>
										</div>
									`)
									let arr = val.searchTags.split(',')
									for (let i = 0; i < arr.length; i++) {
										$('.search__item').last().find('.search__tags-list').append(
											`<div class="search__tag">${arr[i]}</div>`
										)
									}
								}
							})

							loading = false;
						});

					}, 500);
			}
		}
	}
}

if($('.filter').length){
    $('.filter').on('click', '.filter__link', function(){
        let link = $(this).data('link')
        $(this).addClass('_current').siblings('.filter__link').removeClass('_current')
        sessionStorage.setItem('filter', link);
        if(link != 'all'){
            $('[data-filter]').each(function(){
                var tags = $(this).attr('data-filter');
                if(!tags.includes(link)) {
                    $(this).addClass('_hide')
                }else {
                    $(this).removeClass('_hide')
                }
            })
        }else {
            $('._hide[data-filter]').removeClass('_hide')
        }
        if($('.js-massonry').length){
            $('.js-massonry').each(function () {
               $(this).masonry();
            });
        }
        if($('.books-page__container').length){
            sliderBooks.destroy()
            sliderBooksSl()
        }
        return false
    })
}