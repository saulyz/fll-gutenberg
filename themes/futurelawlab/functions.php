<?php

function fll_enqueue_styles() {
  $theme = wp_get_theme();

  wp_enqueue_style( 'futurelawlab-style', get_stylesheet_uri(), ['twentytwenty-style'], $theme->get('Version') );
  wp_enqueue_style( 'twentytwenty-style', get_template_directory_uri() . '/style.css', [], $theme->parent()->get('Version') );
}

add_action( 'wp_enqueue_scripts', 'fll_enqueue_styles' );


function fll_themeprefix_scripts() { 
    wp_enqueue_style( 'futurelawlab-fonts', fll_themeprefix_fonts_url() ); 
}

function fll_themeprefix_fonts_url() { 
    return 'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap'; 
}

add_action( 'wp_enqueue_scripts', 'fll_themeprefix_scripts' ); 