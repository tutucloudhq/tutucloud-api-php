<?php
if ($_POST) {
    require_once "../php/FaceApi.php";
    $api = new FaceApi();

    $group_id = $_POST['group_id'];

    //请求接口
    $return = $api->groupDelete($group_id);

    //显示格式化
    $show = Common::handleData($return);
}
?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 <head>
    <title>删除group demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>删除group【groupDelete】</p>

        <div>
            <span>group_id:<label>*</label></span>
            <input type="text" name="group_id" value="<?php echo empty($_POST['group_id']) ? '' : $_POST['group_id'] ?>">
        </div>

        <input type="submit" name="" value="提交">

    </form>


    <div class="content">
        <p>返回参数：</p>
        <?php echo empty($show) ? '' : $show; ?>
    </div>
</body>
</html>