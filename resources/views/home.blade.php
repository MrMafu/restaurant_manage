<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/321a0183ed.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const categories = @json($categories);
        const menus = @json($menus);
    </script>
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>
<body>
    <!-- Orders Modal -->
    <div id="modalOrders" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h2 class="text-2xl font-bold text-[#6B3109] mb-4 flex items-center">
                <i class="fa-solid fa-receipt mr-2"></i> Order Details
            </h2>

            <!-- Order Details Container -->
            <div id="orderDetails" class="flex flex-col gap-4"></div>

            <!-- Total Price -->
            <div class="flex justify-between items-center mt-4">
                <span class="font-bold text-lg">Total Price:</span>
                <span id="totalPrice" class="text-lg font-semibold text-green-600">Rp. 0,00</span>
            </div>

            <!-- Place Order Button -->
            <button
                id="placeOrderBtn"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full">
                Place Order
            </button>
        </div>
    </div>

    <!-- Header Section -->
    <header class="bg-white border-b sticky top-0 z-10">
        <div class="flex justify-between items-center px-6 py-4 w-full">
            <a href="{{ route('home') }}" class="text-xl font-bold text-[#6B3109] flex items-center">
                Restaurant<i class="fa-solid fa-utensils ml-2"></i>
            </a>

            <nav class="flex justify-end">
                <ul class="flex space-x-6 items-center">
                    @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <li>
                                <a href="{{ route('dashboard') }}" class="text-[#6B3109] hover:text-[#8b4513] transition">
                                    Dashboard<i class="fa-solid fa-database ml-2"></i>
                                </a>
                            </li>
                        @elseif(Auth::user()->role === 'staff')
                            <li>
                                <button id="openModal" class="text-[#6B3109] hover:text-[#8b4513] transition">
                                    Order<i class="fa-solid fa-receipt ml-2"></i>
                                </button>
                            </li>
                        @endif
                    @endif

                    <li class="h-6 border-l border-gray-300"></li>

                    @if(Auth::check())
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[#6B3109] hover:text-[#8b4513] transition">
                                    Log Out
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="text-[#6B3109] hover:text-[#8b4513] transition">
                                Log In
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <!-- Categories Section -->
    <section class="mt-4 px-6">
        <h2 class="text-2xl font-semibold mb-4">
            <i class="fa-solid fa-plate-wheat text-[#6B3109] mr-2"></i>Categories
        </h2>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach ($categories as $category)
                <button 
                    class="category-btn border px-4 py-1 rounded-full text-gray-500 border-gray-300 transition" 
                    data-category-id="{{ $category->id }}">
                    {{ $category->category_name }}
                </button>
            @endforeach
        </div>
    </section>

    <!-- Menus Section -->
    <section class="mt-8 px-6">
        <h2 class="text-2xl font-semibold mb-4">
            <i class="fa-solid fa-bell-concierge text-[#6B3109] mr-2"></i>All Menus
        </h2>
        <div id="menus-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($menus as $menu)
                <div class="bg-white border border-gray-300 rounded shadow-md p-4 flex flex-col">
                    <img 
                        src="{{ asset('storage/' . $menu->image) }}" 
                        alt="Menu Image" 
                        class="aspect-video w-full object-cover rounded mb-4" 
                        loading="lazy">
                    <p class="text-lg text-gray-600">Rp. {{ number_format($menu->price, 2) }}</p>
                    <h3 class="text-xl font-bold truncate mb-2">{{ $menu->name }}</h3>
                    <p class="text-gray-600 line-clamp-2 mb-4">{{ $menu->description }}</p>
                    <button
                        class="order-now mt-auto px-4 py-2 bg-[#6B3109] text-white rounded hover:bg-[#8b4513] transition"
                        data-id="{{ $menu->id }}"
                        data-name="{{ $menu->name }}"
                        data-price="{{ $menu->price }}">
                        Order Now
                    </button>
                </div>
            @endforeach
        </div>
    </section>
</body>
</html>