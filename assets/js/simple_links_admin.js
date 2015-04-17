/**
 * Simple links admin jquery
 *
 * @author Mat Lipe
 *
 */


var isSimpleLinks = false;

jQuery( function( $ ){

	//A boolean to make sure we are on the right page
	if( $( 'input[type="hidden"][name="post_type"]' ).val() == 'simple_link' ){
		isSimpleLinks = true;
	} else {
		if( $( 'input[type="hidden"][name="taxonomy"]' ).val() == 'simple_link_category' ){
			isSimpleLinks = true;
		}
	}

	//easter egg
	$( '.simple-links-title' ).change( function(){
		if( $( this ).val() == "Simple Links" ){
			for( var i = 0; i < 10; i++ ){
				$( this ).css( {'box-shadow' : '0px 0px 10px ' + i + 'px yellow'} );
			}
			$( this ).after( '<h2><center>HALLELUJAH!!</center></h2>' );
		}
	} );

	SLsortPage.init();
	SLsettings.init();

} );

var $s = jQuery.noConflict();


/**
 * The Simple Links Settings Page
 * @since 8/17/12
 */
var SLsettings = {
	init : function(){
		//Add another Row for the additional fields
		$s( '#simple-link-additional' ).click( function(){
			$s( '#link-additional-placeholder' ).after( $s( '#link-extra-field' ).html() );
			return false;
		} );
	}
};


/**
 * The link Sorting Page methods
 * @since 1.23.14
 */
var SLsortPage = {
	init : function(){
		if( $s( '.draggable-children' ).length < 1 ){
			return;
		}

		//Setup the Draggable list
		$s( '.draggable-children' ).sortable( {
			placeholder : 'sortable-placeholder menu-item-depth-1', stop : function(){
				SLsortPage.sort( $s( this ).attr( 'id' ) );
			}
		} );


		//the filter by Categories
		$s( '#SL-sort-cat' ).change( function(){
			SLsortPage.catFilter( $s( this ).val() );
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
		var data = $s( 'ul#' + linkID ).sortable( "serialize" );

		$s.post( sl_sort_url, data, function( respon ){
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
			$s( '#SL-drag-ordering li' ).show( 'slow' );
			$s( '#SL-drag-ordering li' ).each( function(){
				cleanID = $s( this ).attr( 'id' ).replace( /x/g, '' );
				$s( this ).attr( {'id' : cleanID} );
			} );

			return;
		}

		//Show and fix the id of all list items in this category by id
		$s( '#SL-drag-ordering li.' + slug ).show( 'slow' );
		$s( '#SL-drag-ordering li.' + slug ).each( function(){
			cleanID = $s( this ).attr( 'id' ).replace( /x/g, '' );
			$s( this ).attr( {'id' : cleanID} );
		} );

		//Hide and break the id of all the list items not in this category
		$s( '#SL-drag-ordering li' ).not( '.' + slug ).hide( 'slow' );
		$s( '#SL-drag-ordering li' ).not( '.' + slug ).each( function(){
			$s( this ).attr( {'id' : 'x' + $s( this ).attr( 'id' )} );
		} );
	}
};