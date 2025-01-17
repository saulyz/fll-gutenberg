<?php
/**
 * Category template file
 */

get_header();
?>

<main id="site-content" role="main">

	<?php
	
	$category 			= get_queried_object();
	$brand_mark_url = get_stylesheet_directory_uri() . '/assets/images/fll-logo-section-white.svg';
	$artwork_url 	  = get_stylesheet_directory_uri() . '/assets/images/' . $category->slug . '-bg.svg';

	if ( $category->name || $category->description ) {
		?>

		<header class="archive-header header-footer-group has-category-artwork"
			style="background-image: url(<?= $artwork_url ?>)"
		>

			<div class="category-header-inner section-inner medium">

				<div class="brand-mark">
					<img src="<?= $brand_mark_url ?>" alt="FLL brand mark">
				</div>
				<div class="row">
					<div class="col col-6-lg category-header-frame">

						<?php if ( $category->name ) { ?>
							<h1 class="category-title"><?php echo wp_kses_post( $category->name ); ?></h1>
						<?php } ?>

						<?php if ( $category->description ) { ?>
							<div class="category-description"><?php echo wp_kses_post( wpautop( $category->description ) ); ?></div>
						<?php } ?>

					</div>
				</div>

			</div><!-- .archive-header-inner -->

		</header><!-- .archive-header -->

		<?php
	}

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			if ( function_exists( 'post_layouts_fll_get_post_render' ) ) {
				// if post-layouts-fll plugin is active, use its' post render 
				get_template_part( 'template-parts/post-layouts-fll-post-list' );
			} else {
				// use standard theme post content template-part
				get_template_part( 'template-parts/content', get_post_type() );
			}

		}
	} elseif ( is_search() ) {
		?>

		<div class="no-search-results-form section-inner thin">

			<?php
			get_search_form(
				array(
					'label' => __( 'search again', 'twentytwenty' ),
				)
			);
			?>

		</div><!-- .no-search-results -->

		<?php
	}
	?>

	<?php get_template_part( 'template-parts/pagination' ); ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
