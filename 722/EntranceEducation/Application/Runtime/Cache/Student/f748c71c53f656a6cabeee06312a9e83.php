<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
 <head>
  <title></title>
  <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="概率论与数理统计教学平台v3.0">

<link rel="stylesheet" href="/EntranceEducation/Public/lib/weui.min.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/demos.css">
 </head>
 <body ontouchstart="">
  <!--  <div class="weui-pull-to-refresh-layer">
  <div class='pull-to-refresh-arrow'></div>
  <div class='pull-to-refresh-preloader'></div>
  <div class="down">下拉刷新页面</div>
  <div class="up">释放刷新</div>
  <div class="refresh">正在刷新</div>
</div> -->
  <header class="demos-header"> 
   <h1 class="demos-title">我的信息</h1>
  </header> 
  <div class="weui_cells weui_cells_form"> 
   <div class="weui_cell"> 
    <div class="weui_cell_hd">
     <label class="weui_label">姓名</label>
    </div> 
    <div class="weui_cell_bd weui_cell_primary"> 
     <?php echo ((isset($stu_info["name"]) && ($stu_info["name"] !== ""))?($stu_info["name"]):"null"); ?>
    </div> 
   </div>
   <div class="weui_cell">
    <div class="weui_cell_hd">
     <label class="weui_label">班级</label>
    </div> 
    <div class="weui_cell_bd weui_cell_primary"> 
     <?php echo ((isset($stu_info["class"]) && ($stu_info["class"] !== ""))?($stu_info["class"]):"null"); ?>
    </div> 
   </div>
   <div class="weui_cell"> 
    <div class="weui_cell_hd">
     <label class="weui_label">学号</label>
    </div> 
    <div class="weui_cell_bd weui_cell_primary"> 
     <?php echo ((isset($stu_info["number"]) && ($stu_info["number"] !== ""))?($stu_info["number"]):"null"); ?>
    </div> 
   </div>

 </body>
</html>
<script src="/EntranceEducation/Public/lib/jquery-2.1.4.js"></script>
<script src="/EntranceEducation/Public/js/jquery-weui.js"></script>
<!-- <script>
  $(document.body).pullToRefresh().on("pull-to-refresh", function() {
    setTimeout(function() {
      location.reload();
      $(document.body).pullToRefreshDone();
    }, 1200);
  });
</script> -->