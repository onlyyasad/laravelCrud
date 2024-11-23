<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(){
        return view("create");
    }

    public function postStore(Request $request){

        $validated = $request->validate([
            'name'        => ['required', 'max:255'],
            'description' => 'required',
            'image'       => ['nullable', 'mimes:jpg,jpeg,png,bmp,webp']
        ]);

        $imageName = null;
        if(isset($request->image)){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        $post = new Post();

        $post->name        = $request->name;
        $post->description = $request->description;
        $post->image       = $imageName;

        $post->save();
        return redirect()->route('home')->with("success", "Post added successfully!");
    }
}
