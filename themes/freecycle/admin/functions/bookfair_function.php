<?php

// 今日以降のすべての古本市の情報を取ってくる
function get_bookfair_info_of_all_after_today(){
	global $wpdb;
	global $table_prefix;
	$bookfair_infos = $wpdb->get_results($wpdb->prepare("
		SELECT " . $table_prefix . "fmt_book_fair.bookfair_id, start_datetime, end_datetime ,venue
		FROM " . $table_prefix . "fmt_book_fair 
		WHERE end_datetime >= current_timestamp
		ORDER BY start_datetime "
		,null
		));

	return $bookfair_infos;
}

// 古本市の予定欄を表示する関数
function show_bookfair_info_of_all_after_today(){
	$bookfair_infos = get_bookfair_info_of_all_after_today();
	echo <<< BOOKFAIR_TABLE
		<table>
	            <tr>
	                <th>開催日</th>
	                <th>開始時間</th>
	                <th>終了時間</th>
	                <th>開催場所</th>
	                <th></th>
	            </tr>
BOOKFAIR_TABLE;
		        foreach($bookfair_infos as $bookfair_info){
		    		$start_datetime = strtotime($bookfair_info->start_datetime);
		    		$end_datetime = strtotime($bookfair_info->end_datetime);
		    		$bookfair_day = date('Y/m/d',$start_datetime);
		    		$start_time = date('H:i',$start_datetime);
		    		$end_time = date('H:i',$end_datetime);
		    		$venue = $bookfair_info->venue;
		    		$bookfair_id = $bookfair_info->bookfair_id;
		    		echo <<< BOOKFAIR_TABLE
		    		<tr>
		                <td id='bookfair_date_$bookfair_id'> $bookfair_day </td>
		                <td id='bookfair_start_$bookfair_id'> $start_time </td>
		                <td id='bookfair_end_$bookfair_id'> $end_time </td>
		                <td id='bookfair_venue_$bookfair_id'> $venue </td>
		                <td> <a class='bookfair_delete' onClick='postDeleteBookfairInfo($bookfair_id)'>削除</a> </td>
		            </tr>
BOOKFAIR_TABLE;
		        }

	echo "</table>";
}

?>