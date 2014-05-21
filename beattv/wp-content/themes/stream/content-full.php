<?php
/**
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( has_post_thumbnail() ) {

		$header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');	?>
	<?php  

	?>	
	<div class="article-wrap preview-post effect-slide-left" data-effect="slide-left">
	<div class="row">

		<div class="col-md-5 entry-tn" style="background-image: url('<?php echo $header_img[0]; ?>');background-repeat:no-repeat; background-size: cover; -webkit-background-size: cover;">
			 <a href="<?php echo the_permalink(); ?>" target="_self"><?php if(function_exists('taqyeem_get_score')) { 			taqyeem_get_score();  		} ?><div class="pad-blog-tn" style=""></div></a>
		</div>
		<div class="col-md-7  art-ent-simple" >
			<div class=" article-entry">
				<header class="entry-header">
					<!-- .entry-meta -->
					<span class="readtime"><i class="icon-bookmark" style="margin-right: 5px;"></i><?php
		        	$readtime_sec = WP_MinsToRead::get_mtr(get_the_ID()); 
		        	echo $readtime_sec;
        			
        	?>		</span><p class="article-post-date"><?php echo get_the_date(); ?></p>
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				</header><!-- .entry-header -->
				<div class="entry-summary">
					<p class="excerpt"><?php the_excerpt(); ?></p>
					<a href="<?php echo the_permalink(); ?>" target="_self"><button class="moreCta">Read More</button></a>
					<!-- <i class="icon-comments post-comm-link" style=""></i> -->
				</div><!-- .entry-summary -->
			</div>
		</div>
	<?php	
	} else { 		?>
	<div class="article-wrap preview-post effect-slide-left" data-effect="slide-left">
	<div class="row">

			<div class="col-md-12  art-ent-simple" >
				<div class=" article-entry">
				<header class="entry-header">
				<!-- .entry-meta -->
					<span class="readtime"><i class="icon-bookmark" style="margin-right: 5px;"></i><?php
        				$readtime_sec = WP_MinsToRead::get_mtr(get_the_ID()); 
        				echo $readtime_sec;
        	?>		</span><p class="article-post-date"><?php echo get_the_date(); ?></p>
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				</header><!-- .entry-header -->
				<div class="entry-summary">
					<p class="excerpt"><?php the_excerpt(); ?></p>
					<a href="<?php echo the_permalink(); ?>" target="_self"><button class="moreCta">Read More</button></a>
				</div><!-- .entry-summary -->
			</div>
	<?php }; ?>				
	<footer class="entry-meta">
		<span class="comments-link">
		<?php //endif; ?>
	</footer>
	</div><!-- /div row -->
	</div><!-- /article wrap -->
</article><!-- #post-## -->
