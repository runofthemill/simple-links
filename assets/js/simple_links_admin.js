/**
 * Admin js for Simple Links Plugin
 *
 * @author Mat Lipe <mat@matlipe.com>
 * @type {Simple_Links|*|{}}
 */
var Simple_Links = window.Simple_Links || {};

(function( $, s, i18n, config ){
	s.sort = {
		init : function(){
			if( $( '.draggable-children' ).length < 1 ){
				return;
			}

			//Setup the Draggable list
			$( '.draggable-children' ).sortable( {
				placeholder : 'sortable-placeholder menu-item-depth-1',
				stop : function(){
					s.sort.sort( $( this ).attr( 'id' ) );
				}
			} );


			//the filter by Categories
			$( '#SL-sort-cat' ).change( function(){
				s.sort.catFilter( $( this ).val() );
			} );
		},

		/**
		 * Runs the ajax with the new link order
		 * @param string linkID the id of the sortable list
		 * @since 8/15/12
		 */
		sort : function( linkID ){
			/**
			 * @TODO
			 *
			 * We need to grad the selected category and send that along with the sort order
			 * So we may save the sort order by that category.
			 *
			 * We may then later sort by the category's specific sort order when displaying
			 * s
			 */


			//Get the new sort order
			var data = $( 'ul#' + linkID ).sortable( "serialize" );

			$.post( config.sort_url, data, function( response ){
			} );
		},


		/**
		 * Hide all items on the list that are not in the selected category
		 * @param string slug the categories slug
		 * @since 8/15/12
		 */
		catFilter : function( slug ){

			/**
			 *
			 * @TODO
			 *
			 * We only show 200 links in the list so
			 * hiding is not cutting it when there are more than 200
			 * When we select a category we need to retrieve the links
			 * for that category via ajax
			 * and repopulate the list
			 *
			 *
			 */

			//To Reset the category sort
			if( slug == 'Xall-catsX' ){
				$( '#SL-drag-ordering li' ).show( 'slow' );
				$( '#SL-drag-ordering li' ).each( function(){
					cleanID = $( this ).attr( 'id' ).replace( /x/g, '' );
					$( this ).attr( {'id' : cleanID} );
				} );

				return;
			}

			//Show and fix the id of all list items in this category by id
			$( '#SL-drag-ordering li.' + slug ).show( 'slow' );
			$( '#SL-drag-ordering li.' + slug ).each( function(){
				cleanID = $( this ).attr( 'id' ).replace( /x/g, '' );
				$( this ).attr( {'id' : cleanID} );
			} );

			//Hide and break the id of all the list items not in this category
			$( '#SL-drag-ordering li' ).not( '.' + slug ).hide( 'slow' );
			$( '#SL-drag-ordering li' ).not( '.' + slug ).each( function(){
				$( this ).attr( {'id' : 'x' + $( this ).attr( 'id' )} );
			} );
		}
	};


	s.easter = {
		init : function(){
			$( '.simple-links-title' ).change( function(){
				if( $( this ).val() == "Simple Links" ){
					for( var i = 0; i < 10; i++ ){
						$( this ).css( {'box-shadow' : '0px 0px 10px ' + i + 'px yellow'} );
					}
					$( this ).after( '<h2><center>HALLELUJAH!!</center></h2>' );
				}
			} );
		}
	};


	$( function(){
		s.sort.init();
		s.easter.init();
	} );


})( jQuery, Simple_Links, SL_locale, simple_links_sort );