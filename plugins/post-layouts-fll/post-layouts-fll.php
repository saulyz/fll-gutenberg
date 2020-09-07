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
    'attributes' => array(
      'content' => array(
        'type' => 'string',
      ),
      'postId' => array(
        'type' => 'number',
      ),
      'className' => array(
        'type' => 'string',
      ),
    ),
		'style' => 'post-layouts-fll-style',
		'editor_style' => 'post-layouts-fll-style-editor',
    'editor_script' => 'post-layouts-fll-scripts',
    'render_callback' => 'featured_post_render_callback',
  ) );

  register_block_type( 'post-layouts-fll/category-post-list', array(
    'attributes' => array(
      'content' => array(
        'type' => 'string',
      ),
      'className' => array(
        'type' => 'string',
      ),
    ),
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

function category_post_list_render_callback( $attributes ) {
  $limit = 10;
  
  $recent_posts = wp_get_recent_posts( array(
    'numberposts' => $limit,
    'post_status' => 'publish',
  ) );
  if ( count( $recent_posts ) === 0 ) {
      return 'No posts';
  }

  $block_title = ( $attributes['content'] ) ? sprintf( '<h2>%1$s</h2>', $attributes['content'] ) : '';

  $list_item_markup = '';

  foreach ( $recent_posts as $post ) {
    $post_id = $post['ID'];

    $title = get_the_title( $post_id );

    $list_item_markup .= sprintf(
      '<li><a href="%1$s">%2$s</a></li>',
      esc_url( get_permalink( $post_id ) ),
      esc_html( $title )
    );
  }
  
  $class = 'wp-block-post-layouts-fll-category-post-list';
  if ( isset( $attributes['className'] ) ) {
    $class .= ' ' . $attributes['className'];
  }

  $block_content = sprintf(
    '<div class="%1$s">%2$s<ul>%3$s</ul></div>',
    esc_attr( $class ),
    $block_title,
    $list_item_markup
  );

  return $block_content;
}

function featured_post_render_callback( $attributes ) {
  $post_id = ( $attributes['postId'] ) ? $attributes['postId'] : null;

  if ( ! empty( $post_id ) ) {

    $recent_posts = get_posts( array(
      'numberposts' => 1,
      'post_status' => 'publish',
      'include' => $post_id,
      ) );

  } else {
    $recent_posts = array();
  }
  if ( count( $recent_posts ) === 0 ) {
    return 'No posts';
  }

  $block_title = ( $attributes['content'] ) ? 
    sprintf( '<h2 class="featured-label">%1$s</h2>', $attributes['content'] ) 
    : 
    '';

  $class = 'wp-block-post-layouts-fll-featured-post';
  if ( isset( $attributes['className'] ) ) {
    $class .= ' ' . $attributes['className'];
  }

  $title = get_the_title( $post_id );
  $link = sprintf( '<a href="%1$s">%2$s</a>',
    esc_url( get_permalink( $post_id ) ),
    esc_html( $title )
  );
  $post_thumbnail_url = get_the_post_thumbnail_url( $post_id );
  $thumbnail = ( ! empty( $post_thumbnail_url ) ) ? 
    sprintf( '<img class="post-thumbnail" src="%1$s"',
      esc_url( get_the_post_thumbnail_url( $post_id ) )
    )
    :
    '';

  $post_markup = '<div class="post">' . $thumbnail . $link . '</div>';

  $block_content = sprintf( '<div class="%1$s">%2$s</div>', 
    esc_attr( $class ),
    $block_title . $post_markup
  );

  return $block_content;
}
