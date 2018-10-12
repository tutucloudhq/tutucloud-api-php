<?php
if ($_POST) {
    require_once "../php/FilterApi.php";
    $api = new FilterApi();

    //请求接口
    $return = $api->styleList();

    //显示格式化
    $show = Common::handleData($return);
}
?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 <head>
    <title>照片滤镜demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>获取资源列表【styleList】</p>
        <input type="hidden" name="submit" value="无用参数">
        <input type="submit" name="" value="获取">

    </form>


    <div class="content">
        <p>返回参数：</p>
        <?php echo empty($show) ? '' : $show; ?>
    </div>
</body>
</html>