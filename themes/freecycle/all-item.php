<?php
/*
Template Name: 商品一覧
*/

function get_items_with_pagenation($args = array(), $range = 'all'){
	if(isset($args['range'])){
		$range = $args['range'];
	}
	$args['post_per_page'] = 10;

	$items_obj = new WP_Query($args);

	$items = $items_obj->posts;
	//オブジェクトを配列に変換
	$items = json_decode(json_encode($items), true);

	foreach(array_keys($items) as $i){
		//各記事のパーマリンクを追加取得
		$items[$i]['url'] = get_permalink($items[$i]['ID']);

		//各記事のサムネイル追加取得
		$items[$i]['thumbnail'] = false;
		if($thumb_id = get_post_thumbnail_id($items[$i]['ID'])){
			if($tmp = wp_get_attachment_image_src($thumb_id, 'thumbnail')){
				$items[$i]['thumbnail'] = $tmp[0];
				$items[$i]['thumbnail_url'] = $tmp[0];
			}
		}

	}
	$pagenation = create_pagenation($items_obj, $range);

	$return_val = array(
			'posts' 		=> $items,
			'pagenation' 	=> $pagenation
		);

	return $return_val;
}

function create_pagenation($items_obj, $range){
	if(is_object($items_obj)){
		$all_flag = "";
		if(!is_numeric($range)){
			$all_flag = true;
			$range = 1;
		}else{
			$all_flag = false; //range有り
		}

		$url = home_url() . remove_query_arg('paged');


		if(preg_match('/\?/', $url)){
			$url .= "&";
		}else{
			$url .= '?';
		}

		//現在のページ番号
		$paged = "";
		if(!$_GET['page_number']){
			$paged = 1;
		}else{
			$paged = $_GET["page_number"];
		}
		

		$return_val = array(
			"min_num"	=> false,
			"min_url"	=> false,
			"max_num"	=> false,
			"max_url"	=> false,
			"prev_num"	=> false,
			"prev_url"	=> false,
			"next_num"	=> false,
			"next_url"	=> false,
			"pages"	=> false,
			"paged"	=> $paged,
			"range"	=> $range,
			"query_vars"	=> $items_obj->query_vars 
		);

		$st_num = 1;
		$end_num = ceil(count($items_obj->posts) / ($items_obj->query_vars['post_per_page']));
		// $pre_num = ($paged != 1)?($paged - 1):1;
		$pre_num = $paged - 1;
		$next_num = $paged + 1;
		$pages = array();
		for($page_num = 1; $page_num <= $end_num; $page_num++){
			$arr = array();
			$arr['num'] = $page_num;
			$arr['url'] = $url ."page_number=" . $page_num;

			//最初のページ
			if($page_num == 1){
				$return_val['min_num'] = $arr['num'];
				$return_val['min_url'] = $arr['url'];
			}
			//最後のページ
			if($page_num == $end_num){
				$return_val['max_num'] = $arr['num'];
				$return_val['max_url'] = $arr['url'];
			}
			//前のページ
			if($page_num == $pre_num){
				$return_val['pre_num'] = $arr['num'];
				$return_val['pre_url'] = $arr['url'];
			}
			//次のページ
			if($page_num == $next_num){
				$return_val['next_num'] = $arr['num'];
				$return_val['next_url'] = $arr['url'];
			}
		}
		// $return_val['pages'] = $pages;
	}
	return $return_val;
}
?>	

	<div>
		<h3>商品一覧</h3>
		<?php
			$page = isset($_GET['page_number'])?$_GET['page_number']: 1;
			// var_dump($page);
			$args = array(
					'posts_per_page' => -1,
					'paged' => $page
					);
			$items = get_items_with_pagenation($args, 'ALL');
			$pagenation = $items['pagenation'];
			$items_data = $items["posts"];
			$count = 1;
			$row = 2;
			$is_closed = true;
			// var_dump($items);
		?>
		<?php
		// var_dump($pagenation['paged']);
			$item_st_id = ($pagenation['paged'] - 1) * 10;
			// var_dump($items_data);
			// var_dump($items['pagenation']['paged']);
			// var_dump($_GET['paged']);
			for($i = $item_st_id; $i < ($item_st_id + $pagenation['query_vars']['post_per_page']); $i++) :
				if($count%$row == 1){
					$is_closed = true;
					echo '<div class="posts-row">';
				}
				if(!$items_data[$i]['post_title']){
					// echo "<hr>";
					break;
				}
		?>
			<div id='post-<?php echo $i; ?>'>
				<div class="post-content">
					<div class="item-displayed">
				 		<a href='<?php echo $items_data[$i]["url"]; ?>' ><div><?php
				 				if(mb_strlen($items_data[$i]["post_title"]) > 8){
				 					echo mb_substr($items_data[$i]["post_title"], 0, 8) . ".."; 
				 				}else{
				 					echo $items_data[$i]['post_title'];
				 				}
				 		?></div><img src='<?php echo $items_data[$i]["thumbnail"]; ?>' class="item-image"></a>
				 	</div>
				 </div>
			 </div>
		<?php 	if($count%$row == 0):
					$is_closed = false;
		?>
			</div><!-- posts-row -->
			<hr>
			<?php endif; ?>
			<?php $count++;?>
		 	<?php endfor; ?>
		 <?	if($is_closed){
		 		echo '<hr>';
		 }
		 ?>
		<span class="pagenation"><a href='<?php echo $pagenation["min_url"]; ?>' >first</a></span>
		 <?php
		 	if($pagenation['pre_num'] > 1):
		 ?>
			<span class="pagenation"><a href='<?php echo $pagenation["pre_url"]; ?>' >前のページ</a></span>
		 <?php endif; ?>
		<span class="pagenation"><?php echo $pagenation['paged'];?></span>
		<span class="pagenation"><a href='<?php echo $pagenation["next_url"]; ?>' >次のページ</a></span>
		<span class="pagenation"><a href='<?php echo $pagenation["max_url"]; ?>' >last</a></span>
	</div>