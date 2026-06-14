CREATE TABLE tab_color (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tab_size (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    group_type ENUM('Agent', 'Distributor') NOT NULL,
    agent_id INT NULL,
    mobile VARCHAR(15) NOT NULL,
    email VARCHAR(255) NULL,
    area_name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    pincode VARCHAR(10) NOT NULL,
    gst_number VARCHAR(20) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES customers(id) ON DELETE SET NULL
);


CREATE TABLE transport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    area_name VARCHAR(50) NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE tab_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE tab_product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    design_code VARCHAR(50) NOT NULL,
    design_image VARCHAR(255) NULL,
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES tab_category(id) ON DELETE CASCADE
);


CREATE TABLE product_color (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    color_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (color_id) REFERENCES tab_color(id) ON DELETE CASCADE
);


CREATE TABLE color_size (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_color_id INT NOT NULL,
    size_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_color_id) REFERENCES product_color(id) ON DELETE CASCADE,
    FOREIGN KEY (size_id) REFERENCES tab_size(id) ON DELETE CASCADE
);

CREATE TABLE customer_transport (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    transport_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (transport_id) REFERENCES transport(id) ON DELETE CASCADE
);

CREATE TABLE tab_sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(20) NOT NULL,
    customer_id INT NOT NULL,
    order_date DATE NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);


CREATE TABLE sales_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sales_id INT NOT NULL,
    product_color_id INT NOT NULL,
    size_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sales_id) REFERENCES tab_sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_color_id) REFERENCES product_color(id) ON DELETE CASCADE,
    FOREIGN KEY (size_id) REFERENCES tab_size(id) ON DELETE CASCADE
);

CREATE TABLE tab_order_picking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    status ENUM('Pending', 'Ongoing', 'Complete', 'Billing on Hold') NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES tab_sales(id) ON DELETE CASCADE
);


CREATE TABLE tab_order_invoice (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    invoice_number VARCHAR(50) NOT NULL,
    transport_id INT NOT NULL,
    status ENUM('Pending', 'Ongoing', 'Complete', 'Dispatch on Hold') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES tab_sales(id) ON DELETE CASCADE,
    FOREIGN KEY (transport_id) REFERENCES transport(id) ON DELETE CASCADE
);

CREATE TABLE tab_order_dispatch (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    status ENUM('Pending', 'Ongoing', 'Complete') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES tab_sales(id) ON DELETE CASCADE
);


Working with the Relationship

Once the relationships are defined, you can perform various operations:

Attach Colors to a Product:
php
Copy
Edit
$product = Product::find($productId);
$product->colors()->attach($colorId);
Detach Colors from a Product:
php
Copy
Edit
$product = Product::find($productId);
$product->colors()->detach($colorId);
Sync Colors for a Product:
php
Copy
Edit
$product = Product::find($productId);
$product->colors()->sync([$colorId1, $colorId2]);
Retrieve Colors of a Product:
php
Copy
Edit
$product = Product::with('colors')->find($productId);
$colors = $product->colors;
Retrieve Products of a Color:
php
Copy
Edit
$color = Color::with('products')->find($colorId);
$products = $color->products;
By implementing this structure, you can effectively manage the association between products and their available colors within your Laravel application.



CREATE TABLE `tbl_invoice` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `invoice_number` VARCHAR(50) UNIQUE NOT NULL,
    `order_date` DATE NOT NULL,
    `warehouse_id` BIGINT UNSIGNED NOT NULL,
    `customer_id` BIGINT UNSIGNED NOT NULL,
     `select_product` VARCHAR(50) UNIQUE NOT NULL,
     `order_type` ENUM('Fresh order', 'Repeat order') NOT NULL,
     `status` ENUM('Pending', 'Ongoing', 'Complete', 'Dispatch on Hold') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE
);


CREATE TABLE `tbl_invoice_transaction` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `invoice_id` BIGINT UNSIGNED NOT NULL,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `category_id` BIGINT UNSIGNED NOT NULL,
    `color_id` BIGINT UNSIGNED NOT NULL,
    `size_id` BIGINT UNSIGNED NOT NULL,
    `quantity` INT NOT NULL CHECK (`quantity` >= 0),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`invoice_id`) REFERENCES `tbl_invoice`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`color_id`) REFERENCES `tab_color`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`size_id`) REFERENCES `tab_size`(`id`) ON DELETE CASCADE
);
