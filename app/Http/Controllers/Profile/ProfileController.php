<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\User;
// その他
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // ページヘッダーをセッションに格納
        session(['page_header' => 'プロフィール']);
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // ユーザーを取得
        $user = User::ByPk(Auth::user()->user_no)->with('vehicles')->first();
        return view('profile.index')->with([
            'user' => $user,
        ]);
    }
}