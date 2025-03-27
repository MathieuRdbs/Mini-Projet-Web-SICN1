<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class AdminProfileController extends Controller{
    public function showProfile(){
        $admin = Auth::user();
        return view('admin.dynamcomps.profile', compact('admin'));
    }

    public function updateProfile(Request $request, $id){
        $admin = User::find($id);
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($admin->id),
            ],
            'password' => 'nullable|string|min:8',
            'phonenumber' => 'required|string|max:20',
        ],[
            'fullname.required' => 'the full name field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'this email is already used.',
            'email.required' => 'The email field is required.',
            'password.min' => 'the password is below the length authorized.',
            'phonenumber.required' => 'The phone field is required.',
            'phonenumber.max' => 'the phone length does not match',
        ]);
        $admin->update($validated);
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}