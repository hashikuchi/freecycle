 // カレンダーの表示
  jQuery('#bookfair_date').datetimepicker({
    timepicker:false,
    format:'Y/m/d',
  });
  jQuery("#start_bookfair_time").datetimepicker({
    datepicker:false,
    step:15,
    defaultTime:'12:30',
    format:'H:i',
  });
  jQuery("#end_bookfair_time").datetimepicker({
    datepicker:false,
    step:15,
    defaultTime:'12:30',
    format:'H:i',
  });

// 古本市の予定をinsert_bookfair_infoに送信する関数
function post_bookfair_info(){
  var start_datetime = jQuery('#bookfair_date').val()+" "+jQuery('#start_bookfair_time').val();
  var end_datetime = jQuery('#bookfair_date').val()+" "+jQuery('#end_bookfair_time').val();
  var venue = jQuery('#bookfair_place option:selected').val();
  var venue2 = jQuery('#other_place').val();
    jQuery.ajax({
      type:'POST',
      url: ajaxurl,
      data:{
        'action' : 'insert_bookfair_info',
        'bookfair_start_time' : start_datetime,
        'bookfair_end_time' : end_datetime,
        'bookfair_venue' : venue,
        'bookfair_place' : venue2,
      },
      success: function(){
          // alert("開始日時："+jQuery('#start_bookfair_time').val()+"終了日時："+jQuery("#end_bookfair_time").val()+"開催場所："+jQuery('#bookfair_place option:selected').val());
          jQuery('#bookfair_date').val('');
          jQuery('#start_bookfair_time').val('');
          jQuery('#end_bookfair_time').val('');
          jQuery('#other_place').val('');

      }
    });
    return false;
  }

// 入力した古本市の予定内容の確認
  document.querySelector('#insert_bookfair_info').onclick = function(){
        var other_place = jQuery('#other_place').val(); 
            if(other_place==""){
                var place = jQuery('#bookfair_place option:selected').val();
            }else{
                var place = jQuery('#other_place').val(); 
            }
        swal({
            title:"この内容でよろしいですか？", // タイトル文
            text:"開催日:"+jQuery('#bookfair_date').val()+"開始時間："+jQuery('#start_bookfair_time').val()+"終了時間："+jQuery("#end_bookfair_time").val()+"開催場所："+place, //説明文
            type:"warning", // default:null "warning","error","success","info"
            allowOutsideClick:false, // default:false アラートの外を画面クリックでアラート削除
            showCancelButton: true, // default:false キャンセルボタンの有無
            confirmButtonText:"オッケー", // default:"OK" 確認ボタンの文言
            confirmButtonColor: "#DD6B55", // default:"#AEDEF4" 確認ボタンの色
            cancelButtonText:"キャンセル", // キャンセルボタンの文言
            closeOnConfirm: false // default:true 確認ボタンを押したらアラートが削除される
            },
            function(){
                swal("入力完了!", "入力した古本市の予定は記録されました", "success");
                post_bookfair_info(); // 古本市の日付と時間と場所の情報を送信
            }
        );

    };
