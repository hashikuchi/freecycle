<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>古本市</title>
  <link rel="stylesheet" type="text/css" href='wp-content/themes/freecycle/lib/datetimepicker/jquery.datetimepicker.css'; ?>/ >
  <script src=<?php echo get_theme_root_uri().'/freecycle/lib/datetimepicker/jquery.js'; ?>></script>
  <script src=<?php echo get_theme_root_uri().'/freecycle/lib/datetimepicker/build/jquery.datetimepicker.full.min.js'; ?>></script>
</head>
<body>
        	<div class="schedule">
                <h3>古本市の予定入力欄</h3>
                <input type="text" placeholder="クリックして日付選択" id="bookfair_day" /></br>
                <input type="text" placeholder="クリックして開始時間を選択" id="start_bookfair_time" />
                <input type="text" placeholder="クリックして終了時間を選択" id="end_bookfair_time" /></br>
                古本市開催場所指定：</br>
                <select id="bookfair_place" onchange="appendTextBoxOfVenue">
                  <option data-place="">G30</option>
                  <option　data-place="else">その他</option>
                </select>
                </br>
                <input type="submit" value="古本市の予定入力完了" id="insert_bookfair_info" />
        	</div>

<script>
// 古本市の日付と時間と場所の情報を送信
  jQuery('#insert_bookfair_info').click(function(){
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url('admin-ajax.php'); ?>',
      data:{
        'action' : 'insert_bookfair_info',
        'bookfair_date' : jQuery('#bookfair_day').val(),
        'bookfair_start_time' : jQuery('#start_bookfair_time').val(),
        'bookfair_end_time' : jQuery('#end_bookfair_time').val(),
        'bookfair_venue' : jQuery('#bookfair_place option:selected').text(),
      },
      success: function(){
          jQuery('#bookfair_day').val('');
          jQuery('#start_bookfair_time').val('');
          jQuery('#bookfair_place').val('');
          jQuery('#end_bookfair_time').val('');
      }
    });
    return false;
});

// カレンダーの表示
  jQuery("#bookfair_day").datetimepicker({
    timepicker:false
  });
  jQuery("#start_bookfair_time").datetimepicker({
    datepicker:false,
    step:15
  });
  jQuery("#end_bookfair_time").datetimepicker({
    datepicker:false,
    step:15
  });

  // その他の時に場所の入力欄を表示
    var selectPlace = jQuery('#bookfair_place option:selected').data('place');
    function appendTextBoxOfVenue(){
      if(selectPlace='else'){
        jQuery('#bookfair_place').append('<input type="text" placeholder="開催場所を入力"/>');
      }
    }

</script>           
</body>
</html>

