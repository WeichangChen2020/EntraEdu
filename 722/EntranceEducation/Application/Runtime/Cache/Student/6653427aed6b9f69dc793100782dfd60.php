<?php if (!defined('THINK_PATH')) exit();?><!-- 试题分析 -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="概率论与数理统计教学平台v3.0">

<link rel="stylesheet" href="/EntranceEducation/Public/lib/weui.min.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/demos.css">
    <style>
        .cell_top{margin-top:0px;}
        .analyze{margin-left: 40px;}
    </style>
  </head>

  <body ontouchstart>
    <div class="weui-pull-to-refresh-layer">
  <div class='pull-to-refresh-arrow'></div>
  <div class='pull-to-refresh-preloader'></div>
  <div class="down">下拉刷新页面</div>
  <div class="up">释放刷新</div>
  <div class="refresh">正在刷新</div>
</div>
    <header class='demos-header'>
      <h1 class="demos-title">试题解析</h1>
    </header>
    <?php if(is_array($quesList)): $i = 0; $__LIST__ = $quesList;if( count($__LIST__)==0 ) : echo "没有测试题目" ;else: foreach($__LIST__ as $key=>$quesList): $mod = ($i % 2 );++$i;?><div class="weui_cells weui_cells_form cell_top ">
        <div class="" style="padding:0px 15px;"><?php echo ($i); ?></div>
        <div class="weui_cell weui_article" style="padding:0px 15px;">
          <img src="http://testet-public.stor.sinaapp.com<?php echo (str_replace('/Public','',$quesList["questionPicPath"])); echo ($quesList["questionPicName"]); ?>" alt="">
        </div>
        <div class="weui_cells weui_article cell_top" style="padding:0px; left:15px;">
          <div>标准答案：<?php echo ($quesList["rightAnswer"]); ?><span class="analyze">
            解析：<?php if(empty($quesList["analysisPicPath"])): ?>无<?php endif; ?>
          </span></div>
        </div>
        <?php if(!empty($quesList["analysisPicPath"])): ?><div class="weui_cell weui_article" style="padding:0px 15px;"><img src="http://testet-public.stor.sinaapp.com<?php echo (str_replace('/Public','',$quesList["analysisPicPath"])); echo ($quesList["analysisPicName"]); ?>" alt=""></div><?php endif; ?>
      </div><?php endforeach; endif; else: echo "没有测试题目" ;endif; ?>
  </body>
</html>
<script src="/EntranceEducation/Public/lib/jquery-2.1.4.js"></script>
<script src="/EntranceEducation/Public/js/jquery-weui.js"></script>
<script>
  $(document.body).pullToRefresh().on("pull-to-refresh", function() {
    setTimeout(function() {
      location.reload();
      $(document.body).pullToRefreshDone();
    }, 1200);
  });
</script>