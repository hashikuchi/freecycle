<?php
    $url = explode("/",$_SERVER["REQUEST_URI"]);
    if(is_numeric(end($url))){
        $page = end($url);
    }else{
        $page = 1;
    }
    $arg = array(
        'posts_per_page' => 20,
        'paged' => $page
    );
    $items_query = new WP_Query($arg);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.js"></script>
<div class="page" id="blog-latest" role="main">
	
<h4 id="post-list-h4">商品一覧(<?php echo $items_query->found_posts;?>件)</h4>

<?php get_search_form(); ?>
<div class="grid_zoom">
	<div onClick="change('big')">＋</div>
	<div onClick="change('small')">－</div>
</div>

		<!------------------------------------------------------------------------------------------->
		<?php 
				if ( $items_query->have_posts() ) :
					bp_dtheme_content_nav( 'nav-above' );
					$count = 1;
					$row = 2;
					$is_closed = false;

					echo('<div class="grid_center">');
					while ($items_query->have_posts()) : $items_query->the_post();
						do_action( 'bp_before_blog_post' );
						/*if($count%$row == 1) {
							$is_closed = false;
							echo('<div class="posts-row">');
						} */
		?>
							
		<div id="post-<?php the_ID(); ?>" class="grid">
			<div class="grid_title">【 <?php the_category(' '); ?> 】<?php the_tags( '',',',''); ?></div>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large') ?></a>
			<?php 
				wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); 
			?>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<div class="grid_text"><?php the_content(); ?></div>
			<div class="grid_author"><?php the_author(); ?></div>
		</div>
					
<!------------------------------------------------------------------------------------------->							
	
		<?php 
			if($count%$row == 0) {
				$is_closed = true;
			}
			
			do_action( 'bp_after_blog_post' );
			$count++;
			endwhile;
      if($is_closed == false){
        echo('</div><!-- posts-row -->');
        echo('<hr class=\"hr-posts-row\">');
			}

			bp_dtheme_content_nav( 'nav-below' ); 
		?>
<!------------------------------------------------------------------------------------------->
		<?php else : ?>

				<h2 class="center"><?php _e( '商品が見つかりませんでした', 'buddypress' ); ?></h2>
				<p class="center"><?php _e( 'お探しの商品は見つかりませんでした。', 'buddypress' ); ?></p>

		<?php endif; ?>
<!------------------------------------------------------------------------------------------->
		<div class="grid pagenation_grid">
    	<?php  pagenation($page, $items_query->max_num_pages); ?>
		</div>
		</div><!-- page ? -->

		<?php do_action( 'bp_after_blog_home' ); ?>

<!--ページネーション関数----------------------------------------------------------->
<?php
    function pagenation($page, $max_num_pages){
        if($page > $max_num_pages){
            echo_pagenation_link("pagenation_top", "all-items", 1, "商品トップへ");
            return;
        }

        $next = $page + 1;
        $back = $page - 1;
        echo '<div class="pagenation">';
        //back
        if($page == 1){
            echo_pagenation_span("pagenation_back", "< 戻る");
        }else{
            echo_pagenation_link("pagenation_back", "all-items", $back, "< 戻る");
        }

        //pages
        pagenation_select_number($page, $max_num_pages);

        //next
        if($page == $max_num_pages){
            echo_pagenation_span("pagenation_next", "次へ >");
        }else{
            echo_pagenation_link("pagenation_next", "all-items", $next, "次へ >");
        }
        echo '</div>';
    }

    function pagenation_select_number($page, $max_num_pages){
        echo '<select id="pagenation_number" onChange="top.location.href=value" >';
        for($i = 1; $i <= $max_num_pages; $i++){
            if($i == $page){
                echo '<option value="'.home_url().'/all-items/'. $i .'" selected>'.$i.'</option>';
            }else{
                echo '<option value="'.home_url().'/all-items/'. $i .'">'.$i.'</option>';
            }
        }
        echo '</select>';
    }

    function echo_pagenation_link($html_class, $link, $page, $value){
        echo '<div class="'. $html_class .'" ><a href="'.home_url().'/' . $link . '/'.$page.'">'. $value .'</a></div>';
    }

    function echo_pagenation_span($html_class, $value){
        echo '<div class="' . $html_class . '" ><span>' . $value .'</span></div>';
    }
 ?>

<!--可変グリッドアニメーション----------------------------------------------------------->
	<script type="text/javascript">
		jQuery(function(){
    	jQuery('.grid_center').masonry({
      	itemSelector: '.grid',
      	isFitWidth: true,
      	isAnimated: true,
				isFitWidth : true
    	});
		});
		
function change(size){
	if(size == 'big'){ // 拡大の処理
		var width = jQuery('div.grid').width();
		console.log(width);
		jQuery('div.grid').css('width',width+30);
		jQuery('div.pagenation_grid').css('width','100%');
	}
	else if(size == 'small'){ // 縮小の処理
		var width = jQuery('div.grid').width();
		jQuery('div.grid').css('width',width-30);
		jQuery('div.pagenation_grid').css('width','100%');
	}
	jQuery('.grid_center').masonry({
      	itemSelector: '.grid',
      	isFitWidth: true,
      	isAnimated: true,
				isFitWidth : true
    	});
}
</script>
<!----------------------------------------------------------------------------------->
