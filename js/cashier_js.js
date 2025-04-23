// Data structures to hold application state
// let inventory = [
//     { id: 1, name: "Pandesal", category: "Bread", stock: 55, price: 1.00 },
//     { id: 11, name: "Strawberry Shake", category: "Drinks", stock: 0, price: 59.00 },
//     { id: 15, name: "Chocolate Muffin", category: "Pastry", stock: 10, price: 59.00 }
// ];

// let cart = [];

// let currentOrders = [
//     { 
//         id: 54, 
//         items: [
//             { productId: 1, name: "Pandesal", quantity: 5, price: 1.00 },
//             { productId: 15, name: "Chocolate Muffin", quantity: 1, price: 59.00 }
//         ],
//         date: "2025-04-21", 
//         customerName: "John", 
//         employeeName: "Neigar", 
//         status: "In progress"
//     }
// ];

// DOM Elements
// 

// Initialize the application

let preDate = new Date();
let m = '' + (preDate.getMonth() + 1);
let d = '' + (preDate.getDate());
let y = '' + preDate.getFullYear();

if (m.length < 2){
    m = '0' + m;
}
if (d.length < 2){
    d = '0' + d;
}

let fullDate = [y, m, d].join('-');

addEventListener('DOMContentLoaded', loadProductTable);

function loadProductTable(){
    fetch('../api/products_api.php')
    .then(response => response.json())
    .then(data => {
        let productTableBody = document.querySelector("#productTableBody");
        productTableBody.innerHTML = "";

        if (data.status === "success"){
            data.product.forEach(prod => {
                productTableBody.innerHTML += `
                    <tr onclick="addProductOrder(${prod.product_ID}, '${prod.product_name}', ${prod.stock_quantity}, ${prod.product_price})">
                        <td>${prod.product_name}</td>
                        <td>${capitalize(prod.product_category)}</td>
                        <td>${prod.stock_quantity}</td>
                        <td>₱ ${prod.product_price}</td>
                    </tr>
                `
            })
        } else {
            productTableBody.innerHTML = `
                <tr>
                    <td>Product Table Empty</td>
                </tr>
            `
        }
    })
}

function addProductOrder(product_ID, product_name, stock_quantity, product_price){
    if (stock_quantity == 0){
        return;
    }

    let cartTable = document.querySelectorAll("#cartTableBody tr");

    for (let i = 0; i<cartTable.length; i++){
        if (cartTable[i].children[1].textContent == product_name){
            return;
        }
    }

    let cartTableBody = document.querySelector("#cartTableBody");

    cartTableBody.innerHTML += `
                    <tr id="id${product_ID}">
                        <td style="display: none">${product_ID}</td>
                        <td>${product_name}</td>
                        <td id="amount">1</td>
                        <td id="subtotal">₱ ${product_price}</td>
                        <td><button class="btn btn-add" onclick="addAmount(${product_ID}, ${stock_quantity}, ${product_price})">+</button>
                        <button class="btn btn-add" onclick="removeAmount(${product_ID}, ${product_price})">-</button>
                        <button class="btn btn-cancel" onclick="deleteProductOrder(${product_ID})">&times</button></td>
                    </tr 
                    `
    calculateTotal();
}

function addAmount(product_ID, stock_quantity, product_price){
    let cartTable = document.querySelector("#cartTableBody #id"+product_ID);
    let maxQuantity = stock_quantity;
    let currentQuantityRow = cartTable.querySelector("#amount");
    let currentQuantity = currentQuantityRow.textContent

    if (currentQuantity < maxQuantity){
        currentQuantity++;
        currentQuantityRow.textContent = currentQuantity;
    }

    calculateOrderRowSubTotal(product_ID, currentQuantity, product_price);
    calculateTotal();
}

function removeAmount(product_ID, product_price){
    let cartTable = document.querySelector("#cartTableBody #id"+product_ID);
    let currentQuantityRow = cartTable.querySelector("#amount");
    let currentQuantity = currentQuantityRow.textContent;

    if (currentQuantity > 1){
        currentQuantity--;
        currentQuantityRow.textContent = currentQuantity;
    } else if (currentQuantity == 1){
        deleteProductOrder(product_ID);
        return;
    }

    calculateOrderRowSubTotal(product_ID, currentQuantity, product_price);
    calculateTotal();
}

function deleteProductOrder(product_ID){
    let cartTable = document.querySelector("#cartTableBody #id"+product_ID);
    cartTable.remove();
    calculateTotal();

}

function calculateOrderRowSubTotal(product_ID, quantity, product_price){
    let cartTable = document.querySelector("#cartTableBody #id"+product_ID);
    let subTotalRow = cartTable.querySelector("#subtotal");

    subTotalRow.textContent = '₱ ' + quantity * product_price;
}

