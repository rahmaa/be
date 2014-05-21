<?php
/**
 * Template Name: Home - Simple
 * The template used for displaying page content in page.php
 *
 * @author Heath Taskis | http://f-d.com.au
 * @package FD 0.1
 */

get_header(); 


/*
**
**
**
        Featured Slider
**
**
**
*/


		            
?>

<!-- masterslider -->
<?php

  $feat_post = new WP_Query();
  $feat_post->query('category_name=Featured&orderby=rand'); 

  if ( $feat_post->have_posts() ) {
  echo '<div class="master-slider ms-skin-default " id="masterslider">';
  while ($feat_post->have_posts()) : $feat_post->the_post();

  $header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 

  
  ?>
    <!-- new slide -->
    <div class="ms-slide" data-delay="5">
        <!-- slide background -->
        <img src="<?php echo get_template_directory_uri() ?>/ico/blank.gif" data-src="<?php echo $header_img[0]; ?>" alt="lorem ipsum dolor sit"/>     
        <!-- slide text layer -->
        <div class="ms-layer ms-caption">
        	<span class="readtime"><?php
        	$readtime_sec = WP_MinsToRead::get_mtr(get_the_ID()); 
        	echo $readtime_sec;
        	?></span>
        	<h2 class="rounded">FEATURED</h2>

        	<a href="<?php echo the_permalink(); ?>" style="text-decoration:none;">
           	<h1 style="" class="ms-h1"><?php echo the_title(); ?></h1></a>
           	<div class="lead">
           		<?php echo the_excerpt(); ?>
           	</div>
			<a href="<?php echo the_permalink(); ?>" target="_self"><button class="homeCta">Read More</button></a>
        </div>
    </div>
    <!-- end of slide -->
<?php	

$do_not_duplicate = $post->ID;
endwhile; 

echo '
	</div>
	<!-- end of masterslider -->
	 ';
};

wp_reset_postdata();
wp_enqueue_script( 'masterslider-settings-js', get_template_directory_uri().'/js/masterslider.settings.js',array(),'20131031',true);    
?>
	<div class="container" >
	<div class="row">
		<div  class="tab-content home-tabs">
			<?php
	        echo '<div class="col-md-12 col-lg-12">
				  	<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">';


    $args=array(
      'post_type' => 'post'
      );
query_posts( $args );

									 if ( have_posts() ) : ?>
									
										<?php while ( have_posts() ) : the_post(); ?>
							
											<?php  // if( $post->ID == $do_not_duplicate ) continue;
												/* Include the Post-Format-specific template for the content.
												 * If you want to override this in a child theme, then include a file
												 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
												 */
												get_template_part('content', 'simple');												
												$do_not_duplicate = $post->ID;
											?>
							
										<?php endwhile; ?>
							
										<?php 
										upbootwp_content_nav('nav-below'); 
										 else : ?>
											<?php get_template_part( 'no-results', 'index' ); ?>
										<?php endif; ?>
			
						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!-- .col-md-8 -->

		</div><!-- .row -->
	</div><!-- .container -->
<?php get_footer(); ?>