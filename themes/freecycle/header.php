<?php
global $current_user;
get_currentuserinfo();

include_once get_stylesheet_directory().DIRECTORY_SEPARATOR."/head.php";

// DELETE TEMPORARILY
// because of unable to login from smartphone apps
if(!is_user_logged_in() || $current_user->user_level != ADMIN_LEVEL){
	header('Location:' . home_url() . '/renewal.php');
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<?php head_load(); ?>

<body <?php body_class(); ?> id="bp-default">
<?php do_action( 'bp_before_header' ); ?>
	
<!--------------------------------------------->
<!-- サイドオープン時メインコンテンツを覆う -->
<div class="overlay" id="js__overlay"></div>
<!--------------------------------------------->
<!-- サイドメニュー -->
<nav class="slide-menu">
こんにちは、〇〇さん!!<br>
ようこそ、テクスチェンジWeb版へ！
	
<div id="order">
	あなたは○月×日に
	<img src="image/book1.jpg">
	「□□□□□」を注文しています。
</div>
	
<div class="sl_button">メニュータイトル<span class="triangle12"></span></div>
<div class="sl_button">メニュータイトル<span class="triangle12"></span></div>
<div class="sl_button">メニュータイトル<span class="triangle12"></span></div>
</nav>
<!-- サイドメニュー -->
<!--------------------------------------------->
	
	
<!--ヘッダー------------------->
<div id="header_menu_ber" role=”banner”>
	<ul id="dropmenu" class="dropmenu">
		<li id="menu_button">
			<!-- 開閉用ボタン -->
			<div class="slide-menu-btn" id="js__slideMenuBtn">
				<span class="point p1"></span>
				<span class="point p2"></span>
				<span class="point p3"></span>
			</div>
		</li>
		<li id="logo">
			<a title="ホーム"><div id="logo_icon" alt="ロゴ"></div></a>
		</li>
		</li>
	</ul>
</div>
<!--ヘッダー------------------->

<?php if(is_archive() || is_search() || is_single()){ ?>
<?php } ?>
<div id="header_container">
	
	
<!--スライドメニュースクリプト------------------->
<script>
//タップが出来る場合（SP・タブレットなど）
//if (window.ontouchstart === null) alert('タッチ');
//クリックしかできない場合（PCなど）
//if (window.ontouchstart === undefined) alert('クリック');
	
jQuery(function () {
	if (window.ontouchstart === null){
		console.log("SmartPhone");
		return;
	} else {
		var $body = jQuery('body');
		jQuery('#js__slideMenuBtn').on('click', function () {
			$body.toggleClass('slide-open');
			jQuery('#js__overlay').on('click', function () {
				$body.removeClass('slide-open');
			});
		});
	}
});

var $body = jQuery('body');
jQuery("#js__slideMenuBtn").on('touchstart', function(){
	jQuery(".point").addClass('hover');
});
jQuery("#js__slideMenuBtn").on('touchend', function(){
	jQuery(".point").removeClass('hover');
  $body.toggleClass('slide-open');
});
jQuery("#js__overlay").on('touchstart', function(){
   $body.removeClass('slide-open');
});
</script>