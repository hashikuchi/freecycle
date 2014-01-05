<?php get_header(); ?>
	<script type="text/javascript">
		/**
		 This function is called when finish button is clicked.
		 */
		function onFinish(){
			if(confirm("取引を完了状態にします。よろしいですか？")){
				jQuery.ajax({
					type: "POST",
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: {
						"action": "finish",
						"postID": "<?php echo $post->ID ?>",
						"userID": "<?php echo $user_ID ?>"
					},
					success: function(msg){
						afterFinish();
						alert("取引が完了しました。落札者の評価を行ってください！");
					}
				});
			}
		}
		
		/**
		 This function is called when giveme button is clicked.
		 */
		function onGiveme(){
			if(confirm("くださいリクエストをします。よろしいですか？")){
				jQuery.ajax({
					type: "POST",
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: {
						"action": "giveme",
						"postID": "<?php echo $post->ID ?>",
						"userID": "<?php echo $user_ID ?>"
					},
					success: function(msg){
						switchGiveme();
						alert("くださいリクエストを送信しました！");
					}
				});
			}
		}

		/**
		 This function is called when cancelGiveme button is clicked.
		 */
		function onCencelGiveme(){
			if(confirm("くださいリクエストを取消します。よろしいですか？")){
				jQuery.ajax({
					type: "POST",
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: {
						"action": "cancelGiveme",
						"postID": "<?php echo $post->ID ?>",
						"userID": "<?php echo $user_ID ?>"
					},
					success: function(msg){
						switchGiveme();
						alert("くださいリクエストを取消しました！");
					}
				});
			}
		}
		
		function onExhibiterEvaluation(){
			var score = jQuery("#score").val();
			var comment = jQuery("#trade_comment").val();
			// check input values
			if(score === "invalid"){
				alert("評価を選択してください。");
				return;
			}else if(comment.length > 100){
				alert("コメントは100文字以内で記入してください。");
				return;
			}
			// send values
			jQuery.ajax({
				type: "POST",
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				data: {
					"action": "exhibiter_evaluation",
					"postID": "<?php echo $post->ID ?>",
					"score" : score,
					"comment" : comment
				},
				success: function(msg){
					afterEvaluation();
					alert("取引評価を行いました！");
				}
			});
		}
		
		function onBidderEvaluation(){
			var score = jQuery("#score").val();
			var comment = jQuery("#trade_comment").val();
			// check input values
			if(score === "invalid"){
				alert("評価を選択してください。");
				return;
			}else if(comment.length > 100){
				alert("コメントは100文字以内で記入してください。");
				return;
			}
			// send values
			jQuery.ajax({
				type: "POST",
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				data: {
					"action": "bidder_evaluation",
					"postID": "<?php echo $post->ID ?>",
					"score" : score,
					"comment" : comment
				},
				success: function(msg){
					afterEvaluation();
					alert("取引評価を行いました！");
				}
			});
		}
		
		function onDeletePost(){
			if(confirm("取り消した出品は復活できません。よろしいですか？")){
				// send values
				jQuery.ajax({
					type: "POST",
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					data: {
						"action": "delete_post",
						"postID": "<?php echo $post->ID ?>"
					},
					success: function(msg){
						alert("出品を取り消しました。");
						location.href = "<?php echo home_url(); ?>";
					},
					false: function(msg){
						alert("取り消しに失敗しました。");
					}
				});
			}else{
				return false;
			}
		}

		function switchGiveme(){
			if(jQuery("#giveme").size() > 0){
				jQuery('<input type="button" id="cancelGiveme" value="ください取消" onClick="onCencelGiveme();">').replaceAll(jQuery("#giveme"));
				
			}else{
				jQuery('<input type="button" id="giveme" value="ください" onClick="onGiveme();">').replaceAll(jQuery("#cancelGiveme"));
			}
		}

		function afterEvaluation(){
			jQuery("#evaluation").replaceWith("この商品は評価済です。");
		}

		function afterFinish(){
			jQuery("#finish").replaceWith('<div id="evaluation">落札者の評価:</br><select name="score" id="score"><option value="invalid" selected>--選択--</option><option value="5" >とても良い</option><option value="4" >良い</option><option value="3" >普通</option><option value="2" >悪い</option><option value="1" >とても悪い</option></select></br>コメント(任意 100字以内 改行も1文字と数えます)</br><textarea name="trade_comment" id="trade_comment" rows="5" cols="40"></textarea></br><input type="button" id="evaluation" value="評価する" onClick="onBidderEvaluation();"></div>');
		}
		
	</script>
	
	
	
	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ); ?>

					<div class="page" id="blog-single" role="main">

					　<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


					

					<div class="post-content">
						<h2 class="posttitle"><?php the_title(); ?></h2>							
						<div class="item_status">状態:
						<?php
							$item_status = get_post_custom_values("item_status");
							echo get_display_item_status($item_status["0"]);
						?>
						</div>
						<div class="author-box">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
						<p><?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?></p>
					</div>

						<?php
						/*
						  display finish button or giveme button
						  if watching user doesn't log in, button is not shown
						 */
						?>
						
						<!-- when login user is author -->
						<?php if($user_ID == $authordata->ID){
								if(isFinish($post->ID)){
									if(isBidderEvaluated($post->ID)){ ?>
							<!-- when status is finish -->
									この商品は評価済です。
								<?php }else{ ?>
								
								<div id="evaluation">
									落札者の評価:</br>
									<select name="score" id="score">
										<option value="invalid" selected>--選択--</option>
										<option value="5" >とても良い</option>
										<option value="4" >良い</option>
										<option value="3" >普通</option>
										<option value="2" >悪い</option>
										<option value="1" >とても悪い</option>
									</select>
									</br>
									コメント(任意 100字以内 改行も1文字と数えます)</br>
									<textarea name="trade_comment" id="trade_comment" rows="5" cols="40"></textarea></br>
									<input type="button" id="evaluation" value="評価する" onClick="onBidderEvaluation();">
								</div>
								
								<?php } ?>
							<?php }elseif(isConfirm($post->ID)){ ?>
							<!-- when status is confirm -->
							
						<input type="button" id="finish" value="取引完了" onClick="onFinish();">
							<?php }elseif(isGiveme($post->ID)){ ?>
							<!-- when status is giveme -->
						<input type="button" id="finish" value="取引完了(まだ押せない)">
							<?php }else{ ?>
									この商品は「ください」待ちです。
						<?php     } ?>
						
						<!-- when login user is not author -->
						<?php }elseif(isConfirm($post->ID)){
								if(get_confirmed_user_id($post->ID) == $user_ID){
									if(isExhibiterEvaluated($post->ID)){ ?>
										この商品は評価済です。
								<?php }else{ ?>
								<div id="evaluation">
									出品者の評価:</br>
									<select name="score" id="score">
										<option value="invalid" selected>--選択--</option>
										<option value="5" >とても良い</option>
										<option value="4" >良い</option>
										<option value="3" >普通</option>
										<option value="2" >悪い</option>
										<option value="1" >とても悪い</option>
									</select>
									</br>
									コメント(任意 100字以内 改行も1文字と数えます)</br>
									<textarea name="trade_comment" id="trade_comment" rows="5" cols="40"></textarea></br>
									<input type="button" id="evaluation" value="評価する" onClick="onExhibiterEvaluation();">
								</div>
								<?php } ?>
							<?php }else{ ?>
									この商品は取引相手が決まったため、「ください」はできません
							<?php } ?>
						<?php }elseif(is_user_logged_in()){
								if(doneGiveme($post->ID, $user_ID)){ ?>
						<input type="button" id="cancelGiveme" value="ください取消" onClick="onCencelGiveme();">
							<?php }elseif(get_usable_point($user_ID) > 0){ ?>
						<input type="button" id="giveme" value="ください" onClick="onGiveme();">
							<?php }else{ ?>
						使用可能なポイントが無いため「ください」できません。
							<?php } ?>
						<?php } ?>
						
						<p class="date">
							<?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?>
							<!-- edit entry is not available -->
							<!-- <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span> -->
							<?php if($user_ID == $authordata->ID && !isGiveme($post->ID)){ ?><span class="post-utility alignright"><a href="javaScript:onDeletePost();">出品取り消し</a></span><?php } ?>
						</p>

						<div class="entry">
							<?php
							$args = array(
								'post_type' => 'attachment',
								'post_parent' => $post->ID
							);
							//define size
							$size = array(200, 200);
							$attachments = array_reverse(get_posts($args));
							if($attachments){
								foreach($attachments as $attachment){
									echo wp_get_attachment_image( $attachment->ID, $size);
								}
							}
							?>
							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
							
							
						</div>
						
							<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?>&nbsp;</p>

						<div class="alignleft"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'buddypress' ) . '</span> %title' ); ?></div>
						<div class="alignright"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'buddypress' ) . '</span>' ); ?></div>
					</div>

				</div>

			<?php comments_template(); ?>

			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ); ?></p>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_single_post' ); ?>
		
			
			
		</div><!-- .padder -->
	</div><!-- #content -->
	

	<?php get_sidebar(); ?>

<?php get_footer(); ?>