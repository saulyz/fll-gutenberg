<?php

function fll_enqueue_styles() {
  $theme = wp_get_theme();

  wp_enqueue_style( 'futurelawlab-style', get_stylesheet_uri(), ['twentytwenty-style'], $theme->get('Version') );
  wp_enqueue_style( 'twentytwenty-style', get_template_directory_uri() . '/style.css', [], $theme->parent()->get('Version') );
}

add_action( 'wp_enqueue_scripts', 'fll_enqueue_styles' );


function fll_webfonts() {
    wp_enqueue_style( 
      'futurelawlab-fonts', 
      'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap'
    );
}

add_action( 'wp_enqueue_scripts', 'fll_webfonts' ); 
add_action( 'enqueue_block_editor_assets', 'fll_webfonts', 1, 1 );

function fll_block_editor_styles() {
	wp_enqueue_style( 'futurelawlab-block-editor-styles', get_stylesheet_directory_uri() . '/editor-style-block.css', ['futurelawlab-fonts'] );
}

add_action( 'enqueue_block_editor_assets', 'fll_block_editor_styles', 1, 1 );


function fll_block_editor_settings() {

	$editor_color_palette = array(
		array(
			'name'  => __( 'Accent Color', 'futurelawlab' ),
			'slug'  => 'accent',
			'color' => fll_get_color_for_area( 'content', 'accent' ),
		),
		array(
			'name'  => __( 'Primary', 'futurelawlab' ),
			'slug'  => 'primary',
			'color' => fll_get_color_for_area( 'content', 'text' ),
		),
		array(
			'name'  => __( 'Secondary', 'futurelawlab' ),
			'slug'  => 'secondary',
			'color' => fll_get_color_for_area( 'content', 'secondary' ),
		),
		array(
			'name'  => __( 'Subtle Background', 'futurelawlab' ),
			'slug'  => 'subtle-background',
			'color' => fll_get_color_for_area( 'content', 'borders' ),
		),
	);

	$background_color = get_theme_mod( 'background_color' );
	if ( ! $background_color ) {
		$background_color_arr = get_theme_support( 'custom-background' );
		$background_color     = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name'  => __( 'Background Color', 'futurelawlab' ),
		'slug'  => 'background',
		'color' => '#' . $background_color,
	);

	if ( $editor_color_palette ) {
		add_theme_support( 'editor-color-palette', $editor_color_palette );
	}

	// Block Editor Font Sizes. Used from parent theme.

	add_theme_support( 'editor-styles' );

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ( '#ffffff' === strtolower( fll_get_color_for_area( 'content', 'text' ) ) ) {
		add_theme_support( 'dark-editor-style' );
	}

}

add_action( 'after_setup_theme', 'fll_block_editor_settings' );


function fll_get_color_for_area( $area = 'content', $context = 'text' ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
    'accent_accessible_colors',
    
    // defaults for this child theme
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#A91815',
				'secondary' => '#7D848C',
				'borders'   => '#dcd7ca',
			),
			'header-footer' => array(
				'text'      => '#FFFFFF',
				'accent'    => '#E62B27',
				'secondary' => '#C1C3B6',
				'borders'   => '#dcd7ca',
			),
		)
	);

	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {
		return $settings[ $area ][ $context ];
	}

	return false;
}