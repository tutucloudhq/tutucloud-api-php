<?php
if ($_POST) {
    require_once "../php/FaceApi.php";
    $api = new FaceApi();

    $person_name = $_POST['person_name'];
    $group_id    = $_POST['group_id'];
    $face_id     = $_POST['face_id'];

    //请求接口
    $return = $api->personCreate($person_name, $group_id, $face_id);

    //显示格式化
    $show = Common::handleData($return);
}
?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 <head>
    <title>创建person demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>创建person【personCreate】</p>

        <div>
            <span>person_name:<label>*</label></span>
            <input type="text" name="person_name" value="<?php echo empty($_POST['person_name']) ? '' : $_POST['person_name'] ?>">
        </div>

         <div>
            <span>group_id:</span>
            <input type="text" name="group_id" value="<?php echo empty($_POST['group_id']) ? '' : $_POST['group_id'] ?>">
        </div>

         <div>
            <span>face_id:</span>
            <input type="text" name="face_id" value="<?php echo empty($_POST['face_id']) ? '' : $_POST['face_id'] ?>">
        </div>

        <input type="submit" name="" value="提交">

    </form>


    <div class="content">
        <p>返回参数：</p>
        <?php echo empty($show) ? '' : $show; ?>
    </div>
</body>
</html>