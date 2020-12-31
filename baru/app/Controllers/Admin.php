<?php

namespace App\Controllers;

use App\Models\adminModel;

class Admin extends BaseController
{
    public static $session;
    function __construct()
    {
        self::$session = session();
        $this->admin = new \App\Models\adminModel();
    }
    public function isLogged()
    {
        return self::$session->get('logged');
    }
    public function logout()
    {
        self::$session->set('logged', false);
        return redirect()->to('/admin');
    }
    public function index()
    {
        if ($this->isLogged())
            return redirect()->to("/ahp");
        else
            return view("login");
    }
    public function prosesLogin()
    {
        $data = ['admin_username' => $this->request->getVar('user'), 'admin_pass' => $this->request->getVar('pass')];
        $admin = $this->admin->where($data)->first();
        if ($admin != null) {
            self::$session->set('logged', true);
            self::$session->set('user', $admin['admin_nama']);
        }
        return redirect()->to('/admin');
        // dd($this->isLogged());
    }
}