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

define( 'COMPONENTS', plugin_dir_path( __FILE__ ) . 'src/components' );

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
 
  $dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "post-layouts-fll" blocks first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'post-layouts-fll-scripts',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);
	wp_set_script_translations( 'post-layouts-fll-scripts', 'post-layouts-fll' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'post-layouts-fll-style-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'post-layouts-fll-style',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
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

  register_block_type( 'post-layouts-fll/wrapper-block', array(
		'style' => 'post-layouts-fll-style',
		'editor_style' => 'post-layouts-fll-style-editor',
    'editor_script' => 'post-layouts-fll-scripts',
  ) );
 
}





// Dynamic callbacks

function category_post_list_render_callback( $attributes ) {
  $limit = 10;
  
  $recent_posts = wp_get_recent_posts( array(
    'numberposts' => $limit,
    'post_status' => 'publish',
  ) );
  if ( count( $recent_posts ) === 0 ) {
      return 'No posts';
  }

  $block_title = get_plugin_component( 'block-title', ['title' => $attributes['content'] ] );

  $post_list_items = '';

  foreach ( $recent_posts as $post ) {
    $post_id = $post['ID'];
    $post_list_items .= $post = get_post_render( $post_id );
  }
  $post_list = '<div class="post-list">' . $post_list_items . '</div>';
  
  $class = 'wp-block-post-layouts-fll-category-post-list';
  if ( isset( $attributes['className'] ) ) {
    $class .= ' ' . $attributes['className'];
  }

  $block_content = sprintf(
    '<div class="%1$s">%2$s</div>',
    esc_attr( $class ),
    $block_title . $post_list
  );

  return $block_content;
}


function featured_post_render_callback( $attributes ) {
  //error_log('featured_post_render_callback:: ' . var_export(func_get_args(), true));

  $post_id = $attributes['postId'] ?? null;

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

  $class = 'wp-block-post-layouts-fll-featured-post';
  if ( isset( $attributes['className'] ) ) {
    $class .= ' ' . $attributes['className'];
  }

  $block_title = get_plugin_component( 'block-title', ['title' => $attributes['content'] ] );
  $post = get_post_render( $post_id );

  $block_content = sprintf( '<div class="%1$s">%2$s</div>', 
    esc_attr( $class ),
    $block_title . $post
  );

  return $block_content;
}


function get_plugin_component( $name, $args ) {
  // $args is applied in component scope as component params array
  return require( COMPONENTS . "/$name.php" );
}


function get_post_render( $post_id ) {
  $post_title = get_the_title( $post_id );
  $post_link = get_plugin_component( 'link', 
    [
      'href' => get_permalink( $post_id ), 
      'content' => $post_title
    ]
  );
  $post_title_with_link = get_plugin_component( 'post-title', ['title' => $post_link ] );

  $post_meta = get_plugin_component( 'post-meta-set', 
    [
      'post_id' => $post_id,
      'reading_time' => get_post_reading_time( $post_id )
    ]
  );

  $group_body = get_plugin_component( 'post-body-wrapper', 
    ['content' => $post_meta . $post_title_with_link  ]
  );

  $post_thumb_url = get_the_post_thumbnail_url( $post_id );
  $post_thumbnail = get_plugin_component( 'post-thumbnail', ['src' => $post_thumb_url] );

  $group_thumbnail = get_plugin_component( 'post-thumbnail-wrapper', 
    ['content' => $post_thumbnail ]
  );

  return '<div class="post">' 
    . $group_thumbnail 
    . $group_body 
    . '</div>';
}


function get_post_reading_time( $post_id ) {
  $content = get_post_field( 'post_content', $post_id );
  $word_count = str_word_count( strip_tags( $content ) );
  $reading_time = ceil( $word_count / 200 );
  return $reading_time . ' min';
}