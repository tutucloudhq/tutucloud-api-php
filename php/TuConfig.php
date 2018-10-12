<?php
/**
 * 参数设置
 */

/**
 * 基础设置
 *
 * DS：反斜杠 (PS:根据当前集成项目进行修改)
 *
 * BASE_DIR：根目录 (PS:根据当前集成项目进行修改)
 *
 * TU_PATH_IMG：图片目录，兼容低版本
 */

define('TU_DS', DIRECTORY_SEPARATOR);
define('TU_BASE_DIR', realpath('..'));
define('TU_PATH_IMG', TU_BASE_DIR . TU_DS . 'img');

/**
 * 系统设置
 *
 * ERROR_LOG：错误日志保存路径 (PS:根据当前集成项目进行修改)
 */
define('TU_ERROR_LOG', TU_BASE_DIR . TU_DS . 'logs' . TU_DS . 'error.log');
ini_set('error_log', TU_ERROR_LOG);
date_default_timezone_set("Asia/Shanghai");

/**
 *基础参数设置
 */
class TuConfig
{
    /**
     * 基础设置
     *
     * API_URL：api接口访问域名
     *
     * DS：反斜杠
     *
     * BASE_DIR：根目录
     *
     * ERROR_LOG：错误日志保存路径
     */
    const API_URL  = 'https://api.tutucloud.com';
    const BASE_DIR = TU_BASE_DIR;
    const DS       = TU_DS;

    /**
     * 在线滤镜API参数配置
     *
     * FILTER_API_KEY：在线滤镜api_key (必须配置，可从tutucloud控制台获取)
     *
     * FILTER_API_SECRET：在线滤镜api_key (必须配置，可从tutucloud控制台获取)
     */
    const FILTER_API_KEY = '控制台获取的API_KEY';

    const FILTER_API_SECRET = '控制台获取的API_SECRET';

    /**
     * FILTER_ORDINARY_DOWNLOAD：普通滤镜返回图片是否下载(建议保存，api端暂存1~3天)
     *
     * FILTER_ORDINARY_PATH：普通滤镜返回图片下载保存路径 (绝对路径)
     */
    const FILTER_ORDINARY_PATH = TU_PATH_IMG;

    const FILTER_ORDINARY_DOWNLOAD = true;

    /**
     * FILTER_ART_DOWNLOAD：艺术滤镜返回图片是否下载(建议保存，api端暂存1~3天)
     *
     * FILTER_ART_PATH：艺术滤镜返回图片下载保存路径 (绝对路径)
     */
    const FILTER_ART_PATH = TU_PATH_IMG;

    const FILTER_ART_DOWNLOAD = true;

    /**
     * 人脸API参数配置
     *
     * FACE_API_KEY：在线滤镜api_key (必须配置，可从tutucloud控制台获取)
     *
     * FACE_API_SECRET：在线滤镜api_key (必须配置，可从tutucloud控制台获取)
     */
    const FACE_API_KEY = '控制台获取的API_KEY';

    const FACE_API_SECRET = '控制台获取的API_SECRET';

}
