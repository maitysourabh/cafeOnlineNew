<?php
include_once('init.php');
$page = find('first', STATIC_PAGE_HOME, '*', "WHERE id = 1", array());
$sliders = find('all', HOME_SLIDER, '*', "WHERE 1 ORDER BY sl_no", array());
$where_clause=" WHERE status='Y'";
$category_result = find("all", CATEGORIES, "*", "".$where_clause." ORDER BY rand() ", array());
//print_r($_SESSION);
$show_message='';
if(isset($_GET['login']) && $_GET['login']=='123')
{
	if(!isset($_SESSION['user_id']))
	{
	//$_SESSION['SESSION_LOGIN']=$_GET['login'];
	$_SESSION['SET_TYPE'] = 'error';
	$_SESSION['SET_FLASH'] = 'Please login or register';
	$show_message="<div id='notify_msg_div'></div>";
	//header('location:index.php');
	//exit;

	}
else
	{
	$_SESSION['SET_TYPE'] = 'sucess';
	$_SESSION['SET_FLASH'] = 'Login Success';
	$show_message="<div id='notify_msg_div'></div>";
	header('location:checkout.php');
	exit;
	}
}
	
if(!isset($_GET['page']))
{
	unset($_SESSION['ZIPCODE']);
}

if(isset($_POST['btn_search']))
{
	$_SESSION['ZIPCODE'] = $_POST['zipcode'];
	$execution=array();
	$where_clause = "WHERE ";
	if(@$_SESSION['ZIPCODE']!='')
	{
		$where_clause.= "(zipcode LIKE :search_val)  AND ";
		$execution[':search_val'] = "".stripcleantohtml($_SESSION['ZIPCODE'])."";
	}
	if(@$_SESSION['ZIPCODE'] == '')
	{
		$where_clause.= '1';
	}
	
	$where_clause = rtrim($where_clause, 'AND ');
	
	$result = find("first", DELIVERY_ZIPCODES, "*",  $where_clause, $execution);
	if($result>0)
	{
		$_SESSION['DELIVERY_PRICE']=$result['delivery_price'];
		$_SESSION['MINIMUM_COST']=$result['minimum_cost'];
		header('Location:menudetails.php');
		exit;
	}
	else
	{
		$_SESSION['SET_TYPE'] = 'error';
		$_SESSION['SET_FLASH'] = 'Zipcode not found';
		$show_message="<div id='notify_msg_div'></div>";
	}
}
else
{
	//DO NOTHING
}

$home_block1 = find("first", HOME_BLOCK, "*", "WHERE id=1", array());
$home_block2 = find("first", HOME_BLOCK, "*", "WHERE id=2", array());
$home_block3 = find("first", HOME_BLOCK, "*", "WHERE id=3", array());

$bottom_slider = find("all", BOTTOM_SLIDER, "*", "WHERE status=1", array());

$general_settings = find('first', SETTINGS, '*', "WHERE id = 1", array());

$home_popup = find("first", POP_UP, "*", "WHERE id=1  and status=1", array());

?>
<!doctype html>
<html lang="de" id="de" class="modern">
<head>
<meta charset="ISO-8859-1" />
<link rel="stylesheet" type="text/css" href="css/production-en_EN-2.10.3.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<title><?php echo FRONT_TITLE?></title>
<?php include_once('meta.php');?>
<meta http-equiv="Content-Language" content="en-EN">
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="resources/demos/style.css">
<script>
$(function(){
	$("#yd-jig-plz-search").autocomplete({
		source: function( request, response ) {
			$.ajax({
			  url: "ajax_search.php?yd-jig-plz-search="+request.term,
			  dataType: "json",
			  success: function(data) {
				response(data);
			  }
			});
		},
		select: function( event, ui ) {
			$(".ui-widget-content").hide();
		}
	});
});
$(function(){			
	$("#yd-jig-plz-search2").autocomplete({		
		source: function(request, response) {
			$.ajax({
			  url: "ajax_search_responsive.php?yd-jig-plz-search2="+request.term,
			  dataType: "json",
			  success: function(data) {
				response(data);
			  }
			});
		},
		select: function(event, ui) {
			$(".ui-widget-content").hide();
		}
	});
});

	function validation()
		{
			if(document.getElementById('yd-jig-plz-search').value=='')
			{
				document.getElementById('zipcode_msg').style.display="block";
				document.getElementById('yd-jig-plz-search').focus();
				return false;
			}
			else
			{
				document.getElementById('zipcode_msg').style.display="none";
			}
		}
	function validation2()
		{
			if(document.getElementById('yd-jig-plz-search2').value=='')
			{
				document.getElementById('zipcode_msg2').style.display="block";
				document.getElementById('yd-jig-plz-search2').focus();
				return false;
			}
			else
			{
				document.getElementById('zipcode_msg2').style.display="none";
				return true;
			}
		}
	</script>
	<script type="text/javascript">
