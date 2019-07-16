<?php
/**
 * Plugin Name: building-gutenberg-blocks — CGB Gutenberg Block Plugin
 * Plugin URI: https://github.com/ahmadawais/create-guten-block/
 * Description: building-gutenberg-blocks — is a Gutenberg plugin created via create-guten-block.
 * Author: mrahmadawais, maedahbatool
 * Author URI: https://AhmadAwais.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

function building_gutenberg_blocks_cgb_front_end_scripts() {
    wp_enqueue_script( 
		'building_gutenberg_blocks_dropdown_front_end_script', 
		plugins_url( '/building-gutenberg-blocks/src/dropdown/front-end.js', dirname( __FILE__ ) ), 
		array( 'jquery' ), 
		null, 
		true 
	);
}
add_action( 'init', 'building_gutenberg_blocks_cgb_front_end_scripts' );
