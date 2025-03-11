<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BakeryKey</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <script src="app.js" defer></script>
</head>
<body>
    <nav>
        <div class="logo">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3" id="sidebar-toggle" class=""><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>

            <h3>BakeryKey</h3>
        </div>
        <a href="">Admin <img src="assets/icons/user.svg" alt=""></a>
    </nav>

    <main>
        <aside id="sidebar">
            <ul>
                <li class="">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="var(--clr-black)"><path d="M320-280q17 0 28.5-11.5T360-320q0-17-11.5-28.5T320-360q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280Zm0-160q17 0 28.5-11.5T360-480q0-17-11.5-28.5T320-520q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160q17 0 28.5-11.5T360-640q0-17-11.5-28.5T320-680q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm120 320h240v-80H440v80Zm0-160h240v-80H440v80Zm0-160h240v-80H440v80ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
                        <span>Products</span>
                    </a>

                </li>
                <li class="">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="var(--clr-black)"><path d="M160-160v-516L82-846l72-34 94 202h464l94-202 72 34-78 170v516H160Zm240-280h160q17 0 28.5-11.5T600-480q0-17-11.5-28.5T560-520H400q-17 0-28.5 11.5T360-480q0 17 11.5 28.5T400-440ZM240-240h480v-358H240v358Zm0 0v-358 358Z"/></svg>
                        <span>Orders</span>
                    </a>

                </li>
                <li class="">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="var(--clr-black)"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"/></svg>
                        <span>Customers </span>
                    </a>
                </li>
                <li class="">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="var(--clr-black)"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z"/></svg>
                        <span>
                            Employees   
                        </span>
                    </a>
                </li>
            </ul>
        </aside>
        
        <div class="main_body">
            
            <div class="wrapper" id="products">
                <div class="head">
                    <h3>PRODUCTS</h3>
                    <div class="options">
                        <button class="add">➕</button>
                    </div>
                </div>
                <table>
                    <tr>
                        <th>ProductID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $conn = new mysqli('localhost', 'root', '', 'BakeryKey_DB');

                        if ($conn->connect_error){
                            die('Connection Failed' + $conn->connect_error);
                        } else {
                            $sql = 'SELECT product_id, product_name, product_price FROM Products;';
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                    echo "<tr><td>". $row['product_id']. "</td><td>". $row['product_name']. "</td><td>". $row['product_price']. "</td><td class='actions'><Button class='edit'>EDIT</Button><Button class='delete'>DELETE</Button>
                            </tr>";
                                }
                            }
                        }

                    ?>
                </table>
            </div>

            <div class="wrapper" id="products">
                <!-- <div class="insert hide">
                    <form action="" method="post">
                        <label for=""></label>
                        <input type="text">
                        <label for=""></label>
                        <input type="text">
                        <label for=""></label>
                        <input type="text">
                        <label for=""></label>
                        <input type="text">
                    </form>
                </div> -->
                <div class="head">
                    <h3>PRODUCTS</h3>
                    <div class="options">
                        <button class="add">➕</button>
                    </div>
                </div>
                <table>
                    <tr>
                        <th>ProductID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>InventoryID</th>    
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>1001</td>
                        <td>Monalisa</td>
                        <td>5.00</td>
                        <td>1001</td>
                        <td class="actions">
                            <Button class="edit">EDIT</Button>
                            <Button class="delete">DELETE</Button>
                        </td>
                    </tr>
                    <tr>
                        <td>1002</td>
                        <td>Spanish Bread</td>
                        <td>5.00</td>
                        <td>1002</td>
                        <td class="actions">
                            <Button class="edit">EDIT</Button>
                            <Button class="delete">DELETE</Button>
                    </tr>
                    <tr>
                        <td>1003</td>
                        <td>Cheese Bread</td>
                        <td>7.00</td>
                        <td>1003</td>
                        <td class="actions">
                            <Button class="edit">EDIT</Button>
                            <Button class="delete">DELETE</Button>
                    </tr>
                </table>
            </div>
                
            <!-- <div class="wrapper">
                <div class="head">
                    <h3>ORDERS</h3>
                    <div class="options">
                        <button>NEW</button>
                        <button>DELETE</button>
                        <button>EDIT</button>
                    </div>
                </div>
                <table>
                    <tr>
                        <th>ProductID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>InventoryID</th>

                    </tr>
                </table>
            </div>
            
            <div class="wrapper">
                <div class="head">
                    <h3>CUSTOMERS</h3>
                    <div class="options">
                        <button>NEW</button>
                        <button>DELETE</button>
                        <button>EDIT</button>
                    </div>
                </div>
                <table>
                    <tr>
                        <th>ProductID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>InventoryID</th>
                    </tr>
                </table>
            </div>
            
            <div class="wrapper">
                <div class="head">
                    <h3>PRODUCTS</h3>
                    <div class="options">
                        <button>NEW</button>
                        <button>DELETE</button>
                        <button>EDIT</button>
                    </div>
                </div>
                <table>
                    <tr>
                        <th>ProductID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>InventoryID</th>
                    </tr>
                </table>
            </div> -->
        </div>
        
    </main>
</body>
</html>