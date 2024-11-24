<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/321a0183ed.js" crossorigin="anonymous"></script>
</head>
<body class="p-6 bg-gray-50">
    <h1 class="text-2xl font-bold text-[#6B3109] mb-6">Restaurant Dashboard <i class="fa-solid fa-database"></i></h1>

    <div class="mb-6">
        <a href="{{ route('home') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-[#6B3109] hover:text-white transition duration-300 ease-in-out">Back to Home</a>
    </div>

    <div class="flex justify-center space-x-4 mb-4">
        <a href="{{ route('dashboard', ['view' => 'users']) }}"
            class="px-4 py-2 {{ request('view') === 'users' ? 'bg-[#6B3109] text-white' : 'bg-gray-200 hover:bg-[#6B3109] hover:text-white transition duration-300 ease-in-out' }} rounded">
            Users
        </a>
        <a href="{{ route('dashboard', ['view' => 'categories']) }}"
            class="px-4 py-2 {{ request('view') === 'categories' ? 'bg-[#6B3109] text-white' : 'bg-gray-200 hover:bg-[#6B3109] hover:text-white transition duration-300 ease-in-out' }} rounded">
            Categories
        </a>
        <a href="{{ route('dashboard', ['view' => 'menus']) }}"
            class="px-4 py-2 {{ request('view') === 'menus' ? 'bg-[#6B3109] text-white' : 'bg-gray-200 hover:bg-[#6B3109] hover:text-white transition duration-300 ease-in-out' }} rounded">
            Menus
        </a>
    </div>

    @if (request('view') === 'users')
        <h2 class="text-xl font-semibold mb-2">Users Table</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Username</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Role</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $user->id }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $user->username }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $user->role }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300 ease-in-out text-center">
                                Edit
                            </a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-block px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300 ease-in-out text-center"
                                    onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif (request('view') === 'categories')
        <h2 class="text-xl font-semibold mb-2">Categories Table</h2>
        <a href="{{ route('categories.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition duration-300 ease-in-out text-center">Create a Category</a>
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Category Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $category->id }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $category->category_name }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('categories.edit', $category->id) }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300 ease-in-out text-center">Edit</a>
                            
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300 ease-in-out text-center" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif (request('view') === 'menus')
        <h2 class="text-xl font-semibold mb-2">Menus Table</h2>
        <a href="{{ route('menus.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition duration-300 ease-in-out text-center">Create a Menu</a>
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Menu Name</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Price</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Description</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Image</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Category ID</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $menu->id }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $menu->name }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $menu->price }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $menu->description }}</td>
                        <td class="border border-gray-300 px-4 py-2 flex justify-center">
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Menu Image" class="max-w-xs h-auto">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $menu->category_id }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('menus.edit', $menu->id) }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300 ease-in-out text-center">Edit</a>

                            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300 ease-in-out text-center" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center text-gray-500">Please select a table to view.</p>
    @endif
</body>
</html>