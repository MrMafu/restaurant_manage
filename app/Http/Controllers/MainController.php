<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class MainController extends Controller
{
    public function home()
    {
        $categories = Cache::remember('categories', 60, function () {
            return Category::all();
        });

        $menus = Cache::remember('menus', 60, function () {
            return Menu::with('category')->get();
        });

        return view('home', compact('categories', 'menus'));
    }

    public function filterMenus($categoryId)
    {
        $cacheKey = $categoryId == 0 ? 'all_menus' : "menus_category_{$categoryId}";

        $menus = Cache::remember($cacheKey, 60, function () use ($categoryId) {
            return $categoryId == 0
                ? Menu::with('category')->get()
                : Menu::with('category')->where('category_id', $categoryId)->get();
        });

        return response()->json(['menus' => $menus]);
    }
}