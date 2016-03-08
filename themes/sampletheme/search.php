<?php get_header(); // header.phpを読み込む ?>

	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php if ( have_posts() ) : // 記事があるかどうか ?>

				<header class="page-header">
					<h1 class="page-title">「<?php the_search_query(); // 検索キーワードを出力 ?>」の検索結果</h1>
				</header><!-- .page-header -->

				<?php
					while ( have_posts() ) : the_post(); // ループ開始

						get_template_part( 'content' ); // content.phpを読み込む

					endwhile; // ループ終了
				?>
					<nav class="navigation paging-navigation" role="navigation">
						<h1 class="screen-reader-text">投稿ナビゲーション</h1>
						<div class="pagination loop-pagination">
							<?php previous_posts_link( '<span class="meta-nav">&larr;</span> 新しい投稿 ' ); // 前の記事一覧へのリンク ?>
							<?php next_posts_link( ' 古い投稿 <span class="meta-nav">&rarr;</span>' ); // 後の記事一覧へのリンク ?>
						</div><!-- .pagination -->
					</nav><!-- .navigation -->
			<?php
				else : // 記事がなかった場合
					echo 'お探しの記事は見つかりませんでした。' ;
					get_search_form() ;

				endif;
			?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_sidebar(); // sidebar.phpを読み込む
get_footer(); // footer.phpを読み込む
