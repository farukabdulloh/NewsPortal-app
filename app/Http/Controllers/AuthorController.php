<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($username){
        $author = Author::where('username', $username)->firstOrFail();

        return view('pages.author.author', compact('author'));
    }
}
