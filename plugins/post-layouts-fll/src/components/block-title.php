<?php 
// NOTE: this code is meant to run in function scope

$defaults = [
  'tag' => 'h2',
  'title' => '',
];

// $args is protected from global scope overrides
$args = wp_parse_args( $args ?? [], $defaults );

// title can be html elements

return ( ! empty( $args['title'] ) ) ?
  sprintf( '<%1$s class="block-title">%2$s</%1$s>', $args['tag'], $args['title'] )
  : 
  '';