function calculateTotal(){
    let cartTable = document.querySelectorAll("#cartTableBody tr");
    let totalAmountEm = document.getElementById("cartTotal");
    let totalAmount = 0;
    

    cartTable.forEach(item => {
        totalAmount +=+ item.children[3].textContent.slice(1);
    })

    totalAmountEm.textContent = totalAmount;
}

function addOrder(){
    let this_order_ID = '';
    let this_total_amount = 0;
    let cartTableBodyRows = document.querySelectorAll("#cartTableBody tr");

    cartTableBodyRows.forEach(item => {
        this_total_amount +=+ item.children[3].textContent.slice(1);
    })

    fetch('../api/order_api.php', {
        method: 'POST',
        body: JSON.stringify({
            order_date: fullDate,
            total_amount: this_total_amount,
            order_status: "in progress",
            customer_ID: 2
        }),
        headers: {"Control-Type": "application/json"}
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success"){
            this_order_ID = data.order_ID;

            cartTableBodyRows.forEach(productOrder => {
                console.log(productOrder.children[0].textContent)
                
                fetch('../api/order_items_api.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        order_ID: this_order_ID,
                        product_ID: productOrder.children[0].textContent,
                        quantity: productOrder.children[2].textContent,
                        subtotal: productOrder.children[3].textContent.slice(1),
                        employee_ID: 4
                    }),
                    headers: {"Control-Type": "application/json"}
                })
                .then(response => response.json())
                .then(resp => {
                    alert(resp.message);
                    loadProductTable();
                    clearProductOrder();
                })
            })
        } else {
            alert(data.message);
            return;
        }
    })
}


function filterProducts(){
    let searchText = document.getElementById("searchBox").value.toLowerCase();
    let filterCategory = document.getElementById("filterCategory").value.toLowerCase();
    let rows = document.querySelectorAll("#productTableBody tr");
    rows.forEach(row => {
        let productName = row.children[0].textContent.toLowerCase();
        let category = row.children[1].textContent.toLowerCase();

        let matchSearch = productName.includes(searchText) || category.includes(searchText);
        let matchesCategoryFilter = filterCategory === "" || category === filterCategory;

        row.style.display = (matchSearch && matchesCategoryFilter) ? "" : "none";
    })
}

//Utility
function capitalize(string){
    return string[0].toUpperCase() + string.slice(1);
}




// Modal functions
function openConfirmModal() {
    confirmModal.style.display = 'flex';
}

function closeConfirmModal() {
    confirmModal.style.display = 'none';
}

function openLogoutModal() {
    logoutModal.style.display = 'flex';
}

function closeLogoutModal() {
    logoutModal.style.display = 'none';
}

function handleLogout() {
    // In a real app, this would handle logout logic
    alert("You have been logged out.");
    closeLogoutModal();
}

// const cartTableBody = document.getElementById('cartTableBody');
// const inventoryTableBody = document.getElementById('inventoryTableBody');
// const ordersTableBody = document.getElementById('ordersTableBody');
// const cartTotalElement = document.getElementById('cartTotal');
// const proceedBtn = document.getElementById('proceedBtn');
// const confirmModal = document.getElementById('confirmModal');
// const confirmOrderBtn = document.getElementById('confirmOrderBtn');
// const cancelOrderBtn = document.getElementById('cancelOrderBtn');
// const logoutBtn = document.getElementById('logoutBtn');
// const logoutModal = document.getElementById('logoutModal');
// const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
// const cancelLogoutBtn = document.getElementById('cancelLogoutBtn');

// Initial data load
// window.addEventListener('DOMContentLoaded', () => {
//     // Load initial cart data (example)
//     cart = [
//         { id: 1, name: "Pandesal", category: "Bread", price: 1.00, quantity: 5 },
//         { id: 15, name: "Chocolate Muffin", category: "Pastry", price: 59.00, quantity: 1 }
//     ];
    
//     // Update inventory based on cart
//     cart.forEach(item => {
//         const inventoryItem = inventory.find(p => p.id === item.id);
//         if (inventoryItem) {
//             inventoryItem.stock -= item.quantity;
//         }
//     });
    
//     init();
// });

