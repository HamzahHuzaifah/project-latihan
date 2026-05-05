<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    public function index()
    {
        return view('admin/dashboard');
    }

    public function setting()
    {
        return view('admin/setting');
    }

    public function settingUpdate()
    {
        $rules = [
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
            $rules['pass_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new \Myth\Auth\Models\UserModel();
        $user = $userModel->find(user_id());
        
        $user->username = $this->request->getPost('username');
        $user->email = $this->request->getPost('email');

        if ($this->request->getPost('password')) {
            $user->password = $this->request->getPost('password');
        }

        if (!$userModel->save($user)) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        return redirect()->to('/admin/setting')->with('message', 'Profil berhasil diperbarui!');
    }
}
