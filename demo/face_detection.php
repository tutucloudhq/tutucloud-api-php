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

    $normalize = $_POST['normalize'];
    $multiple  = $_POST['multiple'];
    $age       = $_POST['age'];
    $gender    = $_POST['gender'];
    
    //请求接口
    $return = $api->detection($img, $normalize, $multiple, $age, $gender);

    //显示格式化
    $show = Common::handleData($return);
}
?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 <head>
    <title>人脸检测demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>人脸检测【detection】</p>
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
            <span>normalize:</span>
            <select name="normalize">
                <option value="0" >0</option>
                <option value="1" <?php echo empty($_POST['normalize']) ? '' : 'selected'; ?>>1</option>
            </select>
        </div>

        <div>
            <span>multiple:</span>
            <select name="multiple">
                <option value="0" >0</option>
                <option value="1" <?php echo empty($_POST['multiple']) ? '' : 'selected'; ?>>1</option>
            </select>
        </div>

        <div>
            <span>age:</span>
            <select name="age">
                <option value="0" >0</option>
                <option value="1" <?php echo empty($_POST['age']) ? '' : 'selected'; ?>>1</option>
            </select>
        </div>

        <div>
            <span>gender:</span>
            <select name="gender">
                <option value="0" >0</option>
                <option value="1" <?php echo empty($_POST['gender']) ? '' : 'selected'; ?>>1</option>
            </select>
        </div>

        <input type="submit" name="" value="提交">

    </form>


    <div class="content">
        <p>返回参数：</p>
        <?php echo empty($show) ? '' : $show; ?>
    </div>
</body>
</html>