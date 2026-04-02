<?php

namespace App\Http\Controllers\admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('order')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create'); // Your Blade form
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except('_token', 'image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('clients', 'custom');
        }

        $data['order'] = Client::max('order') + 1;

        $i = Client::create($data); // Use create instead of insert

        return $i
            ? redirect()->route('client.index')->with('success', 'Client logo added successfully.')
            : redirect()->back()->with('error', 'We could not add the client logo. Please try again.')->withInput();
    }

    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = $request->except('_token', '_method', 'image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($client->image && Storage::disk('custom')->exists($client->image)) {
                Storage::disk('custom')->delete($client->image);
            }

            // Store new one
            $data['image'] = $request->file('image')->store('clients', 'custom');
        }

        $i = $client->update($data);

        return $i
            ? redirect()->route('client.index')->with('success', 'Client logo updated successfully.')
            : redirect()->back()->with('error', 'We could not update the client logo. Please try again.')->withInput();
    }

    public function reorder(Request $request)
    {
        $newOrder = $request->newOrder;

        foreach ($newOrder as $item) {
            Client::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function delete(string $id)
    {
        $client = Client::findOrFail($id);
        if ($client->image && Storage::disk('custom')->exists($client->image)) {
            Storage::disk('custom')->delete($client->image);
        }

        $deleted = $client->delete();

        return $deleted
            ? redirect()->route('client.index')->with('success', 'Client logo deleted successfully.')
            : redirect()->back()->with('error', 'We could not delete the client logo. Please try again.');
    }
}
