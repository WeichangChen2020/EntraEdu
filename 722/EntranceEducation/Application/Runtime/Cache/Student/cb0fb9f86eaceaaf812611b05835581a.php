<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="概率论与数理统计教学平台v3.0">

<link rel="stylesheet" href="/EntranceEducation/Public/lib/weui.min.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/demos.css">
  </head>

  <body ontouchstart>

    <div class="weui_msg">
      <div class="weui_icon_area"><i class="weui_icon_success weui_icon_msg"></i></div>
      <div class="weui_text_area">
        <h2 class="weui_msg_title">提交成功</h2>
        <p class="weui_msg_desc"><?php echo ($testResult); ?></p>
      </div>
      <div class="weui_opr_area">
        <p class="weui_btn_area">
          <a href="<?php echo U('Teacher/test_view');?>/quizId/<?php echo ($quizId); ?>" class="weui_btn weui_btn_primary">确定</a>
        </p>
      </div>
      <div class="weui_extra_area">
        <a href="<?php echo U('Teacher/test_view');?>/quizId/<?php echo ($quizId); ?>">查看详情</a>
      </div>
    </div>
  </body>
</html>