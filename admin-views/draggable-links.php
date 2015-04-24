<ul>
	<?php
	foreach( $links as $_link ){
		?>
		<li id="postID-<?php echo $_link->ID; ?>" class="<?php echo $_link->cats; ?>">
			<div class="menu-item-handle">
				<span class="item-title">
					<?php echo $_link->post_title ?>
				</span>
			</div>
		</li>
	<?php
	}
	?>
</ul>