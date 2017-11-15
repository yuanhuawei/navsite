<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * �ļ��ϴ���
 * @category   ORG
 * @package  ORG
 * @subpackage  Net
 * @author    liu21st <liu21st@gmail.com>
 */
class UploadFile
{//�ඨ�忪ʼ

    private $config = array(
        'maxSize' => -1, // �ϴ��ļ������ֵ
        'supportMulti' => true, // �Ƿ�֧�ֶ��ļ��ϴ�
        'allowExts' => array(), // �����ϴ����ļ���׺ ���ղ�����׺���
        'allowTypes' => array(), // �����ϴ����ļ����� ���ղ������
        'thumb' => false, // ʹ�ö��ϴ�ͼƬ��������ͼ����
        'imageClassPath' => 'ORG.Util.Image', // ͼ�����·��
        'thumbMaxWidth' => '', // ����ͼ�����
        'thumbMaxHeight' => '', // ����ͼ���߶�
        'thumbPrefix' => 'thumb_', // ����ͼǰ׺
        'thumbSuffix' => '',
        'thumbPath' => '', // ����ͼ����·��
        'thumbFile' => '', // ����ͼ�ļ���
        'thumbExt' => '', // ����ͼ��չ��        
        'thumbRemoveOrigin' => false, // �Ƿ��Ƴ�ԭͼ
        'zipImages' => false, // ѹ��ͼƬ�ļ��ϴ�
        'autoSub' => false, // ������Ŀ¼�����ļ�
        'subType' => 'hash', // ��Ŀ¼������ʽ ����ʹ��hash date custom
        'subDir' => '', // ��Ŀ¼���� subTypeΪcustom��ʽ����Ч
        'dateFormat' => 'Ymd',
        'hashLevel' => 1, // hash��Ŀ¼���
        'savePath' => '', // �ϴ��ļ�����·��
        'autoCheck' => true, // �Ƿ��Զ���鸽��
        'uploadReplace' => false, // ����ͬ���Ƿ񸲸�
        'saveRule' => 'uniqid', // �ϴ��ļ���������
        'hashType' => 'md5_file', // �ϴ��ļ�Hash��������
    );
    // ������Ϣ
    private $error = '';
    // �ϴ��ɹ����ļ���Ϣ
    private $uploadFileInfo;

