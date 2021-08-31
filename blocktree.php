<?php
/**
 * Plugin Name:       Blocktree
 * Description:       Build a Linktree-like page with blocks
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Cadu de Castro Alves
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blocktree
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
 */

function blocktree_register_block_type() {

	$asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php' );

	wp_register_script(
		'blocktree-script',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version']
	);

	register_block_type( 'castroalves/blocktree', [
		'editor_style' => 'blocktree-styles',
		'editor_script' => 'blocktree-script',
		'render_callback' => 'blocktree_render_callback',
	] );
}
add_action( 'init', 'blocktree_register_block_type' );

function blocktree_enqueue_scripts() {
	wp_enqueue_style(
		'blocktree-styles', 
		plugin_dir_url(__FILE__) . 'build/style-index.css',
		['twenty-twenty-one-style']
	);
}
add_action('wp_enqueue_scripts', 'blocktree_enqueue_scripts');

function blocktree_render_callback( $attr ) {
	$linkTarget = (bool) $attr['linkTarget'] ? 'target="_blank" rel="noopener noreferrer"' : '';
	$html = '<div class="blocktree-link-item">';
	$html .= '<a href="'.$attr['linkUrl'].'"'.$linkTarget.'>'.$attr['linkTitle'].'</a>';
	$html .= '</div>';
	return $html;
}

function dd( $content ) {
	echo '<pre>';
	print_r($content);
	echo '</pre>';
	die();
}
