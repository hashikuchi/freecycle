<?php get_header(); // header.phpを読み込む ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php if ( post_type_exists( 'bookreview' ) ) : // カスタム投稿タイプbookreviewがあるかどうか ?>
			<header class="page-header">
				<h1>最近読んだ本</h1>
			</header><!-- .page-header -->

			<?php
			$args = array( 'posts_per_page' => 3, 'post_type' => 'bookreview' ); // データを取得する条件を設定
			$myposts = get_posts( $args ); // データを取得
			if ($myposts) : // データがあるかどうか
				foreach ( $myposts as $post ) : setup_postdata( $post ); // 配列$mypostsから、要素を1つずつ取り出し、$postに格納 ?>
					<article id="post-<?php the_ID(); // 投稿IDを出力 ?>" <?php post_class(); // クラス属性を出力 ?>>
						<div class="entry-content">
							<?php the_terms( $post->ID, 'genre','<span class="entry-meta"><span class="tag-links">', '', '</span></span>' ) // カスタム投稿タイプに付けた、カスタム分類を表示 ?>
							<a href="<?php the_permalink(); // 記事へのリンクを出力 ?>"><?php the_title(); // タイトルを出力 ?></a>
						</div>
					</article>
			<?php
				endforeach; 
				wp_reset_postdata(); // データを元に戻す。setup_postdataの最後に必ず書く
			else:
				echo '記事はありません' ; 
			endif; ?>
		<?php endif;?> 

			<?php if ( have_posts() ) : // 記事があるかどうか
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
					echo '記事はありません' ;

				endif;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar(); // sidebar.phpを読み込む
get_footer(); // footer.phpを読み込む
