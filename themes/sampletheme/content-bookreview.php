<article id="post-<?php the_ID(); // 投稿IDを出力 ?>" <?php post_class(); // クラス属性を出力 ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); // タイトルを出力 ?>

		<div class="entry-meta">
			投稿日: <?php the_date(); // 投稿日を出力 ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( '続きを読む' ); // 本文を出力 ?>
		<table>
		<tr><td>書籍名</td><td><?php echo esc_html( get_post_meta( $post->ID, '書籍名', true ) ); // カスタムフィールド「書籍名」のデータを出力 ?></td></tr>
		<tr><td>出版社</td><td><?php echo esc_html( get_post_meta( $post->ID, '出版社', true ) ); // カスタムフィールド「出版社」のデータを出力 ?></td></tr>
		<tr><td>著者</td><td><?php echo esc_html( get_post_meta( $post->ID, '著者', true ) ); // カスタムフィールド「著者」のデータを出力 ?></td></tr>
		<tr><td>価格</td><td><?php echo esc_html( get_post_meta( $post->ID, '価格', true ) ); // カスタムフィールド「価格」のデータを出力 ?>円</td></tr>
		</table>
	</div><!-- .entry-content -->

	<?php the_terms( $post->ID, 'genre', '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); // カスタム投稿タイプに付けた、カスタム分類を表示 ?>
</article><!-- #post-## -->
