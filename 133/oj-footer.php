<div id=foot>
 <!--<br>

<a href="./"><span class=red>HOME</span></a>
<a href="javascript:history.go(-1)"><span class=red>Back</span></a>

<hr>
-->
<center>
	<p>
	<?php if(file_exists("setlang.php")){?>
		<a href=setlang.php?lang=ko>한국어</a>&nbsp;
		<a href=setlang.php?lang=cn>中文</a>&nbsp;
		<a href=setlang.php?lang=fa>فارسی</a>&nbsp;
		<a href=setlang.php?lang=en>English</a>&nbsp;
		<a href=setlang.php?lang=th>ไทย</a>
	<?php }?>
		<br>
		All Copyright Reserved 2010-2011 <a href='<?php echo $OJ_HOME?>'><?php echo $OJ_NAME?></a> TEAM<br>
		<a href=gpl-2.0.txt><span class=green>GPL2.0</span></a> 2003-2012 <a href='http://code.google.com/p/hustoj/'>HUSTOJ Project</a> TEAM<br>
		Anything about the Problems, Please Contact Admin:<a href="mailto:<?php echo $OJ_ADMIN?>">admin</a><br>
     <?php if ($OJ_SAE) {
                   echo "<a href=http://sae.sina.com.cn><img bolder=0 src=http://static.sae.sina.com.cn/image/poweredby/poweredby.png></a>";
            
           }
     ?>
		<script type="text/javascript" charset="utf-8">
(function(){
  var _w = 86 , _h = 50;
  var param = {
    url:location.href,
    type:'6',
    count:'1', /**是否显示分享数，1显示(可选)*/
    appkey:'', /**您申请的应用appkey,显示分享来源(可选)*/
    title:'', /**分享的文字内容(可选，默认为所在页面的title)*/
    pic:'', /**分享图片的路径(可选)*/
    ralateUid:'', /**关联用户的UID，分享微博会@该用户(可选)*/
	language:'zh_cn', /**设置语言，zh_cn|zh_tw(可选)*/
    rnd:new Date().valueOf()
  }
  var temp = [];
  for( var p in param ){
    temp.push(p + '=' + encodeURIComponent( param[p] || '' ) )
  }
  document.write('<iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?' + temp.join('&') + '" width="'+ _w+'" height="'+_h+'"></iframe>')
})()
</script>
	</p>
</center>
</div><!--end foot-->
</div><!--end main-->
</div><!--end wrapper-->
</body>
</html>
<?php if(file_exists('./include/cache_end.php'))require_once('./include/cache_end.php');?>
