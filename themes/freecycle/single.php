<?php get_header(); ?>

<script type="text/javascript">
function onDeletePost(){
	swal({
		title: "取り消した出品は復活できません。",
		text: "よろしいですか？",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "はい",
		cancelButtonText: "いいえ",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm){
		if (isConfirm) {
				jQuery.ajax({
				type: "POST",
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				data: {
					"action": "delete_post",
					"postID": "<?php echo $post->ID ?>",
					"userID": "<?php echo $user_ID ?>"
				},
				success: function(msg){
					swal({
						title: "商品を取り消しました。",
						type: "success",
						showCancelButton: false,
						confirmButtonColor: "#AEDEF4",
						confirmButtonText: "OK",
						closeOnConfirm: true
					},
					function(){
						location.href = "<?php echo_entry_list_url(); ?>";
					});
				},
				false: function(msg){
					swal({
						title: "商品を取り消しに失敗しました。",
						type: "error",
						showCancelButton: false,
						confirmButtonColor: "#AEDEF4",
						confirmButtonText: "OK",
						closeOnConfirm: true
					});
				}
			});
		}else{return false;}
		});
}
function onEdit(itemStatus){
	//表示内容の削除
	var content = document.getElementById("post-content-edit");
	while(content.firstChild){
		content.removeChild(content.firstChild);
	}

	//編集内容の表示
	var templete = document.getElementById("edit");
	var newNode = templete.cloneNode(true);
	newNode.style.display = '';
	newNode.id = 'edit_content';
	content.appendChild(newNode);

	//隠していた編集内容の削除
	while(templete.firstChild){
		templete.removeChild(templete.firstChild);
	}

	//出品物の状態を保持
	var statusLabel = {
		"verygood" : 0,
		"good"     : 1,
		"bad"      : 2
	};
	var targetOption = document.getElementById("eval" + statusLabel[itemStatus]);
	targetOption.setAttribute("selected", "selected");
	}
function onUpdateEdit(){
			var form = jQuery("#edit_form")[0];
			var fd = new FormData(form);
			fd.append("action", "edit_item");
			jQuery.ajax({
				type : "POST",
				url: "<?php echo admin_url('admin-ajax.php'); ?>",
				processData: false,
				contentType: false,
				mimeType: "multipart/form-data",
				data: fd,
				success : function(msg){
					location.reload();
				}
			});
		}
function zoom(i){
	switch(i){
		case 0:jQuery("#zoom1").hide();jQuery("#zoom2").hide();jQuery("#zoom0").show();break;
		case 1:jQuery("#zoom2").hide();jQuery("#zoom0").hide();jQuery("#zoom1").show();break;
		case 2:jQuery("#zoom0").hide();jQuery("#zoom1").hide();jQuery("#zoom2").show();break;
	}
}

