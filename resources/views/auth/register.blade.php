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
    <div class="flex flex-col items-center space-y-5 w-full max-w-md">
        @if (session('success'))
            <div class="w-full p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded">
                {{ session('success') }}
            </div>
        @else
            @if ($errors->any())
                <div class="w-full p-4 text-sm text-red-700 bg-red-100 border border-red-200 rounded">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        @endif

        <!-- Register Form -->
        <div class="w-full max-w-md p-5 bg-white rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-center text-[#6B3109] mb-5">Register</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" required value="{{ old('username') }}" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:ring-[#6B3109] focus:border-[#6B3109] focus:outline-none transition duration-200 ease-in-out">
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
    </div>
</body>
</html>