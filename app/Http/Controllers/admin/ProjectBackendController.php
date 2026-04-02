<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectBackendController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->with('category');

        $search = trim((string) $request->input('search', ''));
        if ($search !== '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $categoryId = (string) $request->input('category', '');
        if ($categoryId !== '') {
            $query->where('category_id', $categoryId);
        }

        $projects = $query->latest()->paginate(10);
        $categories = Category::query()->orderBy('created_at')->get();

        return view('admin.project.index', compact('projects', 'categories'));
    }

    public function create(): View
    {
        $cats = Category::query()->orderBy('created_at')->get();
        return view('admin.project.create', compact('cats'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $imagePaths = $this->storeImages($request->file('images', []));
        $data = $request->safe()->only([
            'name',
            'desc',
            'location',
            'specifications',
            'category_id',
        ]);

        Product::create([
            ...$data,
            'images' => $imagePaths,
        ]);

        return redirect()->route('project_backend.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Product $project_backend): View
    {
        $cats = Category::query()->orderBy('created_at')->get();
        return view('admin.project.edit', compact('project_backend', 'cats'));
    }

    public function update(UpdateProjectRequest $request, Product $project_backend): RedirectResponse
    {
        $existingImages = collect($project_backend->images ?? [])
            ->filter(static fn (mixed $path): bool => is_string($path) && $path !== '')
            ->values();
        $retainedImages = $existingImages
            ->intersect(
                collect($request->input('old_images', []))
                    ->filter(static fn (mixed $path): bool => is_string($path) && $path !== '')
            )
            ->values()
            ->all();
        $removedImages = array_values(array_diff($existingImages->all(), $retainedImages));
        $newImages = $this->storeImages($request->file('images', []));
        $data = $request->safe()->only([
            'name',
            'desc',
            'location',
            'specifications',
            'category_id',
        ]);

        $this->deleteStoredImages($removedImages);

        $project_backend->update([
            ...$data,
            'images' => [...$retainedImages, ...$newImages],
        ]);

        return redirect()->route('project_backend.index')
            ->with('success', 'Project updated successfully.');
    }

    public function delete(Product $project_backend): RedirectResponse
    {
        $this->deleteStoredImages($project_backend->images ?? []);

        $project_backend->delete();

        return back()->with('success', 'Project deleted successfully.');
    }

    /**
     * @param  array<int, UploadedFile>|UploadedFile|null  $files
     * @return array<int, string>
     */
    private function storeImages(array|UploadedFile|null $files): array
    {
        $fileList = $files instanceof UploadedFile
            ? [$files]
            : ($files ?? []);

        return collect($fileList)
            ->filter(static fn (mixed $file): bool => $file instanceof UploadedFile)
            ->map(fn (UploadedFile $file): string => $file->store('projects', 'public'))
            ->values()
            ->all();
    }

    /**
     * @param  iterable<int, mixed>  $paths
     */
    private function deleteStoredImages(iterable $paths): void
    {
        collect($paths)
            ->filter(static fn (mixed $path): bool => is_string($path) && $path !== '')
            ->each(static fn (string $path): bool => Storage::disk('public')->delete($path));
    }
}
