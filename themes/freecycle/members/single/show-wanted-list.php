<div id="wanted_list">
	<?php
		global $user_ID;
		
		$wanted_list = get_wanted_list($user_ID);
		if(!$wanted_list){
	?>
		<p>ほしいものリストが登録されていません。</p>
	<?php
		}
		$count = 1;
		foreach($wanted_list as $wanted_item){
	?>
		<div id="<?php echo $wanted_item->ASIN ?>" class="item_detail" style="height:160px;margin:5px 5px 5px 5px;">
		<img src="<?php echo $wanted_item->image_url ?>" style="float:left;">
		<ul>
		<li><strong><?php echo $wanted_item->item_name?></strong></li>
		<ul>
		<input type='button' value='削除' onclick='delWantedListFromIndex("<?php echo $wanted_item->ASIN ?>")'>
		</div>
	<?php
		$count++;
		}
	?>
</div>
<hr> <!-- 仕切り線 -->