<?php
require_once dirname(__FILE__) . "/Common.php";

/**
 *
 * 接口访问类，人脸请求接口
 * 每个接口有默认超时时间30秒
 * @author Tusdk
 *
 **/
class FaceApi
{
    /**
     * 人脸检测
     *
     * @param $img object、string 图片或者图片URL
     * @param $normalize int 是否数据归一化 (0：否，1：是)
     * @param $multiple int 是否检测多脸 (0：否，1：是)
     * @param $age int 是否检测年龄 (0：否，1：是)
     * @param $gender int 是否检测性别 (0：否，1：是)
     * @return array
     **/
    public function detection($img, $normalize = 0, $multiple = 0, $age = 0, $gender = 0)
    {
        $url = TuConfig::API_URL . '/v1/face/analyze/detection';

        $data = array(
            'api_key'   => TuConfig::FACE_API_KEY,
            't'         => time(),
            'normalize' => $normalize,
            'multiple'  => $multiple,
            'age'       => $age,
            'gender'    => $gender,
        );

        is_string($img) ? $data['img'] = $img : '';

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        is_string($img) ? '' : $data['img'] = $img['file'];

        $return = Common::curl($data, $url, true);

        return Common::out($return);
    }

    /**
     * 人脸标点
     *
     * @param $img object、string 图片或者图片URL
     * @param $type int 标点数 (5、12、30、40、69、95)
     * @param $normalize int 是否数据归一化 (0：否，1：是)
     * @param $multiple int 是否检测多脸 (0：否，1：是)
     * @param $locate int 是否返回人脸位置 (0：否，1：是)
     * @param $simplify int 是否简化标点位置，去掉标点位置名称 (0：否，1：是)
     * @return array
     **/
    public function landmark($img, $type = 5, $normalize = 0, $multiple = 0, $locate = 0, $simplify = 0)
    {
        $url = TuConfig::API_URL . '/v1/face/analyze/landmark';

        if (!in_array($type, array(5, 12, 30, 40, 69, 95))) {
            return Common::error('标点数只可取（5、12、30、40、69、95）');
        }

        $data = array(
            'api_key'   => TuConfig::FACE_API_KEY,
            't'         => time(),
            'type'      => $type,
            'normalize' => $normalize,
            'multiple'  => $multiple,
            'locate'    => $locate,
            'simplify'  => $simplify,
        );

        is_string($img) ? $data['img'] = $img : '';

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        is_string($img) ? '' : $data['img'] = $img['file'];

        $return = Common::curl($data, $url, true);

        return Common::out($return);
    }

    /**
     * 人脸比对
     *
     * @param $img1 object、string 图片或者图片URL
     * @param $img2 object、string 图片或者图片URL
     * @param $normalize int 是否数据归一化 (0：否，1：是)
     * @param $locate int 是否返回人脸位置 (0：否，1：是)
     * @return array
     **/
    public function comparison($img1, $img2, $normalize = 0, $locate = 0)
    {
        $url = TuConfig::API_URL . '/v1/face/analyze/comparison';

        $data = array(
            'api_key'   => TuConfig::FACE_API_KEY,
            't'         => time(),
            'normalize' => $normalize,
            'locate'    => $locate,
        );

        is_string($img1) ? $data['img1'] = $img1 : '';
        is_string($img2) ? $data['img2'] = $img2 : '';

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        is_string($img1) ? '' : $data['img1'] = $img1['file'];
        is_string($img2) ? '' : $data['img2'] = $img2['file'];

        $return = Common::curl($data, $url, true);

        return Common::out($return);
    }

    /**
     * 查询person列表
     *
     * @return array
     **/
    public function persons()
    {
        $url = TuConfig::API_URL . '/v1/face/persons';

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false, 'get');

