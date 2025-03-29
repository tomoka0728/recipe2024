<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller {

    public function show(){
        $user = Auth::user();
        return view('mypage', compact('user'));
    }

}
