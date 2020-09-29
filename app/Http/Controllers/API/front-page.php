<!DOCTYPE html>
<!----------Hukam Thakur------->
<html  <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<link rel="profile" href="http://gmpg.org/xfn/11">


<!-- Bootstrap -->
<link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php bloginfo('template_url'); ?>/css/main.css?ver=<?php echo rand(111,999)?>" rel="stylesheet" type="text/css">
<link href="<?php bloginfo('template_url'); ?>/style.css?ver=<?php echo rand(111,999)?>" rel="stylesheet" type="text/css">
<link href="<?php bloginfo('template_url'); ?>/css/animate.css" rel="stylesheet" type="text/css">
<link href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
   

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
<style  type="text/css" id="cssID"> 
#collect-chat-launcher-container #collect-chat-avatar-text {
	max-width: 191px !important;
}
#collect-chat-launcher{background-color:#fff !important;}
._25 option {
    background-color: #333!important;
	border-color:#fff !important;
}
.loadframe [themeid="9"] header:after, .siqc_edt, .win_close, [themeid="10"] header:after, header {
    background-image: -moz-linear-gradient(90deg,#bd2f2f 0,#bd2f2f 100%)!important;
    background-image: -webkit-linear-gradient(90deg,#bd2f2f 0,#bd2f2f 100%)!important;
    background-image: -ms-linear-gradient(90deg,#bd2f2f 0,#bd2f2f 100%)!important;
}
.loadframe [themeid="9"] header::after, .siqc_edt, .win_close, [themeid="10"] header::after, header{
	background-image:none;
background-image:none;
	background:#bd2f2f !important;  
	background:	-webkit-#bd2f2f !important; 
} 
.loadframe {
	background:none !important;
	-webkit-background:none !important; 
}


@media screen and (-webkit-min-device-pixel-ratio:0)
{ 
.loadframe [themeid="9"] header::after, .siqc_edt, .win_close, [themeid="10"] header::after, header{
	background-image:none;
	background:#bd2f2f !important;  
} 
.loadframe {
	background:none !important;
}

}

</style>

<!--foriframe-->
<script type="text/javascript">
$(document).ready( function () {
    $('#siqiframe').load( function () {
        $('this').contents().find("header").css("background","#F00 !important");
    });
});


</script>




<script>
$(document).ready(function(){
     $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        $('#back-to-top').tooltip('show');

});
</script>

<script>
document.addEventListener( 'wpcf7mailsent', function( event ) {
    location = 'https://www.chauffeurcarmelbourne.com.au/thankyou/';
}, false );
</script>

<script type="text/javascript">!function(t,e){"use strict";var r=function(t){try{var r=e.head||e.getElementsByTagName("head")[0],a=e.createElement("script");a.setAttribute("type","text/javascript"),a.setAttribute("src",t),r.appendChild(a)}catch(t){}};t.CollectId = "5aa22e8f3256d7b63102255a",r("https://s3.amazonaws.com/collectchat/launcher.js")}(window,document);</script>

<?php  if( is_page('home')){
     $myclass="home-head";

 }else if( is_page('booking')){
     $myclass="booking-head";

 } else if( is_page('gallery')){     $myclass="gallery-head"; }  else if( is_page('about-us')){     $myclass="about-head"; }
 else if( is_page('contact-us')){
     $myclass="contact-head";

 }
 else {$myclass="inner-head";}?>

<?php wp_head(); ?>
  </head> 
  <body class="<?php echo $myclass; ?>">  
<div id="nav" data-spy="affix" data-offset-top="443">

 <nav class="navbar navbar-affix-top navbar">
  <div class="">

    <div class="navbar-header">
	 <a class="new_brand mobile" href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_directory');?>/img/logo-2.png" alt="Chauffeur car Melbourne App" class="img-responsive"></a> 
	 
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button> 
</div>
<div class="collapse navbar-collapse" id="myNavbar">
 <a class="new_brand" href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_directory');?>/img/logo-2.png" alt="Chauffeur car Melbourne App" class="img-responsive"></a> 
   
	<?php
    wp_nav_menu( array(
        'theme_location' => 'top',
        'menu_class'     => 'nav navbar-nav',
         ) );
?>
    </div>
  </div>
</nav> 
</div>