$(function(){
	$(".auto .carousel").jCarouselLite({
		auto: 800,
		visible: 6,
		speed: 1000,
		autoCSS: false,
		responsive: true
	});
});
    </script>
<script type="text/javascript">
function push_val(val){
	document.getElementById('yd-jig-plz-search').value = val;
}
/*$(function(){
$(".search").keyup(function() 
{ 
//alert();
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='');
{
	$.ajax({
	type: "POST",
	url: "ajax_search.php",
	data: dataString,
	cache: false,
	success: function(html)
	{
	//alert(html);
	$("#result").html(html).show();
	},
	complete: function(){
		$("#result .show").on("click",function(e){
			$('#yd-jig-plz-search').val($(this).attr('data-zip'));
		})
	}
	});
}return false;    
});*/

/*$("#result").on("click",function(e){
	var clicked = $(e.target);
	var name = clicked.find('.name').html();
	var decoded = $("<div/>").html(name).text();
	alert(decoded);
	$('#yd-jig-plz-search').val(decoded);
});*/
jQuery(document).on("click", function(e) { 
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search")){
	jQuery("#result").fadeOut(); 
	}
});
$('#yd-jig-plz-search').click(function(){
	jQuery("#result").fadeIn();
});
</script>
<style type="text/css">
	.ui-widget-content{height:300px;overflow-y:auto;overflow-x:hidden;}
</style>
		<style type="text/css">
		.yd-jig-lightbox-content {
			z-index: 100000;
		}
		.yd-jig-info-steps-step01 {
			background: <?php echo $home_block1['back_ground_color']?> url(images/home_block/<?php echo $home_block1['image']?>)no-repeat center center / cover !important;;
		}
		.yd-jig-info-steps-step02{
    		background: <?php echo $home_block2['back_ground_color']?> url(images/home_block/<?php echo $home_block2['image']?>)no-repeat center center  / cover !important;;
		}
		.yd-jig-info-steps-step03 {
			background: <?php echo $home_block3['back_ground_color']?> url(images/home_block/<?php echo $home_block3['image']?>)no-repeat center  / cover !important;;
			margin-right: 0;
		}
		.text_color1
		{
		 color:<?php echo $home_block1['text_color']?>;
		}	
		.text_color2
		{
		 color:<?php echo $home_block2['text_color']?>;
		}	
		.text_color3
		{
		 color:<?php echo $home_block3['text_color']?>;
		}

	
.content{
		width:500px;
		margin:0 auto;
	}
	</style>
