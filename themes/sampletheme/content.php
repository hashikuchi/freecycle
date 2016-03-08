<article id="post-<?php the_ID(); // 投稿IDを出力 ?>" <?php post_class(); // クラス属性を出力 ?>>
	<div class="post-thumbnail">
	<?php the_post_thumbnail(); // アイキャッチを出力 ?>
	</div>
	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' ); // 個別投稿
			else :
				the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); // 個別投稿でない
			endif;
		?>

		<div class="entry-meta">
			投稿日: <?php the_date(); // 投稿日を出力 ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( '続きを読む' ); // 本文を出力 ?>
	</div><!-- .entry-content -->

	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); // タグ名、タグアーカイブへのリンクを出力 ?>
</article><!-- #post-## -->
