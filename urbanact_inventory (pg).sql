-- Postgresql
--
-- Database: urbanact_inventory
--

-- --------------------------------------------------------

--
-- Table structure for table attributes
--

CREATE TABLE attributes (
  id SERIAL PRIMARY KEY NOT NULL,
  name varchar(255) NOT NULL,
  active int NOT NULL,
  UNIQUE(name)
);

--
-- Dumping data for table attributes
--

INSERT INTO attributes (id, name, active) VALUES
(6, 'Size', 1);

-- --------------------------------------------------------

--
-- Table structure for table attribute_value
--

CREATE TABLE attribute_value (
  id SERIAL PRIMARY KEY NOT NULL,
  value varchar(255) NOT NULL,
  attribute_parent_id int NOT NULL,
  UNIQUE(value)
);

--
-- Dumping data for table attribute_value
--

INSERT INTO attribute_value (id, value, attribute_parent_id) VALUES
(30, '28', 6),
(31, '29', 6),
(32, '30', 6),
(33, '31', 6),
(34, '32', 6),
(35, '33', 6),
(36, '34', 6),
(37, '35', 6),
(38, '36', 6),
(39, '38', 6),
(40, '40', 6),
(41, '42', 6),
(43, 'S', 6),
(44, 'M', 6),
(45, 'L', 6),
(46, 'XL', 6),
(47, 'XXL', 6),
(48, 'XXXL', 6),
(49, '8S', 6),
(50, '10S', 6),
(51, '12S', 6),
(52, '14S', 6),
(53, '8R', 6),
(54, '10R', 6),
(55, '12R', 6),
(56, '14R', 6);

-- --------------------------------------------------------

--
-- Table structure for table categories
--

CREATE TABLE categories (
  id SERIAL PRIMARY KEY NOT NULL,
  name varchar(255) NOT NULL,
  active int NOT NULL,
  UNIQUE(name)
);

--
-- Dumping data for table categories
--

INSERT INTO categories (id, name, active) VALUES
(9, 'Jaket', 1),
(10, 'Jas', 1),
(11, 'Celana', 1),
(12, 'Vest', 1),
(13, 'Celana Pendek', 1),
(14, 'Bowtie', 1);

-- --------------------------------------------------------

--
-- Table structure for table groups
--

CREATE TABLE groups (
  id SERIAL PRIMARY KEY NOT NULL,
  group_name varchar(255) NOT NULL,
  permission text NOT NULL
);

--
-- Dumping data for table groups
--

INSERT INTO groups (id, group_name, permission) VALUES
(1, 'Administrator', 'a:36:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s::\"createGroup\";i:5;s::\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s::\"deleteGroup\";i:8;s::\"createItems\";i:9;s::\"updateItems\";i:10;s:9:\"viewItems\";i:;s::\"deleteItems\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s::\"createStore\";i:17;s::\"updateStore\";i:18;s:9:\"viewStore\";i:19;s::\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s::\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s::\"createOrder\";i:29;s::\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s::\"deleteOrder\";i:32;s:17:\"createMarketplace\";i:33;s:17:\"updateMarketplace\";i:34;s:15:\"viewMarketplace\";i:35;s:17:\"deleteMarketplace\";}'),
(5, 'Testing', 'a:36:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s::\"createGroup\";i:5;s::\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s::\"deleteGroup\";i:8;s::\"createItems\";i:9;s::\"updateItems\";i:10;s:9:\"viewItems\";i:;s::\"deleteItems\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s::\"createStore\";i:17;s::\"updateStore\";i:18;s:9:\"viewStore\";i:19;s::\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s::\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s::\"createOrder\";i:29;s::\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s::\"deleteOrder\";i:32;s:17:\"createMarketplace\";i:33;s:17:\"updateMarketplace\";i:34;s:15:\"viewMarketplace\";i:35;s:17:\"deleteMarketplace\";}'),
(6, 'Admin', 'a:36:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s::\"createGroup\";i:5;s::\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s::\"deleteGroup\";i:8;s::\"createItems\";i:9;s::\"updateItems\";i:10;s:9:\"viewItems\";i:;s::\"deleteItems\";i:12;s:14:\"createCategory\";i:13;s:14:\"updateCategory\";i:14;s:12:\"viewCategory\";i:15;s:14:\"deleteCategory\";i:16;s::\"createStore\";i:17;s::\"updateStore\";i:18;s:9:\"viewStore\";i:19;s::\"deleteStore\";i:20;s:15:\"createAttribute\";i:21;s:15:\"updateAttribute\";i:22;s:13:\"viewAttribute\";i:23;s:15:\"deleteAttribute\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s::\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s::\"createOrder\";i:29;s::\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s::\"deleteOrder\";i:32;s:17:\"createMarketplace\";i:33;s:17:\"updateMarketplace\";i:34;s:15:\"viewMarketplace\";i:35;s:17:\"deleteMarketplace\";}');

