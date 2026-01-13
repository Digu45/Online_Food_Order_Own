-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 13, 2026 at 06:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'digu', '1441');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_master`
--

CREATE TABLE `hotel_master` (
  `HotelName` varchar(255) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `ContactNo` varchar(20) DEFAULT NULL,
  `LogoUrl` text DEFAULT NULL,
  `WhatsAppNumber` varchar(20) DEFAULT NULL,
  `InstaUrl` text DEFAULT NULL,
  `FacebookUrl` text DEFAULT NULL,
  `GooglePageUrl` text DEFAULT NULL,
  `Website` varchar(255) DEFAULT NULL,
  `LocationLink` text DEFAULT NULL,
  `AboutUs` text DEFAULT NULL,
  `HotelImageUrl` text DEFAULT NULL,
  `table_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_master`
--

INSERT INTO `hotel_master` (`HotelName`, `Address`, `ContactNo`, `LogoUrl`, `WhatsAppNumber`, `InstaUrl`, `FacebookUrl`, `GooglePageUrl`, `Website`, `LocationLink`, `AboutUs`, `HotelImageUrl`, `table_name`) VALUES
('Digus Restaurant', 'Near Rankala Lake Kolhapur', '9309475959', 'https://xpresshotelerp.com/menucard-img/upload/6_logo.jpg', '9309475959', 'https://www.instagram.com/dig_vapilkar_45/', 'https://www.facebook.com/RNSoftwaresAndConsultors/', 'https://posts.gle/jr9YeD', 'www.rnsoftwares.co.in', 'https://g.page/xpresshotel?share', 'Digus Restaurant, founded in the year 2011', 'https://www.makemytrip.com/travel-guide/media/dg_image/macau/Aruna-Indian-Curry-and-Cafe-House.jpg', 'R1');

-- --------------------------------------------------------

--
-- Table structure for table `item_group_master`
--

CREATE TABLE `item_group_master` (
  `ItemGroupId` int(11) NOT NULL,
  `ItemGroupName` varchar(255) NOT NULL,
  `status_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_group_master`
--

INSERT INTO `item_group_master` (`ItemGroupId`, `ItemGroupName`, `status_id`) VALUES
(141, 'Food', 1),
(145, 'Bar', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `sr_no` int(5) NOT NULL,
  `MenuID` int(5) NOT NULL,
  `MenuName` varchar(255) NOT NULL,
  `MenuImageUrl` varchar(100) DEFAULT NULL,
  `Description` text NOT NULL,
  `Rate` decimal(10,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `MenuTypeID` int(11) NOT NULL,
  `MobileNo` varchar(10) NOT NULL,
  `DeviceID` varchar(100) NOT NULL,
  `Instructions` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`sr_no`, `MenuID`, `MenuName`, `MenuImageUrl`, `Description`, `Rate`, `Quantity`, `Amount`, `MenuTypeID`, `MobileNo`, `DeviceID`, `Instructions`) VALUES
(156, 24, 'Egg Biryani', 'https://spicecravings.com/wp-content/uploads/2020/10/Egg-Biryani-Featured-1.jpg', 'Egg biryani with boiled eggs', 240.00, 1, 240.00, 2, '', '4a5a418cade0d30dad1296aee6f79965', NULL),
(154, 20, 'Chicken Biryani', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwaF6-1Auf1DuOXo9FhalxTrx1j-BnkoOu4A&s', 'Traditional chicken biryani with spices', 300.40, 1, 300.40, 2, '', '4a5a418cade0d30dad1296aee6f79965', NULL),
(155, 21, 'Mutton Biryani', 'https://www.cubesnjuliennes.com/wp-content/uploads/2021/03/Best-Mutton-Biryani-Recipe.jpg', 'Slow cooked mutton biryani', 380.00, 1, 380.00, 2, '', '4a5a418cade0d30dad1296aee6f79965', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_master`
--

