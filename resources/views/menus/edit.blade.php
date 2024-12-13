<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit a Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/321a0183ed.js" crossorigin="anonymous"></script>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="flex flex-col items-center space-y-5 w-full max-w-md">
        @if ($errors->any())
            <div class="w-full p-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="w-full p-5 bg-white rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-center text-[#6B3109] mb-5">Edit Menu</h2>

            <form method="POST" action="{{ route('menus.update', $menu->id) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Menu Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" required
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $menu->price) }}" required step="0.01"
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" required
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">{{ old('description', $menu->description) }}</textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image"
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                    @if ($menu->image)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Current Menu Image" class="max-h-40 rounded-lg">
                        </div>
                    @endif
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" required
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (old('category_id', $menu->category_id) == $category->id) ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="w-full px-4 py-2 text-white bg-[#6B3109] rounded-md hover:bg-[#562707] focus:outline-none focus:ring-2 focus:ring-[#6B3109] transition duration-200 ease-in-out">
                        Update Menu
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('dashboard') }}" class="text-sm text-[#6B3109] hover:text-[#562707] font-semibold">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>