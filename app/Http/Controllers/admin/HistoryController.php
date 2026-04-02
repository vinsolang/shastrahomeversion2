<?php

namespace App\Http\Controllers\admin;

use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::get();
        return view('admin.histories.index', compact('histories'));
    }

    public function create()
    {
        return view('admin.histories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_km' => 'nullable|string',
            'content_ch' => 'nullable|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // $data = $request->except('_token', 'image');

        // $folderName = strtolower(str_replace(' ', '_', $validated['title']['en']));
        $imagePaths = [];

        foreach ($request->file('images') as $imageFile) {
            $path = $imageFile->store("histories", 'custom');
            $imagePaths[] = $path;
        }

        // History::create($data);
         History::create([
            'year' => $validated['year'],
            'content_en' => $validated['content_en'],
            'content_km' => $validated['content_km'],
            'content_ch' => $validated['content_ch'],
            'image' => json_encode($imagePaths),
        ]);

        return redirect()->route('history.index')->with('success', 'History entry created successfully.');
    }


    public function edit(string $id)
    {
        $history = History::findOrFail($id);

        return view('admin.histories.edit', compact('history'));
    }

    public function update(Request $request, string $id)
    {
        $history = History::findOrFail($id);

        $validated = $request->validate([
            'year' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_km' => 'nullable|string',
            'content_ch' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // $data = $request->except('_token', 'image', '_method');

        // if ($request->hasFile('image')) {

        //     // Delete old image
        //     if ($history->image && Storage::disk('custom')->exists($history->image)) {
        //         Storage::disk('custom')->delete($history->image);
        //     }

        //     // Store new image
        //     $data['image'] = $request->file('image')->store('histories', 'custom');
        // }

        $imagePaths = json_decode($history->image, true) ?? [];
        // $folderName = strtolower(str_replace(' ', '_', $validated['title']['en']));

        if ($request->filled('removed_images')) {
            $removedImages = json_decode($request->removed_images, true);

            foreach ($removedImages as $removedImage) {
                if (Storage::disk('custom')->exists($removedImage)) {
                    Storage::disk('custom')->delete($removedImage);
                }
                $imagePaths = array_filter($imagePaths, fn($img) => $img !== $removedImage);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store("histories", 'custom');
                $imagePaths[] = $path;
            }
        }

        $history->update([
            'year' => $validated['year'],
            'content_en' => $validated['content_en'],
            'content_km' => $validated['content_km'],
            'content_ch' => $validated['content_ch'],
            'image' => json_encode(array_values($imagePaths))
        ]);

        return redirect()->route('history.index')
            ->with('success', 'History entry updated successfully.');
    }
}