<!--=====================================================responsive==================================================-->
<script type="text/javascript">
/*$("#result1").on("click",function(e){
	var $clicked = $(e.target);
	var $name = $clicked.find('.name').html();
	var decoded = $("<div/>").html($name).text();
	$('#yd-jig-plz-search2').val(decoded);
});*/
jQuery(document).on("click", function(e) { 
	var $clicked = $(e.target);
	if (! $clicked.hasClass("search_res")){
	jQuery("#result1").fadeOut(); 
	}
});
$('#yd-jig-plz-search2').click(function(){
	jQuery("#result1").fadeIn();
});
</script>
<style>
	#result1
	{
		position:absolute;
		width:91%;
		padding:10px;
		display:none;
		margin-top:0px;
		border-top:0px;
		overflow:hidden;
		border:1px #CCC solid;
		background-color: rgb(80, 174, 204);;
		color: white;
		z-index: 9999;
	}
	</style>


   </head>
   <body data-pagename="index" class="yd-onload" style="overflow-x:hidden;">
   		<?php echo $show_message;?>
      <section class="yd-jig-mobileswitch yd-jig-mobileswitch"></section>
      <section class="yd-jig-appbanner yd-jig-appbanner"></section>
      <div id="fb-root"></div>
	  <div id="slider" class="nivoSlider top">
	  <?php
		foreach($sliders as $salist)
		{
			$exist_file = "images/slideshow/".$salist['slider_image'];
			if (file_exists($exist_file))
					{
		?>
			<img src="resize.php?w=1349&h=485&img=images/slideshow/<?php echo $salist['slider_image'];?>" data-thumb="resize.php?w=1349&h=485&img=images/slideshow/<?php echo $salist['slider_image'];?>" alt="" />
		<?php
		 			}
		 }
		?>
	  </div>
	  
	  <!--header-->
        <?php include_once('header.php')?>
	  <!--header end-->
      <div class="yd-header" style="background:none">
         <div class="yd-inner">
            <div style="visibility: visible;" class="yd-jig-index yd-cta">
               <section class="yd-jig-plz yd_jig_plz">
                  <form action="" method="post" class="ui-front yd-jig-plz-autocomplete-form yd-jig-internallinks-false" id="search_form" name="search_form">
                     <span class="yd-jig-plz-headline" style="color:#fff; display:block"><?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='en'?'Enter Your Postal code':'Geben Sie Ihre Postleitzahl'?></span>
					 <div style="clear:both; height:60px"></div>
					 <div style="padding:15px">
                     <input id="yd-jig-plz-search" class="yd-track-event-zipcode-input ui-autocomplete-input search" name="zipcode" placeholder="<?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='en'?'Zipcode':'Postleitzahl'?>" autofocus="" autocomplete="off" type="text" style="position:relative; width:100% ; padding:0px; margin:0px; left:0px; height:auto; padding:10px 0px; margin-bottom:10px" value = "<?php echo(@$_SESSION['ZIPCODE']);?>">
					 <div id="result"></div>
					 <div style="color:#FF0000;float:left;display:none" id="zipcode_msg"><?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='en'?'Please enter zipcode':'Bitte geben Sie zipcode'?></div>
					 <div style="clear:both"></div>
                     <input id="yd-start-order" class="yd-btn-l yd-btn-order yd-jig-plz-start-order" value="<?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de'?'Startreihenfolge':'Start Order'?>" type="submit" style="position:relative; width:100% ; padding:0px; margin:0px; left:0px; height:auto" name="btn_search" onClick="return validation()">
					 </div>
                     <div id="googlemap_dummy"></div>
                     <div class="yd-jig-plz-trusted-payment" style="bottom: 26px;">
                        <span><?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de'?'Barzahlung oder Paypal!':'Pay cash or paypal!'?></span>

                     </div>
					 <div style="clear:both"></div>
                  </form>
				  <div style="clear:both"></div>
               </section>
            </div>
         </div>
      </div>
	  
	  
      <div class="yd-wrapper" style="background:#fff !important">
         <div class="yd-content">
            <div class="yd-jig-index">
               <div class="yd-inner">
                  <div class="yd-grid">
			   

