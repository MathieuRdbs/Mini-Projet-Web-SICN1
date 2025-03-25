<?php
namespace App\Http\Controllers;

class AdminController extends Controller{
    public function showdashboard(){
        return view('admin.dynamcomps.users');
    }
}