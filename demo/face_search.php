<?php
if ($_POST) {
    require_once "../php/FaceApi.php";
    $api = new FaceApi();

    //img、img_path、img_url 必填一个
    if (!empty($_FILES['img']) && $_FILES['img']['error']=='0') {
        $img = Common::getFormFiles($_FILES['img']);
    }
    if (!empty($_POST['img_path'])) {
        $img = Common::getFile($_POST['img_path']);
    }
    if (!empty($_POST['img_url'])) {
        $img = $_POST['img_url'];
    }

    $group_id = $_POST['group_id'];
    
    //请求接口
    $return = $api->search($img, $group_id);

    //显示格式化
    $show = Common::handleData($return);
}
?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 <head>
    <title>对比group demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>对比group【search】</p>
        <div>
            <span>img_file:<label>*</label></span>
            <input type="file" name="img">
        </div>

        <div>
            <span>img_path:<label>*</label></span>
            <input type="text" name="img_path" placeholder="本地图片路径(图片选项选题一个)" value="<?php echo empty($_POST['img_path']) ? '' : $_POST['img_path'] ?>">
        </div>

        <div>
            <span>img_url:<label>*</label></span>
            <input type="text" name="img_url" placeholder="网络图片地址(图片选项选题一个)" value="<?php echo empty($_POST['img_url']) ? '' : $_POST['img_url'] ?>">
        </div>

        <div>
            <span>group_id:<label>*</label></span>
            <input type="text" name="group_id" value="<?php echo empty($_POST['group_id']) ? '' : $_POST['group_id']; ?>">
        </div>

        <input type="submit" name="" value="提交">

    </form>


    <div class="content">
        <p>返回参数：</p>
        <?php echo empty($show) ? '' : $show; ?>
    </div>
</body>
</html>