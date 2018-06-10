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

<!doctype html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link href="/71/Public/css/kaifang.css" rel='stylesheet' type='text/css' />

<title>狼人</title>

</head>
<body>
<div class="gridContainer clearfix">
<form action="<?php echo U('Home/Game/fangjiannum');?>" method="post">

  <div id="top_box" class="box clearfix">
    <table class="input_table">
      <tr>
        <td colspan="3">
          <span style="display:inline-block; margin-right:1%;  text-align:right">人数：</span>
          <select class="langrensha_select" style="margin-right:5%; width:80px;" name="people" id="people" onchange="changeAll(this.value)">
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
          </select><!-- <a class="am_tab" href="#" onclick="changeAuto();" id="sdpz">自动配置</a></td> -->
      </tr>
      <tr align="center" valign="middle" >
        <td height="50" colspan="3"><hr/></td>
      </tr>
      <tr>
        <td align="left" width="42%"><img src="/71/Public/images/langren.jpg" width="50px" height="50px">狼人</td>
        <td><select class="langrensha_select" style="width:80px;" name="langren" id="langren" onchange="changeLr(this.value)">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
          </select></td>
          <td></td>
      </tr>
      <tr>
        <td align="left"><img src="/71/Public/images/cunmin.jpg" width="50px" height="50px">村民</td>
        <td colspan="2"><input type="text" style="width: 50px;border:0;background-color: #f8e6ca;font-size:22px;" class="red" value="2" id="cunmin" name="cunmin" readonly="readonly"/></td>
      </tr>
      <tr class="small">

        <td width="33%" >

        <input type="checkbox" name="yyj" id="yyj" value="1" checked="checked" class="fuxuan" /> 
        <!-- <div class="roundedOne">
        
            <input type="checkbox" value="None" id="roundedOne" name="check" checked />
            <label for="roundedOne"></label>
        </div> -->
            <img src="/71/Public/images/yyj.jpg" width="40px" height="40px" >预言家</td>

        


      

        <td width="33%" ><input type="checkbox" name="nvwu" id="nvwu" value="1" checked="checked" /> <img src="/71/Public/images/nvwu.jpg" width="40px" height="40px">女巫</td>
        <td width="33%" ><input type="checkbox" name="lieren" id="lieren" value="1" checked="checked" /> <img src="/71/Public/images/lieren.jpg" width="40px" height="40px">猎人</td>
      </tr>
      <tr class="small">
       <td width="33%" ><input type="checkbox" name="qbt" id="qbt" value="1"/> <img src="/71/Public/images/qbt.jpg" width="40px" height="40px">丘比特</td>
        <td width="33%" ><input type="checkbox" name="shouwei" id="shouwei" value="1" /> <img src="/71/Public/images/shouwei.jpg" width="40px" height="40px">守卫</td>
        <td width="33%" ><input type="checkbox" name="baichi" id="baichi" value="1"  /> <img src="/71/Public/images/baichi.jpg" width="40px" height="40px">白痴</td>
      </tr>
      
    </table>
  </div>
  <input id="creategame" type="submit" class="main_btn" value="创建游戏" />
 <!--  </br>
  <a href="" class="weui-btn weui-btn_primary">ggg</a> -->
  <input type="hidden" value="1" name="flag">
</form></div>



<script type="text/javascript" src="/71/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/71/Public/js/kaifang.js"></script>


</body>
</html>
</body>
</html>