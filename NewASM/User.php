<?php

class User implements Serializable
{
    public $id;
    public $username;
    public $role;
    public $email;
    function  __construct($id, $username, $role, $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->role = $role;
        $this->email = $email;
    }

    public function serialize()
    {
        return serialize([
            'username' => $this->username,
            'role' => $this->role,
            'id' => $this->id,
            'email' => $this->email
        ]);
    }

    public function unserialize($data)
    {
        list($this->id, $this->username, $this->role, $this->email) = unserialize($data);
    }
}
