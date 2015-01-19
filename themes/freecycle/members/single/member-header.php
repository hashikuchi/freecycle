<?php

/**
 * freecycle - Users Header
 *
 * @package freecycle
 */

?>

<?php do_action( 'bp_before_member_header' ); ?>
<script type="text/javascript">

	function callOnConfirmGiveme(postID){
		onConfirmGiveme(postID, "<?php echo admin_url('admin-ajax.php'); ?>");
	}
	
	function callOnNewEntry(){
		disableButtons();
		if(jQuery("#field_1").val().length == 0){
			alert("商品名が未入力です。");
			enableButtons();
			return false;
		}

		if(jQuery("#field_2").val().length == 0){
			alert("商品説明が未入力です。");
			enableButtons();
			return false;
		}

		var mainCategory = jQuery('[name=main_category]').val();
		if(mainCategory == ""){
			alert("大学名が未入力です。");
			enableButtons();
			return false;
		}

		var subCategory = jQuery('[name=subcategory]').val();
		if(subCategory == ""){
			alert("学部名が未入力です。");
			enableButtons();
			return false;
		}

		
		var isAttachedFlg = false;
		for (var i = jQuery(".multi").length - 1; i >= 0; i--) {
			var fileName = jQuery(".multi").get(i).value;
			if(fileName){
				isAttachedFlg = true;
			}
			if(fileName && !fileName.match(/\.(jpeg|jpg|png)$/i)){
				alert("不正なファイルです。\n.jpeg,.jpg,.png ファイルのみアップロードできます。");
				enableButtons();
				return false;
			}
		}

		if(!isAttachedFlg){
			alert("写真を添付してください。");
			enableButtons();
			return false;
		}

		if(confirm("出品後の記事の編集はできません。出品しますか？")){
			var form = jQuery("#newentry").get()[0];
			var fd = new FormData(form);
			fd.append("action", "new_entry");
			jQuery.ajax({
				type: "POST",
				url: "<?php echo admin_url('admin-ajax.php'); ?>",
				processData: false,
				contentType: false,
				mimeType:"multipart/form-data",
				data: fd,
				success: function(permalink){
					alert("商品を出品しました。");
					// reload new entry page
					enableButtons();
					location.href = "<?php echo bp_loggedin_user_domain(); ?>" + "new_entry/#newentry";
					jQuery("input[type='text'], input[type='file'], textarea").val("");
					jQuery("option").attr("selected", false);
				}
			});
		}
	}

	function onClickSearchWantedBook(){
		disableButtons();
		jQuery('#search_result').html('<div align=center><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ajax-loader.gif"></div>');
		jQuery.ajax({
			type: "POST",
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			data: {
				"action": "search_wantedbook",
				"keyword": jQuery("#keyword").val()
			},
			success: function(result){
				jQuery('#search_result').html(result);
				jQuery('.button_add_wanted').click(function(){
					addWantedList(jQuery(this).attr('asin'));
				});
				jQuery('.button_del_wanted').click(function(){
					delWantedListByASIN(jQuery(this).attr('asin'));
				});
				jQuery('.item_detail').hover(function(){
					jQuery(this).css('background-color', '#ffffe0');
				},
				function(){
					jQuery(this).css('background-color', '#ffffff');
				});
				enableButtons();
			}
		});
	}

	function addWantedList(asin){
		disableButtons();
		jQuery.ajax({
			type: "POST",
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			data: {
				"action": "add_wanted_item",
				"asin": asin,
				"item_name": jQuery("#name_" + asin).text(),
				"image_url": jQuery("#" + asin + " img").attr("src")
			},
			success: function(){
				jQuery("#button_" + asin).val("追加済");
				jQuery("#button_" + asin)
					.unbind('click')
					.click(function(){
						delWantedListByASIN(asin);
					});
				enableButtons();
			},
			error: function(){
				alert("登録できませんでした。しばらくしてからもう一度おためしください。");
			}
		});
	}

	function delWantedListByASIN(asin){
		disableButtons();
		jQuery.ajax({
			type: "POST",
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			data: {
				"action": "del_wanted_item_by_asin",
				"asin": asin
			},
			success: function(){
				jQuery("#button_" + asin).val("追加");
				jQuery("#button_" + asin)
					.unbind('click')
					.click(function(){
						addWantedList(asin);
					});
				enableButtons();
			},
			error: function(){
				alert("削除できませんでした。しばらくしてからもう一度おためしください。");
				enableButtons();
			}
		});
	}

	function delWantedListFromIndex(asin){
		disableButtons();
		jQuery.ajax({
			type: "POST",
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			data: {
				"action": "del_wanted_item_by_asin",
				"asin": asin
			},
			success: function(){
				jQuery("#" + asin).hide(1000);
				enableButtons();
			},
			error: function(){
				alert("削除できませんでした。しばらくしてからもう一度おためしください。");
				enableButtons();
			}
		});
	}

	var categories = jQuery.parseJSON('<?php echo get_freecycle_category_JSON(array('hide_empty' => 0)); ?>');

	function onChangeMainCategory(){
		// create subcategories select menu
		var maincategory = jQuery("[name='main_category']").val();
		var subcategories = [];
		for (var i = categories.length - 1; i >= 0; i--) {
			if(categories[i].parent == maincategory){
				subcategories.push(categories[i]);
			}
		};

		newentry.subcategory.length = 1;
		newentry.subcategory[0].value = "";
		newentry.subcategory[0].text = "-- 学部 --";

		if(!subcategories){
			return;
		}

		subcategories.forEach(function(subcategory){
			newentry.subcategory.length++;
			newentry.subcategory[newentry.subcategory.length-1].value = subcategory.term_id;
			newentry.subcategory[newentry.subcategory.length-1].text = subcategory.name;
		});
	}

	//ページスクロール
	var url = location.href;
	var str = url.substr(url.indexOf("members"));
	var count = 0;
	var pos = str.indexOf("/");

	while ( pos != -1 ) {
	   count++;
	   pos = str.indexOf("/", pos + 1);
	}

	if(count >= 3){
	 location.href = "#mypage";
	}

