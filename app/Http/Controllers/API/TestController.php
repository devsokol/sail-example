<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function test(Request $request, User $id)
    {
        dd($id);
        dd('test ...');
    }
}
