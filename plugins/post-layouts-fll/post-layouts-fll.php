<?php
/** 
 * Plugin Name: Post Layouts Future Law Lab
 * Description: Blocks for Future Law Lab project posts presentation
 * Author: Saulius Vikerta
 * Author URI: https://github.com/saulyz
 * Version: 1.1.0
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Text Domain: post-layouts-fll
 */

defined( 'ABSPATH' ) || exit;


add_action( 'init', 'post_layouts_fll_load_text_domain' );

function post_layouts_fll_load_text_domain() {
	load_plugin_textdomain( 'post-layouts-fll', false, basename( __DIR__ ) . '/languages' );
}


add_action( 'init', 'post_layouts_fll_register_blocks' );

function post_layouts_fll_register_blocks() {

  if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}
 
  // automatically load dependencies and version
  $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

  wp_register_script(
      'post-layouts-fll-scripts',
      plugins_url( 'build/index.js', __FILE__ ),
      $asset_file['dependencies'],
      $asset_file['version']
  );

  wp_register_style(
		'post-layouts-fll-style-editor',
		plugins_url( 'editor.css', __FILE__ ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' )
	);

	wp_register_style(
		'post-layouts-fll-style',
		plugins_url( 'style.css', __FILE__ ),
		array( ),
		filemtime( plugin_dir_path( __FILE__ ) . 'style.css' )
	);

	register_block_type( 'post-layouts-fll/featured-post', array(
		'style' => 'post-layouts-fll-style',
		'editor_style' => 'post-layouts-fll-style-editor',
    'editor_script' => 'post-layouts-fll-scripts',
  ) );

  register_block_type( 'post-layouts-fll/category-post-list', array(
		'style' => 'post-layouts-fll-style',
		'editor_style' => 'post-layouts-fll-style-editor',
    'editor_script' => 'post-layouts-fll-scripts',
    'render_callback' => 'category_post_list_render_callback',
  ) );
  
  if ( function_exists( 'wp_set_script_translations' ) ) {
    /**
     * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
     * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
     * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
     */
    wp_set_script_translations( 'post-layouts-fll-scripts', 'post-layouts-fll' );
  }
 
}

function category_post_list_render_callback( $block_attributes, $content ) {
  $limit = 10;
  
  $recent_posts = wp_get_recent_posts( array(
      'numberposts' => $limit,
      'post_status' => 'publish',
  ) );
  if ( count( $recent_posts ) === 0 ) {
      return 'No posts';
  }
  
  $output  = '<div class="wp-block-post-layouts-fll-featured-post">' . PHP_EOL;
  foreach ($recent_posts as $post) {
    $post_id = $post['ID'];
    $output .= '<div class="post">' . PHP_EOL;
    $output .= sprintf(
      '<a href="%1$s">%2$s</a>',
      esc_url( get_permalink( $post_id ) ),
      esc_html( get_the_title( $post_id ) )
    );
    $output .= '</div>' . PHP_EOL;
  }
  $output .= '</div>' . PHP_EOL;
  
  return $output;
}