-- --------------------------------------------------------

--
-- Table structure for table items
--

CREATE TABLE items (
  id SERIAL PRIMARY KEY NOT NULL,
  name varchar(255) NOT NULL,
  active int NOT NULL,
  unique(name)
);

--
-- Dumping data for table items
--

INSERT INTO items (id, name, active) VALUES
(149, 'HI - SLIM', 1),
(150, 'HI - TAILORED\r', 1),
(151, 'SLR - SLIM', 1),
(152, 'SLR - TAILORED\r', 1),
(153, 'CVL-SLIM\r', 1),
(154, 'JB-SLIM\r', 1),
(155, 'JB- CBL\r', 1),
(156, 'TNT Abu slim\r', 1),
(157, 'TNT Biru tua SLIM\r', 1),
(158, 'TNT Hitam SLIM\r', 1),
(159, 'HI-PUTIH\r', 1),
(160, 'HI - COFFEE\r', 1),
(161, 'SLK- RDH\r', 1),
(162, 'SLK - RDCokelat\r', 1),
(163, 'SLK - RDB\r', 1),
(164, 'SLK - RDCharcoal\r', 1),
(165, 'SLK - RDA\r', 1),
(166, 'SLK - 2TONE\r', 1),
(167, 'HI - KHAKI\r', 1),
(168, 'UC-Khaki\r', 1),
(169, 'UC-Cokelat\r', 1),
(170, 'CVL-regular\r', 1),
(171, 'JB-regular\r', 1),
(172, 'TNT Abu REG\r', 1),
(173, 'TNT Biru tua REG\r', 1),
(174, 'TNT Hitam REG\r', 1),
(175, 'TNT Cokelat tua REG\r', 1),
(176, 'ALPAZIO-HTM\r', 1),
(177, 'WH X\r', 1),
(178, 'ALPAZIO-NAVY\r', 1),
(179, 'WB X\r', 1),
(180, 'Stretch khaki\r', 1),
(181, 'Stretch hitam\r', 1),
(182, 'Stretch abu\r', 1),
(183, 'Stretch cokelat\r', 1),
(195, 'UC-Abu\r', 1),
(204, 'WB X', 1),
(212, 'putih cvl K2\r', 1),
(213, 'CVL - K 2\r', 1),
(214, 'HI - K 1\r', 1),
(215, 'SLK - RDH\r', 1),
(219, 'JETBLACK - K2\r', 1),
(221, 'JB - CBL - K2\r', 1),
(222, 'JETBLACK - K1\r', 1),
(223, 'CVL - K1\r', 1),
(224, 'ALPAZIO-HTM-22\r', 1),
(225, 'ALPAZIO-ABU-05\r', 1),
(226, 'ALPAZIO-NAVY-14\r', 1),
(227, 'TNT ABU K2\r', 1),
(228, 'TNT HITAM K2\r', 1),
(229, 'TNT BIRU TUA K2\r', 1);

-- --------------------------------------------------------

--
-- Table structure for table marketplace
--

CREATE TABLE marketplace (
  id SERIAL PRIMARY KEY NOT NULL,
  marketplace_name varchar(255) NOT NULL,
  link text DEFAULT NULL,
  active int NOT NULL,
  UNIQUE(marketplace_name)
);

--
-- Dumping data for table marketplace
--

