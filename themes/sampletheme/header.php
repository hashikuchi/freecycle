<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="ja">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="ja">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html lang="ja">
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); // 文字コードUTF-8を出力 ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); // タイトルを出力 ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); // XML-RPCファイルのURLを出力 ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); // get_template_directory_uri: テーマのディレクトリのURLを出力, esc_url: 正しいURLかどうかを確認する ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); // head要素に文字コードやページタイトル、読み込むCSSやJSへのリンクを出力。HTMLのヘッダーの最後に必ず書く ?>
</head>

<body <?php body_class(); // 現在のページに応じて、CSSクラス属性を出力 ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<div class="header-main">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); // home_url: サイトのホームページのURLを出力, esc_url: 正しいURLかどうかを確認する ?>" rel="home"><?php bloginfo( 'name' ); // サイト名を出力 ?></a>
</h1>

			<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<h1 class="menu-toggle">メニュー</h1>
				<a class="screen-reader-text skip-link" href="#content">コンテンツへジャンプする</a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); // メニューを出力 ?>
			</nav>
		</div>
	</header><!-- #masthead -->

	<div id="main" class="site-main">
