<script>

	onClickSearchWantedList(0,"<?php echo (urldecode($_GET[item_name])) ?>");
		
	//Enter押下時読み込まれる関数
	function go(f){
		if(window.event.keyCode == 13){
			f();
		}
	}

	function searchWantedListByKeyword(){
		onClickSearchWantedList(0,document.getElementById("keyword").value);
	}

</script>
<ul>
	<li>
	<input type="text" name="keyword" id="keyword" placeholder="書名検索" size="30" value="<?php echo (urldecode($_GET[item_name])) ?>" onkeydown="go(searchWantedListByKeyword);">
	
	<input type="button" name="btn_search" value="検索" onClick="onClickSearchWantedList(0,document.getElementById('keyword').value);" >
	</li>
	<li>
	<label for='department'>学部で検索</label>
	<select name='department' id='department' onChange="onClickSearchWantedList(0)"><?php echo get_department_options(); ?></select>
	</li>
</ul>
<div id="wanted_list" style="height:auto !important;">
<div align=center><img src="<?php echo get_stylesheet_directory_uri() ?>/images/ajax-loader.gif"></div>
</div>