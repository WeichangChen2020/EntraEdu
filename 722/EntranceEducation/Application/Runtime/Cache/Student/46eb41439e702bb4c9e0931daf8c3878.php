<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title></title>
    <link rel="stylesheet" href="/722/Public/css/weui.min.css"/>
    <link rel="stylesheet" href="/722/Public/css/example.css"/>
    <style type="text/css">
            .container {
                overflow: visible;
            }
            
            .hd {
                padding: 1em;
            }
            
            .weui_cells_title {
                padding-left: 15px;
            }
            .showchoice{
                position: relative;
                line-height: 42px;
                font-size: 17px;
                border-top: 1px solid #d5d5d6;
                margin: 0;
                padding: 0;
            }
        </style>
</head>
<body ontouchstart>
    <div class="container js_container">

    <div class="hd">
        <h1 class="page_title">自由练习</h1>
        <p class="page_desc">请选择篇章</p>
    </div>
    <div class="bd">
        <div class="weui_grids">
            <a href="<?php echo U('Random/random',array('chapter'=>'unit1'));?>" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/rule.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       学生手册制度类
                </p>
            </a>
            <a href="<?php echo U('Random/random');?>/chapter/unit2" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/safety.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       安全教育提醒
                </p>
            </a>
            <a href="<?php echo U('Random/random');?>/chapter/unit3" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/psychological.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       心理健康教育
                </p>
            </a>
            <a href="<?php echo U('Random/random');?>/chapter/unit4" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/infection.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       防传染病、艾滋病
                </p>
            </a>
            <!-- 第五章的题目实际上是第七章的 -->
            <a href="<?php echo U('Random/random');?>/chapter/unit5" class="weui_grid js_grid">  
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/ideology.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       意识形态类
                </p>
            </a>
            <a href="<?php echo U('Exercise/index');?>" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/school.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       爱校荣校、生活化
                </p>
            </a>
            <a href="<?php echo U('Exercise/exercise');?>" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/student.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       学生工作、团学工作应知应会
                </p>
            </a>
            <a href="<?php echo U('Random/random');?>" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/random.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                       任意章节
                </p>
            </a>
<!--             <a href="javascript:alert('该功能还没有开发');" class="weui_grid js_grid">
                <div class="weui_grid_icon">
                    <img src="/722/Public/images/icon_nav_actionSheet.png" alt="">
                </div>
                <p class="weui_grid_label">
                                                        更多
                </p>
            </a> -->
        </div>
    </div>
</div>

</body>
</html>