</script>
<div id="item-header-avatar">

	<a href="<?php bp_displayed_user_link(); ?>">
		<?php bp_displayed_user_avatar( 'type=full' ); ?>
	</a>
	
</div><!-- #item-header-avatar -->

<div id="item-header-content">

	<h2>
		<a href="<?php bp_displayed_user_link(); ?>"><?php bp_displayed_user_fullname(); ?></a>
	</h2>

	<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
		<span class="user-nicename">@<?php bp_displayed_user_username(); ?></span>
	<?php endif; ?>

	<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>
	
	<!-- display when loggin user page -->
	<?php if($user_ID == bp_displayed_user_id()){ ?>
	
	<div id="points-info">
		<h3 class="show-points">使用可能ポイント:<?php echo get_usable_point($user_ID); ?>p <br>(仮払ポイント:<?php echo get_temp_used_point($user_ID); ?>p)</h3>	
	</div>
	
	<?php } ?>
	<h5 class="show-points">評価平均:<?php echo number_format(get_average_score(bp_displayed_user_id()),2); ?>(件数:<?php echo get_count_evaluation(bp_displayed_user_id()); ?>件)</h5>
	<?php do_action( 'bp_before_member_header_meta' ); ?>

	<div id="item-meta">

		<?php if ( bp_is_active( 'activity' ) ) : ?>

			<div id="latest-update">

				<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>

			</div>

		<?php endif; ?>

		<div id="item-buttons">

			<?php do_action( 'bp_member_header_actions' ); ?>

		</div><!-- #item-buttons -->

		<?php
		/***
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		 do_action( 'bp_profile_header_meta' );

		 ?>
		 
	</div><!-- #item-meta -->

</div><!-- #item-header-content -->
<div id="mypage"></div>

<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>