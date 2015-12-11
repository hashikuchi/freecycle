<?php
function ajax_func($str){

$returnObj = array();
$html = "";
	
$url = explode("/",$_SERVER["REQUEST_URI"]);
is_numeric(end($url)) ? $page = end($url) : $page = 1;
$args = array( 'posts_per_page' => 50, 'paged' => $page ,'s' => $str);
$posts = get_posts( $args );   
	
foreach( $posts as $key => $post ) {
	$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
	$image = wp_get_attachment_image_src( $post_thumbnail_id,"large" );
	$returnObj[$key] = array(
		'post_title' => $post->post_title,
		'permalink' => get_permalink( $post->ID ),
		'genre' => $post->post_category,
		'image' => $image
	);
	
	if($returnObj[$key]['image']!=null){
		$image_src = $returnObj[$key]['image'][0];
	} else {
		$image_src = get_stylesheet_directory_uri().'/images/archive/NotImage.png';
	}
?>

<div class="archive_grid">
<!-------------------------->
<!--表示-->
<!-------------------------->
<div class="archive_colm_header"></div>
<!---画像--------------------------->
<div class="archive_colm1">
	<div class="archive_img_center">
	<a href="<? //echo $returnObj[$key]['permalink']; ?>">
		<img class="archive_entry_img" src="<? echo $image_src ?>">
	</a>
	</div>
</div>
	
<!---情報--------------------------->
<div class="archive_colm2">
	<!---タイトル--------------------------->
	<div class="archive_title">
	<p href="<? echo $returnObj[$key]['permalink']; ?>"><?php echo $returnObj[$key]['post_title'] ?></p>
	</div>
	<!---説明------------------------------>
	<div class="archive_explanation">
	<!--p>nullnullnullnullnullnullnullnullnullnullnullnull</p-->
	</div>
	<div class="archive_colm3">
	<!---在庫------------------------------->
	<div class="archive_stock">
	<div>残り <?php ?>冊</div>
	</div>
	<!---ジャンル---------------------------->
	<div class="archive_genre">
	<div><?php echo get_category($returnObj[$key]['genre'][0])->cat_name ?></div>
	</div>
	</div>
	<!---予約ボタン-------------------------->
	<div class="archive_reser">
	<!--div>予約<br>ボタン</div-->
	<a href="#" class="archive_reser_button">この本を予約</a>
	</div>
	<!------------------------------------->
</div>
	
<div class="archive_colm_fotter"></div>
</div>


<?php
}
	die();
}
?>