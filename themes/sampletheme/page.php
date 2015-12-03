<?php get_header(); // header.phpを読み込む ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php	
				while ( have_posts() ) : the_post(); // ループ開始

					get_template_part( 'content', 'page' ); // content-page.phpを読み込む

				endwhile; // ループ終了
			?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar(); // sidebar.phpを読み込む
get_footer(); // footer.phpを読み込む