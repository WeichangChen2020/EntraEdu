<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
 <html>
 <head>
<meta charset="UTF-8">
 	<title>登录界面</title>
 </head>
 <body>
 <form action="/cplatv2/index.php/Home/Index/check" method="post">
 	帐号：
 	<textarea cols="20" rows="2" name="id" ></textarea>
 	</br>
 	密码：
 	
 	<textarea cols="20" rows="2" name="password"></textarea>
 	</br>
 	</br> 	
 	<button type="submit">登录</button>
 </form>
 </body>
 </html>