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
        $menus = Menu::all();
        return view('dashboard', compact('menus'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $request->file('image')->store('menu_images', 'public');

        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard', ['view' => 'menus'])->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($menu->image);

            $menu->image = $request->file('image')->store('menu_images', 'public');
        }

        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $menu->image,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard', ['view' => 'menus'])->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        Storage::disk('public')->delete($menu->image);

        $menu->delete();

        return redirect()->route('dashboard', ['view' => 'menus'])->with('success', 'Menu deleted successfully.');
    }
}