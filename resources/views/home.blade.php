<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/321a0183ed.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            <div id="orderDetails">
                <div class="order-item mb-4">
                    <div class="flex items-start">
                        <img src="https://i.pinimg.com/564x/5c/a1/42/5ca142d34fd1903773b4f4e6f43d9045.jpg" alt="Menu 1" class="w-20 h-20 object-cover rounded mr-4">
                    
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">Menu 1</p>
                                    <p class="text-gray-600">Rp. 50,000</p>
                                </div>

                                <div class="flex items-center gap-5">
                                    <div class="flex items-center">
                                        <button class="decrementBtn w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>

                                        <input 
                                            type="number" 
                                            value="1" 
                                            class="quantityInput w-8 h-8 text-center border border-gray-300 rounded mx-2" 
                                            readonly>

                                        <button class="incrementBtn w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>

                                    <button class="text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash text-xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button
                onclick="submitOrder()"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full">
                Place Order
            </button>
        </div>
    </div>

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

    <section class="mt-4 px-6">
        <h2 class="text-2xl font-semibold mb-4"><i class="fa-solid fa-plate-wheat text-[#6B3109] mr-2"></i>Categories</h2>
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

    <section class="mt-8 px-6">
        <h2 class="text-2xl font-semibold mb-4"><i class="fa-solid fa-bell-concierge text-[#6B3109] mr-2"></i>All Menus</h2>
        <div id="menus-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- @foreach ($menus as $menu)
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
                        class="mt-auto px-4 py-2 bg-[#6B3109] text-white rounded hover:bg-[#8b4513] transition"
                        data-id="{{ $menu->id }}"
                        data-name="{{ $menu->name }}"
                        data-price="{{ $menu->price }}"
                        id="orderButton{{ $menu->id }}">
                        Order Now
                    </button>

                </div>
            @endforeach --}}
        </div>
    </section>