        return Common::out($return);
    }

    /**
     * 创建person
     *
     * @param $person_name string person名称
     * @param $group_id string 组id (添加到指定组)
     * @param $face_id string 人脸id (可通过 人脸检测[detection()],人脸标点[landmark()] 获取face_id参数,可用逗号分隔一组数据)
     * @return array
     **/
    public function personCreate($person_name, $group_id = '', $face_id = '')
    {
        $url = TuConfig::API_URL . '/v1/face/persons';

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
            'uid'     => $person_name,
        );

        empty($group_id) ? '' : $data['group_id'] = $group_id;
        empty($face_id) ? '' : $data['face_id']   = $face_id;

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false);

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 在某person添加face
     *
     * @param $person_id string person id(可通过persons()获取，可通过personCreate()创建)
     * @param $face_id string 人脸id (可通过 人脸检测[detection()],人脸标点[landmark()] 获取face_id参数,可用逗号分隔一组数据)
     * @return array
     **/
    public function facesAdd($person_id, $face_id)
    {
        $url = TuConfig::API_URL . '/v1/face/persons/' . $person_id . '/faces';

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
            'face_id' => $face_id,
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false);

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 验证person
     * @param $img object、string 图片或者图片URL
     * @param $person_id string person id(可通过persons()获取，可通过personCreate()创建，PS:person_id没有face_id,或者上传图片没有人脸，返回“Face not exists”)
     * @return array
     **/
    public function verification($img, $person_id)
    {
        $url = TuConfig::API_URL . '/v1/face/persons/' . $person_id . '/verification';

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
        );

        is_string($img) ? $data['img'] = $img : '';

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        is_string($img) ? '' : $data['img'] = $img['file'];

        $return = Common::curl($data, $url, true);

        return Common::out($return);
    }

    /**
     * 删除person
     *
     * @param $person_id string person id(可通过persons()获取)
     * @return array
     **/
    public function personDelete($person_id)
    {
        $url = TuConfig::API_URL . '/v1/face/persons/' . $person_id;

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false, 'delete');

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 在某person删除某face
     *
     * @param $person_id string person id(可通过persons()获取)
     * @param $face_id string face id
     * @return array
     **/
    public function faceDelete($person_id, $face_id)
    {
        $url = TuConfig::API_URL . '/v1/face/persons/' . $person_id . '/faces';

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
            'face_id' => $face_id,
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false, 'delete');

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 查询group列表
     *
     * @return array
     **/
    public function groups()
    {
        $url = TuConfig::API_URL . '/v1/face/groups';

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false, 'get');

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 创建group
     *
     * @param $group_name string 组名称
     * @return array
     **/
    public function groupCreate($group_name)
    {
        $url = TuConfig::API_URL . '/v1/face/groups';

        $data = array(
            'api_key'    => TuConfig::FACE_API_KEY,
            't'          => time(),
            'group_name' => $group_name,
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false);

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 在某 group 添加 person
     *
     * @param $group_id string 组id
     * @param $person_id string person id(可用逗号分隔一组数据，一组最多添加10000个person)
     * @return array
     **/
    public function personAdd($group_id, $person_id)
    {
        $url = TuConfig::API_URL . '/v1/face/groups/' . $group_id . '/persons';

        $data = array(
            'api_key'   => TuConfig::FACE_API_KEY,
            't'         => time(),
            'person_id' => $person_id,
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false);

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 上传图片 对比 group 内相似度最高的 person
     *
     * @param $img object、string 图片或者图片URL
     * @param $group_id string 组id
     * @return array
     **/
    public function search($img, $group_id)
    {
        $url = TuConfig::API_URL . '/v1/face/groups/' . $group_id . '/search';

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
        );

        is_string($img) ? $data['img'] = $img : '';

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        is_string($img) ? '' : $data['img'] = $img['file'];

        $return = Common::curl($data, $url, true);

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 删除group
     *
     * @param $group_id string 组id
     * @return array
     **/
    public function groupDelete($group_id)
    {
        $url = TuConfig::API_URL . '/v1/face/groups/' . $group_id;

        $data = array(
            'api_key' => TuConfig::FACE_API_KEY,
            't'       => time(),
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false, 'delete');

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

    /**
     * 在某group删除某person
     *
     * @param $group_id string 组id
     * @param $person_id string person id
     * @return array
     **/
    public function groupPersonDelete($group_id, $person_id)
    {
        $url = TuConfig::API_URL . '/v1/face/groups/' . $group_id . '/persons';

        $data = array(
            'api_key'   => TuConfig::FACE_API_KEY,
            't'         => time(),
            'person_id' => $person_id,
        );

        $data['sign'] = Common::signAture($data, TuConfig::FACE_API_SECRET);

        $return = Common::curl($data, $url, false, 'delete');

        if (!$return) {
            return Common::error('接口请求失败_具体错误请查看日志');
        }

        return Common::out($return);
    }

}
