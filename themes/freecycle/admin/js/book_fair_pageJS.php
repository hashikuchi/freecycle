<script>
 // カレンダーの表示
  jQuery("#start_bookfair_time").datetimepicker({
    step:15,
    defaultTime:'12:30'
  });
  jQuery("#end_bookfair_time").datetimepicker({
    step:15,
    defaultTime:'12:30'
  });

 </script>

 <script>
// 古本市の予定をinsert_bookfair_infoに送信する関数
function post_bookfair_info(){
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url('admin-ajax.php'); ?>',
      data:{
        'action' : 'insert_bookfair_info',
        'bookfair_start_time' : jQuery('#start_bookfair_time').val(),
        'bookfair_end_time' : jQuery('#end_bookfair_time').val(),
        'bookfair_venue' :    jQuery('#bookfair_place option:selected').val(),
      },
      success: function(){
          alert("開始日時："+jQuery('#start_bookfair_time').val()+"終了日時："+jQuery("#end_bookfair_time").val()+"開催場所："+jQuery('#bookfair_place option:selected').val());
          jQuery('#start_bookfair_time').val('');
          jQuery('#end_bookfair_time').val('');
      }
    });
    return false;
  }

  // 古本市の日付と時間と場所の情報を送信
  jQuery('#insert_bookfair_info').click(post_bookfair_info);
</script>

 

 