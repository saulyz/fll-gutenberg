<?php 
// NOTE: this code is meant to run in function scope

$defaults = [
  'tag' => 'h3',
  'class' => 'post-title',
  'title' => '',
];

// $args is protected from global scope overrides
$args = wp_parse_args( $args ?? [], $defaults );

return sprintf( '<%1$s class="%2$s">%3$s</%1$s>', 
  $args['tag'], esc_attr( $args['class'] ), $args['title']
);
