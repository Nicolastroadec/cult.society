<?php
defined( 'ABSPATH' ) or exit;


/**
 * Ajout d'un menu d'accès aux blocs réutilisables
 * 
 * @since 1.0.0
 */
function _ffecore_reusable_blocks_menu_display( $type, $args ) {
    if ( 'wp_block' !== $type ) {
        return;
    }
    $args->show_in_menu = true;
    $args->_builtin = false;
    $args->labels->name = esc_html__( "Blocs réutilisables", 'ffe-core' ); 
    $args->labels->menu_name = esc_html__( "Blocs réutilisables", 'ffe-core' ); 
    $args->menu_icon = 'dashicons-layout';
    $args->menu_position = 58;
}
add_action( 'registered_post_type', '_ffecore_reusable_blocks_menu_display', 10, 2 );


/**
 * Récupération du contenu d'un bloc réutilisable via son id
 * 
 * @since 1.0.0
 */
function ffe_get_reusable_block( $block_id, $echo = true ) {
    if( empty( $block_id ) ) {
        return;
    }
    $block = get_post( (int)$block_id );
    if( $block ) {
        $block_content = apply_filters( 'the_content', $block->post_content );
        if( $echo ) {
            echo $block_content;
        } else {
            return $block_content;
        }
    }
    return;
}


/**
 * Récupération de la liste des blocs réutilisables sous la forme d'un tableau id => nom
 * 
 * @since 1.0.0
 */
function ffe_get_reusable_block_list() {
    $blocks_list = array(
        '' => "-- " . __( "Aucun", 'ffe-core' ) . " --"
    );

    $blocks = new WP_Query( array(
        'post_type' => 'wp_block',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ) );
    if( $blocks->have_posts() ) {
        while( $blocks->have_posts() ) {
            $blocks->the_post();
            $block_id = get_the_ID();
            $blocks_list[$block_id] = get_the_title();
        }
    }
    
    return $blocks_list;
}
