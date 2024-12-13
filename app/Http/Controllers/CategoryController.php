<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboard', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories',
        ], [
            'category_name.required' => 'The category name is required.',
            'category_name.unique' => 'This category name already exists.',
            'category_name.max' => 'The category name cannot exceed 255 characters.',
        ]);

        try {
            Category::create(['category_name' => trim($request->category_name)]);
            return redirect()
                ->route('dashboard', ['view' => 'categories'])
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors('An error occurred while creating the category. Please try again.');
        }
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->id,
        ], [
            'category_name.required' => 'The category name is required.',
            'category_name.unique' => 'This category name already exists.',
            'category_name.max' => 'The category name cannot exceed 255 characters.',
        ]);

        try {
            $category->update(['category_name' => trim($request->category_name)]);
            return redirect()
                ->route('dashboard', ['view' => 'categories'])
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors('An error occurred while updating the category. Please try again.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()
                ->route('dashboard', ['view' => 'categories'])
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors('An error occurred while deleting the category. Please try again.');
        }
    }
}