<article id="post-<?php the_ID(); // 投稿IDを出力 ?>" <?php post_class(); // クラス属性を出力 ?>>
	<?php
		the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' ); // タイトルを出力
	?>

	<div class="entry-content">
		<?php
			the_content(); // 本文を出力
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
