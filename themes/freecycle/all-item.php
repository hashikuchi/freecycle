<?php
/*
Template Name: 商品一覧
*/

function get_items_with_pagenation($args = array()){
	if(!isset($args['post_per_page'])){
		$args['post_per_page'] = 10;
	}
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
	$pagenation = create_pagenation($items_obj);

	$return_val = array(
			'posts' 		=> $items,
			'pagenation' 	=> $pagenation
		);

	return $return_val;
}

function create_pagenation($items_obj){
	if(is_object($items_obj)){
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
	}
	return $return_val;
}
?>

	<div>
		<h3>商品一覧</h3>
		<?php
		   get_search_form();
		?>
		<hr>
		<?php
			$page = isset($_GET['page_number'])?$_GET['page_number']: 1;
			// var_dump($page);
			$args = array(
					'posts_per_page' => -1,
					'paged' => $page
					);
			$items = get_items_with_pagenation($args);
			$page = $items['pagenation'];
			$items_data = $items["posts"];
			$count = 1;
			$row = 2;
			$is_closed = true;
		?>
		<?php
			$item_st_id = ($page['paged'] - 1) * 10;
			for($i = $item_st_id; $i < ($item_st_id + $page['query_vars']['post_per_page']); $i++) :
				if(!$items_data[$i]['post_title']){
					break;
				}
				if($count%$row == 1){
					$is_closed = true;
					echo '<div class="posts-row">';
				}
		?>
			<div id='post-<?php echo $i; ?>'>
				<div class="post-content">
					<div class="item-displayed">
				 		<a href='<?php echo $items_data[$i]["url"]; ?>' ><div><?php  echo $items_data[$i]['post_title'];
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
		 <?php	if($is_closed){
					echo "<hr>";
			 }
		 ?>
		<div class="pagenation">
			<?php if($page["paged"] == $page["min_num"]): ?>
				<span>最初のページ</span>
			<?php else : ?>
				<span><a href='<?php echo $page["min_url"]; ?>' >最初のページ</a></span>
			<?php endif; ?>
			<?php if($page['pre_num'] > 0): ?>
				<span><a href='<?php echo $page["pre_url"]; ?>' >前ページ</a></span>
			<?php endif; ?>
			<span><?php echo $page['paged'];?></span>
			<?php  if(!empty($page["next_url"])):?>
				<span><a href='<?php echo $page["next_url"]; ?>' >次ページ</a></span>
			<?php  endif; ?>
			<?php if($page["paged"] == $page["max_num"]): ?>
				<span>最後のページ</span>
			<?php else : ?>
				<span><a href='<?php echo $page["max_url"]; ?>' >最後のページ</a></span>
			<?php endif; ?>
		</div>
	</div>
