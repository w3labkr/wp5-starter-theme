// the semi-colon before the function invocation is a safety net against concatenated 
// scripts and/or other plugins that are not closed properly
;(function ( $, window, document, undefined ) {
    Nk = window.Nk || {};

    Nk.init = function() {

        // vendor
        this.initOwlCarousel2();
        this.initSlick();
        this.initMasonry();
        this.initHighlight();
        this.initNkScroll();
        this.initNkGeography();
        // this.initNkDialog();

        this.onMenuOpened();
        this.onHashChangeAnimation();

        // this.onLoad();
        // this.onResizeAndOrientationchange();
        // this.onTracking();

    };

    Nk.initNkScroll = function() {
        if ( !$('#scroll-to-top').length ) { return; }

        $('#scroll-to-top').scrolling();

    };

    Nk.initOwlCarousel2 = function() {
        if ( !$('.owl-carousel').length ) { return; }

        $('.owl-carousel').on( 'initialized.owl.carousel', function(event) {
            // hide slider initialize image
            if ( !! $(this).prev('.slider-initialize').length ) {
                $(this).prev('.slider-initialize').hide();
            }
        })
        .owlCarousel({
            center: false,
            loop:false,
            items:1,
            nav:true,
            navClass: ['ir-phark slider-arrow slider-prev','ir-phark slider-arrow slider-next'],
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            dots:false
        });

    };

    Nk.initSlick = function() {
        if ( !$('.slider-slick').length ) { return; }

        var $slides = $('.slider-slick');

        $slides.on( 'init', function(event, slick){
            /**
             * slick kills background-attachment
             * @link https://github.com/kenwheeler/slick/issues/941
             */
            $(this).find(".slick-list").css("transform", "none");
            $(this).find(".slick-track").css("transform", "none");
            // hide slider initialize image
            if ( !! $(this).prev('.slider-initialize').length ) {
                $(this).prev('.slider-initialize').hide();
            }
        })
        .slick({
            fade: true,
            infinite: false,
            slidesToShow: 1,
            prevArrow : '<button type="button" class="slider-arrow slider-prev outer-arrow ir-phark">Previous</button>',
            nextArrow : '<button type="button" class="slider-arrow slider-next outer-arrow ir-phark">Next</button>',
            dots: false
        });

    };

    Nk.initMasonry = function() {
        if ( !$('#main.masonry .columns').length ) { return; }

        // init Isotope after all images have loaded
        var $grid = $('#main.masonry .columns').imagesLoaded(function(){
            // init Isotope
            $grid.masonry({
                itemSelector: '.column',
                percentPosition: true
            });
        });

    };

    Nk.initHighlight = function() {
        if ( !$('.highlight').length ) { return; }

        hljs.initHighlightingOnLoad();

    };

    Nk.initNkGeography = function() {
        if ( !$('.map-google').length ) { return; }

        $('.map-google').geography({
            google: {
                api: {
                    uri: 'https://maps.googleapis.com/maps/api/js',
                    key: '', // API KEY
                    language: 'en',
                    region: 'AU'
                },
                map: {
                    zoom: 8,
                    styleWizard: 'retro'
                }
            }
        });

    };

    Nk.initNkDialog = function() {
        $('.nkdialog').NkDialog({
            target: {
                header: '.entry-title',
                content: '.entry-summary',
                footer: '.entry-permalink'
            }
        });
    }

    Nk.onMenuOpened = function() {
        $('#navbtn, #navbg').on('click.Nk.menuOpened', function(e){
            if(!$(this).length) { return; }

            e = e || window.e;
            e.preventDefault();

            $('body').toggleClass('menu-opened');
        });
    }

    Nk.onHashChangeAnimation = function() {
        var doHashChangeAnimate = function(hash) {
            var duration = 100;
            $('html,body').stop().animate({ 
                scrollTop: $(hash).offset().top - $('#masthead').height()
            }, duration, function() {
                window.history.replaceState({}, '', hash);
            });
        };

        // When a document ready
        if ( !!window.location.hash ) {
            doHashChangeAnimate(window.location.hash);
        }

        // Add hashChanged event handler 
        $('a').each(function(){
            if ( !this.hash ){ return; }
            $(this).on('click.Nk.hashChangeAnimation', {href:this.getAttribute('href')}, function(e){
                e = e || window.e;
                if ( /^#/.test(e.data.href) ) {
                    e.preventDefault();
                } else {
                    e.stopPropagation();
                }
                doHashChangeAnimate(this.hash); 
            });
        });
    }

    Nk.onTracking = function() {
        if ( !$('#download a').length ) { return; }

        $('#download a').on('click.Nk.googleAnalyticsTracking',function(event){
            var split = $(this).attr('href').split('/');
            var filename = split[split.length-1].replace('?raw=true','');
            gtag('event', 'ZIP', {
              'event_category': 'Download',
              'event_label': filename,
              'value': 1
            });
        });

    }

    Nk.onLoad = function() {
        var run = function() {
            // ...
        };
        $(window).on('load.Nk', run);
    }

    Nk.onResizeAndOrientationchange = function() {
        var opts = {
            orientationchange: false,
            resized: false,
            resize: true
        };
        if( opts.orientationchange ) {
            this.onOrientationchange();
        } else if( opts.resied ) {
            this.onResized();
        } else if( opts.resize ) {
            this.onResize();
        }
    }

    Nk.onResize = function() {
        var timer = null, delta = 0;
        var run = function() {
            // ...
        };
        $(window).on('resize.Nk', function(){
            clearTimeout( timer );
            timer = setTimeout( run, delta );
        });
    }

    Nk.onResized = function() {
        var timer = null, delta = 250;
        var run = function() {
            // ...
        };
        $(window).on('resize.Nk.resized', function(){
            clearTimeout( timer );
            timer = setTimeout( run, delta );
        });
    }

    Nk.onOrientationchange = function() {
        var timer = null, delta = 0;
        var run = function() {
            // ...
        };
        if ('orientation' in window) {
            $(window).on('orientationchange.Nk', function(){
                clearTimeout( timer );
                timer = setTimeout( run, delta );
            });
        }
    }

    Nk.init();
})( jQuery, window, document );