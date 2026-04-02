<?php

namespace App\Http\Controllers\admin;

use App\Models\Why;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class WhyController extends Controller
{
     public function index()
    {
        $whys = Why::get();
        return view('admin.whys.index', compact('whys'));
    }

    public function create()
    {
        return view('admin.whys.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'nullable|string|max:255',
            'title_km' => 'nullable|string|max:255',
            'title_ch' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_km' => 'nullable|string',
            'content_ch' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->except('_token', 'image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('whys', 'custom');
        }

        Why::create($data);

        return redirect()->route('why.index')->with('success', 'Why Choose Us section created successfully.');
    }


    public function edit(string $id)
    {
        $why = Why::findOrFail($id);

        return view('admin.whys.edit', compact('why'));
    }

    public function update(Request $request, string $id)
    {
        $why = Why::findOrFail($id);

        $validated = $request->validate([
            'title_en' => 'nullable|string|max:255',
            'title_km' => 'nullable|string|max:255',
            'title_ch' => 'nullable|string|max:255',
            'content_en' => 'nullable|string',
            'content_km' => 'nullable|string',
            'content_ch' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $data = $request->except('_token', 'image', '_method');

        if ($request->hasFile('image')) {

            // Delete old image
            if ($why->image && Storage::disk('custom')->exists($why->image)) {
                Storage::disk('custom')->delete($why->image);
            }

            // Store new image
            $data['image'] = $request->file('image')->store('whys', 'custom');
        }

        $update = $why->update($data);

        if ($update) {
            return redirect()->route('why.index')->with('success', 'Why Choose Us section updated successfully.');
        } else {
            return redirect()->route('why.edit')
                ->with('error', 'We could not update the Why Choose Us section. Please try again.')
                ->withInput();
        }
    }
}
