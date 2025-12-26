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
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {

            $filename = uniqid() . '.' . $request->file('image')->extension();

            // SIMPAN IMAGE (POLA SAMA DENGAN PROFILE)
            $request->file('image')
                ->storeAs('news_images', $filename, 'public');

            News::create([
                'title'       => $request->title,
                'description' => $request->description,
                'image'       => $filename,
            ]);
        }

        return back()->with('success', 'Berita berhasil ditambah!');
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {

            // HAPUS FOTO LAMA (POLA SAMA DENGAN PROFILE)
            if ($news->image) {
                Storage::disk('public')->delete('news_images/' . $news->image);
            }

            $filename = uniqid() . '.' . $request->file('image')->extension();

            $request->file('image')
                ->storeAs('news_images', $filename, 'public');

            $news->image = $filename;
        }

        $news->title       = $request->title;
        $news->description = $request->description;
        $news->save();

        return back()->with('success', 'Berita berhasil diupdate!');
    }
}