// function init() {
    //     renderInventory();
    //     renderCart();
    //     renderOrders();
        
    //     // Initialize event listeners
    //     proceedBtn.addEventListener('click', handleProceedOrder);
    //     confirmOrderBtn.addEventListener('click', handleConfirmOrder);
    //     cancelOrderBtn.addEventListener('click', closeConfirmModal);
        
    //     logoutBtn.addEventListener('click', openLogoutModal);
    //     confirmLogoutBtn.addEventListener('click', handleLogout);
    //     cancelLogoutBtn.addEventListener('click', closeLogoutModal);
    // }
    
    // // Rendering functions
    // function renderInventory() {
    //     inventoryTableBody.innerHTML = '';
        
    //     inventory.forEach(product => {
    //         const row = document.createElement('tr');
            
    //         row.innerHTML = `
    //             <td>${product.id}</td>
    //             <td>${product.name}</td>
    //             <td>${product.category}</td>
    //             <td>${product.stock}</td>
    //             <td>${product.price.toFixed(2)}</td>
    //             <td>
    //                 <button class="btn btn-add" data-id="${product.id}" 
    //                     ${product.stock <= 0 ? 'disabled' : ''}>Add</button>
    //             </td>
    //         `;
            
    //         inventoryTableBody.appendChild(row);
    //     });
        
    //     // Add event listeners to add buttons
    //     document.querySelectorAll('.btn-add').forEach(button => {
    //         button.addEventListener('click', () => {
    //             const productId = parseInt(button.getAttribute('data-id'));
    //             addToCart(productId);
    //         });
    //     });
    // }
    
    // function renderCart() {
    //     cartTableBody.innerHTML = '';
    //     let total = 0;
        
    //     cart.forEach(item => {
    //         const subtotal = item.price * item.quantity;
    //         total += subtotal;
            
    //         const row = document.createElement('tr');
            
    //         row.innerHTML = `
    //             <td>${item.id}</td>
    //             <td>${item.name}</td>
    //             <td>${item.category}</td>
    //             <td>${item.quantity}</td>
    //             <td>${subtotal.toFixed(2)}</td>
    //             <td>
    //                 <button class="btn btn-remove" data-id="${item.id}">REMOVE</button>
    //                 <button class="btn btn-quantity increase-btn" data-id="${item.id}">+</button>
    //                 <button class="btn btn-quantity decrease-btn" data-id="${item.id}" 
    //                     ${item.quantity <= 1 ? 'disabled' : ''}>-</button>
    //             </td>
    //         `;
            
    //         cartTableBody.appendChild(row);
    //     });
        
    //     cartTotalElement.textContent = total.toFixed(2);
        
    //     // Add event listeners to cart buttons
    //     document.querySelectorAll('.btn-remove').forEach(button => {
    //         button.addEventListener('click', () => {
    //             const productId = parseInt(button.getAttribute('data-id'));
    //             removeFromCart(productId);
    //         });
    //     });
        
    //     document.querySelectorAll('.increase-btn').forEach(button => {
    //         button.addEventListener('click', () => {
    //             const productId = parseInt(button.getAttribute('data-id'));
    //             updateCartItemQuantity(productId, 1);
    //         });
    //     });
        
    //     document.querySelectorAll('.decrease-btn').forEach(button => {
    //         button.addEventListener('click', () => {
    //             const productId = parseInt(button.getAttribute('data-id'));
    //             updateCartItemQuantity(productId, -1);
    //         });
    //     });
    // }
    
    // function renderOrders() {
    //     ordersTableBody.innerHTML = '';
        
    //     currentOrders.forEach(order => {
    //         order.items.forEach(item => {
    //             const row = document.createElement('tr');
                
    //             row.innerHTML = `
    //                 <td>${order.id}</td>
    //                 <td>${item.name}</td>
    //                 <td>${order.date}</td>
    //                 <td>${(item.price * item.quantity).toFixed(2)}</td>
    //                 <td>${order.status}</td>
    //                 <td>${order.customerName}</td>
    //                 <td>${order.employeeName}</td>
    //                 <td>
    //                     <button class="btn btn-complete" data-order-id="${order.id}" data-product-id="${item.productId}">Complete</button>
    //                     <button class="btn btn-cancel" data-order-id="${order.id}" data-product-id="${item.productId}">Cancel</button>
    //                 </td>
    //             `;
                
    //             ordersTableBody.appendChild(row);
    //         });
    //     });
        
    //     // Add event listeners to order buttons
    //     document.querySelectorAll('.btn-complete').forEach(button => {
    //         button.addEventListener('click', () => {
    //             const orderId = parseInt(button.getAttribute('data-order-id'));
    //             const productId = parseInt(button.getAttribute('data-product-id'));
    //             completeOrderItem(orderId, productId);
    //         });
    //     });
        
    //     document.querySelectorAll('.btn-cancel').forEach(button => {
    //         button.addEventListener('click', () => {
    //             const orderId = parseInt(button.getAttribute('data-order-id'));
    //             const productId = parseInt(button.getAttribute('data-product-id'));
    //             cancelOrderItem(orderId, productId);
    //         });
    //     });
    // }
    
    // // Cart operations
    // function addToCart(productId) {
    //     const product = inventory.find(p => p.id === productId);
        
    //     if (!product || product.stock <= 0) return;
        
    //     const existingItem = cart.find(item => item.id === productId);
        
    //     if (existingItem) {
    //         updateCartItemQuantity(productId, 1);
    //     } else {
    //         cart.push({
    //             id: product.id,
    //             name: product.name,
    //             category: product.category,
    //             price: product.price,
    //             quantity: 1
    //         });
            
    //         // Update inventory
    //         const inventoryItem = inventory.find(item => item.id === productId);
    //         inventoryItem.stock--;
            
    //         renderCart();
    //         renderInventory();
    //     }
    // }
    
    // function removeFromCart(productId) {
    //     const itemIndex = cart.findIndex(item => item.id === productId);
        
    //     if (itemIndex !== -1) {
    //         const removedItem = cart[itemIndex];
            
    //         // Return stock to inventory
    //         const inventoryItem = inventory.find(item => item.id === productId);
    //         inventoryItem.stock += removedItem.quantity;
            
    //         // Remove from cart
    //         cart.splice(itemIndex, 1);
            
    //         renderCart();
    //         renderInventory();
    //     }
    // }
    
    // function updateCartItemQuantity(productId, change) {
    //     const cartItem = cart.find(item => item.id === productId);
    //     const inventoryItem = inventory.find(item => item.id === productId);
        
    //     if (!cartItem) return;
        
    //     if (change > 0) {
    //         // Check if enough stock
    //         if (inventoryItem.stock <= 0) return;
            
    //         cartItem.quantity++;
    //         inventoryItem.stock--;
    //     } else {
    //         cartItem.quantity--;
    //         inventoryItem.stock++;
            
    //         if (cartItem.quantity <= 0) {
    //             removeFromCart(productId);
    //             return;
    //         }
    //     }
        
    //     renderCart();
    //     renderInventory();
    // }
    
    // // Order handling
    // function handleProceedOrder() {
    //     if (cart.length === 0) {
    //         alert("Your cart is empty!");
    //         return;
    //     }
        
    //     openConfirmModal();
    // }
    
    // function handleConfirmOrder() {
    //     if (cart.length === 0) return;
        
    //     const newOrderId = currentOrders.length > 0 ? Math.max(...currentOrders.map(o => o.id)) + 1 : 1;
        
    //     const newOrder = {
    //         id: newOrderId,
    //         items: cart.map(item => ({
    //             productId: item.id,
    //             name: item.name,
    //             quantity: item.quantity,
    //             price: item.price
    //         })),
    //         date: new Date().toISOString().split('T')[0],
    //         customerName: "Customer", // In a real app, you'd get this from input
    //         employeeName: "CashierLan", // In a real app, you'd get this from session
    //         status: "In progress"
    //     };
        
    //     currentOrders.push(newOrder);
    //     cart = [];
        
    //     closeConfirmModal();
    //     renderCart();
    //     renderOrders();
    // }
    
    // function completeOrderItem(orderId, productId) {
    //     const order = currentOrders.find(o => o.id === orderId);
    //     if (!order) return;
        
    //     const itemIndex = order.items.findIndex(item => item.productId === productId);
    //     if (itemIndex === -1) return;
        
    //     // Remove the completed item
    //     order.items.splice(itemIndex, 1);
        
    //     // If no items left, remove the order
    //     if (order.items.length === 0) {
    //         const orderIndex = currentOrders.findIndex(o => o.id === orderId);
    //         currentOrders.splice(orderIndex, 1);
    //     }
        
    //     renderOrders();
    // }
// 

// function cancelOrderItem(orderId, productId) {
//     const order = currentOrders.find(o => o.id === orderId);
//     if (!order) return;
    
//     const itemIndex = order.items.findIndex(item => item.productId === productId);
//     if (itemIndex === -1) return;
    
//     const cancelledItem = order.items[itemIndex];
    
//     // Return stock to inventory
//     const inventoryItem = inventory.find(item => item.id === cancelledItem.productId);
//     if (inventoryItem) {
//         inventoryItem.stock += cancelledItem.quantity;
//     }
    
//     // Remove the cancelled item
//     order.items.splice(itemIndex, 1);
    
//     // If no items left, remove the order
//     if (order.items.length === 0) {
//         const orderIndex = currentOrders.findIndex(o => o.id === orderId);
//         currentOrders.splice(orderIndex, 1);
//     }
    
//     renderInventory();
//     renderOrders();
// }