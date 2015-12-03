<?php if ( is_active_sidebar( 'sidebar-right' ) ) : // ウィジェットが登録されているかチェック ?>
<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-right' ); // ウィジェットを出力 ?>
</div><!-- #content-sidebar -->
<?php endif; ?>
<div id="secondary">
	<?php
		$description = get_bloginfo( 'description', 'display' ); // サイトのキャッチフレーズを取得
		if ( ! empty ( $description ) ) : // キャッチフレーズが空でない場合、出力
	?>
	<h2 class="site-description"><?php echo esc_html( $description ); // エスケープしてから出力 ?></h2>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-left' ) ) : // ウィジェットが登録されているかチェック ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-left' ); // ウィジェットを出力 ?>
	</div><!-- #primary-sidebar -->
	<?php endif; ?>
</div><!-- #secondary -->
