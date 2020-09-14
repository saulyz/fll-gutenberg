<?php 
// NOTE: this code is meant to run in function scope

$defaults = [
  'class' => 'post-body-wrapper',
  'content' => '',
];

// $args is protected from global scope overrides
$args = wp_parse_args( $args ?? [], $defaults );

return sprintf( 
  '<div class="%1$s">%2$s</div>', 
  $args['class'], 
  $args['content']
);
