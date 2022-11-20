<?php

Class ModelUser {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function verifyLogin($username, $password) {
        $this->db->query('SELECT * FROM '.USERS.' WHERE username=:username AND password=:password');
        $this->db->bind('username', $username);
        $this->db->bind('password', md5($password));
        $result =  $this->db->single();
        
        if ($result) {
            if ($result['user_type'] == 1) {
                $_SESSION['login'] = [
                    'id' => $result['id'],
                    'username' => $result['username'],
                    'name' => $result['name'],
                    'user_type' => $result['user_type']
                ];
                return true;
            }
            else if ($result['user_type'] == 2) {
                $_SESSION['login'] = [
                    'id' => $result['id'],
                    'username' => $result['username'],
                    'name' => $result['name'],
                    'user_type' => $result['user_type']
                ];
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function register($username, $password, $email, $name, $type) {
        $this->db->query('SELECT * FROM '.USERS.' WHERE username=:username OR email=:email');
        $this->db->bind('username', $username);
        $this->db->bind('email', $email);
        $result = $this->db->resultSet();
        //loop $result using foreach
        foreach ($result as $row) {
            if ($row['username'] == $username) {
                return 'Username already exists';
            }
            else if ($row['email'] == $email) {
                return 'Email already exists';
            }
        }

        $this->db->query('INSERT INTO '.USERS.' VALUES(NULL, :username, :email, :name, :user_type, :password)');
        $this->db->bind('username', $username);
        $this->db->bind('password', md5($password));
        $this->db->bind('email', $email);
        $this->db->bind('name', $name);
        $this->db->bind('user_type', $type);
        $result = $this->db->execute();

        if (is_null($result)) {
            return 'success';
        }
        else {
            return 'Registration failed';
        }
    }

    public function updateUser($id, $username, $email, $name) {
        $this->db->query('SELECT * FROM '.USERS.' WHERE (username=:username OR email=:email) AND id!=:id');
        $this->db->bind('id', $id);
        $this->db->bind('username', $username);
        $this->db->bind('email', $email);
        $result = $this->db->resultSet();
        //loop $result using foreach
        foreach ($result as $row) {
            if ($row['username'] == $username) {
                return 'Username already exists';
            }
            else if ($row['email'] == $email) {
                return 'Email already exists';
            }
        }

        $this->db->query('UPDATE '.USERS.' SET username=:username, email=:email, name=:name WHERE id=:id');
        $this->db->bind('id', $id);
        $this->db->bind('username', $username);
        $this->db->bind('email', $email);
        $this->db->bind('name', $name);
        $result = $this->db->execute();

        if (is_null($result)) {
            return 'success';
        }
        else {
            return 'Profile update failed';
        }
    }

    public function updatePassword($id, $password, $confirm_password) {
        if ($password == $confirm_password) {
            $this->db->query('UPDATE '.USERS.' SET password=:password WHERE id=:id');
            $this->db->bind('id', $id);
            $this->db->bind('password', md5($password));
            $result = $this->db->execute();

            if (is_null($result)) {
                return 'success';
            }
            else {
                return 'Password update failed';
            }
        }
        else {
            return 'Password does not match';
        }
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM '.USERS.' WHERE id=:id');
        $this->db->bind('id', $id);
        $result =  $this->db->single();
        
        return $result;
    }
}