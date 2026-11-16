<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Post::where('picture', '!=', '')
            ->whereNotNull('picture')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999',
        ]);

        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();

            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
        } else {
            $filenameSimpan = 'noimage.png';
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'picture' => $filenameSimpan,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Berhasil menambahkan data baru.');
    }

    public function edit(Post $post)
    {
        return view('gallery.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999',
        ]);

        if ($request->hasFile('picture')) {
            if ($post->picture && $post->picture !== 'noimage.png') {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('posts_image/' . $post->picture);
            }
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
            $post->picture = $filenameSimpan;
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return redirect()->route('gallery.index')->with('success', 'Data gallery berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->picture && $post->picture !== 'noimage.png') {
            \Illuminate\Support\Facades\Storage::disk('public')->delete('posts_image/' . $post->picture);
        }
        $post->delete();

        return redirect()->route('gallery.index')->with('success', 'Data gallery berhasil dihapus.');
    }
}
