<?php
require_once dirname(__FILE__) . "/Common.php";

/**
 *
 * 接口访问类，在线滤镜请求接口
 * 每个接口有默认超时时间30秒
 * @author Tusdk
 *
 **/
class FilterApi
{

    /**
     * 普通滤镜
     *
     * @param $img object、string 图片或者图片URL
     * @param $id int 滤镜id
     * @param $args string 滤镜效果参数(json格式) 非必须 (PS:需根据当前滤镜用于的参数来设置，参数值0~1浮点数，未设置某个效果参数或者设置错误，都已系统默认效果参数进行处理)
     * @param $reuse int 是否复用上一次上传图片 非必须
     * @param $cache_key string 缓存key 非必须 (PS:每次请求成功返回，都会携带缓存key，可以根据返回的缓存key，进行接口提交，使用复用img就可以为空，复用优先与img)
     * @return array
     **/
    public function ordinary($img, $id, $args, $reuse = 0, $cache_key = '')
    {

        $url = TuConfig::API_URL . '/v1/filter/rendering';

        $data = array(
            'api_key'   => TuConfig::FILTER_API_KEY,
            'id'        => $id,
            'args'      => $args,
            't'         => time(),
            'reuse'     => $reuse,
            'cache_key' => $cache_key,
        );

        is_string($img) ? $data['img'] = $img : '';

        $data['sign'] = Common::signAture($data, TuConfig::FILTER_API_SECRET);

        is_string($img) ? '' : $data['img'] = $img['file'];

        $return = Common::curl($data, $url, true);

        return Common::out($return);
    }

    /**
     * 获取艺术滤镜类型列表
     *
     * @return array
     **/
    public function styleList()
    {

        $url = TuConfig::API_URL . '/v1/filter/styletrans/getList';

        $data = array(
            'api_key' => TuConfig::FILTER_API_KEY,
            't'       => time(),
        );

        $data['sign'] = Common::signAture($data, TuConfig::FILTER_API_SECRET);

        $return = Common::curl($data, $url);

        return Common::out($return);
    }

    /**
     * 艺术滤镜
     *
     * @param $img object、string 图片或者图片URL
     * @param $style style 滤镜类型(可根据filterStyleList()方法获取)
     * @param $reuse int 是否复用上一次上传图片 非必须
     * @param $cache_key string 缓存key 非必须 (PS:每次请求成功返回，都会携带缓存key，可以根据返回的缓存key，进行接口提交，使用复用img就可以为空，复用优先与img)
     * @return array
     **/
    public function art($img, $style, $reuse = 0, $cache_key = '')
    {

        $url = TuConfig::API_URL . '/v1/filter/styletrans/process';

        $data = array(
            'api_key'   => TuConfig::FILTER_API_KEY,
            'style'     => $style,
            't'         => time(),
            'reuse'     => $reuse,
            'cache_key' => $cache_key,
        );

        is_string($img) ? $data['img'] = $img : '';

        $data['sign'] = Common::signAture($data, TuConfig::FILTER_API_SECRET);

        is_string($img) ? '' : $data['img'] = $img['file'];

        $return = Common::curl($data, $url, true);

        return Common::out($return);
    }

}
