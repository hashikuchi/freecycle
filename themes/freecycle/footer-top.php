	<!-- #container -->

		<?php do_action( 'bp_after_container' ); ?>
		<?php do_action( 'bp_before_footer'   ); ?>

		<div id="footer">
		<!-- <div id="pagetop_link"><a href="#logo">Go to pagetop</a></div> -->
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
				<div id="footer-widgets">
					<?php get_sidebar( 'footer' ); ?>
				</div>
			<?php endif; ?>

			<div id="site-generator" role="contentinfo">
				<?php do_action( 'bp_dtheme_credits' ); ?>
				<p>
				<?php printf( __( 'Copyright  <a href="%1$s">てくすちぇんじ</a>.', 'buddypress' ),  'http://texchg.com' ); ?>
				</p>
			</div>

			<?php do_action( 'bp_footer' ); ?>

		</div><!-- #footer -->

		<?php do_action( 'bp_after_footer' ); ?>

		<?php wp_footer(); ?>
	<script src="<?php echo home_url(); ?>/wp-content/themes/freecycle/bootstrap/js/bootstrap.min.js"></script> 
	</body>

</html>