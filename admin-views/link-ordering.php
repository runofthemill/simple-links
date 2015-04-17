<div class="wrap">
	<h2>
		<?php _e( 'Keeping Your Links In Order', 'simple-links' ); ?>!
	</h2>

	<?php
	if( is_array( $categories ) ){
		?>
		<h3>
			<?php _e( 'Select a link category to sort links in that category only ( optional )', 'simple-links' ); ?>
		</h3>
		<select id="SL-sort-cat">
			<option value="Xall-catsX">
				<?php _e( 'All Categories', 'simple-links' ); ?>
			</option>

			<?php
			foreach( $categories as $_cat ){
				printf( '<option value="%s">%s</option>', $_cat->term_id, $_cat->name );
			}
			?>
		</select>
	<?php

	} else {
		?>
		<h3>
			<?php _e( 'To sort by link categories, you must add some links to them', 'simple-links' ); ?>.
			<a href="/wp-admin/edit-tags.php?taxonomy=<?php echo Simple_Links_Categories::TAXONOMY; ?>&post_type=<?php echo SIMPLE_LINK::POST_TYPE; ?>">
				<?php _e( 'Follow Me', 'simple-links' ); ?>
			</a>
		</h3>
	<?php
	}
	?>

	<ul class="draggable-children" id="SL-drag-ordering">
		<?php

		#-- Create the items list
		foreach( $links as $link ){
			?>
			<li id="postID-<?php echo $link->ID; ?>" class="<?php echo $link->cats; ?>">
				<div class="menu-item-handle">
					<span class="item-title"><?php echo $link->post_title ?></span>
				</div>
			</li>
		<?php
		}
		?>
	</ul>
</div>