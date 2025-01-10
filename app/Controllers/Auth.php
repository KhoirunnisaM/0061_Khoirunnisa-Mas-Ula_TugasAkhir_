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

            // Validasi username
            if (!$user) {
                return redirect()->back()->with('error', 'Username tidak terdaftar.');
            }

            // Validasi password
            if ($user && !password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Password yang dimasukkan salah.');
            }

            // Update kolom last_login
            $userModel->update($user['id_user'], [
                'last_login' => date('Y-m-d H:i:s')
            ]);

            // Jika validasi berhasil, set session data
            session()->set([
                'id_user' => $user['id_user'],
                'username' => $user['username'],
                'level' => $user['level'],
                'isLoggedIn' => true,
            ]);

            // Redirect berdasarkan level user
            if ($user['level'] === 'admin') {
                return redirect()->to('/Admin/dashboard')->with('success', 'Login berhasil! Selamat datang, Admin.');
            } elseif ($user['level'] === 'pegawai') {
                return redirect()->to('/Pegawai/dashboard')->with('success', 'Login berhasil! Selamat datang, Pegawai.');
            }
        }

        // Load the login view
        return view('Views/Admin/dashboard');
    }

    public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Redirect to the login page
        return redirect()->to('/')->with('message', 'You have been logged out.');
    }
}
