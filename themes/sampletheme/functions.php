<?php

/**
 * LESSON 07
 * ウィジェットエリアを登録する。
 */
function sampletheme_widgets_init() {
	register_sidebar( array(
		'name'          => 'コンテンツサイドバー',
		'id'            => 'sidebar-right',
		'description'   => '右サイドバーに表示するウィジェット',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'			=> 'メインサイドバー',
		'id'			=> 'sidebar-left',
		'description'	=> '左サイドバーに表示するウィジェット',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</aside>',
		'before_title'	=> '<h1 class="widget-title">',
		'after_title'	=> '</h1>',
	) );
}
add_action( 'widgets_init', 'sampletheme_widgets_init' );

/**
 * LESSON 09
 * カスタム投稿タイプ、カスタム分類を登録する。
 */
function sampletheme_post_type() {
	register_post_type( 'bookreview', array(
		'labels' => array( 'name' => '書評' ), 
		'public' => true,
		'menu_position' => 6,
		'supports' => array( 'title', 'editor', 'custom-fields' ),
	) );

	register_taxonomy( 'genre', 'bookreview', array(
		'labels' => array( 'name' => 'ジャンル' ),
		'hierarchical' => true,
	) );
}
add_action( 'init', 'sampletheme_post_type', 1 );


/**
 * コンテンツ幅を設定する。
 * テーマのデザインに合わせて、幅を設定しておくと、oEmbed(本文にURLを記入すると、外部サイトの画像や動画等を埋め込んでくれる)を使用する時に適切な大きさで表示する。
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

if ( ! function_exists( 'sampletheme_setup' ) ) :
	/**
	 * LESSON 13
	 * テーマのデフォルトの設定を行い、様々なWordPress機能を使用するように登録する
	 *
	 * この関数は after_setup_theme フックで実行される。
	 * after_setup_theme は init フックよりも前に実行される。
	 * アイキャッチ画像等いくつかの機能は init フックより前に実行しておく必要がある。
	 *
	 */
	function sampletheme_setup() {

		// ビジュアルエディタでの表示が、実際の表示に近くなるように、スタイルシートを登録する。
		add_editor_style( array( 'css/editor-style.css', sampletheme_font_url() ) );

		// 投稿／コメントの RSS フィードへのリンクを <head> に追加する。
		add_theme_support( 'automatic-feed-links' );

		// アイキャッチ画像を登録する。
		add_theme_support( 'post-thumbnails' );
		// アイキャッチ画像のサイズを設定する。
		set_post_thumbnail_size( 672, 372, true );

		// wp_nav_menu() で使用するロケーションを設定する。
		register_nav_menus( array(
			'primary'	=> 'メインメニュー',
		) );

		// 検索フォーム、コメントフォーム、コメントの出力をHTML5形式にする。
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list',
		) );
	}
endif; // sampletheme_setup
add_action( 'after_setup_theme', 'sampletheme_setup' );

/**
 * Lato Google フォントを登録する。
 * sampletheme_scripts 関数で呼び出されている。
 *
 * @return string  // 戻り値が文字列であることを示す
 */
function sampletheme_font_url() {

	$font_url = '//fonts.googleapis.com/css?family=Lato%3A300%2C400%2C700%2C900%2C300italic%2C400italic%2C700italic';
	return $font_url;
}

/**
 * LESSON 13
 * フロントエンドで使用するJavaScriptとスタイルシートを登録する。
 *
 * @return void  // 戻り値無しを示す
 */
function sampletheme_scripts() {
	// Lato フォントを追加する。このフォントは主スタイルシートで使用されている。
	// sampletheme_font_url関数は、google apiへのリンクを生成する。
	wp_enqueue_style( 'sampletheme-lato', sampletheme_font_url(), array(), null );

	// Genericons フォントを追加する。このフォントは主スタイルシートで使用されている。
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// 主スタイルシートを読み込む。
	wp_enqueue_style( 'sampletheme-style', get_stylesheet_uri(), array( 'genericons' ) );

	// Internet Explorer 用のスタイルシートを読み込む。
	wp_enqueue_style( 'sampletheme-ie', get_template_directory_uri() . '/css/ie.css', array( 'sampletheme-style', 'genericons' ), '20131205' );
	wp_style_add_data( 'sampletheme-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'sampletheme-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20131209', true );
}
add_action( 'wp_enqueue_scripts', 'sampletheme_scripts' );


/**
 * wp_title にフックを追加して、ページ毎に詳細なタイトル設定を行う。
 *
 * @param string $title Default title text for current view. // 引数 $title は元のタイトル
 * @param string $sep Optional separator. // 引数 $sep は区切り文字、空のこともある
 * @return string The filtered title. // 戻り値が文字列であることを示す。
 */
function sampletheme_wp_title( $title, $sep ) {

	if ( is_feed() ) {
		return $title;
	}

	// サイト名を追加する
	$title .= get_bloginfo( 'name' );

	// サイトのキャッチフレーズがある場合、トップページではキャッチフレーズを追加する
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	return $title;
}
add_filter( 'wp_title', 'sampletheme_wp_title', 10, 2 );