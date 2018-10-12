<?php
require_once dirname(__FILE__) . "/TuConfig.php";
require_once dirname(__FILE__) . "/ApiException.php";

/**
 *
 * 公用方法
 * @author Tusdk
 *
 **/
class Common
{

    /**
     * 签名参数
     *
     * @param $query_paras array 提交的参数
     * @param $api_secret string 秘钥
     * @return string
     **/
    public static function signAture($query_paras, $api_secret)
    {
        $sign_str = '';
        //参数按字典升序排序
        ksort($query_paras);
        foreach ($query_paras as $para => $value) {
            $sign_str .= strtolower($para) . $value;
        }
        //拼接参数与秘钥
        return md5($sign_str . $api_secret);
    }

    /**
     * 以post、get、delete方式提交参数到对应的接口url
     *
     * @param $data array 需要传输的数据,包括post、get、delete参数
     * @param $url string url
     * @param $file boolean 上传文件
     * @param $type string 数据传输类型
     * @param $second int url执行超时时间，默认30s
     **/
    public static function curl($data, $url, $file = false, $type = 'post', $second = 30)
    {
        $oCurl = curl_init();

        if (class_exists('\CURLFile')) {
            curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, false);
            }
        }

        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        if ($file) {
            $strPOST = $data;
        } else {
            $aPOST = array();
            foreach ($data as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }

        if ($type == 'get' || $type == 'delete') {
            $url .= '?' . $strPOST;
        }

        //设置超时
        curl_setopt($oCurl, CURLOPT_HEADER, false);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, $second);
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        switch ($type) {
            case 'get':
                curl_setopt($oCurl, CURLOPT_HTTPGET, true);
                break;

            case 'delete':
                curl_setopt($oCurl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            default:
                curl_setopt($oCurl, CURLOPT_POST, true);
                curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
                break;
        }

        $sContent = curl_exec($oCurl);
        $aStatus  = curl_getinfo($oCurl);

        if (intval($aStatus["http_code"]) == 200) {
            curl_close($oCurl);
            return $sContent;
        } else {
            $error = curl_errno($oCurl);
            curl_close($oCurl);
            throw new ApiException($sContent);
            return false;
        }
    }

    /**
     * curl传输文件
     *
     * @param $file_name string 文件路径
     * @param $mime_type string 文件类型
     * @param $post_name string 文件名称
     * @return object、string
     **/
    public static function curl_file($file_name, $mime_type = '', $post_name = '')
    {
        if (function_exists('curl_file_create')) {
            $file = curl_file_create($file_name, $mime_type, $post_name);
        } else {
            $file = "@$file_name;filename="
                . ($post_name ? basename($file_name) : '')
                . ($mime_type ? ";type=$mime_type" : '');
        }

        return array('file' => $file);
    }

    /**
     * 下载文件
     *
     * @param $url string 文件地址
     * @param $file_name string 本地保存文件路径
     * @param $second int url执行超时时间，默认30s
     * @return array
     **/
    public static function downloadFile($url, $file_name, $second = 30)
    {
        if (is_dir(basename($file_name))) {
            return false;
        }
        $oCurl = curl_init();
        if (stripos($url, "https://") !== false) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }

        $fp = fopen($file_name, 'w');
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_FILE, $fp);
        curl_setopt($oCurl, CURLOPT_HEADER, 0);
        curl_setopt($oCurl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, $second);
        curl_exec($oCurl);
        curl_close($oCurl);
        fclose($fp);
        return $file_name;
    }

    /**
     * 错误返回
     *
     * @param $msg string 错误提示
     * @return array
     **/
    public static function error($msg = '')
    {
        $return = array('error' => '1', 'msg' => $msg);
        return $return;
    }

    /**
     * 成功返回
     *
     * @param $data array 返回参数
     * @param $msg string 提示
     * @return array
     **/
    public static function out($data = array(), $msg = '')
    {
        $data = json_decode($data, true);
        return $data;
    }

    /**
     * 创建目录
     *
     * @param $path string
     * @param $mode int
     **/
    public static function mkdir($path, $mode = 0777)
    {
        if (!file_exists($path)) {
            self::mkdir(dirname($path));
            mkdir($path, $mode);
        }
    }

    /**
     * 创建文件路径
     * @param $path string 保存的文件目录
     * @param $file_name 文件名称
     * @param $date_path boolean 是否生成时间目录
     * @return string
     **/
    public static function createPath($path, $file_name = '', $date_path = true)
    {
        if ($date_path) {
            $path .= TuConfig::DS . date('Ymd');
        }
        self::mkdir($path);
        $path .= TuConfig::DS . $file_name;
        return $path;
    }

    /**
     * 封装表单上传文件格式
     *
     * @param $path string 文件目录
     * @return object
     **/
    public static function getFile($path)
    {
        if (!is_file($path)) {
            throw new ApiException("Picture doesn't exist");
        }
        $type = self::getImgType($path);
        $name = self::getFileName($path);
        return self::curl_file($path, $type, $name);
    }

    /**
     * 获取图片格式
     *
     * @param $path string 图片目录
     * @return string
     **/
    public static function getImgType($path)
    {
        if (function_exists('exif_imagetype')) {
            $type = exif_imagetype($path);
            return image_type_to_mime_type($type);
        }

        $type = substr($path, strrpos($path, '.') + 1, strlen($path));
        $type == 'jpg' ? $type = 'jpeg' : '';
        return 'image/' . $type;
    }

    /**
     * 获取文件名称
     *
     * @param $path string 文件目录
     * @return string
     **/
    public static function getFileName($path)
    {
        $delimiter = '/';
        $delimiter = strrpos($path, $delimiter) == 0 ? '\\' : '/';
        $return    = substr($path, strrpos($path, $delimiter) + 1, strlen($path));
        return $return;
    }

    /**
     * 通过FILES获取curlFile
     *
     * @param $file array 上传文件$_FILTER
     * @return object
     **/
    public static function getFormFiles($file)
    {
        if ($file['error'] != 0) {
            throw new ApiException("FILES ERROR " . $file['error']);
        }
        return self::curl_file($file['tmp_name'], $file['type'], $file['name']);
    }

    /**
     * 结果处理成ul
     *
     * @param $return array 返回参数
     * @return string
     **/
    public static function handleData($return, $list = '')
    {
        $list = '<ul>';
        foreach ($return as $key => $value) {
            if (is_array($value)) {
                $list .= '<li><span>' . $key . ':</span>';
                $list .= self::handleData($value, $list);
                $list .= '</li>';
            } else {
                $list .= '<li><span>' . $key . ':</span><label>' . $value . '</label></li>';
            }
        }
        return $list . '</ul>';
    }
}
