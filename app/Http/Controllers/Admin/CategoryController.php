<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => true,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'required|boolean',
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->is_active,
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete a category that has products assigned to it.');
        }

        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