    public function __get($name)
    {
        if (isset($this->config[$name]))
        {
            return $this->config[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        if (isset($this->config[$name]))
        {
            $this->config[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return isset($this->config[$name]);
    }

    /**
     * �ܹ�����
     * @access public
     * @param array $config  �ϴ�����
     */
    public function __construct($config = array())
    {
        if (is_array($config))
        {
            $this->config = array_merge($this->config, $config);
        }
    }

    /**
     * �ϴ�һ���ļ�
     * @access public
     * @param mixed $name ����
     * @param string $value  ���ݱ���
     * @return string
     */
    private function save($file)
    {
        $filename = $file['savepath'] . $file['savename'];
        if (!$this->uploadReplace && is_file($filename))
        {
            // ������ͬ���ļ�
            $this->error = '�ļ��Ѿ����ڣ�' . $filename;
            return false;
        }
        // �����ͼ���ļ� ����ļ���ʽ
        if (in_array(strtolower($file['extension']), array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'swf')))
        {
            $info = getimagesize($file['tmp_name']);
            if (false === $info || ('gif' == strtolower($file['extension']) && empty($info['bits'])))
            {
                $this->error = '�Ƿ�ͼ���ļ�';
                return false;
            }
        }
        if (!move_uploaded_file($file['tmp_name'], $this->autoCharset($filename, 'utf-8', 'gbk')))
        {
            $this->error = '�ļ��ϴ��������';
            return false;
        }
        if ($this->thumb && in_array(strtolower($file['extension']), array('gif', 'jpg', 'jpeg', 'bmp', 'png')))
        {
            $image = getimagesize($filename);
            if (false !== $image)
            {
                //��ͼ���ļ���������ͼ
                $thumbWidth = explode(',', $this->thumbMaxWidth);
                $thumbHeight = explode(',', $this->thumbMaxHeight);
                $thumbPrefix = explode(',', $this->thumbPrefix);
                $thumbSuffix = explode(',', $this->thumbSuffix);
                $thumbFile = explode(',', $this->thumbFile);
                $thumbPath = $this->thumbPath ? $this->thumbPath : dirname($filename) . '/';
                $thumbExt = $this->thumbExt ? $this->thumbExt : $file['extension']; //�Զ�������ͼ��չ��
                // ����ͼ������ͼ
                //import($this->imageClassPath);
                Yii::import('application.vendors.*');
                require_once('Tp/Image.class.php');
                for ($i = 0, $len = count($thumbWidth); $i < $len; $i++)
                {
                    if (!empty($thumbFile[$i]))
                    {
                        $thumbname = $thumbFile[$i];
                    } else
                    {
                        $prefix = isset($thumbPrefix[$i]) ? $thumbPrefix[$i] : $thumbPrefix[0];
                        $suffix = isset($thumbSuffix[$i]) ? $thumbSuffix[$i] : $thumbSuffix[0];
                        $thumbname = $prefix . basename($filename, '.' . $file['extension']) . $suffix;
                    }
                    Image::thumb($filename, $thumbPath . $thumbname . '.' . $thumbExt, '', $thumbWidth[$i], $thumbHeight[$i], true);
                }
                if ($this->thumbRemoveOrigin)
                {
                    // ��������ͼ֮��ɾ��ԭͼ
                    unlink($filename);
                }
            }
        }
        if ($this->zipImags)
        {
            // TODO ��ͼƬѹ�������߽�ѹ
        }
        return true;
    }

    /**
     * �ϴ������ļ�
     * @access public
     * @param string $savePath  �ϴ��ļ�����·��
     * @return string
     */
    public function upload($savePath = '')
    {
        //�����ָ�������ļ���������ϵͳĬ��
        if (empty($savePath))
            $savePath = $this->savePath;
        // ����ϴ�Ŀ¼
        if (!is_dir($savePath))
        {
            // ���Ŀ¼�Ƿ������
            if (is_dir(base64_decode($savePath)))
            {
                $savePath = base64_decode($savePath);
            } else
            {
                // ���Դ���Ŀ¼
                if (!mkdir($savePath))
                {
                    $this->error = '�ϴ�Ŀ¼' . $savePath . '������';
                    return false;
                }
            }
        } else
        {
            if (!is_writeable($savePath))
            {
                $this->error = '�ϴ�Ŀ¼' . $savePath . '����д';
                return false;
            }
        }
        $fileInfo = array();
        $isUpload = false;

        // ��ȡ�ϴ����ļ���Ϣ
        // ��$_FILES������Ϣ����
        $files = $this->dealFiles($_FILES);
        foreach ($files as $key => $file)
        {
            //������Ч���ϴ�
            if (!empty($file['name']))
            {
                //�Ǽ��ϴ��ļ�����չ��Ϣ
                if (!isset($file['key']))
                    $file['key'] = $key;
                $file['extension'] = $this->getExt($file['name']);
                $file['savepath'] = $savePath;
                $file['savename'] = $this->getSaveName($file);

                // �Զ���鸽��
                if ($this->autoCheck)
                {
                    if (!$this->check($file))
                        return false;
                }

                //�����ϴ��ļ�
                if (!$this->save($file))
                    return false;
                if (function_exists($this->hashType))
                {
                    $fun = $this->hashType;
                    $file['hash'] = $fun($this->autoCharset($file['savepath'] . $file['savename'], 'utf-8', 'gbk'));
                }
                //�ϴ��ɹ��󱣴��ļ���Ϣ���������ط�����
                unset($file['tmp_name'], $file['error']);
                $fileInfo[] = $file;
                $isUpload = true;
            }
        }
        if ($isUpload)
        {
            $this->uploadFileInfo = $fileInfo;
            return true;
        } else
        {
            $this->error = 'û��ѡ���ϴ��ļ�';
            return false;
        }
    }

    /**
     * �ϴ������ϴ��ֶ��е��ļ� ֧�ֶ฽��
     * @access public
     * @param array $file  �ϴ��ļ���Ϣ
     * @param string $savePath  �ϴ��ļ�����·��
     * @return string
     */
    public function uploadOne($file, $savePath = '')
    {
        //�����ָ�������ļ���������ϵͳĬ��
        if (empty($savePath))
            $savePath = $this->savePath;
        // ����ϴ�Ŀ¼
        if (!is_dir($savePath))
        {
            // ���Դ���Ŀ¼
            if (!mkdir($savePath, 0777, true))
            {
                $this->error = '�ϴ�Ŀ¼' . $savePath . '������';
                return false;
            }
        } else
        {
            if (!is_writeable($savePath))
            {
                $this->error = '�ϴ�Ŀ¼' . $savePath . '����д';
                return false;
            }
        }
        //������Ч���ϴ�
        if (!empty($file['name']))
        {
            $fileArray = array();
            if (is_array($file['name']))
            {
                $keys = array_keys($file);
                $count = count($file['name']);
                for ($i = 0; $i < $count; $i++)
                {
                    foreach ($keys as $key)
                        $fileArray[$i][$key] = $file[$key][$i];
                }
            } else
            {
                $fileArray[] = $file;
            }
            $info = array();
            foreach ($fileArray as $key => $file)
            {
                //�Ǽ��ϴ��ļ�����չ��Ϣ
                $file['extension'] = $this->getExt($file['name']);
                $file['savepath'] = $savePath;
                $file['savename'] = $this->getSaveName($file);
                // �Զ���鸽��
                if ($this->autoCheck)
                {
                    if (!$this->check($file))
                        return false;
                }
                //�����ϴ��ļ�
                if (!$this->save($file))
                    return false;
                if (function_exists($this->hashType))
                {
                    $fun = $this->hashType;
                    $file['hash'] = $fun($this->autoCharset($file['savepath'] . $file['savename'], 'utf-8', 'gbk'));
                }
                unset($file['tmp_name'], $file['error']);
                $info[] = $file;
            }
            // �����ϴ����ļ���Ϣ
            return $info;
        } else
        {
            $this->error = 'û��ѡ���ϴ��ļ�';
            return false;
        }
    }

    /**
     * ת���ϴ��ļ��������Ϊ��ȷ�ķ�ʽ
     * @access private
     * @param array $files  �ϴ����ļ�����
     * @return array
     */
    private function dealFiles($files)
    {
        $fileArray = array();
        $n = 0;
        foreach ($files as $key => $file)
        {
            if (is_array($file['name']))
            {
                $keys = array_keys($file);
                $count = count($file['name']);
                for ($i = 0; $i < $count; $i++)
                {
                    $fileArray[$n]['key'] = $key;
                    foreach ($keys as $_key)
                    {
                        $fileArray[$n][$_key] = $file[$_key][$i];
                    }
                    $n++;
                }
            } else
            {
                $fileArray[$key] = $file;
            }
        }
        return $fileArray;
    }

    /**
     * ��ȡ���������Ϣ
     * @access public
     * @param string $errorNo  �������
     * @return void
     */
    protected function error($errorNo)
    {
        switch ($errorNo)
        {
            case 1:
                $this->error = '�ϴ����ļ������� php.ini �� upload_max_filesize ѡ�����Ƶ�ֵ';
                break;
            case 2:
                $this->error = '�ϴ��ļ��Ĵ�С������ HTML ���� MAX_FILE_SIZE ѡ��ָ����ֵ';
                break;
            case 3:
                $this->error = '�ļ�ֻ�в��ֱ��ϴ�';
                break;
            case 4:
                $this->error = 'û���ļ����ϴ�';
                break;
            case 6:
                $this->error = '�Ҳ�����ʱ�ļ���';
                break;
            case 7:
                $this->error = '�ļ�д��ʧ��';
                break;
            default:
                $this->error = 'δ֪�ϴ�����';
        }
        return;
    }

    /**
     * �����ϴ��ļ���������ȡ�ñ����ļ���
     * @access private
     * @param string $filename ����
     * @return string
     */
    private function getSaveName($filename)
    {
        $rule = $this->saveRule;
        if (empty($rule))
        {//û�ж������������򱣳��ļ�������
            $saveName = $filename['name'];
        } else
        {
            if (function_exists($rule))
            {
                //ʹ�ú�������һ��Ψһ�ļ���ʶ��
                $saveName = $rule() . "." . $filename['extension'];
            } else
            {
                //ʹ�ø������ļ�����Ϊ��ʶ��
                $saveName = $rule . "." . $filename['extension'];
            }
        }
        if ($this->autoSub)
        {
            // ʹ����Ŀ¼�����ļ�
            $filename['savename'] = $saveName;
            $saveName = $this->getSubName($filename) . $saveName;
        }
        return $saveName;
    }

    /**
     * ��ȡ��Ŀ¼������
     * @access private
     * @param array $file  �ϴ����ļ���Ϣ
     * @return string
     */
    private function getSubName($file)
    {
        switch ($this->subType)
        {
            case 'custom':
                $dir = $this->subDir;
                break;
            case 'date':
                $dir = date($this->dateFormat, time()) . '/';
                break;
            case 'hash':
            default:
                $name = md5($file['savename']);
                $dir = '';
                for ($i = 0; $i < $this->hashLevel; $i++)
                {
                    $dir .= $name{$i} . '/';
                }
                break;
        }
        if (!is_dir($file['savepath'] . $dir))
        {
            mkdir($file['savepath'] . $dir, 0777, true);
        }
        return $dir;
    }

    /**
     * ����ϴ����ļ�
     * @access private
     * @param array $file �ļ���Ϣ
     * @return boolean
     */
    private function check($file)
    {
        if ($file['error'] !== 0)
        {
            //�ļ��ϴ�ʧ��
            //����������
            $this->error($file['error']);
            return false;
        }
        //�ļ��ϴ��ɹ��������Զ��������
        //����ļ���С
        if (!$this->checkSize($file['size']))
        {
            $this->error = '�ϴ��ļ���С������';
            return false;
        }

        //����ļ�Mime����
        if (!$this->checkType($file['type']))
        {
            $this->error = '�ϴ��ļ�MIME���Ͳ�����';
            return false;
        }
        //����ļ�����
        if (!$this->checkExt($file['extension']))
        {
            $this->error = '�ϴ��ļ����Ͳ�����';
            return false;
        }

        //����Ƿ�Ϸ��ϴ�
        if (!$this->checkUpload($file['tmp_name']))
        {
            $this->error = '�Ƿ��ϴ��ļ���';
            return false;
        }
        return true;
    }

    // �Զ�ת���ַ��� ֧������ת��
    private function autoCharset($fContents, $from = 'gbk', $to = 'utf-8')
    {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
        if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)))
        {
            //���������ͬ���߷��ַ���������ת��
            return $fContents;
        }
        if (function_exists('mb_convert_encoding'))
        {
            return mb_convert_encoding($fContents, $to, $from);
        } elseif (function_exists('iconv'))
        {
            return iconv($from, $to, $fContents);
        } else
        {
            return $fContents;
        }
    }