</body>
<script>
    // Category buttons and filtering logic
    const categories = @json($categories);
    const menus = @json($menus);

    const categoryButtons = document.querySelectorAll('.category-btn');
    const menusContainer = document.getElementById('menus-container');
    let selectedCategoryId = null;

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            const categoryId = button.dataset.categoryId;

            if (selectedCategoryId === categoryId) {
                selectedCategoryId = null;
                button.classList.remove('text-[#6B3109]', 'border-[#6B3109]');
                button.classList.add('text-gray-500', 'border-gray-300');
                renderMenus(menus);
            } else {
                categoryButtons.forEach(btn => {
                    btn.classList.remove('text-[#6B3109]', 'border-[#6B3109]');
                    btn.classList.add('text-gray-500', 'border-gray-300');
                });

                selectedCategoryId = categoryId;
                button.classList.remove('text-gray-500', 'border-gray-300');
                button.classList.add('text-[#6B3109]', 'border-[#6B3109]');

                const filteredMenus = menus.filter(menu => menu.category_id == categoryId);
                renderMenus(filteredMenus);
            }
        });
    });

    function formatPrice(price) {
        return price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,' );
    }

    function renderMenus(menuList) {
        menusContainer.innerHTML = '';
        menuList.forEach(menu => {
            const menuHTML = `
                <div class="menu-item bg-white border border-gray-300 rounded shadow-md p-4 flex flex-col">
                    <img 
                        src="/storage/${menu.image}" 
                        alt="Menu Image" 
                        class="aspect-video w-full object-cover rounded mb-4">
                    <p class="text-lg text-gray-600">Rp. ${formatPrice(parseFloat(menu.price))}</p>
                    <h3 class="text-xl font-bold truncate mb-2">${menu.name}</h3>
                    <p class="text-gray-600 line-clamp-2 mb-4">${menu.description}</p>
                    <button data=${JSON.stringify(menu)} class="mt-auto px-4 py-2 bg-[#6B3109] text-white rounded hover:bg-[#8b4513] transition">
                        Order Now
                    </button>
                </div>`;
            menusContainer.innerHTML += menuHTML;
        });
    }
    renderMenus(menus);

    const orders = [];
    const modalOrders = document.getElementById("modalOrders");
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");

    // Modal functionality
    openModal.addEventListener("click", () => {
        modalOrders.classList.remove("hidden");
        displayOrderDetails();
    });

    closeModal.addEventListener("click", () => {
        modalOrders.classList.add("hidden");
    });

    modalOrders.addEventListener("click", (e) => {
        if (e.target === modalOrders) {
            modalOrders.classList.add("hidden");
        }
    });
    
    console.log(document.querySelectorAll("button[data]"));
    document.querySelectorAll("button[data]").forEach((btn) => {
        btn.addEventListener("click", () => {
            console.log(btn);
            
            const menuId = btn.dataset.id;
            const name = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);

            const existingItem = orders.find((order) => order.menu_id === menuId);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                orders.push({ menu_id: menuId, name, price, quantity: 1 });
            }

            Swal.fire({
                icon: "success",
                title: "Added to Order",
                text: `${name} has been added to your order.`,
            });
        });
    });


    // Render order details in the modal
    function displayOrderDetails() {
        const orderDetails = document.getElementById("orderDetails");
        orderDetails.innerHTML = "";

        orders.forEach((order, index) => {
            const subtotal = (order.price * order.quantity).toFixed(2);

            const orderItem = `
                <div class="order-item mb-4">
                    <div class="flex items-start">
                        <img
                            src="https://via.placeholder.com/100"
                            alt="${order.name}"
                            class="w-20 h-20 object-cover rounded mr-4"
                        />
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">${order.name}</p>
                                    <p class="text-gray-600">Rp. ${subtotal}</p>
                                </div>

                                <div class="flex items-center gap-5">
                                    <div class="flex items-center">
                                        <button onclick="decrementQuantity(${index})" class="decrementBtn w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>

                                        <input
                                            type="number"
                                            value="${order.quantity}"
                                            class="quantityInput w-8 h-8 text-center border border-gray-300 rounded mx-2"
                                            readonly
                                        />

                                        <button onclick="incrementQuantity(${index})" class="incrementBtn w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>

                                    <button onclick="removeOrderItem(${index})" class="text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash text-xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            orderDetails.innerHTML += orderItem;
        });
    }

    function incrementQuantity(index) {
        orders[index].quantity += 1;
        displayOrderDetails();
    }

    function decrementQuantity(index) {
        if (orders[index].quantity > 1) {
            orders[index].quantity -= 1;
        } else {
            orders.splice(index, 1);
        }
        displayOrderDetails();
    }

    function removeOrderItem(index) {
        orders.splice(index, 1);
        displayOrderDetails();
    }

    // Submit order to backend
    async function submitOrder() {
        const customerName = prompt("Please enter the customer name:");
        if (!customerName) {
            Swal.fire({
                icon: "warning",
                title: "Customer Name Required",
                text: "Please enter the customer name to proceed.",
            });
            return;
        }

        const payload = {
            customer_name: customerName,
            items: orders.map((order) => ({
                menu_id: order.menu_id,
                quantity: order.quantity,
            })),
        };

        try {
            const response = await fetch("{{ route('order.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify(payload),
            });

            if (response.ok) {
                const data = await response.json();
                Swal.fire({
                    icon: "success",
                    title: "Order Placed Successfully",
                    text: `Order ID: ${data.order_id}`,
                });
                orders.length = 0;
                modalOrders.classList.add("hidden");
            } else {
                const error = await response.json();
                Swal.fire({
                    icon: "error",
                    title: "Order Failed",
                    text: error.message || "An unexpected error occurred.",
                });
            }
        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Order Failed",
                text: error.message || "An unexpected error occurred.",
            });
        }
    }
</script>
</html>