<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sellItems = $user->items()->paginate(10);
        $soldItems = $user->soldToItems()->paginate(10);

        $data = [
            'user' => $user,
            'sellItems' => $sellItems,
            'soldItems' => $soldItems,
        ];

        return view('mypage', $data);
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = null;

        if ($user->profile) {
            $profile = $user->profile;
        }

        return view('profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $userForm = $request->only('name');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $filename = time() . '_' . $file->getClientOriginalName();

            $path = $file->storeAs('uploads', $filename, 'public');
   
            $imgUrl = Storage::url($path);

            $userForm['img_url'] = $imgUrl;
        } else {
            $userForm['img_url'] = $user->img_url;
        }

        $user->update($userForm);

        $profileForm = $request->only(['postcode', 'address', 'building']);
        $profile = $user->profile;

        if ($profile) {
            $profile->update($profileForm);
        } else {
            $user->profile()->create($profileForm);
        }

        return redirect()->back()->with('success', 'プロフィールを変更しました');
    }
}
