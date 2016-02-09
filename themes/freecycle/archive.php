<!--

	stylesheet : style/archive.css

-->

<?php include_once get_stylesheet_directory().DIRECTORY_SEPARATOR."/functions/archive_func.php"; ?>

<?php get_header(); ?>
<?php archive_load_masonry(); ?>

<!------------------------------------------------------>
	<!--カテゴリ検索-->
	<nav id="header-nav">カテゴリ検索
	<ul>
<?php
		$main_categories = get_categories(array(
      "parent" => 0,
      "hide_empty" => 0,
      "exclude" => 1 //'uncategorized'
   	));

   foreach ((array)$main_categories as $main_category) {
      $main_id = $main_category->term_id;
      $main_name = $main_category->name;
      $main_slug = $main_category->slug;
      $sub_categories = get_categories(array("parent" => $main_id));


      foreach((array)$sub_categories as $sub_category){
         $sub_name = $sub_category->name;
         $sub_slug = $sub_category->slug;
				echo "<a href='". home_url()."/archives/category/".$main_slug."/".$sub_slug ."'>
							<li>$sub_name</li>
							</a>";
      }
		 //echo "</div>";
   }
?>		
	</ul>
	</nav>
	<!------------------------------------------------------>

<h4 id="post-list-h4">商品一覧 (<?php archive_count_book(); ?>件)</h4>


<!-- 検索フォーム --> 
<!--form id="ad_search_form">
<div>
<div><input class="ad_search" id="searchsubmit" style="float:right;"/></div>
<input type="text" placeholder="検索" class="ad_input" name="s" id="s" value="" style="float:right;"/>
</div>
<div style="clear:both;">         
</form-->
<?php //archive_search_form(); ?>
<!-- 検索フォーム --> 
	
<?php archive_search_init(); ?>
<div class="archive_grid_center">Now Loading...</div>

<script>
jQuery(window).on('load resize', function(){
	var b = jQuery('.archive_grid_center');
	console.log(b.width());
	if(b.width() > 1200)
		jQuery('.archive_grid').width((b.width()/4)-30);
	else if(b.width() > 900)
		jQuery('.archive_grid').width((b.width()/3)-30);
	else if(b.width() > 600)
		jQuery('.archive_grid').width((b.width()/2)-30);
	else
		jQuery('.archive_grid').width(b.width()-10);
});
</script>

<?php get_footer(); ?>
