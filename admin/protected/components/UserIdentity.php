<?php

class UserIdentity extends CUserIdentity
{

    private $_id;
    public $group_id;

    public function authenticate()
    {
        $username = strtolower($this->username);
        $user = Admin::model()->find('LOWER(username)=? ', array($username));
        if ($user === null)
        {
            $this->errorCode = self:: ERROR_USERNAME_INVALID;
        } else if (!$user->validatePassword($this->password))
        {
            $this->errorCode = self:: ERROR_PASSWORD_INVALID;
        } else
        {
            $this->_id = $user->id;
            $this->username = $user->username;
            $this->group_id = $user->group_id;
            $this->errorCode = self:: ERROR_NONE;
        }

        return $this->errorCode == self:: ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }

}
