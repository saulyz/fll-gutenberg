<?php 
// NOTE: this code is meant to run in function scope

$defaults = [
  'content' => '',
];

// $args is protected from global scope overrides
$args = wp_parse_args( $args ?? [], $defaults );

if ( empty( $args['href'] ) || empty( $args['content'] ) ) {
  return '';
}

$class = ( isset( $args['class'] ) ) ? ' class="' . esc_attr( $args['class'] ) . '"' : '';
$target = ( isset( $args['target'] ) ) ? ' target="' . esc_attr( $args['target'] ) . '"' : '';
$href = ' href="' . esc_url( $args['href'] ) . '"';
$content = esc_html( $args['content'] );

return "<a{$class}{$href}{$target}>$content</a>";
