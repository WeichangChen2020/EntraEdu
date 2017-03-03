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
<!DOCTYPE html>
<html>
  <head>
    <title>jQuery WeUI</title>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">

<link rel="stylesheet" href="/71/Public/css/weui.min.css">
<link rel="stylesheet" href="/71/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/71/Public/css/demos.css">




  </head>

  <body ontouchstart>

    <header class='demos-header'>
      <h1 class="demos-title">欢迎你</h1>
      <p class='demos-sub-title'><?php echo ($_SESSION['user']['id']); ?>同学</p>
    </header>

    <div class="weui_grids">
      <a href="<?php echo U('Home/Communicationplat/index');?>" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_button.png" alt="">
        </div>
        <p class="weui_grid_label">
          互动平台
        </p>
      </a>
      <a href="cell.html" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_cell.png" alt="">
        </div>
        <p class="weui_grid_label">
          随机练习
        </p>
      </a>
      <a href="index.php?p=admin&c=user&a=add" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_cell.png" alt="">
        </div>
        <p class="weui_grid_label">
          Form
        </p>
      </a>
      <a href="toast.html" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_toast.png" alt="">
        </div>
        <p class="weui_grid_label">
          Toast
        </p>
      </a>
      <a href="dialog.html" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_dialog.png" alt="">
        </div>
        <p class="weui_grid_label">
          Dialog
        </p>
      </a>
      <a href="index.php?p=admin&c=user&a=show" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_article.png" alt="">
        </div>
        <p class="weui_grid_label">
          Show
        </p>
      </a>
      <a href="<?php echo U('Home/Game/index');?>" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_panel.png" alt="">
        </div>
        <p class="weui_grid_label">
          狼人杀
        </p>
      </a>
      <a href="index.php?p=admin&c=user&a=ptr" class="weui_grid js_grid" >
        <div class="weui_grid_icon">
          <img src="/71/Public/images/icon_nav_ptr.png" alt="">
        </div>
        <p class="weui_grid_label">
          下拉刷新
        </p>
      </a>
    </div>

    <style>
      .weui_icon_info_circle:before {
        font-size: 28px;
        color: #09BB07;
      }
    </style>

<script src="/71/Public/js/jquery-weui.js"></script>

    </body>

  </html>

</body>
</html>