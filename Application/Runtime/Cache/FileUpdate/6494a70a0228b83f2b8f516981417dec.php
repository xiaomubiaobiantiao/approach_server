<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="/Public/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<!--
<script language="javascript">
$(function(){   
    //导航切换
    $(".imglist li").click(function(){
        $(".imglist li.selected").removeClass("selected")
        $(this).addClass("selected");
    })  
})  
</script>
-->
<script type="text/javascript">

$(document).ready(function(){

    $(".toolbar2").click(function(){
        //alert( 'aaa' );
    });
/*
    $(".click").click(function(){
        $(".tip").fadeIn(200);
        });
      
        $(".tiptop a").click(function(){
        $(".tip").fadeOut(200);
    });
        $(".sure").click(function(){
        $(".tip").fadeOut(100);
    });

        $(".cancel").click(function(){
        $(".tip").fadeOut(100);
    });
*/
});

</script>

</head>


<body>

    <div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">更新包管理</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
        <ul class="toolbar" style="float:left;">
        <li class="click"><span><img src="/Public/images/t02.png" /></span>修改</li>
        <li><span><img src="/Public/images/t03.png" /></span>删除</li>

        


        <!-- <li><span><img src="/Public/images/t04.png" /></span>统计</li> -->
        </ul>
        <!--
        <form action="<?php echo U( 'FileUpdate/Pack/upload' );?>" method="post" enctype="multipart/form-data" id="fileUpload" >
        <ul class="toolbar1">
        <li class="toolbar2" style="width:200px;" ><label for="file" style="width:200px;">&nbsp;&nbsp;文件路径：</label></li>
        <input hidden type="file" name="file" id="file" />
        <li class="click" style="float:left;"><span><a onclick="document:fileUpload.submit()" ><img src="/Public/images/t01.png" /></span>上传更新包</a></li>
        <!-- <li><span><img src="/Public/images/t05.png" /></span>设置</li> --><!--
        </ul>
        </form>-->

        <form action="<?php echo U( 'FileUpdate/Pack/add' );?>" enctype="multipart/form-data" method="post" >
        <input type="text" name="name" />
        <input type="file" name="photo" />
        <input type="submit" value="提交" >
        </form>

        


    </div>
    
    
    <table class="imgtable">
    
    <thead>
    <tr>
    <!--<th>选项</th>-->
    <th width="100px;">缩略图</th>
    <th>标题</th>
    <th>栏目</th>
    <th>类别</th>
    <th>发布人</th>
    <th>操作</th>
    </tr>
    </thead>
    
    <tbody>
  
    <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
        <!--<td><input name="" type="radio" value="" /></td>-->
        <td class="imgtd">
            <a href="<?php echo U( 'FileUpdate/Pack/check', array( 'id'=>$vo['id'] ));?>" >
            <img src="/Public/images/rar_01.png" /></a>
        </td>
        <td>
            <a href="<?php echo U( 'FileUpdate/Pack/check', array( 'id'=>$vo['id'] ));?>"> <?php echo ($vo["pack_name"]); ?> </a>
            <p>发布时间： <?php echo (date('Y-m-d H:i:s',$vo["add_time"])); ?></p>
            <p>相对路径: <?php echo ($vo["relative_path"]); ?></p>
            <p>下载地址: <?php echo ($vo["download"]); ?></p>
        </td>
        <td>编号<p>ID: <?php echo ($vo["id"]); ?></p></td>
        <td>暂未开放</td>
        <td> <?php echo ($vo["user"]); ?> </td>
        <td>
            <a href="<?php echo U( 'FileUpdate/Pack/check', array( 'id'=>$vo['id'] ));?>" class="tablelink">查看</a> 
            <a href="<?php echo U( 'FileUpdate/Pack/del', array( 'id'=>$vo['id'] ));?>" class="tablelink">删除</a>
        </td>
        </tr><?php endforeach; endif; ?>
   

    </tbody>
    
    </table>
    
    
    
    
    
   
    <div class="pagin">
        <div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
        <ul class="paginList">
        <li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>
        <li class="paginItem"><a href="javascript:;">1</a></li>
        <li class="paginItem current"><a href="javascript:;">2</a></li>
        <li class="paginItem"><a href="javascript:;">3</a></li>
        <li class="paginItem"><a href="javascript:;">4</a></li>
        <li class="paginItem"><a href="javascript:;">5</a></li>
        <li class="paginItem more"><a href="javascript:;">...</a></li>
        <li class="paginItem"><a href="javascript:;">10</a></li>
        <li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>
        </ul>
    </div>
    
    
    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="/Public/images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
    
    
    </div>
    
    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="/Public/images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
    
<script type="text/javascript">
    $('.imgtable tbody tr:odd').addClass('odd');
    </script>
    
</body>

</html>

<!-- 弹出提示框和文件路径信息
<script>
         $("input[name=fileString]").change(function() {
            //var names = [];
            
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
               // names.push($(this).get(0).files[i].name);
                //console.log($(this).get(0).files[i].mozFullPath);
                //方式一：
                var filePath = $(this).val();
                console.log(filePath);
                //方式二：
                alert($('input[type=file]').val());
            }
            //console.log(names);
            //方式三：
            alert($("input[name=fileString]").val());
 
        })
        
    </script>
-->