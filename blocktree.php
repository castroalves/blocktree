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

namespace CastroAlves;

class Blocktree {

	private $backgroundColor;
	private $textColor;

	public function __construct()
	{
		add_action( 'init', [$this, 'blocktree_register_block_type'] );	
		add_action( 'wp_enqueue_scripts', [$this, 'blocktree_enqueue_scripts'] );
	}

	public function blocktree_register_block_type() {

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
			'render_callback' => [$this, 'blocktree_render_callback'],
		] );
	}
	

	public function blocktree_enqueue_scripts() {
		wp_enqueue_style(
			'blocktree-styles', 
			plugin_dir_url(__FILE__) . 'build/style-index.css',
			['twenty-twenty-one-style']
		);

		if ($this->backgroundColor && $this->textColor) {
			$inlineCss = '
			.blocktree-link-item > a,
			.blocktree-link-item > a:focus {
				background-color: ' . $this->backgroundColor . ',
				color: ' . $this->textColor . ',
			}
			';
	
			wp_add_inline_style('blocktree-styles', $inlineCss);
		}
	}

	public function blocktree_render_callback( $attr ) {

		$this->backgroundColor = $attr['linkBgColor'];
		$this->textColor = $attr['linkTextColor'];

		$linkTarget = (bool) $attr['linkTarget'] ? 'target="_blank" rel="noopener noreferrer"' : '';
		$html = '<div class="blocktree-link-item">';
		$html .= '<a href="'.$attr['linkUrl'].'"'.$linkTarget.'>'.$attr['linkTitle'].'</a>';
		$html .= '</div>';

		return $html;
	}

	private function dd( $content ) {
		echo '<pre>';
		print_r($content);
		echo '</pre>';
		die();
	}

	
}

$blocktree = new Blocktree;
