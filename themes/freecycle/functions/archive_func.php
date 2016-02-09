<?php
/**可変グリッドアニメーションJSロード**/
function archive_load_masonry(){
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>
<!---->
<script type="text/javascript">
jQuery(function(){
	jQuery('#archive_grid_center').masonry({
		itemSelector: '.archive_grid',
		isFitWidth: true,
		isAnimated: true,
		isFitWidth : true
	});
});
</script>
<?
}
/**可変グリッドアニメーションJSロード**/
?>

<?
/**冊数のカウンター**/
function archive_count_book(){
	$url = explode("/",$_SERVER["REQUEST_URI"]);
	is_numeric(end($url)) ? $page = end($url) : $page = 1;

	$arg = array( 'posts_per_page' => 30, 'paged' => $page );
	$items_query = new WP_Query($arg);
	echo $items_query->found_posts;//冊数を出力
}
/**冊数のカウンター**/
?>
	

<?php
/**管理者用検索フォーム**/
function archive_search_init(){ 
?>
			
<script type="text/javascript">
var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
console.log("Ajax");
jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
			'str' : "",
			'action' : 'get_search_json_archive',
		},
		success: function(json){
			jQuery(".archive_grid_center").empty();
			jQuery(".archive_grid_center").append(json);
			/*console.log(json);*/
		}
});
	
jQuery(function(){
	var b = jQuery('.archive_grid_center');
	console.log(b.width());
	if(b.width() > 900)
		jQuery('.archive_grid').width((b.width()/3)-20);
	else if(b.width() > 600)
		jQuery('.archive_grid').width((b.width()/2)-20);
	else
		jQuery('.archive_grid').width(b.width()-10);
});
</script>
<?php } 
/**管理者用検索フォーム**/
?>

<?
/**archive用検索フォーム**/
function archive_search_form(){ 
?>
<script type="text/javascript">
jQuery(function() {
	var $Inputs = jQuery("#ad_search_form").find("#searchsubmit");
	$Inputs.on("click",function(){
		console.log("Ajax");
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
			'str' : jQuery(".ad_input").val(),
			'action' : 'get_search_json',
		},
		success: function(json){
			jQuery(".grid_center").empty();
			jQuery(".grid_center").append(json);
		}
		});
	});
});
</script>
<?php } 
/**archive用検索フォーム**/
?>