    /**
     * ����ϴ����ļ������Ƿ�Ϸ�
     * @access private
     * @param string $type ����
     * @return boolean
     */
    private function checkType($type)
    {
        if (!empty($this->allowTypes))
            return in_array(strtolower($type), $this->allowTypes);
        return true;
    }

    /**
     * ����ϴ����ļ���׺�Ƿ�Ϸ�
     * @access private
     * @param string $ext ��׺��
     * @return boolean
     */
    private function checkExt($ext)
    {
        if (!empty($this->allowExts))
            return in_array(strtolower($ext), $this->allowExts, true) && !in_array($ext, array('php', 'asp', 'jsp', 'aspx'));
        return true;
    }

    /**
     * ����ļ���С�Ƿ�Ϸ�
     * @access private
     * @param integer $size ����
     * @return boolean
     */
    private function checkSize($size)
    {
        return !($size > $this->maxSize) || (-1 == $this->maxSize);
    }

    /**
     * ����ļ��Ƿ�Ƿ��ύ
     * @access private
     * @param string $filename �ļ���
     * @return boolean
     */
    private function checkUpload($filename)
    {
        return is_uploaded_file($filename);
    }

    /**
     * ȡ���ϴ��ļ��ĺ�׺
     * @access private
     * @param string $filename �ļ���
     * @return boolean
     */
    private function getExt($filename)
    {
        $pathinfo = pathinfo($filename);
        return $pathinfo['extension'];
    }

    /**
     * ȡ���ϴ��ļ�����Ϣ
     * @access public
     * @return array
     */
    public function getUploadFileInfo()
    {
        return $this->uploadFileInfo;
    }

    /**
     * ȡ�����һ�δ�����Ϣ
     * @access public
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->error;
    }

}
