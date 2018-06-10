<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title></title>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- bootstrap-css -->
<link href="/cplatv2/Public/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- //bootstrap-css -->
<!-- css -->
<link href="/cplatv2/Public/css/style.css" rel='stylesheet' type='text/css' />
<!-- //css -->
<script src="/cplatv2/Public/js/jquery-1.11.1.min.js"> </script>	
<script src="/cplatv2/Public/js/bootstrap.js"></script>
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
								<li><a href="contact.html">Contact</a></li>
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
	<title>回复界面</title>
</head>
<body>
<span>对他说些什么吧</span>


<form action="<?php echo U('addcomment',array('numr'=>$number));?>" name="comment" method="post">
	<textarea cols="50" rows="10"></textarea></br>
	<button type="submit">提交</button>
</form>
</body>
</html>
</body>
</html>