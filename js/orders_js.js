document.addEventListener('DOMContentLoaded', loadOrderHistory);
// document.addEventListener('DOMContentLoaded', loadProductTable);

// gets today's date. too lazy to make it a function so mehhhh
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

//start of functionsssssssssssss
function loadProductTable(){
    fetch('../api/products_api.php')
    .then(response => response.json())
    .then(data => {
        let productTableBody = document.querySelector("#productTableBody");
        productTableBody.innerHTML = "";

        if (data.status === "success"){
            data.product.forEach(prod => {
                productTableBody.innerHTML += `
                    <tr>
                        <td>${prod.product_ID}</td>
                        <td>${prod.product_name}</td>
                        <td>${capitalize(prod.product_category)}</td>
                        <td>${prod.stock_quantity}</td>
                        <td>${prod.product_price}</td>
                        <td><button onclick="addProductOrder(${prod.product_ID}, '${prod.product_name}', '${capitalize(prod.product_category)}', ${prod.stock_quantity}, ${prod.product_price})">Add</button></td>
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

function loadOrderHistory(){
    fetch('../api/order_api.php')
    .then(response => response.json())
    .then(data => {

        let orderTableBody = document.querySelector("#orderTableBody");
        orderTableBody.innerHTML = ""

        if (data.status === "success"){
            data.orders.forEach(ord => {
                orderTableBody.innerHTML += `
                    <tr>
                        <td>${ord['order_ID']}</td>
                        <td>${ord['order_date']}</td>
                        <td>${ord['customer_name']}</td>
                        <td>${ord['product_name'].replace(/\n/g, '<br>')}</td>
                        <td>${ord['quantity'].replace(/\n/g, '<br>')}</td>
                        <td>${ord['subtotal'].replace(/\n/g, '<br>')}</td>
                        <td>${'₱ ' + ord['total_amount']}</td>
                        <td>${ord['employee_name']}</td>
                        <td id="${ord['order_status']}">${capitalize(ord['order_status'])}</td>
                    </tr>
                `
                if (!finishedStatus.includes(ord['order_status'])){
                    console.log("haja")
                    orderTableBody.lastElementChild.innerHTML += `
                        <td><button class="save-btn" onclick="completeOrder(${ord.order_ID})">Complete</button>
                        <button class="delete-btn" onclick="cancelOrder(${ord.order_ID})">Cancel</button></td>
                    `
                } else {
                    orderTableBody.lastElementChild.innerHTML += `
                        <td>:></td>
                    `
                }
            })
        } else {
            orderTableBody.innerHTML += `
                <h3>Table Empty</h3>
            `
        }
    })
}



function addOrder(){
    let this_total_amount = 0;
    let this_order_ID = '';

    let productOrderBodyRows = document.querySelectorAll("#productOrderBody tr");

    productOrderBodyRows.forEach(productOrder => {
        this_total_amount +=+ productOrder.querySelector("#subtotal").textContent;
    })


    fetch('../api/order_api.php', {
        method: 'POST',
        body: JSON.stringify({
            order_date: fullDate,
            total_amount: this_total_amount,
            order_status: "in progress",
            customer_ID: 1
        }),
        headers: {"Control-Type": "application/json"}
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success"){
            this_order_ID = data.order_ID;

            productOrderBodyRows.forEach(productOrder => {
                fetch('../api/order_items_api.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        order_ID: this_order_ID,
                        product_ID: productOrder.children[0].textContent,
                        quantity: productOrder.children[3].textContent,
                        subtotal: productOrder.children[4].textContent,
                        employee_ID: 1
                    }),
                    headers: {"Control-Type": "application/json"}
                })
                .then(response => response.json())
                .then(resp => {
                    alert(resp.message);
                    loadOrderHistory();
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


function addProductOrder(product_ID, product_name, product_category, stock_quantity, product_price){
    if (stock_quantity == 0){
        return;
    }

    let productRows = document.querySelectorAll("#productOrderBody tr");

    for (let i = 0; i<productRows.length; i++){
        if (productRows[i].children[0].textContent == product_ID){
            return;
        }
    }

    let productOrderBody = document.querySelector("#productOrderBody");

    productOrderBody.innerHTML += `
                    <tr id="id${product_ID}">
                        <td>${product_ID}</td>
                        <td>${product_name}</td>
                        <td>${product_category}</td>
                        <td id="amount">1</td>
                        <td id="subtotal">${product_price}</td>
                        <td><button onclick="deleteProductOrder(${product_ID})">REMOVE</button></td>
                        <td><button onclick="addAmount(${product_ID}, ${stock_quantity}, ${product_price})">+</button></td>
                        <td><button onclick="removeAmount(${product_ID}, ${product_price})">-</button></td>
                    </tr 
                    `
}

const finishedStatus = ['cancelled', 'completed'];

function completeOrder(this_order_ID){
    let orderTableBody = document.querySelectorAll("#orderTableBody tr");

    for (let i=0; i<orderTableBody.length; i++){
        if (finishedStatus.includes(orderTableBody[i].children[4].textContent.toLowerCase()) && orderTableBody[i].children[0].textContent == this_order_ID){
            return;
        }
    }

    fetch('../api/order_api.php', {
        method: 'PUT',
        body: JSON.stringify({
            order_ID: this_order_ID,
            status: 'completed'
        }),
        headers: {"Control-Type" : "application/json"}
    })
    .then(response => response.json())
    .then(resp => {
        alert(resp.message);
        loadOrderHistory();
    })
} 

function cancelOrder(this_order_ID){
    let orderTableBody = document.querySelectorAll("#orderTableBody tr");

    for (let i=0; i<orderTableBody.length; i++){
        if (finishedStatus.includes(orderTableBody[i].children[4].textContent.toLowerCase()) && orderTableBody[i].children[0].textContent == this_order_ID){
            return;
        }
    }

    fetch('../api/order_api.php', {
        method: 'PUT',
        body: JSON.stringify({
            order_ID: this_order_ID,
            status: 'cancelled'
        }),
        headers: {"Control-Type" : "application/json"}
    })
    .then(response => response.json())
    .then(resp => {
        alert(resp.message);
        loadOrderHistory();
    })


    fetch('../api/order_items_api.php',{
        method: 'PUT',
        body: JSON.stringify({
            order_ID: this_order_ID,
        }),
        headers: {"Control-Type": "application/json"}
    })
    .then(response => response.json())
    .then(resp => {
        alert(resp.message);
        loadOrderHistory();
        loadProductTable();
    })
}
// -- utility functions --

function capitalize(string){
    return string[0].toUpperCase() + string.slice(1);
}

function clearProductOrder(){
    let productOrderBody = document.querySelector("#productOrderBody");
    productOrderBody.innerHTML = "";
}

function addAmount(product_ID, stock_quantity, product_price){
    let productRow = document.querySelector("#productOrderBody #id"+product_ID);
    let maxQuantity = stock_quantity;
    let currentQuantityRow = productRow.querySelector("#amount");
    let currentQuantity = currentQuantityRow.textContent

    if (currentQuantity < maxQuantity){
        currentQuantity++;
        currentQuantityRow.textContent = currentQuantity;
    }

    calculateOrderRowSubTotal(product_ID, currentQuantity, product_price);
}

function removeAmount(product_ID, product_price){
    let productRow = document.querySelector("#productOrderBody #id"+product_ID);
    let currentQuantityRow = productRow.querySelector("#amount");
    let currentQuantity = currentQuantityRow.textContent;

    if (currentQuantity > 1){
        currentQuantity--;
        currentQuantityRow.textContent = currentQuantity;
    } else if (currentQuantity == 1){
        deleteProductOrder(product_ID);
        return;
    }

    calculateOrderRowSubTotal(product_ID, currentQuantity, product_price);
    
}

function calculateOrderRowSubTotal(product_ID, quantity, product_price){
    let productRow = document.querySelector("#productOrderBody #id"+product_ID);
    let subTotalRow = productRow.querySelector("#subtotal");

    subTotalRow.textContent = quantity * product_price;
}


function deleteProductOrder(product_ID){
    let productRow = document.querySelector("#productOrderBody #id"+product_ID);
    productRow.remove();
}

function filterOrders(){
    let searchDate = document.getElementById("searchBox").value.toLowerCase();
    let filterStatus = document.getElementById("filterStatus").value.toLowerCase();
    let rows = document.querySelectorAll("#orderTableBody tr");
    
    rows.forEach(row => {
        let productDate = row.children[1].textContent.toLowerCase();
        let status = row.children[8].textContent.toLowerCase();

        let matchSearch = productDate.includes(searchDate);
        let matchesFilterStatus = filterStatus === "" || status === filterStatus;

        row.style.display = (matchSearch && matchesFilterStatus) ? "" : "none";
    })
}