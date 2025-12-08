<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * List all categories
     */
    public function index(): View
    {
        $categories = Category::withCount('items')->orderBy('name')->paginate(15);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('categories.form', ['category' => null]);
    }

    /**
     * Store category
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        Category::create($request->only(['name', 'description', 'icon']));

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit(Category $category): View
    {
        return view('categories.form', compact('category'));
    }

    /**
     * Update category
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        $category->update($request->only(['name', 'description', 'icon']));

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Toggle active status
     */
    public function toggle(Category $category): RedirectResponse
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Kategori berhasil {$status}.");
    }

    /**
     * Delete category
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->items()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki item.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
