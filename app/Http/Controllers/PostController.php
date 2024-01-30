<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): view 
    {
        $query = $request->input('query');
    
        if ($query) {
            $posts = Post::where('tenant', 'LIKE', "%$query%")->orWhere('menu', 'LIKE', "%$query%")->latest()->paginate(5);
        } else {
            $posts = Post::latest()->paginate(5);
        }
        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //create validate
        $this->validate($request, [
            'image'   => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'tenant'  => 'required|min:4',
            'menu'    => 'required|min:5'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        Post::create([
            'image'  => $image->hashName(),
            'tenant' => $request->tenant,
            'menu'   => $request->menu,
            'price'  => $request->price
        ]);

        return redirect()->route('posts.index')->with(['success' => 'Data Added Successfully!']);
    }

    public function edit(string $id): View
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'image'   => 'image|mimes:jpeg,jpg,png,webp|max:2048',
            'tenant'  => 'required|min:4',
            'menu'    => 'required|min:5'
        ]);

        $post = Post::findOrFail($id);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            Storage::delete('public/posts/'.$post->image);

            $post->update([
                'image'  => $image->hashName(),
                'tenant' => $request->tenant,
                'menu'   => $request->menu,
                'price'  => $request->price
            ]);

        } else {

            //update post without image
            $post->update([
                'tenant' => $request->tenant,
                'menu'   => $request->menu,
                'price'  => $request->price
            ]);
        }

        return redirect()->route('posts.index')->with(['success' => 'Data Successfully Update!']);
    }

    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $post = Post::findOrFail($id);

        //delete image
        Storage::delete('public/posts/'. $post->image);

        //delete post
        $post->delete();

        //redirect to index
        return redirect()->route('posts.index')->with(['success' => 'Data Deleted Successfully!']);
    }
}
