-- Insert dummy data into brands table with mobile phone brands
INSERT INTO `brands` (`brand_name`) VALUES
('Samsung'),
('Apple'),
('Xiaomi'),
('Huawei'),
('Google'),
('OnePlus'),
('Oppo'),
('Vivo'),
('Motorola'),
('Sony'),
('Nokia'),
('Realme'),
('Nothing'),
('Asus'),
('Honor');


-- Insert dummy data into products table
INSERT INTO `products` (`product_name`, `brand_id`, `description`, `price`, `sku`, `quantity`, `status`, `image_url`) VALUES
-- Samsung products (brand_id = 1)
('Samsung Galaxy S24', 1, 'Epic, just like that. Imagine the videos you\'ll shoot, the pics you\'ll edit and the connections you make, all elevated to new heights with mobile AI. Features: 5,000 mAh Battery, Wireless PowerShare, Snapdragon 8 Gen 3, 5G (sub6, mmW), 6.2" FHD+ display.', 326859.00, 'SAM-GS24-01', 0, 'out_of_stock', 'images/samsung-galaxy-s24.jpg'),
('Samsung Galaxy S24+', 1, 'More screen. More battery. More processing power. Galaxy S24+ comes with QHD+, the highest screen resolution on a Galaxy smartphone. Features: 5,000 mAh Battery, Wireless PowerShare, Snapdragon 8 Gen 3, 5G (sub6, mmW), 6.7" QHD+ display.', 389999.00, 'SAM-GS24P-01', 15, 'available', 'images/samsung-galaxy-s24-plus.jpg'),
('Samsung Galaxy Z Fold 5', 1, 'Experience the ultimate foldable smartphone with a 7.6" main display and 6.2" cover display. Features: Snapdragon 8 Gen 2, 12GB RAM, 256GB storage, triple camera system.', 429999.00, 'SAM-ZF5-01', 8, 'available', 'images/samsung-galaxy-z-fold5.jpg'),

-- Apple products (brand_id = 2)
('Apple iPhone 15 Pro', 2, 'The ultimate iPhone with a titanium design, A17 Pro chip, and a 48MP main camera. Features: 6.1" Super Retina XDR display, iOS 17, Action button, USB-C.', 349999.00, 'APP-IP15P-01', 20, 'available', 'images/apple-iphone15-pro.jpg'),
('Apple iPhone 15', 2, 'A powerful iPhone with A16 Bionic chip and a 48MP main camera. Features: 6.1" Super Retina XDR display, iOS 17, Dynamic Island, USB-C.', 279999.00, 'APP-IP15-01', 25, 'available', 'images/apple-iphone15.jpg'),
('Apple iPhone SE (2022)', 2, 'The most affordable iPhone with A15 Bionic chip and Touch ID. Features: 4.7" Retina HD display, 12MP camera, IP67 water resistance.', 149999.00, 'APP-IPSE-01', 0, 'discontinued', 'images/apple-iphone-se.jpg'),

-- Xiaomi products (brand_id = 3)
('Xiaomi 14 Ultra', 3, 'Professional photography in your pocket with Leica optics and a 1-inch sensor. Features: Snapdragon 8 Gen 3, 6.73" AMOLED display, 5000mAh battery, 90W fast charging.', 289999.00, 'XIA-14U-01', 12, 'available', 'images/xiaomi-14-ultra.jpg'),
('Xiaomi Redmi Note 13 Pro', 3, '200MP camera and powerful performance at an accessible price. Features: MediaTek Dimensity 7200 Ultra, 6.67" AMOLED display, 5100mAh battery, 67W fast charging.', 89999.00, 'XIA-RN13P-01', 30, 'available', 'images/xiaomi-redmi-note13-pro.jpg'),

-- Google products (brand_id = 5)
('Google Pixel 8 Pro', 5, 'The smartest Pixel yet with Google AI and incredible camera capabilities. Features: Google Tensor G3, 6.7" Super Actua display, 50MP triple camera system, 7 years of updates.', 279999.00, 'GOO-P8P-01', 10, 'available', 'images/google-pixel8-pro.jpg'),
('Google Pixel 8a', 5, 'Google AI and great photography at a more accessible price. Features: Google Tensor G3, 6.1" OLED display, 64MP main camera, 7 years of updates.', 159999.00, 'GOO-P8A-01', 18, 'available', 'images/google-pixel8a.jpg'),

-- OnePlus products (brand_id = 6)
('OnePlus 12', 6, 'The ultimate performance flagship with Hasselblad cameras. Features: Snapdragon 8 Gen 3, 6.82" LTPO AMOLED display, 5400mAh battery, 100W SUPERVOOC charging.', 249999.00, 'ONP-12-01', 15, 'available', 'images/oneplus-12.jpg'),
('OnePlus Nord CE 3', 6, 'Exceptional performance in the mid-range segment. Features: Snapdragon 782G, 6.7" AMOLED display, 5000mAh battery, 80W SUPERVOOC charging.', 99999.00, 'ONP-NCE3-01', 22, 'available', 'images/oneplus-nord-ce3.jpg'),

-- Nothing products (brand_id = 13)
('Nothing Phone (2)', 13, 'Innovative design with Glyph Interface and clean software. Features: Snapdragon 8+ Gen 1, 6.7" LTPO OLED display, 50MP dual camera, Nothing OS 2.0.', 149999.00, 'NOT-P2-01', 8, 'available', 'images/nothing-phone2.jpg'),

-- Nokia products (brand_id = 11)
('Nokia G42', 11, 'Repairable smartphone with great battery life. Features: Snapdragon 480+ 5G, 6.56" HD+ display, 50MP camera, 5000mAh battery, 3 years of security updates.', 69999.00, 'NOK-G42-01', 15, 'available', 'images/nokia-g42.jpg');