</script>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ); ?>

					<div class="page" id="blog-single" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


						<div class="author-box" >
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
						<p><?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?></p>
						</div>


					<div class="post-content" id="post-content-edit">
						<h2 class="posttitle"><?php the_title(); ?></h2>


						<div class="item_status">状態:
						<?php
							$item_status = get_post_custom_values("item_status");
							echo get_display_item_status($item_status["0"]);
						?>
						</div>
						<div>
							<?php
								$sub_category = get_the_category();
								if($sub_category[0]->term_id == '1'):
									echo "カテゴリ:未設定";
								else:
									$main_category = get_category($sub_category[0]->parent);
								?>
	 							大学: <?php echo $main_category->cat_name;?> <br>
	 							学部: <?php echo $sub_category[0]->cat_name; ?>
 							<?php endif; ?>
						</div>
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
									コメント(任意 100字以内)</br>
									<textarea name="trade_comment" id="trade_comment" rows="5" cols="40"></textarea></br>
									<input type="button" id="evaluation" value="評価する" onClick="onBidderEvaluation();">
								</div>

								<?php } ?>
							<?php }else if(isConfirm($post->ID)){ ?>
							<!-- when status is confirm -->

									<input type="button" id="finish" value="取引完了" onClick="onFinish();">
							<?php }else{ ?>
									<input type="button" id="edit" value="編集" onClick='onEdit("<?php echo $item_status[0]; ?>");'>
							<?php }
							 } ?>	
							 <?php  echo '<p style="font-style:oblique;font-weight:bold">※現在、ユーザ間での取引は停止されています</p>';    ?>					

						<p class="date">
							<!-- <span></span>がないと次の<span>がイタリックになる -->
							<?php printf( __( '%1$s <span></span>', 'buddypress' ), get_the_date()); ?>
							<!-- edit entry is not available -->
							<!-- <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span> -->
							<?php if($user_ID == $authordata->ID && !isGiveme($post->ID)){ ?><span class="post-utility alignright"><a href="javaScript:onDeletePost();">出品取り消し</a></span><?php } ?>
							<?php if($user_ID == $authordata->ID && isConfirm($post->ID) && !isFinish($post->ID)){ ?><span class="post-utility alignright"><a href="javaScript:onCancelTradeFromExhibitor();" id="cancelTradeFromExhibitor">取引キャンセル</a></span><?php } ?>
							<?php if($user_ID == get_bidder_id($post->ID) && isConfirm($post->ID) && !isFinish($post->ID)){ ?><span class="post-utility alignright"><a href="javaScript:onCancelTradeFromBidder();" id="cancelTradeFromBidder">取引キャンセル</a></span><?php } ?>
						</p>

						<div class="entry">

							<p class="author_name"><?php printf( _x( 'by %s', 'Post written by...', 'buddypress' ), bp_core_get_userlink( $post->post_author ) ); ?></p>

							<?php
							$args = array(
								'post_type' => 'attachment',
								'post_parent' => $post->ID
							);
							//define size
							$size = array(200, 200);
							$attachments = array_reverse(get_posts($args));
							if($attachments){
								$i=0;
								foreach($attachments as $attachment){
									echo "<div class='zoom_image'  onclick=zoom(";
									echo $i;
									echo ")>";
									echo wp_get_attachment_image( $attachment->ID,'thumbnail');
									echo "</div>";
                	$i++;
								}
							}
							?>
							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
							<?php
								$i=0;
								foreach($attachments as $attachment){
									echo "<div class='zoom_in_image' id=zoom";
									echo $i;
									echo " style='display: none;'>";
									echo wp_get_attachment_image( $attachment->ID,'full');
									echo "</div>";
									$i++;
								}
							?>
						</div>

							<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?>&nbsp;</p>

						<div class="alignleft"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'buddypress' ) . '</span> %title' ); ?></div>
						<div class="alignright"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'buddypress' ) . '</span>' ); ?></div>
					</div>

				</div>

			<?php if(is_user_logged_in()) {
						comments_template();
					}
			?>

			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ); ?></p>

			<?php endif; ?>


		</div>

		<?php do_action( 'bp_after_blog_single_post' ); ?>



		</div><!-- .padder -->
	</div><!-- #content -->

	<div id="edit" style="display : none">
	<form id="edit_form" method="post" enctype="multipart/form-data">
	<?php if($attachments){
			foreach($attachments as $attachment){
				echo wp_get_attachment_image( $attachment->ID, $size);
			}
	} ?>
	<br>
	<label>商品名</label><br><input type="text" name="item_title" value="<?php echo get_the_title(); ?>" ><br>
	<label>状態</label><br><select name="item_status" >
				<option id="eval0" value="verygood"><?php echo get_display_item_status("verygood"); ?></option>
				<option id="eval1" value="good" ><?php echo get_display_item_status("good"); ?></option>
				<option id="eval2" value="bad"><?php echo get_display_item_status("bad"); ?></option>
			</select><br>
	<label>商品説明</label><br><textarea rows="5" cols="40" name="item_content" ><?php remove_filter('the_content', 'wpautop'); the_content(); ?></textarea></br>
	<label>カテゴリ</label></br>
	<select name="main_category" onChange="onChangeMainCategory(1)">
	<?php
		$sub_category = get_the_category();
		$main;
		$sub;
		if($sub_category[0]->cat_name == 'Uncategorized'){
			$main = 0;
			$sub = 0;
		}else{
			$main = get_category($sub_category[0]->parent)->cat_name;
			$sub = $sub_category[0]->cat_name;
		}
	?>
			<option value="">-- 大学 --</option>
			<?php $item_main_category_name = output_main_category($main); ?>
			</select>
			<select name="subcategory">
			<option value="1">-- 学部 --</option>
			<?php output_sub_category($item_main_category_name,$sub); ?>
			</select><br>

	<label>写真</label><br>
		<input type="file" class="multi" name="upload_attachment[]" ></br>
		<input type="file" class="multi" name="upload_attachment[]" ></br>
		<input type="file" class="multi" name="upload_attachment[]" ></br><br>
	<input type="hidden" name="itemID" value="<?php echo $post->ID; ?>">
	<input type="button" value="編集完了" onClick="onUpdateEdit();">
	</form>
	</div><!-- hidden_content -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