<style>
.search_content{
margin-top: 15px;
height: 194px;
background: #0003;
}
.plz-search{
position: relative;
width: 100%;
padding: 0px;
margin: 0px;
left: 0px;
height: auto;
}
.show_div{
display:none;
}
@media(max-width:1020px){
.show_div{
display:block;
}
}
</style>

               <section class="yd_jig_plz show_div">
                  <form action="" method="post" class="search_content" id="search_form" name="search_form">
                     <span class="yd-jig-plz-headline" style="display:block"><?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de'?'Finden Sie ein Essen zum Mitnehmen Restaurant in Ihrer Nähe':'Enter Your Postal Code'?></span>
					 <div style="clear:both;"></div>
					 <div style="padding:15px">
                     <!-- <input id="yd-jig-plz-search2" class="plz-search yd-track-event-zipcode-input ui-autocomplete-input search_res" name="zipcode" placeholder="<?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de'?'Postleitzahl':'Zipcode'?>" autofocus="" autocomplete="off" type="text" style="width: 98%;height: 32px;border-radius: 5px;font-size: 26px;" value = "<?php echo(@$_SESSION['ZIPCODE']);?>" onkeypress='return validateQty(event);'> -->
                     <input id="yd-jig-plz-search2" class="yd-track-event-zipcode-input ui-autocomplete-input search" name="zipcode" placeholder="<?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='en'?'Zipcode':'Postleitzahl'?>" autofocus="" autocomplete="off" type="text" style="width: 98%;height: 32px;border-radius: 5px;font-size: 26px;" value = "<?php echo(@$_SESSION['ZIPCODE']);?>">
					 <div id="result1"></div>
					 <div style="color:#FF0000;float:left;display:none" id="zipcode_msg2"><?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de'?'Bitte geben Sie zipcode':'Please enter zipcode'?></div>
					 <div style="clear:both"></div>
                     <input id="yd-start-order" class="plz-search yd-btn-l yd-btn-order yd-jig-plz-start-order" value="<?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de'?'Suche':'Start Order'?>" type="submit" style="margin-top: 80px;" name="btn_search" onClick="return validation2()">
					 </div>
                     <div id="googlemap_dummy"></div>
                     <div class="yd-jig-plz-trusted-payment" style="bottom: 26px;">
                        <span><?=isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de'?'Barzahlung oder online!':'Pay cash or online!'?></span>
                     <span class="yd-icon"></span>
                     </div>
					 <div style="clear:both"></div>
                  </form>
				  <div style="clear:both"></div>
				</section>



                     <section class="yd-jig-info-fb yd-jig-info-homepage"></section>
                     <section class="yd-jig-info-steps">
                        <div class="yd-grid-24">
                           <div class="yd-jig-info-steps-step yd-jig-info-steps-step01 yd-grid-08 yd-box" style="display:table;">
							  <div style="display:table-cell; vertical-align:middle;">
                              <!--<span>1</span> -->
                              <div class="text_color1">
								  <?php 
									if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de')
									{
										 echo $home_block1['title_language2'];
									}
									else
									{
										echo $home_block1['title'];
									}
									?>
								</div>
								  <p class="text_color1">
								  <?php 
									if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de')
									{
										 echo $home_block1['long_text_language2'];
									}
									else
									{
										echo $home_block1['long_text'];
									}
									?>
								  
								  </p>
                           </div>
						   </div>
                           <div class="yd-jig-info-steps-step yd-jig-info-steps-step02 yd-grid-08 yd-grid-gap-l yd-box" style="display:table;">
							  <div style="display:table-cell; vertical-align:middle;">
                              <!-- <span>2</span> -->
                              <div class="text_color2">
								  <?php 
									if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de')
									{
										 echo $home_block2['title_language2'];
									}
									else
									{
										echo $home_block2['title'];
									}
									?>
							  </div>
                              <p class="text_color2">
								  <?php 
									if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de')
									{
										 echo $home_block2['long_text_language2'];
									}
									else
									{
										echo $home_block2['long_text'];
									}
									?>
							  </p>
                           </div>
						   </div>
                           <div class="yd-jig-info-steps-step yd-jig-info-steps-step03 yd-grid-08 yd-grid-gap-l yd-box"style="display:table;">
							  <div style="display:table-cell; vertical-align:middle;">
                              <!-- <span>3</span> -->
                              <div class="text_color3">
								  <?php 
									if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de')
									{
										 echo $home_block3['title_language2'];
									}
									else
									{
										echo $home_block3['title'];
									}
									?>
							  </div>
                              <p class="text_color3"> <!-- yd-jig-info-steps-step03-break -->
								  <?php 
									if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de')
									{
										 echo $home_block3['long_text_language2'];
									}
									else
									{
										echo $home_block3['long_text'];
									}
									?>
							  </p>
							  </div>
                           </div>
                        </div>
                     </section>
                  </div>
               </div>
			   <div style="background:#f2f2f2; padding:25px 0px">
			   <div class="new-width auto">
			   <div class="carousel" style="width: 100% !important; height:auto;">
				   <h2 style="text-align:center; font-size:22px; margin-bottom:15px">
				   		<?php
						if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='de')
						{
							echo $general_settings['home_middle_title_language2'];
						}
						else
						{
							echo $general_settings['home_middle_title'];
						}
						
						?>
					</h2>			<!--ADD BY NEO CODERZ TECHNOLOGIES START -->

				   <ul class="yd-list2">
				   <?php
				   $count='';
				   foreach($bottom_slider as $bottom_slider_listing)
				   {
				   		$count++;
						if($count=='6') {break;}
						
						$cattrgory_file = "images/bottom_slider/".$bottom_slider_listing['image'];
						if (file_exists($cattrgory_file))
							{

							$link=$bottom_slider_listing['link_url'];
							if($link=='') { 
				   ?>
				   <li><img src="images/bottom_slider/<?php echo $bottom_slider_listing['image'];?>"  alt=""><div style="padding: 8px; font-size: 19px;"><b><?php echo $bottom_slider_listing['title'];?></b></div> <div><?php echo $bottom_slider_listing['title'];?> </div></li>


				   <?php  } else{ ?>
					  <li><a href="<?php echo $link;?>"><img src="images/bottom_slider/<?php echo $bottom_slider_listing['image'];?>"  alt=""></a><div style="padding: 8px; font-size: 19px;"><b><?php echo $bottom_slider_listing['title'];?></b></div> <div><?php echo $bottom_slider_listing['title'];?> </div></li>
				  <?php
				  			}	
				  	}
				   }
				  ?>
				   </ul>
				   			<!--ADD BY NEO CODERZ TECHNOLOGIES START -->

					<div style="clera:both"></div>
				</div>
				<div style="clear:both"></div>
				</div>
				</div>
                
            </div>
            <section class="yd-jig-user-jigs hidden"></section>
         </div>
<style>
#mask {
  position: absolute;
  left: 0;
  top: 0;
  z-index: 9000;
  background-color: #000;
  display: none;
}

