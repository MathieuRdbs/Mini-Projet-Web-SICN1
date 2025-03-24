<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller{

    public function showhome(Request $request){
        $user = Auth::user();

        return view('homepage', compact(['user']));
    }
}