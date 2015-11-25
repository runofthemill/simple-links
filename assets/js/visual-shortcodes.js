/**
 * Convert the output to a placholder image and back to the output
 *
 * @see !!! on line 11 or so
 */
(function(){

	/* convert to placeholder */
	tinymce.PluginManager.add( 'simpleLinksShortcodeWrapper', function( editor ){
		function wrapSimpleLinksShortcodes( content ){
			return content.replace( /\[simple-links([^\]]*)\]/g, function( match ){
				return html( 'simple-links', match );
			} );
		}

		function stripEmbedCodes( content ){
			return content.replace( /(\[embed\])(\[simple-links([^\]]*)\])(\[\/embed\])/g, function( match ){
				match = match.replace( "[embed]", '' );
				match = match.replace( "[/embed]", '' );

				return match;

			} );
		}

		function html( shortcode ){
			return '[embed][' + shortcode + '][/embed]';

		}

		editor.on( 'BeforeSetContent', function( event ){
			var $original = event.content;
			event.content = wrapSimpleLinksShortcodes( event.content );
			if( event.content != $original ){
				/**
				 * Find a way to make the editor update on the
				 * first entry of this autowrap
				 *
				 *
				 *
				 *
				 *
				 */
				//editor.execCommand("onChange");
			}
		} );

		editor.on('PostProcess', function(event) {

			/**
			 * If the setting is turned off then use this to strip the
			 * embeds from the content.
			 *
			 * Also make sure that if the setting is on that
			 * the embed don't break stuff on the front end,
			 * they should use their default and therefore
			 * no embeds.
			 *
			 *
			 *
			 */

			if (event.get) {
				//event.content = stripEmbedCodes( event.content );
			}
		});

	} );

})();