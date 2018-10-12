<?php
if ($_POST) {
    require_once "../php/FaceApi.php";
    $api = new FaceApi();

    //img、img_path、img_url 必填一个
    if (!empty($_FILES['img1']) && $_FILES['img1']['error']=='0') {
        $img1 = Common::getFormFiles($_FILES['img1']);
    }
    if (!empty($_POST['img1_path'])) {
        $img1 = Common::getFile($_POST['img1_path']);
    }
    if (!empty($_POST['img1_url'])) {
        $img1 = $_POST['img1_url'];
    }

    if (!empty($_FILES['img2']) && $_FILES['img2']['error']=='0') {
        $img2 = Common::getFormFiles($_FILES['img2']);
    }
    if (!empty($_POST['img2_path'])) {
        $img2 = Common::getFile($_POST['img2_path']);
    }
    if (!empty($_POST['img2_url'])) {
        $img2 = $_POST['img2_url'];
    }

    $normalize = $_POST['normalize'];
    $locate    = $_POST['locate'];

    //请求接口
    $return = $api->comparison($img1, $img2, $normalize, $locate);

    //显示格式化
    $show = Common::handleData($return);
}
?>

 <!DOCTYPE html>
 <html>
 <meta charset="utf-8">
 <head>
    <title>人脸对比demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>人脸对比【comparison】</p>
        <div>
            <span>img1_file:<label>*</label></span>
            <input type="file" name="img1">
        </div>

        <div>
            <span>img1_path:<label>*</label></span>
            <input type="text" name="img1_path" placeholder="本地图片1路径(图片选项选题一个)" value="<?php echo empty($_POST['img1_path']) ? '' : $_POST['img1_path'] ?>">
        </div>

        <div>
            <span>img1_url:<label>*</label></span>
            <input type="text" name="img1_url" placeholder="网络图片1地址(图片选项选题一个)" value="<?php echo empty($_POST['img1_url']) ? '' : $_POST['img1_url'] ?>">
        </div>

        <div>
            <span>img2_file:<label>*</label></span>
            <input type="file" name="img2">
        </div>

        <div>
            <span>img2_path:<label>*</label></span>
            <input type="text" name="img2_path" placeholder="本地图片2路径(图片选项选题一个)" value="<?php echo empty($_POST['img2_path']) ? '' : $_POST['img2_path'] ?>">
        </div>

        <div>
            <span>img2_url:<label>*</label></span>
            <input type="text" name="img2_url" placeholder="网络图片2地址(图片选项选题一个)" value="<?php echo empty($_POST['img2_url']) ? '' : $_POST['img2_url'] ?>">
        </div>

        <div>
            <span>normalize:</span>
            <select name="normalize">
                <option value="0" >0</option>
                <option value="1" <?php echo empty($_POST['normalize']) ? '' : 'selected'; ?>>1</option>
            </select>
        </div>

        <div>
            <span>locate:</span>
            <select name="locate">
                <option value="0" >0</option>
                <option value="1" <?php echo empty($_POST['locate']) ? '' : 'selected'; ?>>1</option>
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