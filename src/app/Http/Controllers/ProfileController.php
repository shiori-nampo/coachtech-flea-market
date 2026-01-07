<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function mypage(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab','sell');

        if ($tab === 'buy') {
            $products = Product::whereHas('order',function($q) use ($user) {
                $q->where('user_id',$user->id);
            })->get();
        }else {
            $products = Product::where('user_id',$user->id)->get();
        }
        return view('profile.mypage',compact('user','products','tab'));

    }




    public function mypageProfile()
    {
        $user = Auth::user();
        return view('profile.edit',compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = [
            'name' => $request->name,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ];

        if ($request->hasFile('image')) {
            $filename = 'user_' . $user->id . '_profile.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('profiles',$filename,'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.edit');
    }
}
