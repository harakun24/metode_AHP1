<?php

namespace App\Controllers;

class Ahp extends BaseController
{

    public function index()
    {
        $admin = new \App\Controllers\Admin();
        if ($admin->isLogged()) {
            return view("ahp/home");
        } else {
            return redirect()->to("/");
        }
    }
}