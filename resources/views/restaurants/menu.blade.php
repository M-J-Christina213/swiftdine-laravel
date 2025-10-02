
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Full Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    // AJAX helper
    async function ajaxCart(action, menu_id, quantity=1) {
        const response = await fetch("{{ route('cart.add') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                menu_id: menu_id,
                quantity: quantity,
                action: action
            }),
        });

        const data = await response.json();
        if (data.status === "success") {
            loadCart();
        } else {
            alert("Something went wrong.");
        }
    }

    async function loadCart() {
        const response = await fetch("{{ route('cart.index') }}");
        const html = await response.text();
        document.getElementById("cart-summary").innerHTML = html;
    }


    // On page load, load cart
    document.addEventListener('DOMContentLoaded', () => {
        loadCart();

        // Attach add to cart handlers
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const menuId = e.target.dataset.menuId;
                const qtyElem = document.querySelector(`#qty-${menuId}`);
                const quantity = parseInt(qtyElem.value) || 1;
                ajaxCart('add', menuId, quantity);
            });
        });

        // Attach quantity increment/decrement
        document.querySelectorAll('.qty-decrease').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const menuId = e.target.dataset.menuId;
                const qtyElem = document.querySelector(`#qty-${menuId}`);
                let val = parseInt(qtyElem.value) || 1;
                if(val > 1) val--;
                qtyElem.value = val;
            });
        });

        document.querySelectorAll('.qty-increase').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const menuId = e.target.dataset.menuId;
                const qtyElem = document.querySelector(`#qty-${menuId}`);
                let val = parseInt(qtyElem.value) || 1;
                val++;
                qtyElem.value = val;
            });
        });
    });
    </script>
</head>


<!-- Banner Section -->
<div class="relative h-[350px]">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://media.cntravellerme.com/photos/66cc5cb74871ab67bc593f1b/16:9/w_2560%2Cc_limit/ShoulldersByHarpos3.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div> <!-- Transparent dark overlay -->
    </div>

    <!-- Banner Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full px-10 text-center text-white">
        <h1 class="text-5xl font-extrabold mb-2">Where Flavor Meets Passion</h1>
        <p class="text-xl font-light italic">Delicious meals, made fresh for you</p>
    </div>
</div>

<!-- Nav, Cancel & Confirm -->
<div class="flex justify-between items-center px-6 py-4">
  <div class="flex gap-3">
    <a href="home.php" class="text-sm text-red-500 border border-red-500 px-4 py-2 rounded hover:bg-red-100">
      Cancel
    </a>
    <a href="restuarants.php" class="text-sm text-gray-600 hover:text-black flex items-center">
      <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg> Back
    </a>
    
  </div>

  <a href="checkout.php" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
    Proceed to Cart →
  </a>
</div>


<!-- Step Progress Section -->
<div class="flex items-center justify-center mt-12 px-10">
    
    <!-- Step 1 and 2 -->
    <div class="flex gap-6 items-center text-white">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                <span class="text-sm mt-1 text-orange-500">Discover</span>
            </div>
            <div class="w-16 h-1 bg-orange-500"></div>
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                <span class="text-sm mt-1 text-orange-500">View Restaurant</span>
            </div>
            <div class="w-16 h-1 bg-orange-500"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold">3</div>
                <span class="text-sm mt-1 text-black">Menu</span>
            </div>
            <div class="h-1 w-14 bg-black"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">4</div>
                <span class="text-sm mt-1 text-black">Cart</span>
            </div>
             <div class="h-1 w-14 bg-black"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">5</div>
                <span class="text-sm mt-1 text-black">Checkout</span>
            </div>
             <div class="h-1 w-14 bg-black"></div>
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold">6</div>
                <span class="text-sm mt-1 text-black">Confirmation</span>
            </div>


        </div>
        
    
</div>
<!-- Main Container -->
<div class="flex flex-col lg:flex-row max-w-7xl mx-auto p-6 gap-6">

    <!-- Menu Items Section -->
    <div class="flex-1">
        <h1 class="text-4xl font-bold text-orange-600 mb-6">Full Menu</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($menus as $menu): ?>
                <div class="bg-white rounded-2xl shadow hover:shadow-xl transition p-4 flex flex-col">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $menu->image_url) }}" 
                            alt="{{ $menu->name }}" 
                            class="w-full h-48 object-cover rounded-lg">
                        <span class="absolute top-2 right-2 bg-orange-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                            Rs {{ number_format($menu->price, 2) }}
                        </span>
                    </div>

                    <div class="mt-4 flex flex-col flex-grow">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $menu->name }}</h3>
                        <p class="text-gray-500 text-sm flex-grow">{{ $menu->description }}</p>

                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center border rounded-lg">
                                <button data-menu-id="{{ $menu->id }}" 
                                        class="qty-decrease px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                <input id="qty-{{ $menu->id }}" 
                                    type="number" min="1" value="1" 
                                    class="w-12 text-center border-0">
                                <button data-menu-id="{{ $menu->id }}" 
                                        class="qty-increase px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                            </div>

                            <button data-menu-id="{{ $menu->id }}" 
                                    class="add-to-cart-btn bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg shadow">
                                Add +
                            </button>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>

    <!-- Order Summary Sidebar -->
    <div id="cart-summary" class="w-full lg:w-96 bg-white rounded-lg shadow-lg p-6 sticky top-6 self-start">
        <!-- Cart summary will load here by AJAX -->
        <h2 class="text-2xl font-bold mb-4 text-orange-600">Order Summary</h2>
        <p>Loading your cart...</p>
    </div>
    
</div>
</body>
</html>