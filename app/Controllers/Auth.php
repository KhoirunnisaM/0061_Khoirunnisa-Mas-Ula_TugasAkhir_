<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;
use App\Filters\Auth_filters;

class Auth extends BaseController

{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new Users();
            $user = $userModel->where('username', $username)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Username tidak terdaftar.');
            }

            if ($user && !password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Password yang dimasukkan salah.');
            }

            $userModel->update($user['id_user'], [
                'last_login' => date('Y-m-d H:i:s')
            ]);

            session()->set([
                'id_user' => $user['id_user'],
                'fullname' => $user['fullname'],
                'level' => $user['level'],
                'isLoggedIn' => true
            ]);

            if ($user['level'] === 'admin') {
                return redirect()->to('/Admin/dashboard')->with('success', 'Login berhasil! Selamat datang, Admin.');
            } elseif ($user['level'] === 'pegawai') {
                return redirect()->to('/Pegawai/dashboard')->with('success', 'Login berhasil! Selamat datang, Pegawai.');
            }
        }

        return view('Views/Admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/')->with('message', 'You have been logged out.');
    }
}
