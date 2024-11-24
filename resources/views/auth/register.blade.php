<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-5 bg-white rounded-lg shadow-md sm:w-11/12 md:w-1/3">
        <h2 class="text-3xl font-semibold text-center text-[#6B3109] mb-5">Register</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" required class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
            </div>

            <div>
                <button type="submit" class="w-full px-4 py-2 text-white bg-[#6B3109] rounded-md hover:bg-[#562707] focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 ease-in-out">
                    Register
                </button>
            </div>
        </form>    

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">Already have an account? 
                <a href="{{ route('login') }}" class="text-[#6B3109] hover:text-[#562707] font-semibold">Log In here</a>
            </p>
        </div>
    </div>
</body>
</html>