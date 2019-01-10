<?php
	header('Cache-Control: max-age=86400');
	header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta http-equiv="Cache-control" content="public">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png" type="image/png">
	<script>function loadFont(a,b,c,d){function e(){if(!window.FontFace)return!1;var a=new FontFace("t",'url("data:application/font-woff2,") format("woff2")',{}),b=a.load();try{b.then(null,function(){})}catch(c){}return"loading"===a.status}var f=navigator.userAgent,g=!window.addEventListener||f.match(/(Android (2|3|4.0|4.1|4.2|4.3))|(Opera (Mini|Mobi))/)&&!f.match(/Chrome/);if(!g){var h={};try{h=localStorage||{}}catch(i){}var j="x-font-"+a,k=j+"url",l=j+"css",m=h[k],n=h[l],o=document.createElement("style");if(o.rel="stylesheet",document.head.appendChild(o),!n||m!==b&&m!==c){var p=c&&e()?c:b,q=new XMLHttpRequest;q.open("GET",p),q.onload=function(){q.status>=200&&q.status<400&&(h[k]=p,h[l]=q.responseText,d||(o.textContent=q.responseText))},q.send()}else o.textContent=n}}
loadFont('amaticsc-bold','<?php echo get_template_directory_uri(); ?>/css/amaticsc-bold.css');loadFont('amaticsc-regular','<?php echo get_template_directory_uri(); ?>/css/amaticsc-regular.css');loadFont('roboto-bold','<?php echo get_template_directory_uri(); ?>/css/roboto-bold.css');loadFont('roboto-light','<?php echo get_template_directory_uri(); ?>/css/roboto-light.css');loadFont('roboto-regular','<?php echo get_template_directory_uri(); ?>/css/roboto-regular.css')</script>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/libs.min.css">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.min.css">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>