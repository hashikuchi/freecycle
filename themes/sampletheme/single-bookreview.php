<?php get_header(); // header.phpを読み込む ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				while ( have_posts() ) : the_post(); // ループ開始
					get_template_part( 'content', 'bookreview' ); // content-bookreview.phpを読み込む

	// ↓ 紙面では、HTMLを省略 ?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text">投稿ナビゲーション</h1>
		<div class="nav-links">
	<?php // ↑ 紙面では、HTMLを省略

					previous_post_link( '%link', '<span class="meta-nav">前の記事</span>%title' ); // 前記事へのリンク
					next_post_link( '%link', '<span class="meta-nav">次の記事</span>%title' ); // 後記事へのリンク

	// ↓ 紙面では、HTMLを省略 ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php // ↑ 紙面では、HTMLを省略

					if ( comments_open() || get_comments_number() ) { // コメント機能が有効、またはコメントが存在する場合は、コメントテンプレートを出力する
						echo '<div id="comments" class="comments-area">'; // 紙面ではHTMLを省略
						comments_template();
						echo '</div>'; // 紙面ではHTMLを省略
					}
				endwhile; // ループ終了
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php

get_sidebar(); // sidebar.phpを読み込む
get_footer(); // footer.phpを読み込む
