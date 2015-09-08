<?php get_header(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>

	<!--div id="content"-->
		<div class="padder">

		<?php do_action( 'bp_before_archive' ); ?>

		<div class="page" id="blog-archives" role="main">

			<h3 class="pagetitle"><?php printf('「%1$s」の商品一覧', wp_title( false, false ) ); ?></h3>

<!------------------------------------------------------------------------------------------->
			<?php 
				if ( have_posts() ) :
				bp_dtheme_content_nav( 'nav-above' ); 
				$count = 1;
				$row= 2;
				$is_closed = false;
				
				echo('<div class="grid_center">');
				while (have_posts()){
					the_post();
					do_action( 'bp_before_blog_post' );
			?>
			
				<div id="post-<?php the_ID(); ?>" class="grid">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array(150, 150)) ?></a>
						<?php 
							wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); 
						?>
					<div class="grid_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
					<span class="grid_text"><?php the_content(); ?></span>
					<div class="grid_author"><?php the_author(); ?></div>
				</div>
			<?php
				do_action( 'bp_after_blog_post' );
				$count++;
			}

			bp_dtheme_content_nav( 'nav-below' ); 
		?>

<!------------------------------------------------------------------------------------------->
			<?php 
				else : /*見つからなかった*/
				echo('<h2 class="center">'._e( 'Not Found', 'buddypress' ).'</h2>');
				get_search_form();
				endif; 
			?>
<!------------------------------------------------------------------------------------------->

		</div>

		<?php do_action( 'bp_after_archive' ); ?>

		</div><!-- .padder -->
	<!--/div--><!-- #content -->

	<!--?php get_sidebar(); ?-->

<?php get_footer(); ?>

<!--可変グリッドアニメーション----------------------------------------------------------->
	<script type="text/javascript">
		jQuery(function(){
    	jQuery('.grid_center').masonry({
      	itemSelector: '.grid',
      	isFitWidth: true,
      	isAnimated: true,
				isFitWidth : true
    	});
		});
	</script>
<!----------------------------------------------------------------------------------->
