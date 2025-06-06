# 📱 MobiMart – Mobile Phone Shop Management System

**MobiMart** is a web-based solution crafted for mobile phone

## 🛠️ Tech Stack

- **Frontend**: HTML, CSS, Bootstrap, JavaScript, jQuery
- **Backend**: PHP
- **Database**: MySQL

## 🚀 Features

- ✅ Online & offline sales management
- 📦 Inventory tracking system to monitor stock levels
- 🧾 Billing & invoicing system for generating receipts
- 👥 User management for admins and customers
- 📊 Reports & analytics to track sales trends
- 🛒 Shopping cart functionality
- 📱 Product catalog with detailed views
- 🎨 Responsive and modern UI design

## 📂 Project Structure

```plaintext
/MobiMart
├── index.php                # Main entry point
├── /assets
│   ├── /css                # Stylesheets
│   ├── /js                 # JavaScript files
│   ├── /images             # Image assets
│   ├── /doc                # Documentation
│   └── /uploads            # User uploaded content
├── /config
│   └── db.php             # Database configuration
├── /controller             # PHP controllers
│   ├── address_process.php
│   ├── cart_process.php
│   └── ...
├── /includes              # Reusable components
│   ├── nav.php
│   ├── footer.php
│   └── ...
├── /pages                 # Main application pages
│   ├── cart.php
│   ├── checkout.php
│   ├── /Admin             # Admin dashboard
│   └── /User              # User dashboard
└── /sql                   # Database scripts
    ├── dummyData.sql
    └── ministore.sql
```

## 📦 Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/mobimart.git
   ```

2. Set up your local environment:
   - Install XAMPP (or similar) if you haven't already
   - Start Apache and MySQL services
   - Place the project in `htdocs` folder

3. Database setup:
   - Open phpMyAdmin ([http://localhost/phpmyadmin](http://localhost/phpmyadmin))
   - Create a new database named 'ministore'
   - Import `sql/ministore.sql`
   - (Optional) Import `sql/dummyData.sql` for test data

4. Configure the application:
   - Navigate to `config/db.php`
   - Update database credentials if needed

5. Access the application:
   - Open your browser and visit: [http://localhost/MobiMart](http://localhost/MobiMart)

## 🔐 Login Credentials

- **Admin**: `admin@example.com` / `admin123`
- **Customer**: `user@example.com` / `user123`

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open source and available under the MIT License.

## 📸 Screenshots

### Home Page
![Home Page Banner](assets/images/banner-image.png)

### Product Catalog
<div style="display: flex; gap: 10px;">
    <img src="assets/images/product-item1.jpg" alt="Product Catalog" width="200"/>
    <img src="assets/images/product-item2.jpg" alt="Product Display" width="200"/>
    <img src="assets/images/product-item3.jpg" alt="Featured Products" width="200"/>
</div>

### Product Details
![Product Details](assets/images/singel-product-item.jpg)

### User Dashboard
<div style="display: flex; gap: 10px;">
    <img src="assets/images/user_dashbord01.webp" alt="User Dashboard" width="300"/>
    <img src="assets/images/user_dashbord02.webp" alt="Order History" width="300"/>
</div>

### Shopping Cart & Checkout
![Shopping Cart](assets/images/cart-item1.jpg)

### Payment Options
<div style="display: flex; gap: 10px; align-items: center;">
    <img src="assets/images/paypal.jpg" alt="PayPal" height="30"/>
    <img src="assets/images/mastercard.jpg" alt="Mastercard" height="30"/>
    <img src="assets/images/visa.jpg" alt="Visa" height="30"/>
</div>

### Shipping Partners
<div style="display: flex; gap: 10px; align-items: center;">
    <img src="assets/images/dhl.png" alt="DHL" height="40"/>
    <img src="assets/images/shippingcard.png" alt="Shipping Options" height="40"/>
</div>
