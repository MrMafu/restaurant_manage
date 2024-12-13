<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->get();
        return view('dashboard', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:menus,name',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
                'category_id' => 'required|exists:categories,id',
            ]);

            $validated['image'] = $request->file('image')->store('menu_images', 'public');

            Menu::create($validated);

            return redirect()
                ->route('dashboard', ['view' => 'menus'])
                ->with('success', 'Menu created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors('Failed to create the menu. Please try again.');
        }
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:menus,name,' . $menu->id,
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
                'category_id' => 'required|exists:categories,id',
            ]);

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($menu->image);
                $validated['image'] = $request->file('image')->store('menu_images', 'public');
            }

            $menu->update($validated);

            return redirect()
                ->route('dashboard', ['view' => 'menus'])
                ->with('success', 'Menu updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors('Failed to update the menu. Please try again.');
        }
    }

    public function destroy(Menu $menu)
    {
        try {
            Storage::disk('public')->delete($menu->image);
            $menu->delete();

            return redirect()
                ->route('dashboard', ['view' => 'menus'])
                ->with('success', 'Menu deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('dashboard', ['view' => 'menus'])
                ->withErrors('Failed to delete the menu. Please try again.');
        }
    }
}