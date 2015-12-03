<?php get_header(); // header.phpを読み込む ?>


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<header class="page-header">
				<h1 class="page-title">お探しのページは見つかりませんでした。</h1>
			</header>

			<div class="page-content">
				<p>お探しのページは見つかりませんでした。よろしければ検索してください。</p>

				<?php get_search_form(); // 検索フォームを出力 ?>
			</div><!-- .page-content -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php

get_sidebar(); // sidebar.phpを読み込む
get_footer(); // footer.phpを読み込む
