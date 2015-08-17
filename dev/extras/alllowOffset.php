<?php

add_action( 'simple_links_widget_form', 'sl_offset', 9, 2 );
if( !function_exists( 'sl_offset' ) ){
    function sl_offset( $instance, \WP_Widget $object ){
        $instance[ 'offset' ] = empty( $instance[ 'offset' ] ) ? 0 : $instance[ 'offset' ];
        ?>
        <strong>Offset</strong>
        <input type="number" id="<?php echo $object->get_field_id( 'offset' ); ?>" name="<?php echo $object->get_field_name( 'offset' ); ?>" value="<?php echo esc_attr( $instance[ 'offset' ] ); ?>" class="widefat"/>
        <?php

    }
}

add_filter( 'simple_links_parsed_query_args', 'sl_allow_offset', 1, 2 );
function sl_allow_offset( $args, \SimpleLinksFactory $object ){
    if( !empty( $object->args[ 'offset' ] ) ){
        $args[ 'offset' ]      = (int) $object->args[ 'offset' ];
        $args[ 'numberposts' ] = $args[ 'numberposts' ] == - 1 ? 1000000 : $args[ 'numberposts' ];
    }

    return $args;
}