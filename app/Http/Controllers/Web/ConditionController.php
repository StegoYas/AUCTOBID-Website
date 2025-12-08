<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConditionController extends Controller
{
    /**
     * List all conditions
     */
    public function index(): View
    {
        $conditions = Condition::withCount('items')->orderBy('quality_rating', 'desc')->paginate(15);

        return view('conditions.index', compact('conditions'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('conditions.form', ['condition' => null]);
    }

    /**
     * Store condition
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:conditions,name',
            'description' => 'nullable|string|max:500',
            'quality_rating' => 'required|integer|min:1|max:10',
        ]);

        Condition::create($request->only(['name', 'description', 'quality_rating']));

        return redirect()->route('conditions.index')->with('success', 'Kondisi berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit(Condition $condition): View
    {
        return view('conditions.form', compact('condition'));
    }

    /**
     * Update condition
     */
    public function update(Request $request, Condition $condition): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:conditions,name,' . $condition->id,
            'description' => 'nullable|string|max:500',
            'quality_rating' => 'required|integer|min:1|max:10',
        ]);

        $condition->update($request->only(['name', 'description', 'quality_rating']));

        return redirect()->route('conditions.index')->with('success', 'Kondisi berhasil diperbarui.');
    }

    /**
     * Toggle active status
     */
    public function toggle(Condition $condition): RedirectResponse
    {
        $condition->update(['is_active' => !$condition->is_active]);

        $status = $condition->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Kondisi berhasil {$status}.");
    }

    /**
     * Delete condition
     */
    public function destroy(Condition $condition): RedirectResponse
    {
        if ($condition->items()->exists()) {
            return back()->with('error', 'Kondisi tidak dapat dihapus karena masih digunakan oleh item.');
        }

        $condition->delete();

        return redirect()->route('conditions.index')->with('success', 'Kondisi berhasil dihapus.');
    }
}
