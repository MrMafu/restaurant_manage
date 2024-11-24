<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/321a0183ed.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-5 bg-white rounded-lg shadow-md mx-auto">
        <h2 class="text-3xl font-semibold text-center text-[#6B3109] mb-5">Create a Menu</h2>

        <form method="POST" action="{{ route('menus.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Menu Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                
                @error('name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" required step="0.01" 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                
                @error('price')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" required 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">{{ old('description') }}</textarea>
                
                @error('description')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                @error('image')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" required 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" 
                    class="w-full px-4 py-2 text-white bg-[#6B3109] rounded-md hover:bg-[#562707] focus:outline-none focus:ring-2 focus:ring-[#6B3109] transition duration-200 ease-in-out">
                    Create Menu
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                <a href="{{ route('dashboard') }}" class="text-[#6B3109] hover:text-[#562707] font-semibold">Back to Dashboard</a>
            </p>
        </div>
    </div>
</body>
</html>