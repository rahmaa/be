<?php
/**
 * The Template for displaying all single posts.
 *
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
get_header(); ?>
<?php while (have_posts()) : the_post(); 
// Views Counter
setPostViews(get_the_ID());
echo '<div id="progress"><div id="bar"></div></div>';
?><div class="container"><div class="row"><div class="title-scroll">
				<span class="readtime"><?php
	        	$readtime_sec = WP_MinsToRead::get_mtr(get_the_ID()); 
	        	echo $readtime_sec;
	        	?></span>
<?php echo the_title(); ?> </div></div></div>
<?php

?>
	<div class="container" style="margin-top: 30px;">
		<div class="row">
			<div class="col-md-12">
				<span class="readtime">
					<i class="icon-bookmark" style="margin-right: 5px;"></i>
						<?php
		        	$readtime_sec = WP_MinsToRead::get_mtr(get_the_ID()); 
		        	echo $readtime_sec;
		        	?>
	        	</span>
				<a href="<?php print $_SERVER['HTTP_REFERER'];?>" style="font-size: 11px;"><i class="icon-chevron-left" ></i> &nbsp;BACK </a><br/><br/>
				<h1 class="entry-title-single"><?php the_title(); ?></h1>	
				<hr class="blog-title-rule"/>						
			</div>
		</div>
	</div>	
<?php endwhile; // end of the loop. ?>
	<div class="container" >
		<div class="row">
			<div class="col-md-8">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
			
					<?php while ( have_posts() ) : the_post(); ?>
			
						<?php get_template_part( 'content', 'single' ); ?>
						<?php // include( 'inc/post-share.php' ); // Get Share Button template ?>	
						<?php //upbootwp_content_nav( 'nav-below' ); ?>
			
						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() )
								comments_template();
						?>
			
					<?php endwhile; // end of the loop. ?>
			
					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- .col-md-8 -->
			
			<div class="col-md-4">
				<div id="secondary" class="widget-area">
				<?php 				if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Post')) : 
				endif; ?>
				</div>
			</div><!-- .col-md-4 -->
		</div><!-- .row -->
		<hr class="hr-dashed" />
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Below Post Content')) : ?>

		<?php endif; ?>
	</div><!-- .container -->
<?php get_footer(); ?>