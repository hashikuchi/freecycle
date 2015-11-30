
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>古本市</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" >
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" >
  <script>
  $(function() {
    $("#datepicker").datepicker();
  });
</script>
</head>
<body>
    <!-- <form method="GET" action="huruhon_date.php"> -->
	<?php 

  ?>
        	<div class="schedule">
                <h3>古本市の日付入力欄</h3>
                <input type="text"  placeholder="クリックして日付入力" name="book_fair_date" id="datepicker">
                <input type="text" placeholder="場所を入力"　name="book_fair_venue" id="venue">
                <input type="submit" value="日付と場所決定" id="insert_bookfair_date_venue">
        	</div>
<script>
// function insert_bookfair_date_venue(){
  jQuery('#insert_bookfair_date_venue').click(function(){
    jQuery.ajax({
      type:'POST',
      url:'<?php echo admin_url('admin-ajax.php'); ?>',
      data:{
        'action' : 'insert_bookfair_date_venue',
        'book_fair_date' : jQuery('#datepicker').val(),
        'book_fair_venue' : jQuery('#venue').val(),
      },
      success: function(){
          // jQuery("#insert_bookfair_date_venue").empty();
          alert(jQuery('#datepicker').val());
          // jQuery('#datepicker').val().remove();
          // jQuery('#venue').val().remove();

          // console.log(jQuery('#book_fair_venue').val(););
      }
    });
    return false;
});
// }

</script>
            
</body>
</html>

