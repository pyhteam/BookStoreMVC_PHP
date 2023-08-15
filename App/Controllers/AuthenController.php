<?php

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Services\Common\Enums\HttpMethod;
use App\Services\Common\JWTToken;
use App\Services\Common\Pagination;
use App\Services\Common\Request;
use App\Services\Common\Response;
use App\Services\Common\Session;
use App\Services\OrderServices\OrderService;
use App\Services\RoleServices\RoleService;
use App\Services\UserRoleServices\UserRoleService;
use App\Services\UserServices\UserService;

class AuthenController extends Controller
{
    private $userService = null;
    private $userRoleService = null;
    private $roleService = null;
    private $orderService = null;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->userRoleService = new UserRoleService();
        $this->roleService = new RoleService();
        $this->orderService = new OrderService();
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
                 'role' => $roleName,
                'token' => $token,
            ], 'Đăng nhập thành công');
            return;
        }
        $this->render('Authen.Login', '_AuthenLayout', ['title' => 'Login']);
    }
    public function Register()
    {
        if (Request::method("POST")) {
            $username = Request::post('Username');
            $password = Request::post('Password');
            $confirmPassword = Request::post('ConfirmPassword');
            $email = Request::post('Email');
            if ($username == null || $password == null || $confirmPassword == null || $email == null) {
                Response::badRequest([], 'Vui lòng nhập đầy đủ thông tin');
                return;
            }
            // validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Response::badRequest([], 'Email không hợp lệ');
                return;
            }
            if ($password != $confirmPassword) {
                Response::badRequest([], 'Mật khẩu không khớp');
                return;
            }
            // check email exist
            $user = $this->userService->GetByEmail($email);
            if ($user != null) {
                Response::notFound([], 'Email đã tồn tại');
                return;
            }
            $roleId = $this->roleService->GetByName('Member')->Id;
            $user = [
                'Username' => $username,
                'Password' => $password,
                'Email' => $email,
            ];
            $result = $this->userService->Register($user);
            if ($result == null) {
                Response::notFound([], 'Tài khoản đã tồn tại');
                return;
            }

            $user = $this->userService->GetByEmail($email);
            $userId = $user->Id;
            $userRole = [
                'UserId' => $userId,
                'RoleId' => $roleId
            ];
            $this->userRoleService->AddRoleToUser($userId, $roleId);
            Response::success([], 'Đăng ký thành công');
            return;
        }
        $this->render('Authen.Register', '_ClientLayout', ['title' => 'Register']);
    }
    public function Logout()
    {
        Session::destroy();
        $this->redirect('/');
    }

    // For Client Site
    public function UserLogin($page = 1)
    {
        if (Request::method("POST")) {
            $post = $_POST;
            $username = Request::post('Username');
            $password = Request::post('Password');
            if ($username == null || $password == null) {
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
        if(Session::has('user')) {
            $userId = Session::get('user')->Id;
            $pageConfig = Config::PageConfig();
            $pageIndex = $page ?? 1;
            $totalRecords   = count($this->orderService->GetAll());
            $pagConfig = [
                'baseURL' => '/account/page',
                'totalRows' => $totalRecords,
                'perPage' => $pageConfig['PageSize'],
            ];
            $pagination = new Pagination($pagConfig);

            $orders = $this->orderService->GetByUserId($userId, $pageIndex, $pageConfig['PageSize']);
            $this->render('Authen.UserLogin', '_ClientLayout', [
                'title' => 'Account page',
                'orders' => $orders,
                'pagination' => $pagination
            ]);
            return;
        }

        $this->render('Authen.UserLogin', '_ClientLayout', [
            'title' => 'Account page']);
    }
}
