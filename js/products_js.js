document.addEventListener("DOMContentLoaded", loadProducts);

function loadProducts(){

    fetch("../api/products_api.php")
    .then(response => response.json())
    .then(data => {

        let productTableBody = document.getElementById("productTableBody");
        productTableBody.innerHTML = ""

        if (data.status === "success"){
            data.product.forEach(product => {
                productTableBody.innerHTML += `
                    <tr>
                        <td>${product.product_ID}</td>                    
                        <td>${product.product_name}</td>                    
                        <td>${product.product_description}</td>                    
                        <td>${capitalize(product.product_category)}</td>                    
                        <td>${product.stock_quantity}</td>                    
                        <td>${'₱ ' + product.product_price}</td>
                        <td><div class="action-buttons">
                                <button class="edit-btn" onclick="openEditModal(${product.product_ID}, '${product.product_name}', '${product.product_description}', '${product.product_category}', '${product.stock_quantity}', '${product.product_price}')">Edit</button>
                                <button class="delete-btn" onclick="deleteProduct(${product.product_ID})">Delete</button></td>                    
                            </div>
                    </tr>
                `
            })
        } else {
        }
    })
};

function capitalize(string){
    return string[0].toUpperCase() + string.slice(1);
};

function addProduct(){
    let this_product_name = document.getElementById("productName").value.trim();
    let this_product_description = document.getElementById("productDescription").value.trim();
    let this_product_category = document.getElementById("productCategory").value.trim();
    let this_stock_quantity = document.getElementById("stockQuantity").value.trim();
    let this_product_price = document.getElementById("productPrice").value.trim();
    
    if (!this_product_name || !this_product_description || !this_product_category || !this_stock_quantity || !this_product_price){
        alert("Please do not leave any fields blank. AND PLEASE DO NOT REDEEM THE CARD, MA'AM!!")
        return;
    }

    fetch("../api/products_api.php", {
        method: "POST",
        body: JSON.stringify({
            product_name: this_product_name,
            product_description: this_product_description,
            product_category: this_product_category,
            stock_quantity: this_stock_quantity,
            product_price: this_product_price
        }),
        headers: {"Control-Type": "application/json"}
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        closeAddProductModal();
        loadProducts();
    })
    .catch(error=> console.error("Error adding product:", error));
};

function updateProduct(){
    let this_product_ID = document.getElementById("editProductID").value.trim();
    let this_product_name = document.getElementById("editProductName").value.trim();
    let this_product_description = document.getElementById("editDescription").value.trim();
    let this_product_category = document.getElementById("editCategory").value.trim();
    let this_stock_quantity = document.getElementById("editStockQuantity").value.trim();
    let this_product_price = document.getElementById("editProductPrice").value.trim();
    
    if (!this_product_ID || !this_product_name || !this_product_description || !this_product_category || !this_stock_quantity || !this_product_price){
        alert("WHY DID YOU REMOVE IT!!!");
        return;
    }

    fetch('../api/products_api.php', {
        method: "PUT",
        body: JSON.stringify({
            product_ID: this_product_ID,
            product_name: this_product_name,
            product_description: this_product_description,
            product_category: this_product_category,
            stock_quantity: this_stock_quantity,
            product_price: this_product_price
        }),
        headers: {"Control-Type": "application/json"}
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        closeEditModal();
        loadProducts();
    })
    .catch(error => console.error("Error editing product: ", error));

};

function deleteProduct(id){    
    let confirm_txt = confirm("Are you sure to delete this product?");

    if (confirm_txt){
        fetch("../api/products_api.php", {
            method: "DELETE",
            body: JSON.stringify({
                product_ID: id
            }),
            headers: {"Control-Type": "application/json"}
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadProducts();
        });
    }
};

function filterProducts(){
    let searchText = document.getElementById("searchBox").value.toLowerCase();
    let filterCategory = document.getElementById("filterCategory").value.toLowerCase();
    let rows = document.querySelectorAll("#productTableBody tr");
    
    rows.forEach(row => {
        let productName = row.children[1].textContent.toLowerCase();
        let category = row.children[3].textContent.toLowerCase();

        let matchSearch = productName.includes(searchText) || category.includes(searchText);
        let matchesCategoryFilter = filterCategory === "" || category === filterCategory;

        row.style.display = (matchSearch && matchesCategoryFilter) ? "" : "none";
    })
}

document.addEventListener("DOMContentLoaded", () => {

});

let addProductModal = document.querySelector("#addModal");

function openAddModal(){
    addProductModal.classList.toggle("show")
};

function closeAddModal(){
    document.getElementById("productName").value = "";
    document.getElementById("productDescription").value = "";
    document.getElementById("productCategory").value = "";
    document.getElementById("stockQuantity").value = "";
    document.getElementById("productPrice").value = "";
    addProductModal.classList.toggle("show");
};

let editModal = document.querySelector("#editModal");

function openEditModal(product_ID, product_name, product_description, product_category, stock_quantity, product_price){
    document.getElementById("editProductID").value = product_ID;
    document.getElementById("editProductName").value = product_name;
    document.getElementById("editDescription").value = product_description;
    document.getElementById("editCategory").value = product_category;
    document.getElementById("editStockQuantity").value = stock_quantity;
    document.getElementById("editProductPrice").value = product_price;
    editModal.classList.toggle("show");
};

function closeEditModal(){
    editModal.classList.toggle("show");
    document.getElementById("editProductID").value = "";
    document.getElementById("editProductName").value = "";
    document.getElementById("editDescription").value = "";
    document.getElementById("editCategory").value = "";
    document.getElementById("editStockQuantity").value = "";
    document.getElementById("editProductPrice").value = "";
};

// , , product_description, product_category, stock_quantity, product_price
