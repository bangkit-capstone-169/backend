<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function store(Request $request,$id){
        $request->validate([
            'users_id' => 'required',
            ''
        ])        
    }
}
