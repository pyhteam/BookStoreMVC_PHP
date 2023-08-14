<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\Common\Enums\HttpMethod;
use App\Services\Common\JWTToken;
use App\Services\Common\Request;
use App\Services\Common\Response;
use App\Services\Common\Session;
use App\Services\RoleServices\RoleService;
use App\Services\UserRoleServices\UserRoleService;
use App\Services\UserServices\UserService;

class AuthenController extends Controller
{
    private $userService = null;
    private $userRoleService = null;
    private $roleService = null;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->userRoleService = new UserRoleService();
        $this->roleService = new RoleService();
    }
    public function Login()
    {
        if (Request::method("POST") ) {
            $post = $_POST;
            $username = Request::post('Username');
            $password = Request::post('Password');
            if($username == null || $password == null){
                Response::badRequest([], 'Vui lòng nhập đầy đủ thông tin');
                return;
            }

            $result = $this->userService->Login($username, $password);
            if ($result == null) {
                Response::notFound([], 'Tài khoản không tồn tại');
                return;
            }
            // get role
            $userRole = $this->userRoleService->GetRoleByUsername($result->Username);
            $roleId = $userRole[0]['Id'];
            $roleName =  $userRole[0]['Name'];
            // set session
            Session::set('user', $result);
            $token = JWTToken::generateToken([
                'userId' => $result->Id,
                'username' => $result->Username,
                'email' => $result->Email,
                'roleId' => $roleId
            ], time() + 3600);
            Session::set('token', $token);
            Session::set('role', $roleName);
            // set time out session
            Session::set('timeout', time() + 3600);

            Response::success([
                'userId' => $result->Id,
                'token' => $token,
            ], 'Đăng nhập thành công');
            return;
        }
        $this->render('Authen.Login', '_AuthenLayout', ['title' => 'Login']);
    }
    public function Register()
    {
        if (Request::method(HttpMethod::POST)) {
            $username = Request::post('Username');
            $password = Request::post('Password');
            $confirmPassword = Request::post('ConfirmPassword');
            $email = Request::post('Email');
            if ($password != $confirmPassword) {
                Response::badRequest([], 'Mật khẩu không khớp');
            }
            $roleId = $this->roleService->GetByName('Member')->Id;
            $user = [
                'Username' => $username,
                'Password' => $password,
                'Email' => $email,
                'RoleId' => $roleId
            ];
            $result = $this->userService->Register($user);
            if ($result == null) {
                Response::notFound([], 'Tài khoản đã tồn tại');
            }
            Response::success([], 'Đăng ký thành công');
            return;
        }
        $this->render('Authen.Register', '_AuthenLayout', ['title' => 'Register']);
    }
    public function Logout()
    {
        Session::destroy();
        $this->redirect('/auth/login');
    }
}
