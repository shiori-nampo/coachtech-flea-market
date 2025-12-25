<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function mypageProfile()
    {
        $user = Auth::user();
        return view('profile.edit',compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($equest->hasFile('image')) {
            $path = $request->file('image')->store('profiles','public');
            $user->image = $path;
        }

        $user->update([
            'name' => $request->name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        return redirect()->route('profile.edit');//->with('success','プロフィールを更新しました');
    }
}
