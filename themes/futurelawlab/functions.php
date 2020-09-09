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
