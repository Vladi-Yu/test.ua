<?php

namespace App\Models\UsersModels;

use mysqli;

class UsersModels
{
    protected $server = '';
    protected $dbName = '';
    protected $user = '';
    protected $password = '';

    public function __construct()
    {
        $config = require(__DIR__ . '/../Core/db_config.php');

        $this->server = $config['server'];
        $this->dbName = $config['db_name'];
        $this->user = $config['user'];
        $this->password = $config['password'];
    }

    public function getAllUsers()
    {
        $sql = 'SELECT `users`.*, `user_roles`.name as name_role FROM `users` LEFT JOIN `user_roles` ON `users`.id_role = `user_roles`.id  ORDER BY `users`.id ASC';
        return $this->SendRequestMysql($sql);
    }
    public function getAllRoles()
    {
        $sql = 'SELECT * FROM `user_roles`';
        return $this->SendRequestMysql($sql);
    }

    public function getUser($id)
    {
        $sql = "SELECT `users`.*, `user_roles`.name as name_role FROM `users` LEFT JOIN `user_roles` ON `users`.id_role = `user_roles`.id WHERE `users`.id = '" . (int)$id . "'";
        return $this->SendRequestMysql($sql, 'r');
    }

    public function setUser($data)
    {
        $sql = "INSERT INTO `users` (`id`, `first_name`, `last_name`, `id_role`, `status`) VALUES (";
        $sql .= "NULL, ";
        $sql .= "'" . htmlspecialchars($data['first_name']) . "',";
        $sql .= "'" . htmlspecialchars($data['last_name']) . "',";
        $sql .= "'" . (int) $data['id_role'] . "',";
        $sql .= ($data['status']) ? "'" . (bool) $data['status'] . "')" : "'0')";
        return $this->SendRequestMysql($sql, 'w')->insert_id;

    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM `users` WHERE `id` = '" . (int)$id . "'";
        return $this->SendRequestMysql($sql, 'w')->affected_rows;
    }

    public function deleteUsers($ids)
    {
        $sql = "DELETE FROM `users` WHERE `id` IN('". implode('\', \'', $ids) ."')";
        return $this->SendRequestMysql($sql, 'w')->affected_rows;
    }

    public function updateUser($data)
    {
        $sql = "UPDATE `users` SET ";
        $sql .= "`first_name` = '" . (($data['first_name']) ? htmlspecialchars($data['first_name']) : '') . "', ";
        $sql .= "`last_name` = '" . (($data['last_name']) ? htmlspecialchars($data['last_name']) : '') . "', ";
        $sql .= "`id_role` = '" . (($data['id_role']) ? (int) $data['id_role'] : '') . "', ";
        $sql .= "`status` = '" . (($data['status']) ? (bool) $data['status'] : '0') . "'";
        $sql .= " WHERE `id` = '" . $data['id'] . "'";
        return $this->SendRequestMysql($sql, 'w');
    }

    public function updateUsersStatus(array $ids, $status = 1)
    {
        $sql = "UPDATE `users` SET `status` = '$status' WHERE `id` IN('". implode('\', \'', $ids) ."')";
        return $this->SendRequestMysql($sql, 'w')->affected_rows;
    }

    private function SendRequestMysql($sql, $type = 'all')
    {
        $this->mysqli = new mysqli($this->server, $this->user, $this->password, $this->dbName);
        $mysqli = $this->mysqli;
        if ($mysqli->connect_errno) {
            exit();
        };
        $mysqli->set_charset("utf8");
        $result = $mysqli->query($sql);
        if ($type == 'r') {
            $data = mysqli_fetch_assoc($result);
        } elseif ($type == 'all') {
            $data = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        } else {
            $data = $mysqli;
        }
        return $data;
    }
}