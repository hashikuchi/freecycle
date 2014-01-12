<?php
wp_register_script(
	'freecycleScript',
	get_stylesheet_directory_uri() . '/js/freecycle.js',
	false,
	'20131028'
);

wp_enqueue_script('freecycleScript');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<?php if ( current_theme_supports( 'bp-default-responsive' ) ) : ?><meta name="viewport" content="width=device-width, initial-scale=1.0" /><?php endif; ?>
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php bp_head(); ?>
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?> id="bp-default">
		<?php do_action( 'bp_before_header' ); ?>

		<header>
			<h1 id="logo"><a href="<?php echo home_url(); ?>" title="<?php _ex( 'Home', 'Home page banner link title', 'buddypress' ); ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/images/texchange_header_b.png" alt="ヘッダー" width="700px" height="200px"></a></h1>
		</header><!-- header -->
		
		
<div class="header_img_navi">

				<div class="header_img_navi_contents">
					<?php if(is_user_logged_in()) { 
								 if(messages_get_unread_count() > 0){ 
					?>
							<a class="unread_alert" href="<?php echo bp_loggedin_user_domain() . "messages"; ?>">未読メッセージが<?php echo messages_get_unread_count();?>件あります！</a>
					<?php 		} 
						} ?> 
				</div>
				
				<div class="grobal_nav_div">
				<nav>
					<ul class="navi" class="clearfix">
					<li class="grobal_nav"><a href="<?php echo home_url(); ?>" >ホーム</a></li>
					<?php if(is_user_logged_in()){ ?>
					<li class="grobal_nav"><a href="<?php echo bp_loggedin_user_domain(); ?>" >マイページ</a></li>
					<?php } ?>
					<li class="grobal_nav"><a href="<?php echo home_url() . "/about"; ?>" >TexChangeとは</a></li>
					<li class="grobal_nav"><a href="<?php echo home_url() . "/faq"; ?>" >FAQ</a></li>
					<li class="grobal_nav"><a href="<?php echo home_url() . "/contact"; ?>" >お問い合わせ</a></li>
					</ul>
				</nav>
				</div>
</div>
					

<div class="header_form_">
	<div>
	<ul id="header-under">
		<?php if(!is_user_logged_in() && get_permalink() != get_home_url()."/register"){ ?>
		<li>
			<form name="login-form" id="header-login-form" class="standard-form" action="<?php echo home_url(); ?>/wp-login.php" method="post">
							<label>ユーザ名<br/>
							<input type="text" name="log" id="sidebar-user-login" class="input" value="" tabindex="97" /></label>
							<label>パスワード<br />
							<input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>
							<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> Remember Me</label></p>
							<p class="register"><a href="<?php echo home_url(); ?>/register">アカウント作成はこちら</a></p>
							<p class="lostpassword"><a href="<?php echo home_url(); ?>/wp-login.php?action=lostpassword">パスワードを忘れた方はこちら</a></p>
							<input type="submit" name="wp-submit" id="sidebar-wp-submit" value="Log In" tabindex="100" />
							<input type="hidden" name="redirect_to" value="" />
			</form>
		</li>
		<?php } ?>
	</ul>
	</div>


		<?php if(bp_is_front_page()){ ?>
		
		<!-- <hr class="line-search"> -->
		
	<div id="search-23" class="widget widget_search"><!-- 検索バー -->
				<form role="search" method="get" id="searchform_main" action="<?php echo home_url(); ?>">
					<!-- <label>検索：</label> -->
						<div id="searchform_text">
					  			<input type="text" id="searchtext" value="" name="s" id="s" />
					  	</div>
						<div id="searchform_text_pulldown">
							<div id="searchform_pulldown">
								<select name="categories_seachform">
									<option value="#">すべて</option>
									<option value="#">ください可能</option>
								</select>
							</div>
							<div id="searchform_submit">
								<input type="submit" id="searchsubmit" value="Search" />
							</div> 
						</div> 
				</form>	
	</div><!-- 検索バー -->
</div>	
		<!--<hr class="line-search"> -->
		<?php } ?>
		<div id="container">
