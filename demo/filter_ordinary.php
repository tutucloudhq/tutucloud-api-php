<?php
if ($_POST) {
    require_once "../php/FilterApi.php";
    $api = new FilterApi();

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

    $id        = $_POST['id'];
    $args      = $_POST['args'];
    $reuse     = $_POST['reuse'];
    $cache_key = $_POST['cache_key'];
    $face_plastic = $_POST['face_plastic'];
    $plastic_args = $_POST['plastic_args'];


    //请求接口
    $return = $api->ordinary($img, $id, $args, $reuse, $cache_key, $face_plastic, $plastic_args);

    $cache_key = empty($_POST['cache_key']) ? (empty($return['data']['cache_key']) ? '' : $return['data']['cache_key']) : $_POST['cache_key'];
    
    //保存图片
    if (TuConfig::FILTER_ORDINARY_DOWNLOAD) {
        $path_name = Common::createPath(TuConfig::FILTER_ORDINARY_PATH, Common::getFileName($return['data']['url']));
        $down      = Common::downloadFile($return['data']['url'], $path_name);
        //保存本地图片地址
        $return['data']['path'] = $down;
    }

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
        <p>照片滤镜【ordinary】</p>
        <div>
            <span>img_file:<label>*</label></span>
            <input type="file" name="img">
        </div>

        <div>
            <span>img_path:<label>*</label></span>
            <input type="text" name="img_path" placeholder="本地图片路径(图片选项选择一个)" value="<?php echo empty($_POST['img_path']) ? '' : $_POST['img_path'] ?>">
        </div>

        <div>
            <span>img_url:<label>*</label></span>
            <input type="text" name="img_url" placeholder="网络图片地址(图片选项选择一个)" value="<?php echo empty($_POST['img_url']) ? '' : $_POST['img_url'] ?>">
        </div>

        <div>
            <span>id:<label>*</label></span><input type="text" name="id" value="<?php echo empty($_POST['id']) ? '' : $_POST['id'] ?>">
        </div>

        <div>
            <span>args:</span><input type="text" name="args" value="<?php echo empty($_POST['args']) ? '' : $_POST['args'] ?>">
        </div>

        <div>
            <span>reuse:</span>
            <select name="reuse">
                <option value="0" selected>0</option>
                <option value="1">1</option>
            </select>
        </div>
        <div>
            <span>face_plastic:</span>
            <select name="face_plastic">
                <option value="0" >0</option>
                <option value="1" selected>1</option>
            </select>
        </div>
        <div>
            <span>plastic_args:</span><input type="text" name="plastic_args" value="<?php echo empty($_POST['plastic_args']) ? '' : $_POST['plastic_args'] ?>">
        </div>
        <div>
            <span>cache_key:</span><input type="text" name="cache_key" value="<?php echo empty($cache_key) ? '' : $cache_key ?>">
        </div>


        <input type="submit" name="" value="提交">

    </form>


    <div class="content">
        <p>返回参数：</p>
        <?php echo empty($show) ? '' : $show; ?>
    </div>
</body>
</html>