INSERT INTO marketplace (id, marketplace_name, link, active) VALUES
(2, 'Tokopedia', 'tokopedia.com/urbanact', 1),
(3, 'Shopee', 'shopee.com/urbanact', 1);

-- --------------------------------------------------------

--
-- Table structure for table orders
--

CREATE TABLE orders (
  id SERIAL PRIMARY KEY NOT NULL,
  bill_no varchar(255) NOT NULL,
  customer_name varchar(255) NOT NULL,
  customer_address varchar(255) DEFAULT NULL,
  customer_phone varchar(255) NOT NULL,
  date varchar(255) NOT NULL,
  marketplace int NOT NULL,
  gross_amount int NOT NULL,
  net_amount int NOT NULL,
  discount int DEFAULT NULL,
  user_id int NOT NULL,
  created_on date NOT NULL DEFAULT current_timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table orders_item
--

CREATE TABLE orders_item (
  id SERIAL PRIMARY KEY NOT NULL,
  order_id int NOT NULL,
  product_id int NOT NULL,
  qty varchar(255) NOT NULL,
  rate varchar(255) NOT NULL,
  amount varchar(255) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table products
--

CREATE TABLE products (
  id SERIAL PRIMARY KEY NOT NULL,
  name varchar(255) NOT NULL,
  hpp varchar(255) NOT NULL,
  price varchar(255) NOT NULL,
  qty varchar(255) NOT NULL,
  image text NOT NULL,
  description text NOT NULL,
  attribute_value_id int NOT NULL,
  items_id int NOT NULL,
  category_id int NOT NULL,
  store_id int NOT NULL,
  availability int NOT NULL,
  UNIQUE(name)
);

--
-- Dumping data for table products
--

INSERT INTO products (id, name, hpp, price, qty, image, description, attribute_value_id, items_id, category_id, store_id, availability) VALUES
(33, 'JB - H', '90000', '120000', '101', '<p>You did not select a file to upload.</p>', '', 45, 150, 10, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table stores
--

CREATE TABLE stores (
  id SERIAL PRIMARY KEY NOT NULL,
  name varchar(255) NOT NULL,
  active int NOT NULL,
  UNIQUE(name)
);

--
-- Dumping data for table stores
--

INSERT INTO stores (id, name, active) VALUES
(5, 'Teluk Gong', 1),
(7, 'Cengkareng', 1);

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  id SERIAL PRIMARY KEY NOT NULL,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  phone varchar(255) NOT NULL,
  group_id int NOT NULL,
  UNIQUE(username)
);

--
-- Dumping data for table users
--

INSERT INTO users (id, username, password, email, firstname, lastname, phone, group_id) VALUES
(1, 'super admin', '$2y$10$yfi5nUQGXUZtMdl27dWAyOd/jMOmATBpiUvJDmUu9hJ5Ro6BE5wsK', 'admin@admin.com', 'john', 'doe', '65646546', 1),
(13, 'urbanact', '$2y$10$n5qwLOk3IzWn8mQlP8QPw.z8bSRUuaFFdxqbsvr0XzCb1ycH7qvfu', 'urbanact@gmail.com', 'Urban', 'Act', '081291919', 6);


--
-- Constraints for table attribute_value
--
ALTER TABLE attribute_value
  ADD CONSTRAINT ref_attribute_parent_id FOREIGN KEY (attribute_parent_id) REFERENCES attributes (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table orders
--
ALTER TABLE orders
  ADD CONSTRAINT ref_marketplace_id FOREIGN KEY (marketplace) REFERENCES marketplace (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ref_user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table orders_item
--
ALTER TABLE orders_item
  ADD CONSTRAINT ref_order_id FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ref_product_id FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table products
--
ALTER TABLE products
  ADD CONSTRAINT ref_attribute_id FOREIGN KEY (attribute_value_id) REFERENCES attribute_value (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ref_category_id FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ref_item_id FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ref_store_id FOREIGN KEY (store_id) REFERENCES stores (id) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table users
--
ALTER TABLE users
  ADD CONSTRAINT ref_group_user FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE ON UPDATE CASCADE;