#boxes .window {
  position: absolute;
  left: 0;
  top: 0;
  width: 440px;
  height: 200px;
  display: none;
  z-index: 9999;
  padding: 20px;
  border-radius: 15px;
  text-align: center;
  
}
.window img{ max-width:100%; height:auto !important; }


#boxes #dialog {
  width: 60%;
  height: auto;
  padding: 10px;
  background-color: #f36214;
  font-family: 'Segoe UI Light', sans-serif;
  font-size: 15pt;
  top: 33px;
}
@media(max-width:555px){#boxes #dialog {top: 50px;}}
#popupfoot {
	font-size: 16pt;
	position: absolute;
	bottom: 0px;
	width: 100%;
	margin: 0px auto;
}
</style>

<!--=======================add by neo coderz technologies start========================-->
<?php 

if(isset($home_popup)){
if($home_popup['description']!='')
{
if(!isset($_SESSION['user_id']))
{
?>	

<div id="boxes">
 <div id="dialog" class="window">
<?php echo $home_popup['description'];?>
<div id="popupfoot"> <a href="#" class="close agree"><input type="button" value="Close" onclick="" style="padding: 3px 15px;border-radius: 4px;
margin-bottom: 10px;background-color: #871819;color: #ffffff;font-size: 16px;font-weight: bold;"></a></div>
 </div>
 <div id="mask"></div>
</div>	
<?php
}
}
}
?>   
<!--=======================add by neo coderz technologies start========================-->
<!--footer-->
		 <?php include_once('footer.php')?>
		 <!--end footer-->
		 
      </div>
      <section class="yd-jig-register hidden"></section>
      <section class="yd-jig-forgotpassword hidden"></section>
      <section class="yd-jig-scrolltotop yd-track-event-click-totop hidden"></section>
      <div class="yd-banner">
         <section class="yd-jig-ie"></section>
         <section class="yd-jig-cookielaw"></section>
         <section class="yd-jig-mobile-redirectbutton"></section>
      </div>
      <section class="yd-jig-noscript">
         <noscript>
            <div class="yd-jig-noscript-wrapper">
               <div class="yd-jig-noscript-inner">
                  <div class="yd-icon">&#xe8b9;</div>
                  You have disabled JavaScript in your browser. Please activate JavaScript so that you can to use the service of yoursite.com
               </div>
            </div>
         </noscript>
      </section>
      <section class="yd-jig-maintenance yd-jig-maintenance"></section>
	  <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
	  <script src="js/jquery.nivo.slider.js"></script> 
	  <script type="text/javascript" src="source/jquery.fancybox.js"></script>
	  
	  
	<link rel="stylesheet" type="text/css" href="source/jquery.fancybox.css?v=2.1.5" media="screen" />
	  <script type="text/javascript">
		$(window).load(function() {
			$('#slider').nivoSlider({
				effect:'fade'
			});
		});
    </script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();
			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.php',
					type : 'iframe',
					padding : 5
				});
			});
		})

	</script>
	
	<script>
$(document).ready(function() {	

var id = '#dialog';
	
//Get the screen height and width
var maskHeight = $(document).height();
var maskWidth = $(window).width();
	
//Set heigth and width to mask to fill up the whole screen
$('#mask').css({'width':maskWidth,'height':maskHeight});

//transition effect
$('#mask').fadeIn(500);	
$('#mask').fadeTo("slow",0.9);	
	
//Get the window height and width
var winH = $(window).height();
var winW = $(window).width();
              
//Set the popup window to center
//$(id).css('top',  winH/2-$(id).height()/2);
$(id).css('left', winW/2-$(id).width()/2);
	
//transition effect
$(id).fadeIn(2000); 	
	
//if close button is clicked
$('.window .close').click(function (e) {
//Cancel the link behavior
e.preventDefault();

$('#mask').hide();
$('.window').hide();
});

//if mask is clicked
$('#mask').click(function () {
$(this).hide();
$('.window').hide();
});
	
});	
	</script>
   </body>
</html>

<?php
if(isset($_SESSION['SET_FLASH']))
{
	if($_SESSION['SET_TYPE']=='error')
	{
		echo "<script type='text/javascript'>showError('".$_SESSION['SET_FLASH']."');</script>";
	}
	if($_SESSION['SET_TYPE']=='success')
	{
		echo "<script type='text/javascript'>showSuccess('".$_SESSION['SET_FLASH']."');</script>";
	}
}
unset($_SESSION['SET_FLASH']);
unset($_SESSION['SET_TYPE']);
$db=NULL;
//$_SESSION['popup']="OPEN_POPUP";
?>