<?php

function register_acf_block_types_userpage() {

    // register a testimonial block.
    acf_register_block_type(array(
        'name'              => 'sedoo_userpage',
        'title'             => __('Userpage'),
        'description'       => __('Ajoute un élément userpage'),
        'render_callback'   => 'sedoo_blocks_userpage_render_callback',
        'category'          => 'widgets',
        'icon'              => 'admin-comments',
        'keywords'          => array( 'userpage', 'sedoo' ),
    ));
}

// Check if function exists and hook into setup.
if( function_exists('acf_register_block_type') ) {
    add_action('acf/init', 'register_acf_block_types_userpage');
}