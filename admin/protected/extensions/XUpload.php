<?php

/**
 * �ļ��ϴ�
 */
class XUpload
{

    /**
     * �����ļ��ϴ�
     *
     * @param $fileFields
     * @param $thumb
     * @param $thumbSize
     * @param $allowExts
     * @param $maxSize
     * @param $savePath
     * @return unknown
     */
    private static function _saveRule($params = array('rule' => 'default', 'format' => 'Ymd','path'=>'uploads/'))
    {
        $path = '';
        switch ($params['rule'])
        {
            case 'custom':
                $path .= $params['string'] . '/';
                break;
            case 'user':
                isset($params['userPath']) && $path .= $params['userPath'] . '/';
                isset($params['userId']) && $path .= $params['userId'] . '/';
                isset($params['format']) && $path .= date($params['format']) . '/';
                break;
            default:
                $paths = isset($params['format']) ? date($params['format']) . '/' : date('Ym') . '/';
                $path .= $paths;
                break;
        }
        return $params['path']. $path;
    }

    /**
     * �����ļ��ϴ�
     *
     * @param [type]  $fileFields [description]
     * @return [type]             [description]
     */
    static public function upload($fileFields, $params = array('thumb' => false, 'thumbSize' => array(400, 400), 'allowExts' => 'jpg,gif,png,jpeg', 'maxSize' => 3292200))
    {
        Yii::import('application.vendor.*');
        require_once 'Tp/UploadFile.class.php';
        $upload = new UploadFile();
        // �����ϴ��ļ���С
        $upload->maxSize = isset($params['maxSize']) ? $params['maxSize'] : Config::get('maxSize');
        // �����ϴ��ļ�����
        $upload->allowExts = isset($params['allowExts']) ? explode(',', $params['allowExts']) : explode(',', Config::get('upload_allow_ext'));
        // ���ø����ϴ�Ŀ¼
        empty($params['saveRule']) && $params['saveRule'] = array('rule' => 'default', 'format' => 'Ymd','path'=>'uploads/');
        $upload->savePath = self::_saveRule($params['saveRule']);
        if ($params['thumb'])
        {
            // ������Ҫ��������ͼ������ͼ���ļ���Ч
            $upload->thumb = isset($params['thumb']) ? $params['thumb'] : Config::get('thumb');
            // ������Ҫ��������ͼ���ļ���׺
            $upload->thumbPrefix = 'thumb_'; // ����2������ͼ
            // ��������ͼ�����
            $upload->thumbMaxWidth = $params['thumbSize'][0];
            // ��������ͼ���߶�
            $upload->thumbMaxHeight = $params['thumbSize'][1];
        }
        // �����ϴ��ļ�����
        $upload->saveRule = 'uniqid';
        // ɾ��ԭͼ
        $upload->thumbRemoveOrigin = false;
        $file = $upload->uploadOne($fileFields);

        if (!is_array($file))
        {
            return $upload->getErrorMsg();
        } else
        {
            // ��������������
            $fileget['name'] = $file[0]['name'];
            $fileget['type'] = $file[0]['type'];
            $fileget['size'] = $file[0]['size'];
            $fileget['extension'] = $file[0]['extension'];
            $fileget['savepath'] = $file[0]['savepath'];
            $fileget['savename'] = $file[0]['savename'];
            $fileget['hash'] = $file[0]['hash'];
            $fileget['pathname'] = $upload->savePath . $file[0]['savename'];
            if (Config::get('upload_water_status') == 'open')
            {
                require_once 'Tp/Image.class.php';
                Image::water($fileget['pathname'], './' . Config::get('upload_water_file'), null, Config::get('upload_water_trans'));
            }
            // ����ͼ����
            if (true == $upload->thumb)
            {
                $fileget['thumb'] = $upload->thumbPrefix . $file[0]['savename'];
                $fileget['paththumbname'] = $upload->savePath . $upload->thumbPrefix . $file[0]['savename'];
            }
            return $fileget;
        }
    }

    /**
     * ���ļ��ϴ�
     *
     * @param boolean $thumb [description]
     * @return [type]         [description]
     */
    static public function uploads($thumb = true, $params = array('thumb' => false, 'thumbSize' => array(400, 400), 'allowExts' => 'jpg,gif,png,jpeg', 'maxSize' => 3292200))
    {
        Yii::import('application.vendors.*');
        require_once 'Tp/UploadFile.class.php';
        
        // �����ϴ��ļ���С
        $upload->maxSize = isset($params['maxSize']) ? $params['maxSize'] : Config::get('maxSize');
        // �����ϴ��ļ�����
        $upload->allowExts = isset($params['allowExts']) ? explode(',', $params['allowExts']) : explode(',', Config::get('upload_allow_ext'));
        // ���ø����ϴ�Ŀ¼
        empty($params) && $params = array('thumb' => false, 'thumbSize' => array(400, 400), 'allowExts' => 'jpg,gif,png,jpeg', 'maxSize' => 3292200);
        $upload->savePath = self::_saveRule($params);
        // ������Ҫ��������ͼ������ͼ���ļ���Ч
        $upload->thumb = isset($params['thumb']) ? $params['thumb'] : Config::get('thumb');
        // ������Ҫ��������ͼ���ļ���׺
        $upload->thumbPrefix = 'thumb_'; // ����2������ͼ
        // ��������ͼ�����
        $upload->thumbMaxWidth = $params['thumbSize'][0];
        // ��������ͼ���߶�
        $upload->thumbMaxHeight = $params['thumbSize'][1];
        // �����ϴ��ļ�����
        $upload->saveRule = 'uniqid';
        // ɾ��ԭͼ
        $upload->thumbRemoveOrigin = false;

        if (!$upload->upload())
        {
            return $upload->getErrorMsg();
        } else
        {
            $fileinfo = $upload->getUploadFileInfo();
            require_once 'Tp/Image.class.php';
            Image::water($fileget['pathname'], './' . Config::get('upload_water_file'), null, Config::get('upload_water_trans'));
            foreach ($fileinfo as $key => $row)
            {
                if (true == $upload->thumb)
                    $fileinfo[$key]['thumb'] = $upload->thumbPrefix . $fileinfo[$key]['savename'];
                $fileinfo[$key]['pathname'] = $upload->savePath . $fileinfo[$key]['savename'];
                $fileinfo[$key]['paththumbname'] = $upload->savePath . $upload->thumbPrefix . $fileinfo[$key]['savename'];
                if (Config::get('upload_water_status') == 'open')
                    Image::water($fileinfo[$key]['pathname'], './' . Config::get('upload_water_file'), null, Config::get('upload_water_trans'));
            }
            return $fileinfo;
        }
    }

}
