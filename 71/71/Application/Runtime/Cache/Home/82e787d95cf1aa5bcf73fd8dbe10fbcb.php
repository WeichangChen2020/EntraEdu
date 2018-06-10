<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">

<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script> -->

<link rel="stylesheet" href="/71/Public/css/weui.min.css">
<link rel="stylesheet" href="/71/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/71/Public/css/demos.css">
<link rel="stylesheet" type="text/css" href="/71/Public/css/background.css">



<title><?php echo ($title); ?></title>

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- bootstrap-css -->
<link href="/71/Public/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- //bootstrap-css -->
<!-- css -->
<link href="/71/Public/css/style.css" rel='stylesheet' type='text/css' />
<!-- //css -->
<script src="/71/Public/js/jquery-1.11.1.min.js"> </script>	
<script src="/71/Public/js/bootstrap.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>	










</head>
<body>
<div class="header">
			<!-- container -->
			<div class="container">
				<div class="logo">
					<h1><a href="<?php echo U('Index/index');?>"><span>C语言</span>V2</a></h1>
				</div>
				<div class="top-nav">
					<nav class="navbar navbar-default">
						<div class="container">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu						
							</button>
						</div>
						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="<?php echo U('Index/index');?>" class="active">Home</a></li>
								<li><a href="about.html">About</a></li>
								<li><a href="codes.html">Codes</a></li>
								<li><a href="#" class="dropdown-toggle hvr-bounce-to-bottom" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gallery<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a class="hvr-bounce-to-bottom" href="gallery.html">Gallery1</a></li>
										<li class="dropdown-submenu">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown-submenu" role="button" aria-haspopup="true" aria-expanded="false">Gallery2<span class="caret"></span></a>
											<ul class="dropdown-menu">
											  <li><a tabindex="-1" href="gallery.html">Gallery4</a></li>
												<li><a href="gallery.html">Gallery5</a></li>
											  <li><a href="gallery.html">Gallery6</a></li>
											</ul>
										  </li>
										<li><a class="hvr-bounce-to-bottom" href="gallery.html">Gallery3</a></li>           
									</ul>
								</li>	
								<li><a href="blog.html">Blog</a></li>
								<li><a href="<?php echo U('Communicationplat/index');?>}">Contact</a></li>
							</ul>	
							<div class="clearfix"> </div>
						</div>	
					</nav>		
				</div>
			</div>
			<!-- //container -->
		</div>

<style type="text/css">
	body {
    background-color: #f8e6ca;
    margin: 0;
    padding-left: 5px;
    padding-right: 5px;
}
	.box {
    border: 2px #b08023 solid;
    background-color: rgba(54, 85, 222, 0.26);
    box-shadow: 0 2px #fbf4eb;
    border-radius: 5px;
    text-align: center;
    margin:0 auto;
    margin-top:43%;
    left: 50%;
}
	.orange {
	color: #fef4e9;
	width: 200px;
	height: 50px;
	border-radius: 30px;
	border: solid 1px #da7c0c;
	background: #f78d1d;
	background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
	background: -moz-linear-gradient(top,  #faa51a,  #f47a20);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
}

	.orange:active {
	color: #fcd3a5;
	background: -webkit-gradient(linear, left top, left bottom, from(#f47a20), to(#faa51a));
	background: -moz-linear-gradient(top,  #f47a20,  #faa51a);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#f47a20', endColorstr='#faa51a');
}
</style>

<div class="box">
	</br>
	</br>
	<span><h1>房间号为<?php echo ($fangjianhao); ?></h1></span>
	</br>
	</br>
	</br>
	</br>
	
	<input type="button" value="进入房间" onclick="javascript:window.location.href='<?php echo U('Game/gamehome',array('fangjianhao'=>$fangjianhao));?>'" class="orange" >
	</br>
	</br>
</div>
</body>
</html>