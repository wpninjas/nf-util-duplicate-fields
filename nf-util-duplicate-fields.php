<?php

/*
 * Plugin Name: Ninja Forms - [Utility] Duplicate Fields
 */

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'src/Plugin.php';

add_action( 'plugins_loaded', 'nf_util_duplicate_fields' );

function nf_util_duplicate_fields() {

    static $instance;
    if ( is_null( $instance ) ) {
        $instance = new NF_Util_DuplicateFields_Plugin( '1.0.0', __FILE__ );
    }

    return $instance;
}
