<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title>新生入学考试系统</title>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

<meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">

<link rel="stylesheet" href="/EntranceEducation/Public/css/weui.min.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/EntranceEducation/Public/css/demos.css">
<link rel="stylesheet" type="text/css" href="/EntranceEducation/Public/css/index.css">




  </head>
  <style type="text/css">
      html{
        background-image: url('/EntranceEducation/Public/images/newer/edu_logo.jpg');
        background-position: 10px 10px;
        background-size: 100px 100px;
        background-repeat: no-repeat;
        
      }
  </style>

  <body ontouchstart>

    <header class='demos-header'>
      <h1 class="demos-title">欢迎你</h1>
      <p class='demos-sub-title'><?php echo ($stu_info["name"]); ?>&nbsp同学</br></p>
      
      <p class='demos-sub-title'><?php echo ($stu_info["class"]); ?></br><p>
      <p class='demos-sub-title'><?php echo ($stu_info["number"]); ?></p>
    </header>


    <div class="weui_grids">

      <a href="<?php echo U('Random/index');?>" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/EntranceEducation/Public/images/practice.png" alt="">
<!--           <img src="/EntranceEducation/Public/images/pass.png" class="pass" style="display:<?php echo ($requirement1); ?>">
 -->        </div>
        <p class="weui_grid_label">
          自由练习
        </p>
      </a>

      <a href="<?php echo U('Test/testList');?>" class="weui_grid js_grid">
        <div class="weui_grid_icon">
          <img src="/EntranceEducation/Public/images/exam.png" alt="">
          <!-- <img src="/EntranceEducation/Public/images/pass.png" class="pass" style="display:<?php echo ($requirement2); ?>"> -->
        </div>
        <p class="weui_grid_label">
          考试
        </p>
      </a>

    </div>

    <style>
      .weui_icon_info_circle:before {
        font-size: 28px;
        color: #09BB07;
      }
    </style>

<!-- <img src="http://localhost/xsc/index.php/Student/Index/check.html"> -->
<script src="/EntranceEducation/Public/js/jquery-weui.js"></script>

    </body> 

  </html>