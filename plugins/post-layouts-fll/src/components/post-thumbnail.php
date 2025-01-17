<?php 
// NOTE: this code is meant to run in function scope

$defaults = [
  'class' => 'post-thumbnail',
];

// $args is protected from global scope overrides
$args = wp_parse_args( $args ?? [], $defaults );

if ( empty( $args['src'] ) ) {
  return '';
}

$alt = ( isset( $args['alt'] ) ) ? 'alt="' . esc_attr( $args['alt'] ) . '"' : '';

return sprintf( 
  '<img class="%1$s" src="%2$s" %3$s>', 
  $args['class'], esc_url( $args['src'] ), $alt
);
