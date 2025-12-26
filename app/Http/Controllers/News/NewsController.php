<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->extension();
            
            // Simpan ke storage/app/public/News-images
            $file->storeAs('News-images', $filename, 'public');

            News::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $filename, // Simpan nama file saja
            ]);
        }

        return redirect()->back()->with('success', 'Berita berhasil ditambah!');
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada di folder News-images
            if ($news->image && Storage::disk('public')->exists('News-images/' . $news->image)) {
                Storage::disk('public')->delete('News-images/' . $news->image);
            }

            $file = $request->file('image');
            $filename = uniqid() . '.' . $file->extension();
            $file->storeAs('News-images', $filename, 'public');
            $news->image = $filename;
        }

        $news->title = $request->title;
        $news->description = $request->description;
        $news->save();

        return redirect()->back()->with('success', 'Berita berhasil diupdate!');
    }
}