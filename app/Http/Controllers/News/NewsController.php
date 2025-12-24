<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('news', compact('news')); 
    }


    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image'       => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $filename = uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->storeAs('news', $filename, 'public');

        News::create([
            'title'       => $request->title, 
            'description' => $request->description,
            'image'       => $filename,
        ]);

        return redirect()->route('news.index')->with('success', 'News berhasil ditambahkan!');
    }

    public function edit(News $news)
    {
        // Perbaikan: compact('news') bukan 'brand'
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        // 1. Validasi Update
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // 2. Cek apakah ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($news->image) {
                Storage::disk('public')->delete('news/' . $news->image);
            }

            $filename = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('news', $filename, 'public');
            
            // Update properti image pada object $news
            $news->image = $filename;
        }

        // 3. Update data text
        $news->title = $request->title;             // Ganti name jadi title
        $news->description = $request->description; // Update description
        
        $news->save();

        return redirect()->route('news.index')->with('success', 'News berhasil diupdate!');
    }

    // Perbaikan: Type Hint menjadi News, bukan Brand
    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete('news/' . $news->image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News berhasil dihapus!');
    }
}