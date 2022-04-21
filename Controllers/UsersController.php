<?php

namespace App\Controllers\UsersController;

use App\Models\UsersModels\UsersModels;

class UsersController
{
    private $db;
    protected $status = true;
    protected $error = null;
    protected $data = [];

    public function __construct()
    {
        $this->db = new UsersModels();
    }

    public function index()
    {
        if(!empty($_GET)){
            $this->getRequestAnswer();
        }
        else {
            $this->view();
        }


    }
    private function getRequestAnswer()
    {
        $getAction = $_GET['action'];
        switch ($getAction){
            case 'add':
                $this->createNewUser();
                break;
            case 'update':
                $this->updateUser();
                break;
            case 'delete':
                $this->deleteUser();
                break;
            case 'getUser':
                $this->getUserById();
                break;
            case 'groupSelect':
                $this->setGroupOperation();
                break;
            default:
                $this->error = [
                    'code' => 404,
                    'message' => 'No find method',
                ];
        }
        $this->answerJson();
    }
    private function getPostRequest()
    {
        if ($_POST) {
            $data = $_POST;
            $this->dataClear($data);
            return $data;
        }
        return null;
    }


    private function view()
    {
        $users = $this->db->getAllUsers();
        
        $roles = $this->db->getAllRoles();
        include __DIR__ . '/../Views/users_views.php';
    }

    private function createNewUser()
    {
        $data = $this->getPostRequest();

        if ($this->validation($data)) {
            $data['id'] = ($this->db->setUser($data)) ?? false;
            if (empty($data['id'])) {
                $this->status = false;
                $this->error = [
                    'code' => 101,
                    'message' => "error base",
                ];
            } else {
                $this->data['user'] = $this->db->getUser($data['id']);
            }
        }
    }

    private function validation($request)
    {
        $message = '';
        switch (true) {
            case (empty($request['first_name'])):
                $message = "Not set First Name";
                break;
            case (empty($request['last_name'])):
                $message = "Not set Last Name";
                break;
            case (empty($request['id_role'])):
                $message = "Not set Role";
                break;
        }
        if(!empty($message)){
            $this->status = false;
            $this->error = [
                'code' => 100,
                'message' => $message,
            ];
            return false;
        }
        return $this->status;
    }

    private function updateUser()
    {
        $data = $this->getPostRequest();
        if ($this->validation($data)) {
            $update = ($this->db->updateUser($data)) ?? false;
            if ($update->error) {
                $this->status = false;
                $this->error = [
                    'code' => 101,
                    'message' => "error base",
                ];
            } else {
                $this->data['user'] = $this->db->getUser($data['id']);
            }
        }
    }

    private function deleteUser()
    {
        if($_GET['id']) {
            $this->db->deleteUser($_GET['id']);
        }
    }

    private function getUserById()
    {
        if($_GET['id']) {
            $this->data['user'] = $this->db->getUser($_GET['id']);
        } else {
            $this->error = [
                'code' => 104,
                'message' => 'Request Error'
                ];
        }
    }

    private function answerJson()
    {
        $send = [
            'status' => ($this->error === null) ?? false,
            'error' => $this->error,
        ];
        echo json_encode(array_merge($send, $this->data));
    }

    private function setGroupOperation()
    {
        $getJSONString = file_get_contents('php://input');
        $data = json_decode($getJSONString);
        if(empty($data->action)
            || empty($data->users_id)
            || !is_array($data->users_id)){
            $this->error = [
                'code' => 105,
                'message' => 'Invalid data'
            ];
            return;
        };
        $rows = 0;
        switch ($data->action) {
            case 'setActive' :
                $rows = $this->db->updateUsersStatus($data->users_id);
                break;
            case 'setNotActive' :
                $rows = $this->db->updateUsersStatus($data->users_id, 0);
                break;
            case 'delete' :
                $rows = $this->db->deleteUsers($data->users_id);
                break;
            default:
                $this->error = [
                    'code' => 105,
                    'message' => 'Invalid data'
                ];
                return;
        }
        $this->data['users_id'] = $data->users_id;


    }

    private function dataClear(array &$data): array
    {
        foreach ($data as &$item) {
            if(is_array($item)) {
                $this->dataClear($item);
            } else {
                $item = trim($item, " \n\r\t\v\x00");
            }
        }
        return $data;
    }
}