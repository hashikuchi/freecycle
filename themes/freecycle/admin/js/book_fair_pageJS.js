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
function postBookfairInfo(){
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
          location.reload();
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
                postBookfairInfo(); // 古本市の日付と時間と場所の情報を送信
                swal("入力完了!", "入力した古本市の予定は記録されました", "success");
            }
        );

    };

// delete_bookfair_infoに削除する情報の古本市IDを渡す関数
function postDeleteBookfairInfo(bookfairID){
  swal({
            title:"削除してもよろしいですか？", // タイトル文
            // text:"開催日:"+jQuery('#bookfair_date').val()+"開始時間："+jQuery('#start_bookfair_time').val()+"終了時間："+jQuery("#end_bookfair_time").val()+"開催場所："+place, //説明文
            type:"warning", // default:null "warning","error","success","info"
            allowOutsideClick:false, // default:false アラートの外を画面クリックでアラート削除
            showCancelButton: true, // default:false キャンセルボタンの有無
            confirmButtonText:"オッケー", // default:"OK" 確認ボタンの文言
            confirmButtonColor: "#DD6B55", // default:"#AEDEF4" 確認ボタンの色
            cancelButtonText:"キャンセル", // キャンセルボタンの文言
            closeOnConfirm: false // default:true 確認ボタンを押したらアラートが削除される
            },
            function(){
                    jQuery.ajax({
                        type:'POST',
                        url: ajaxurl,
                        data:{
                          'action' : 'delete_bookfair_info',
                          'bookfair_id' : bookfairID,
                        },                        
                    success: function(msg){
                      swal({
                        title: "古本市の情報を取り消しました。",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonColor: "#AEDEF4",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                      },
                      function(){
                        location.reload();
                      });
                    },
                    false: function(msg){
                      swal({
                        title: "古本市の情報の取り消しに失敗しました。",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#AEDEF4",
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                      });
                    }
                  });
                return false;
            }
        );
}