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

    $style     = $_POST['style'];
    $reuse     = $_POST['reuse'];
    $cache_key = $_POST['cache_key'];

    //请求接口
    $return = $api->art($img, $style, $reuse, $cache_key);

    $cache_key = empty($_POST['cache_key']) ? (empty($return['data']['cache_key']) ? '' : $return['data']['cache_key']) : $_POST['cache_key'];

    //保存图片
    if (TuConfig::FILTER_ART_DOWNLOAD) {
        $path_name = Common::createPath(TuConfig::FILTER_ART_PATH, Common::getFileName($return['data']['url']));
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
    <title>艺术滤镜demo</title>
 </head>
 <link rel="stylesheet" type="text/css" href="./style.css">
 <body>
    <?php echo file_get_contents('./nav.php') ?>
    <form method="post" action="" enctype="multipart/form-data" >
        <p>艺术滤镜【art】</p>
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
            <span>style:<label>*</label></span><input type="text" name="style" value="<?php echo empty($_POST['style']) ? '' : $_POST['style'] ?>">
        </div>

        <div>
            <span>reuse:</span>
            <select name="reuse">
                <option value="0" >0</option>
                <option value="1" <?php echo empty($cache_key) ? '' : 'selected'; ?>>1</option>
            </select>
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