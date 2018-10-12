<?php
if ($_POST) {
    require_once "../php/FaceApi.php";
    $api = new FaceApi();

    $group_name = $_POST['group_name'];

    //请求接口
    $return = $api->groupCreate($group_name);

    //显示格式化
    $show = Common::handleData($return);
}
?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 <head>
    <title>创建group demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>创建group【groupCreate】</p>

        <div>
            <span>group_name:<label>*</label></span>
            <input type="text" name="group_name" value="<?php echo empty($_POST['group_name']) ? '' : $_POST['group_name'] ?>">
        </div>

        <input type="submit" name="" value="提交">

    </form>


    <div class="content">
        <p>返回参数：</p>
        <?php echo empty($show) ? '' : $show; ?>
    </div>
</body>
</html>