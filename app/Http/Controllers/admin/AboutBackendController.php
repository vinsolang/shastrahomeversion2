<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutBackendController extends Controller
{
    private const SECTION_ORDER = [
        'overview',
        'vision',
        'mission',
        'core-values',
        'reliability',
        'quality-assurance',
        'elevated-standards',
        'long-term-value',
        'founder',
        'company-profile',
    ];

    public function index()
    {
        $abouts = About::query()
            ->orderByRaw($this->sectionOrderCaseSql())
            ->orderBy('id')
            ->get();

        return view('admin.abouts.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.abouts.create');
    }

    public function store(Request $request)
    {
        // In store(), validate section_key separately:
        $request->validate([
            'section_key' => 'required|string|max:100|unique:abouts,section_key',
        ]);
        $data = $this->syncUploads($request, $this->validatedData($request));
        
        // section_key must come from the form or be set explicitly
        $data['section_key'] = $request->input('section_key'); // ← ADD THIS

        About::query()->create($data);

        return redirect()->route('about.index')->with('success', 'About section created successfully.');
    }

    public function edit(string $id)
    {
        $about = About::findOrFail($id);

        return view('admin.abouts.edit', compact('about'));
    }

    public function update(Request $request, string $id)
    {
        $about = About::findOrFail($id);
        $data = $this->syncUploads($request, $this->validatedData($request), $about);

        $update = $about->update($data);

        if ($update) {
            return redirect()->route('about.index')->with('success', 'About section updated successfully.');
        } else {
            return redirect()->route('about.edit', $about->id)
                ->with('error', 'We could not update the about section. Please try again.')
                ->withInput();
        }
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            // ← Remove section_key entirely — it must never be overwritten
            'title_en' => 'nullable|string|max:255',
            'title_km' => 'nullable|string|max:255',
            'title_ch' => 'nullable|string|max:255',

            'content1_en' => 'nullable|string',
            'content1_km' => 'nullable|string',
            'content1_ch' => 'nullable|string',

            'content2_en' => 'nullable|string',
            'content2_km' => 'nullable|string',
            'content2_ch' => 'nullable|string',

            'content3_en' => 'nullable|string',
            'content3_km' => 'nullable|string',
            'content3_ch' => 'nullable|string',

            'content4_en' => 'nullable|string',
            'content4_km' => 'nullable|string',
            'content4_ch' => 'nullable|string',

            'content5_en' => 'nullable|string',
            'content5_km' => 'nullable|string',
            'content5_ch' => 'nullable|string',

            'pdf_file' => 'nullable|file|mimes:pdf|max:30720',
            'image_file' => 'nullable|image|max:5120',
        ], [
            'pdf_file.max' => 'The PDF file must not be larger than 30MB.',
            'pdf_file.mimes' => 'Only PDF files are allowed.',
            'image_file.max' => 'Image must not exceed 5MB.',
        ]);
    }

    private function syncUploads(Request $request, array $data, ?About $about = null): array
    {
        unset($data['pdf_file'], $data['image_file']);

        if ($request->hasFile('pdf_file')) {
            $this->deleteExistingAsset($about?->pdf_path);
            $data['pdf_path'] = $request->file('pdf_file')->store('abouts/pdfs', 'custom');
        }

        if ($request->hasFile('image_file')) {
            $this->deleteExistingAsset($about?->image_path);
            $data['image_path'] = $request->file('image_file')->store('abouts/images', 'custom');
        }

        return $data;
    }

    private function deleteExistingAsset(?string $path): void
    {
        if (! is_string($path) || $path === '' || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        if (Storage::disk('custom')->exists($path)) {
            Storage::disk('custom')->delete($path);
        }
    }

    private function sectionOrderCaseSql(): string
    {
        $clauses = [];

        foreach (self::SECTION_ORDER as $index => $sectionKey) {
            $clauses[] = "WHEN '{$sectionKey}' THEN ".($index + 1);
        }

        return 'CASE section_key '.implode(' ', $clauses).' ELSE 999 END';
    }
}
