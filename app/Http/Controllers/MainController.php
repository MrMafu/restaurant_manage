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
        $categories = Category::all();
        $menus = Menu::all();

        return view('home', compact('categories', 'menus'));
    }

    public function filterMenus($categoryId)
    {
        $cacheKey = $categoryId == 0 ? 'all_menus' : "menus_category_{$categoryId}";

        $menus = Cache::remember($cacheKey, 60, function () use ($categoryId) {
            if ($categoryId == 0) {
                return Menu::all();
            } else {
                return Menu::where('category_id', $categoryId)->get();
            }
        });

        return response()->json(['menus' => $menus]);
    }
}