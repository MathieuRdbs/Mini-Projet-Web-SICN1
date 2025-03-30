<?php
namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller{
    public function showUsers(){
        $users = User::where('role', 'user')->paginate(5);
        return view('admin.dynamcomps.users', compact('users'));
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}