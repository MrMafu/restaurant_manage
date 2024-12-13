document.addEventListener("DOMContentLoaded", () => {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const menusContainer = document.getElementById('menus-container');
    let selectedCategoryId = null;

    categoryButtons.forEach(button => {
        console.log(button.dataset.categoryId);

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
        return price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
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
                    <button
                        class="mt-auto px-4 py-2 bg-[#6B3109] text-white rounded hover:bg-[#8b4513] transition"
                        data=${JSON.stringify(menu)}
                        data-id="${menu.id}"
                        data-name="${menu.name}"
                        data-price="${menu.price}">
                        Order Now
                    </button>
                </div>`;
            menusContainer.innerHTML += menuHTML;
        });
    }
    renderMenus(menus);

    console.log(menus);

    const cart = [];

    document.getElementById("openModal").addEventListener("click", () => {
        document.getElementById("modalOrders").classList.remove("hidden");
    });

    document.getElementById("closeModal").addEventListener("click", () => {
        document.getElementById("modalOrders").classList.add("hidden");
    });

    document.addEventListener("click", (event) => {
        if (event.target.matches(".order-now")) {
            const button = event.target;
            console.log("Button clicked:", button);
            const menuId = button.dataset.id;
            const menuName = button.dataset.name;
            const menuPrice = parseFloat(button.dataset.price);
            
            console.log("Menu details:", { menuId, menuName, menuPrice });

            console.log(button.dataset);

            const existingItem = cart.find((item) => item.menuId === menuId);

            if (existingItem) {
                Swal.fire("Item already in the cart!", "", "info");
                return;
            }

            cart.push({
                menu_id: menuId,
                name: menuName,
                price: menuPrice,
                quantity: 1,
                subtotal: menuPrice,
            });

            console.log("Updated cart:", cart);
            updateCartUI();
        }
    });

    function updateCartUI() {
        const orderDetails = document.getElementById("orderDetails");
        orderDetails.innerHTML = "";

        let totalPrice = 0;

        cart.forEach((item, index) => {
            const orderItemHTML = `
                <div class="order-item mb-4">
                    <div class="flex items-start">
                        <div class="w-full">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-lg font-semibold">${item.name}</p>
                                    <p class="text-gray-600">Rp. ${formatPrice(item.price)}</p>
                                </div>
                                <div class="flex items-center gap-5">
                                    <div class="flex items-center">
                                        <button data-index="${index}" class="decrement-btn w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">-</button>
                                        <input 
                                            type="number" 
                                            value="${item.quantity}" 
                                            class="quantity-input w-8 h-8 text-center border border-gray-300 rounded mx-2" 
                                            readonly>
                                        <button data-index="${index}" class="increment-btn w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300">+</button>
                                    </div>
                                    <button data-index="${index}" class="remove-btn text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash text-xl"></i>
                                    </button>
                                </div>
                            </div>
                            <p class="text-gray-600">Subtotal: Rp. ${formatPrice(item.subtotal)}</p>
                        </div>
                    </div>
                </div>
            `;
            orderDetails.innerHTML += orderItemHTML;
            totalPrice += item.subtotal;
        });

        document.getElementById("totalPrice").textContent = `Rp. ${formatPrice(totalPrice)}`;
    }

    document.getElementById("orderDetails").addEventListener("click", (event) => {
        const index = parseInt(event.target.dataset.index, 10);

        if (event.target.matches(".increment-btn")) {
            cart[index].quantity++;
            cart[index].subtotal = cart[index].quantity * cart[index].price;
            updateCartUI();
        } else if (event.target.matches(".decrement-btn")) {
            if (cart[index].quantity > 1) {
                cart[index].quantity--;
                cart[index].subtotal = cart[index].quantity * cart[index].price;
                updateCartUI();
            }
        } else if (event.target.matches(".remove-btn")) {
            cart.splice(index, 1);
            updateCartUI();
        }
    });

    function submitOrder() {
        Swal.fire({
            title: "Enter Customer Name",
            input: "text",
            inputPlaceholder: "Customer Name",
            showCancelButton: true,
            confirmButtonText: "Place Order",
        }).then((result) => {
            if (result.isConfirmed && result.value.trim()) {
                const customerName = result.value;

                const payload = {
                    customer_name: customerName,
                    items: cart.map((item) => ({
                        menu_id: item.menu_id,
                        quantity: item.quantity,
                    })),
                };

                fetch("/orders", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify(payload),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.message) {
                            Swal.fire(data.message, "", "success");
                            cart.length = 0;
                            updateCartUI();
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error)
                        Swal.fire("Failed to place order.", "", "error");
                    });
            } else if (!result.value.trim()) {
                Swal.fire("Customer name is required!", "", "error");
            }
        });
    }
});