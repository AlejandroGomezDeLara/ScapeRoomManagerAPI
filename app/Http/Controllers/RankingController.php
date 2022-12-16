<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(){
        $paginate=25;
        return User::orderBy('funly_points','desc')->paginate($paginate);
    }
}
