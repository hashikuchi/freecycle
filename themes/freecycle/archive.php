<!--

	stylesheet : style/archive.css

-->

<?php include_once get_stylesheet_directory().DIRECTORY_SEPARATOR."/functions/archive_func.php"; ?>

<?php get_header(); ?>
<?php archive_load_masonry(); ?>
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

<?php get_footer(); ?>
