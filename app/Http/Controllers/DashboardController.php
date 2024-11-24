<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $view = request('view');

        $users = ($view === 'users') ? User::all() : [];
        $categories = ($view === 'categories') ? Category::all() : [];
        $menus = ($view === 'menus') ? Menu::with('category')->get() : [];

        return view('dashboard', compact('users', 'categories', 'menus'));
    }
}