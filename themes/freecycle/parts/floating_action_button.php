<?php
function floating_action_button(){
?>

<div id="floating_action_button">
	<a type="button" class="fa_button fa_main" id="fa_main">検索</a>
	<a><div class="fa_button fa_sub" id="fa1">キーワード</div></a>
	<a><div class="fa_button fa_sub" id="fa2">名古屋大学</div></a>
	<a><div class="fa_button fa_sub" id="fa3">南山大学</div></a>
	<a><div class="fa_button fa_sub" id="fa4">その他</div></a>
</div>

<script>
jQuery(function(){
	
if (window.ontouchstart === null){
	console.log("SmartPhone");
	jQuery("#fa_main").on('touchstart',function(){
	 var fa1_bottom = $("#fa1").css('bottom');
	 var max = 180;
	 var min = 20;
	 var a = (max-min)/2*Math.sqrt(3)+min;
	 var b = (max-min)/2+min;

	 if(fa1_bottom == min+"px"){
		//$("#fa_main").animate({width:'50px',height:'50px',font:'25px',bottom:"25px",right:"25px"},10);
		$("#fa1").animate({bottom: max+"px", right: min+"px",opacity: '0.9'},80,"swing");
		$("#fa3").animate({bottom: a+"px", right: b+"px",opacity: '0.9'},133,"swing");
		$("#fa2").animate({bottom: b+"px", right: a+"px",opacity: '0.9'},166,"swing"),"swing";
		$("#fa4").animate({bottom: min+"px", right: max+"px",opacity: '0.9'},200,"swing");
		console.log("true",a,b);
	 } else {
		 //$("#fa_main").animate({width:"60px",height:"60px",font:"30px",bottom:"20px",right:"20px"},10);
		 $("#fa1").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 $("#fa2").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 $("#fa3").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 $("#fa4").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 console.log("false",fa1_bottom);
	 }
	});
} else {
	jQuery("#fa_main").on('click',function(){
	 var fa1_bottom = $("#fa1").css('bottom');
	 var max = 180;
	 var min = 20;
	 var a = (max-min)/2*Math.sqrt(3)+min;
	 var b = (max-min)/2+min;

	 if(fa1_bottom == min+"px"){
		//$("#fa_main").animate({width:'50px',height:'50px',font:'25px',bottom:"25px",right:"25px"},10);
		$("#fa1").animate({bottom: max+"px", right: min+"px",opacity: '0.9'},80,"swing");
		$("#fa3").animate({bottom: a+"px", right: b+"px",opacity: '0.9'},133,"swing");
		$("#fa2").animate({bottom: b+"px", right: a+"px",opacity: '0.9'},166,"swing"),"swing";
		$("#fa4").animate({bottom: min+"px", right: max+"px",opacity: '0.9'},200,"swing");
		console.log("true",a,b);
	 } else {
		 //$("#fa_main").animate({width:"60px",height:"60px",font:"30px",bottom:"20px",right:"20px"},10);
		 $("#fa1").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 $("#fa2").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 $("#fa3").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 $("#fa4").animate({bottom: min+"px",right: min+"px",opacity: '0'},"fast");
		 console.log("false",fa1_bottom);
	 }
	});
}});
	
</script>

<?php
}
?>