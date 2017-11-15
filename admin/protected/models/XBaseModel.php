<?php
/**
 * ģ�ͻ����࣬����ģ�;���̳д���
 */ 
class XBaseModel extends CActiveRecord
{
    /**
     * ����û�����
     *
     * @return boolean
     */
    public function validatePassword ($password)
    {
        return $this->hashPassword($this->password) === $password;
    }

    /**
     * ������м���
     * @return string password
     */
    public function hashPassword ($password)
    {
        return md5($password);
    }

    /**
     * ���ݱ���ǰ����
     * @return boolean.
     */
    protected function beforeSave ()
    {
        if ($this->isNewRecord) {
            isset($this->create_time) && $this->create_time = time();
        } else {
            isset($this->last_update_time) && $this->last_update_time = time();
        }
        return true;
    }
    
}