CREATE TABLE `menu_master` (
  `MenuId` int(11) NOT NULL,
  `MenuSubCategoryName` varchar(100) DEFAULT NULL,
  `MenuName` varchar(255) DEFAULT NULL,
  `MenuImageUrl` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Rate` decimal(10,2) DEFAULT NULL,
  `MenuTypeId` int(11) DEFAULT NULL,
  `Discount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_master`
--

INSERT INTO `menu_master` (`MenuId`, `MenuSubCategoryName`, `MenuName`, `MenuImageUrl`, `Description`, `Rate`, `MenuTypeId`, `Discount`) VALUES
(20, 'Biryani', 'Chicken Biryani', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwaF6-1Auf1DuOXo9FhalxTrx1j-BnkoOu4A&s', 'Traditional chicken biryani with spices', 300.40, 2, 10.00),
(21, 'Biryani', 'Mutton Biryani', 'https://www.cubesnjuliennes.com/wp-content/uploads/2021/03/Best-Mutton-Biryani-Recipe.jpg', 'Slow cooked mutton biryani', 380.00, 2, 12.00),
(22, 'Biryani', 'Veg Biryani', 'data:image/jpeg;base64,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', 'Mixed vegetable biryani', 220.00, 1, 8.00),
(24, 'Biryani', 'Egg Biryani', 'https://spicecravings.com/wp-content/uploads/2020/10/Egg-Biryani-Featured-1.jpg', 'Egg biryani with boiled eggs', 240.00, 2, 9.00),
(25, 'Starters', 'Chicken Tikka', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_7EmdH71bX6lKH9qRzkm70schQnx1_q05Ug&s', 'Grilled chicken tikka', 280.00, 2, 10.00),
(26, 'Starters', 'Paneer Tikka', 'https://www.indianveggiedelight.com/wp-content/uploads/2021/08/air-fryer-paneer-tikka-featured.jpg', 'Grilled paneer cubes', 260.00, 1, 9.00),
(27, 'Starters', 'Veg Manchurian', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS8U6Z3mjWIladtAvQb-Uz6I-S6cXZXTTFK2Q&s', 'Crispy veg balls in sauce', 190.00, 1, 7.00),
(28, 'Starters', 'Chicken Manchurian', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEgAtrinlnlAFg1jvyspOO2uW37LS7UU-HWw&s', 'Chicken tossed in manchurian sauce', 230.00, 2, 8.00),
(29, 'Starters', 'Hara Bhara Kabab', 'https://palatesdesire.com/wp-content/uploads/2021/06/Untitled-design-1.jpg', 'Spinach and pea kababs', 180.00, 1, 6.00),
(30, 'Main Course', 'Butter Chicken', 'https://www.licious.in/blog/wp-content/uploads/2020/10/butter-chicken--600x600.jpg', 'Creamy tomato chicken curry', 320.00, 2, 12.00),
(31, 'Main Course', 'Paneer Butter Masala', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU2GVSX6yMjCLHtHBaQwyqjUw1rkC1sF9H8g&s', 'Paneer in buttery gravy', 290.00, 1, 10.00),
(32, 'Main Course', 'Dal Tadka', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVMGvL1fKs_FIa6SSdCictZQ1YnLRGEcsQYg&s', 'Yellow dal tempered with spices', 180.00, 1, 5.00),
(33, 'Main Course', 'Chicken Curry', 'https://kitchenofdebjani.com/wp-content/uploads/2023/04/easy-indian-chicken-curry-Recipe-for-beginners-Debjanir-rannaghar.jpg', 'Spicy chicken curry', 300.00, 2, 10.00),
(34, 'Main Course', 'Veg Kolhapuri', 'https://www.vegrecipesofindia.com/wp-content/uploads/2022/05/veg-kolhapuri-recipe-2-500x500.jpg', 'Spicy mixed veg curry', 220.00, 1, 8.00),
(35, 'Snacks', 'Samosa', 'https://instamart-media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,h_960,w_960//InstamartAssets/samosa.webp?updatedAt=1727156367955', 'Crispy potato samosa', 40.00, 1, 2.00),
(36, 'Snacks', 'Veg Pakora', 'https://static.toiimg.com/thumb/58416335.cms?imgsize=417147&width=800&height=800', 'Deep fried veg fritters', 120.00, 1, 5.00),
(37, 'Snacks', 'Chicken Pakora', 'https://www.yellowthyme.com/wp-content/uploads/2024/08/Chicken-pakora-3.jpg', 'Crispy chicken fritters', 160.00, 2, 6.00),
(38, 'Snacks', 'Paneer Pakora', 'https://foodtrails25.com/wp-content/uploads/2022/02/chutney-paneer-pakora-featured.jpg', 'Paneer dipped in gram flour', 150.00, 1, 5.00),
(39, 'Snacks', 'French Fries', 'https://kirbiecravings.com/wp-content/uploads/2019/09/easy-french-fries-1-500x500.jpg', 'Crispy potato fries', 110.00, 1, 4.00),
(40, 'Beverages', 'Cold Coffee', 'https://www.whiskaffair.com/wp-content/uploads/2021/03/Cold-Coffee-2-3-500x500.jpg', 'Chilled coffee with milk', 120.00, 1, 5.00),
(41, 'Beverages', 'Masala Tea', 'https://cdn.shopify.com/s/files/1/0758/6929/0779/files/Masala_Tea_-_Annams_Recipes_Shop_2_480x480.jpg?v=1732347934', 'Indian spiced tea', 40.00, 1, 2.00),
(42, 'Beverages', 'Lassi', 'https://www.indianveggiedelight.com/wp-content/uploads/2023/01/sweet-lassi-recipe-featured.jpg', 'Sweet yogurt drink', 90.00, 1, 4.00),
(43, 'Beverages', 'Fresh Lime Soda', 'https://sattvakitchen.com/wp-content/uploads/2024/05/SWEET-LIME-SODA-shutterstock_2309599743-copy-Copy-copy.jpg', 'Refreshing lime soda', 80.00, 1, 3.00),
(44, 'Beverages', 'Butter Milk', 'https://instamart-media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,h_960,w_960//InstamartAssets/buttermilk.webp?updatedAt=1727162114085', 'Spiced butter milk', 60.00, 1, 3.00),
(45, 'Main Course', 'Chicken Handi', 'https://instamart-media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,h_960,w_960//InstamartAssets/chicken_handi.webp', 'Chicken cooked in handi style', 340.00, 2, 12.00),
(46, 'Main Course', 'Veg Handi', 'https://www.vegrecipesofindia.com/wp-content/uploads/2014/11/veg-diwani-handi-recipe-1.jpg', 'Vegetables cooked in handi gravy', 260.00, 1, 9.00),
(47, 'Main Course', 'Mutton Curry', 'https://www.licious.in/blog/wp-content/uploads/2020/12/Mutton-Curry.jpg', 'Spicy mutton curry', 390.00, 2, 15.00),
(48, 'Main Course', 'Paneer Kadai', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcScVAKa5Hd4RaGtsmBVshz3hO4hdZ1A5ZSx_w&s', 'Paneer with capsicum and spices', 300.00, 1, 10.00),
(49, 'Main Course', 'Egg Curry', 'https://www.kitchensanctuary.com/wp-content/uploads/2025/02/Egg-Curry-Square-FS.jpg', 'Boiled eggs in spicy gravy', 210.00, 2, 7.00),
(50, 'Starters', 'Chicken Soup', 'https://www.tasteofhome.com/wp-content/uploads/2024/08/Creamy-Tuscan-Chicken-Soup_EXPS_FT24_277472_EC_080724_1.jpg', 'Hot chicken soup', 150.00, 2, 5.00),
(51, 'Starters', 'Veg Soup', 'https://www.connoisseurusveg.com/wp-content/uploads/2024/02/vegetable-noodle-soup-sq.jpg', 'Mixed vegetable soup', 130.00, 1, 4.00),
(52, 'Starters', 'Sweet Corn Soup', 'https://www.kitchensanctuary.com/wp-content/uploads/2023/06/Chicken-and-Sweetcorn-Soup-square-FS.jpg', 'Sweet corn vegetable soup', 140.00, 1, 4.00),
(53, 'Starters', 'Chicken Lollipop', 'https://www.cookwithkushi.com/wp-content/uploads/2022/01/best_chicken_lollipop_drums_of_chicken.jpg', 'Fried chicken lollipop', 260.00, 2, 9.00),
(54, 'Starters', 'Crispy Corn', 'https://seasonalflavours.net/wp-content/uploads/2022/07/cripsy-corn-serving-dish.jpg', 'Fried crispy corn', 180.00, 1, 6.00),
(55, 'Snacks', 'Veg Burger', 'https://images.immediate.co.uk/production/volatile/sites/30/2020/10/Secret-Veg-Cheeseburgers-c981dd6.jpg', 'Veg patty burger', 120.00, 1, 5.00),
(56, 'Snacks', 'Chicken Burger', 'https://hips.hearstapps.com/hmg-prod/images/chicken-burgers-index-667b185b5f528.jpg?crop=0.500xw:1.00xh;0.282xw,0&resize=1200:*', 'Chicken patty burger', 150.00, 2, 6.00),
(57, 'Snacks', 'Veg Pizza', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAuIWVImcsHeJN6y_yYNzl9aZXoepG9Vg1CQ&s', 'Cheese loaded veg pizza', 220.00, 1, 8.00),
(58, 'Snacks', 'Chicken Pizza', 'https://media.istockphoto.com/id/1340589333/photo/homemade-indian-chicken-tikka-masala-pizza.jpg?s=612x612&w=0&k=20&c=QetWD3UJeCFoTq6OYNJehauw7Utc8MxH6B90Cb9zvLw=', 'Chicken toppings pizza', 260.00, 2, 10.00),
(59, 'Snacks', 'Paneer Sandwich', 'https://www.cookwithmanali.com/wp-content/uploads/2021/04/Smoked-Tandoori-Paneer-Sandwich-500x500.jpg', 'Grilled paneer sandwich', 140.00, 1, 5.00),
(60, 'Biryani', 'Hyderabadi Chicken Biryani', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQoIycguxFgTpIN3L00tYQhJ2WkypXj5w_QkQ&s', 'Authentic hyderabadi style biryani', 340.00, 2, 12.00),
(61, 'Biryani', 'Lucknowi Biryani', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7QFZUmujYAbgCdAwHinByVrqvRhzKaNTZzA&s', 'Awadhi style biryani', 360.00, 2, 12.00),
(62, 'Biryani', 'Mushroom Biryani', 'https://www.cookwithkushi.com/wp-content/uploads/2015/09/best_quick_easy_veg_mushroom_biryani.jpg', 'Spicy mushroom biryani', 260.00, 1, 9.00),
(63, 'Starters', 'Chicken Seekh Kabab', 'https://www.indianhealthyrecipes.com/wp-content/uploads/2024/02/chicken-seekh-kabab-recipe.jpg', 'Juicy minced chicken kababs', 280.00, 2, 10.00),
(64, 'Starters', 'Veg Cutlet', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbMf1s3IzmvuBKRhukMUKTaSgJzREt7v432w&s', 'Crispy vegetable cutlet', 140.00, 1, 5.00),
(65, 'Starters', 'Fish Fry', 'https://www.licious.in/blog/wp-content/uploads/2022/05/shutterstock_1116124928.jpg', 'Crispy fried fish', 320.00, 2, 12.00),
(66, 'Main Course', 'Chicken Korma', 'https://www.masalakorb.com/wp-content/uploads/2015/04/Quick-Chicken-Korma-V1.jpg', 'Creamy chicken curry', 330.00, 2, 11.00),
(67, 'Main Course', 'Malai Kofta', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSmhV6ZEiWU3bd22lF4iFh5kKJYwNxSYlRSfQ&s', 'Paneer kofta in rich gravy', 290.00, 1, 10.00),
(68, 'Main Course', 'Rajma Masala', 'https://www.cookwithmanali.com/wp-content/uploads/2014/10/Rajma-Kidney-Beans-Curry.jpg', 'Red kidney beans curry', 220.00, 1, 8.00),
(69, 'Chinese', 'Veg Hakka Noodles', 'https://www.whiskaffair.com/wp-content/uploads/2020/10/Veg-Hakka-Noodles-2-3.jpg', 'Stir fried veg noodles', 210.00, 1, 7.00),
(70, 'Chinese', 'Chicken Hakka Noodles', 'https://tiffinandteaofficial.com/wp-content/uploads/2020/11/IMG_7663-1-scaled-e1605519663454.jpg', 'Chicken noodles', 240.00, 2, 8.00),
(71, 'Chinese', 'Veg Fried Rice', 'https://www.whiskaffair.com/wp-content/uploads/2018/11/Vegetable-Fried-Rice-2-3.jpg', 'Fried rice with vegetables', 200.00, 1, 7.00),
(72, 'Chinese', 'Chicken Fried Rice', 'https://www.eatingonadime.com/wp-content/uploads/2022/11/eod-ground-chicken-fried-rice-10.jpg', 'Chicken fried rice', 230.00, 2, 8.00),
(73, 'Chinese', 'Chilli Paneer', 'https://spicecravings.com/wp-content/uploads/2022/01/Chilli-Paneer-Featured-2.jpg', 'Paneer tossed in spicy sauce', 260.00, 1, 9.00),
(74, 'South Indian', 'Masala Dosa', 'https://shop.sresthproducts.com/wp-content/uploads/2024/12/masala-dosa-1200x675.jpg', 'Crispy dosa with potato filling', 150.00, 1, 5.00),
(75, 'South Indian', 'Plain Dosa', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7AxRY49COoG_4Q9_acZwQp0MWHwUGFIoQpQ&s', 'Traditional plain dosa', 120.00, 1, 4.00),
(76, 'South Indian', 'Idli Sambhar', 'https://instamart-media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,h_960,w_960//InstamartAssets/Receipes/sambhar_idli.webp', 'Steamed idli with sambhar', 110.00, 1, 4.00),
(77, 'South Indian', 'Vada Sambhar', 'https://t4.ftcdn.net/jpg/04/34/93/43/360_F_434934399_px1pXbG9U4NU5H10kCPkkwlKfOwREZVu.jpg', 'Crispy vada with sambhar', 130.00, 1, 5.00),
(78, 'South Indian', 'Uttapam', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5ki8o6GETlaoyqdgCZnM_G4M1fFj0DuRsgQ&s', 'Thick dosa with toppings', 160.00, 1, 6.00),
(79, 'Snacks', 'Pav Bhaji', 'https://upload.wikimedia.org/wikipedia/commons/4/4a/Bambayya_Pav_bhaji.jpg', 'Spicy mashed vegetables with pav', 180.00, 1, 6.00),
(80, 'Snacks', 'Vada Pav', 'https://instamart-media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,h_960,w_960//InstamartAssets/Receipes/schezwan_vada_pav.webp', 'Mumbai special vada pav', 80.00, 1, 3.00),
(81, 'Snacks', 'Chicken Roll', 'https://www.licious.in/blog/wp-content/uploads/2022/12/Shutterstock_2132499279.jpg', 'Chicken wrapped roll', 160.00, 2, 6.00),
(82, 'Snacks', 'Paneer Roll', 'https://spicecravings.com/wp-content/uploads/2020/12/Paneer-kathi-Roll-Featured-1.jpg', 'Paneer wrapped roll', 150.00, 1, 5.00),
(83, 'Fast Food', 'Veg Sandwich', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5mxPW-2W_xvjQBjAAn4Go4OGQVlTpCAU4nA&s', 'Grilled vegetable sandwich', 120.00, 1, 4.00),
(84, 'Fast Food', 'Chicken Sandwich', 'https://c.ndtvimg.com/2021-07/vckh316o_grilled-chicken-sandwich_625x300_28_July_21.jpg', 'Grilled chicken sandwich', 150.00, 2, 5.00),
(85, 'Fast Food', 'Veg Momos', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSP72-PzEpnLqD91YFoBQOFyLcH34FE_3kcNw&s', 'Steamed veg momos', 140.00, 1, 5.00),
(86, 'Fast Food', 'Chicken Momos', 'https://meatington.com/cdn/shop/files/ChickenMomos.jpg?v=1709983319&width=480', 'Steamed chicken momos', 170.00, 2, 6.00),
(87, 'Desserts', 'Gulab Jamun', 'https://bakewithzoha.com/wp-content/uploads/2023/04/gulab-jamun-featured.jpg', 'Sweet milk dumplings', 90.00, 1, 3.00),
(88, 'Desserts', 'Rasgulla', 'https://i0.wp.com/www.ramasrey.com/wp-content/uploads/2018/08/Rasgulla.jpg?fit=560%2C560&ssl=1', 'Soft cottage cheese balls', 100.00, 1, 3.00),
(89, 'Desserts', 'Ice Cream', 'https://www.indianhealthyrecipes.com/wp-content/uploads/2022/04/homemade-ice-cream-recipe.jpg', 'Assorted ice cream scoops', 120.00, 1, 4.00),
(90, 'Desserts', 'Brownie', 'https://icecreambakery.in/wp-content/uploads/2024/12/Brownie-Recipe-with-Cocoa-Powder-1200x821.jpg', 'Chocolate brownie', 150.00, 1, 5.00),
(91, 'Beverages', 'Mango Shake', 'https://www.funfoodfrolic.com/wp-content/uploads/2021/05/Mango-Shake-Thumbnail.jpg', 'Fresh mango milkshake', 130.00, 1, 4.00),
(92, 'Beverages', 'Chocolate Shake', 'https://static.toiimg.com/thumb/84170265.cms?imgsize=299797&width=800&height=800', 'Chocolate milkshake', 140.00, 1, 5.00),
(93, 'Beverages', 'Green Tea', 'https://images.ctfassets.net/e8bhhtr91vp3/7ABcGFEo7JEFhG5XWuqA3D/e850cd98c6646b119fd645e29341baca/Hero2_HOW-TO-GREEN-TEA_17315-mob.webp?w=800&q=50', 'Healthy green tea', 80.00, 1, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `M_Ledgers`
--

CREATE TABLE `M_Ledgers` (
  `LedgerId` int(11) NOT NULL,
  `LedgerName` varchar(30) NOT NULL,
  `Hotelid` int(11) NOT NULL,
  `StatusID` tinyint(1) NOT NULL,
  `LedgerType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `M_Ledgers`
--

INSERT INTO `M_Ledgers` (`LedgerId`, `LedgerName`, `Hotelid`, `StatusID`, `LedgerType`) VALUES
(1, 'Digvijay', 56, 1, 1),
(2, 'Suhas', 56, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `placeorder`
--

CREATE TABLE `placeorder` (
  `OrderId` int(11) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `total_tax_amt` decimal(10,2) NOT NULL,
  `rounded_amt` decimal(10,2) NOT NULL,
  `grand_amt` decimal(10,2) NOT NULL,
  `table_id` varchar(50) NOT NULL,
  `Instructions` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Preparing','Completed','Cancelled') NOT NULL,
  `status_id` tinyint(1) DEFAULT 0,
  `payment_method` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `order_group_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `item_group_master`
--
ALTER TABLE `item_group_master`
  ADD PRIMARY KEY (`ItemGroupId`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `menu_master`
--
ALTER TABLE `menu_master`
  ADD PRIMARY KEY (`MenuId`);

--
-- Indexes for table `M_Ledgers`
--
ALTER TABLE `M_Ledgers`
  ADD PRIMARY KEY (`LedgerId`);

--
-- Indexes for table `placeorder`
--
ALTER TABLE `placeorder`
  ADD PRIMARY KEY (`OrderId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_group_master`
--
ALTER TABLE `item_group_master`
  MODIFY `ItemGroupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `sr_no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `M_Ledgers`
--
ALTER TABLE `M_Ledgers`
  MODIFY `LedgerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `placeorder`
--
ALTER TABLE `placeorder`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
