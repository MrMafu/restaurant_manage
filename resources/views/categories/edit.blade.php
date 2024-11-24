<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit a Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/321a0183ed.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-5 bg-white rounded-lg shadow-md sm:w-11/12 md:w-1/3 mx-auto">
        <h2 class="text-3xl font-semibold text-center text-[#6B3109] mb-5">Edit Category</h2>

        <form method="POST" action="{{ route('categories.update', ['category' => $category->id]) }}" class="space-y-5">
            @csrf
            @method('put')

            <div>
                <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" name="category_name" id="category_name" value="{{ $category->category_name }}" required 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
                
                @error('category_name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" 
                    class="w-full px-4 py-2 text-white bg-[#6B3109] rounded-md hover:bg-[#562707] focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 ease-in-out">
                    Update Category
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