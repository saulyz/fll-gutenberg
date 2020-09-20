<?php

// based on Plugin "Post List Layout FLL"

?>
<div class="entry-content category-post">
  <?= post_layouts_fll_get_post_render( get_the_ID() ); ?>
</div>