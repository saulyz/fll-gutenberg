<?php 
// NOTE: this code is meant to run in function scope

$defaults = [
  'wrapper-class' => 'post-details',
  'class' => 'post-meta',
];

// $args is protected from global scope overrides
$args = wp_parse_args( $args ?? [], $defaults );

if ( empty( $args['post_id'] ) ) {
  return '';
}

$author_id = get_post_field( 'post_author', $args['post_id'] );
$display_name = get_the_author_meta( 'display_name' , $author_id );
$icon = '<div class="author-thumbnail">' . strtoupper( substr( $display_name, 0, 1 ) ). '</div>';
$date_published = get_the_date( 'Y M d' );
$reading_time = ( isset( $args['reading_time'] ) ) ? $args['reading_time'] : '';

$post_meta_texts = sprintf( '<div class="%1$s-wrapper"><div class="%1$s">%2$s</div><div class="%1$s">%3$s</div></div>',
  esc_attr( $args['class'] ), 
  $display_name, 
  ( ! empty( $reading_time ) ) ? $date_published . ' - ' . $reading_time : $date_published
);

return sprintf( '<div class="%1$s">%2$s</div>', 
  esc_attr( $args['wrapper-class'] ), 
  $icon . $post_meta_texts
);
