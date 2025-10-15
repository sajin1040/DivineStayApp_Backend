-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2025 at 10:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `divinestay`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `hotel_name` varchar(150) NOT NULL,
  `hotel_image` varchar(255) DEFAULT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `adults` int(11) DEFAULT 1,
  `children` int(11) DEFAULT 0,
  `room_type` varchar(50) DEFAULT 'Standard',
  `nights` int(11) DEFAULT 1,
  `phone_number` varchar(20) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `platform_fee` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `religion_id` int(11) NOT NULL,
  `place_name` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `religion_id`, `place_name`, `state`, `image_url`) VALUES
(1, 1, 'Kashi Vishwanath', 'Uttar Pradesh', 'images/destinations/kashi.jpg'),
(2, 1, 'Tirupati Balaji', 'Andhra Pradesh', 'images/destinations/tirupati.jpg'),
(3, 1, 'Meenakshi Temple', 'Tamil Nadu', 'images/destinations/meenakshi.jpg'),
(4, 2, 'Jama Masjid', 'Delhi', 'images/destinations/jama_masjid.jpg'),
(5, 2, 'Charminar', 'Telangana', 'images/destinations/charminar.jpg'),
(6, 2, 'Haji Ali Dargah', 'Maharashtra', 'images/destinations/haji_ali.jpg'),
(7, 3, 'Velankanni Church', 'Tamil Nadu', 'images/destinations/velankanni.jpg'),
(8, 3, 'Basilica of Bom Jesus', 'Goa', 'images/destinations/bom_jesus.jpg'),
(9, 3, 'St. Paul’s Cathedral', 'West Bengal', 'images/destinations/paul_cathedral.jpg'),
(10, 4, 'Mahabodhi Temple', 'Bihar', 'images/destinations/mahabodhi.jpg'),
(11, 4, 'Sarnath', 'Uttar Pradesh', 'images/destinations/sarnath.jpg'),
(12, 4, 'Tawang Monastery', 'Arunachal Pradesh', 'images/destinations/tawang.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `hotel_id`) VALUES
(11, 4, 7),
(12, 4, 1),
(13, 4, 4),
(14, 4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `hotel_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `facilities` text DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `distance` varchar(20) DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `place_id`, `hotel_name`, `location`, `price_per_night`, `image_url`, `description`, `rating`, `facilities`, `latitude`, `longitude`, `distance`, `duration`) VALUES
(1, 1, 'Divine Kashi Inn', 'Varanasi, UP', 1200.00, 'images/hotels/kashi_inn.jpg', 'A peaceful retreat just steps from the sacred Kashi Vishwanath Temple, offering a serene traditional ambiance blended with modern amenities. Guests can enjoy spacious, well-ventilated rooms, authentic décor inspired by local heritage, and round-the-clock assistance for temple visits or city tours. Ideal for pilgrims seeking quiet reflection after a day of worship.', 4.50, 'AC Rooms, Free WiFi, 24x7 Reception, Room Service, Clean Beds, Power Backup, Breakfast Available, CCTV Security, Hot Water, Heritage Decor', 25.3108072, 83.0132603, '320 meters', '5 mins'),
(2, 2, 'Balaji Comfort Stay', 'Tirupati, AP', 1100.00, 'images/hotels/balaji_stay.jpg', 'Perfectly located for Balaji Darshan, this hotel combines convenience with a warm, family-friendly environment. Spotlessly clean rooms, attentive staff, and vegetarian dining options make it a favorite for devotees. After visiting the temple, relax in comfortable lounges or take advantage of travel assistance for nearby holy sites.', 4.20, 'AC Rooms, Free WiFi, 24x7 Reception, Room Service, Clean Beds, Power Backup, Free Breakfast, Lounge Area, Prayer Hall, Guided Temple Tours', 13.6816399, 79.3464804, '450 meters', '8 mins'),
(3, 3, 'Meenakshi Heritage', 'Madurai, TN', 1300.00, 'images/hotels/meenakshi_heritage.jpg', 'Stay within walking distance of the famous Meenakshi Temple and immerse yourself in rich South Indian culture. The interiors feature intricate carvings and vibrant colors that reflect centuries of tradition, while modern comforts like WiFi and air-conditioning ensure a restful experience. Ideal for travelers seeking both spiritual connection and authentic regional charm.', 4.30, 'AC Rooms, Free WiFi, 24x7 Reception, Room Service, Clean Beds, Power Backup, Hot Water, Vegetarian Dining, Shoe Storage for Temple Visits, Early Morning Check-in', 9.9501629, 78.1116552, '120 meters', '2 mins'),
(4, 4, 'Hazrat Stay Inn', 'Ajmer, RJ', 1000.00, 'images/hotels/ajmer_stay.jpg', 'Ideal stay for pilgrims visiting the sacred Ajmer Sharif Dargah, offering a serene and spiritual atmosphere.\nSpacious rooms with modern comforts ensure restful nights after prayers and ziyarat.\nClose to local markets for traditional handicrafts and authentic Rajasthani cuisine.\nDedicated prayer space and courteous staff to guide first-time visitors.\nPerfect balance of devotion, comfort, and cultural experience.', 4.10, 'Prayer Area, Daily Housekeeping, Free WiFi, Air Conditioning, AC Rooms, Local Cuisine, Taxi Service, Room Heater, 24-Hour Front Desk, Laundry Service', 26.4479821, 74.5954297, '280 meters', '4 mins'),
(5, 5, 'Charminar Residency', 'Hyderabad, TS', 950.00, 'images/hotels/charminar_residency.jpg', 'Elegant ambiance just steps away from the iconic Charminar and grand Mecca Masjid.\nBeautiful interiors with traditional Hyderabadi decor and warm hospitality.\nEnjoy evening walks through historic lanes filled with pearls and aromatic biryani.\nFacilities include dedicated prayer area and family-friendly services.\nAn authentic blend of heritage charm and modern convenience.', 4.00, 'Prayer Area, Free WiFi, Air Conditioning, AC Rooms, Daily Housekeeping, TV, Parking, Taxi Service, Laundry Service, Halal Dining Options', 17.3615636, 76.0356997, '410 meters', '7 mins'),
(6, 6, 'Nizam Hotel', 'Lucknow, UP', 1150.00, 'images/hotels/nizam_hotel.jpg', 'Stay in the heart of Lucknow’s royal Nawabi heritage, where culture meets comfort.\nSpacious, well-appointed rooms reflect Mughal-inspired architecture and style.\nClose to famous Imambaras, bustling chowks, and vibrant food streets.\nPersonalized services ensure a memorable and peaceful pilgrimage experience.\nIdeal for travelers seeking history, spirituality, and refined luxury.', 4.40, 'Prayer Area, Free WiFi, AC Rooms, Air Conditioning, Daily Housekeeping, Room Heater, 24-Hour Front Desk, Taxi Service, Parking, Complimentary Tea/Coffee', 18.9827148, 72.8062926, '150 meters', '3 mins'),
(7, 7, 'Velankanni Comfort Inn', 'Velankanni, TN', 1250.00, 'images/hotels/velankanni_inn.jpg', 'Just minutes from the revered Velankanni Shrine, this welcoming hotel is ideal for families and large groups.\nSpacious rooms and warm hospitality create a peaceful base for prayer and reflection.\nGuests enjoy easy access to the basilica grounds and nearby devotional shops.\nModern comforts blend with a calm, faith-filled atmosphere.', 4.30, 'Free WiFi, Cable TV, Free Breakfast, Luggage Storage, Air Conditioning, Minibar, Daily Housekeeping, Prayer Room, 24-Hour Reception, Airport Shuttle', 10.6803019, 79.8472978, '490 meters', '12 mins'),
(8, 8, 'San Thome Suites', 'Ella, Goa', 1350.00, 'images/hotels/santhome_suites.jpg', 'Experience a luxurious beachside escape only steps from the historic San Thome Cathedral.\nElegant rooms with ocean views pair perfectly with serene prayer spaces.\nRelax with premium amenities and attentive service after a day of devotion or sightseeing.\nPerfect for couples or pilgrims seeking both comfort and inspiration.', 4.50, 'Sea View, Room Service, Air Conditioning, Minibar, Garden View, Free WiFi, Daily Housekeeping, Private Balcony, Laundry Service, Complimentary Parking', 15.500829, 73.9088258, '230 meters', '4 mins'),
(9, 9, 'St. Francis Guest House', 'Maidan, WB', 1100.00, 'images/hotels/stfrancis_guest.jpg', 'Stay in a lovingly preserved Portuguese-colonial guest house rich in history and charm.\nArched verandas and antique furnishings capture centuries of Christian heritage.\nA quiet garden courtyard invites reflection after visiting nearby churches.\nCombines old-world character with modern conveniences for a memorable pilgrimage.', 4.20, 'Lounge Area, WiFi, Free Breakfast, Cable TV, Room Heater, Power Backup, Conference Hall, Elevator Access, In-House Chapel Access, Taxi Service', 22.5442755, 88.3440729, '390 meters', '7 mins'),
(10, 10, 'Bodh Gaya Inn', 'Bodh Gaya, BR', 1000.00, 'images/hotels/bodhgaya_inn.jpg', 'Peaceful retreat located beside the sacred Mahabodhi Temple, ideal for meditation and inner reflection.\nSurrounded by lush gardens and gentle walking paths that encourage mindfulness.\nSpacious rooms with natural light and calming décor promote a serene atmosphere.\nVegetarian meals and a dedicated meditation hall create the perfect spiritual setting.\nPerfect choice for pilgrims and seekers of quiet rejuvenation.', 4.60, 'Meditation Room, Vegetarian Meals, AC Rooms, Garden, WiFi, On-Site Café, Walking Paths, Yoga Deck, Organic Food, Travel Desk', 24.6959271, 84.988839, '200 meters', '3 mins'),
(11, 11, 'Sarnath Stay Lodge', 'Sarnath, UP', 950.00, 'images/hotels/sarnath_lodge.jpg', 'Budget-friendly lodge tucked away in a calm neighborhood near ancient Buddhist Stupas.\nOffers simple yet comfortable rooms designed for restful stays after temple visits.\nComplimentary WiFi and 24-hour reception ensure convenience for all travelers.\nLocal vegetarian eateries and peaceful lanes surround the property.\nIdeal for backpackers and spiritual explorers seeking affordability and comfort.', 4.10, 'Meditation Hall, Herbal Tea Lounge, Air Conditioning, Library of Buddhist Texts, Free WiFi, Garden Courtyard, Yoga Pavilion, Organic Vegetarian Cuisine, Guided Temple Tours, Peaceful Walking Trails', 25.3715612, 83.0226333, '470 meters', '11 mins'),
(12, 12, 'Kushinagar Retreat', 'Kushinagar, UP', 1150.00, 'images/hotels/kushinagar_retreat.jpg', 'Tranquil retreat crafted for spiritual travelers with a blend of tradition and modern comfort.\nFeatures a meditation deck, yoga spaces, and eco-friendly interiors for holistic well-being.\nRooms provide soothing colors, soft lighting, and fresh air for complete relaxation.\nGuests can enjoy organic meals and participate in daily mindfulness sessions.\nA harmonious base for exploring nearby monasteries and sacred sites.', 4.40, 'Silent Meditation Area, Eco-Friendly Rooms, Fan Rooms, Mindfulness Workshop Space, Free WiFi, Rooftop Yoga Deck, Organic Farm-to-Table Dining, Scenic Garden Paths, Travel Assistance Desk, Evening Chanting Sessions', 26.0675663, 86.0466271, '350 meters', '6 mins');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT 'booking',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `type`, `created_at`) VALUES
(19, 4, 'Your booking for \'Velankanni Comfort Inn\' is confirmed.', 'booking', '2025-09-25 04:56:53'),
(20, 4, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-13 08:34:37'),
(21, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 06:44:04'),
(22, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 06:44:32'),
(23, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 06:44:33'),
(24, 5, 'Your booking for \'Meenakshi Heritage\' is confirmed.', 'booking', '2025-10-15 06:46:04'),
(25, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 06:55:22'),
(26, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 06:57:49'),
(27, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 07:23:09'),
(28, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 07:31:01'),
(29, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 07:31:03'),
(30, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 07:39:50'),
(31, 5, 'Your booking for \'\' is confirmed.', 'booking', '2025-10-15 07:40:12'),
(32, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 07:45:13'),
(33, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 07:45:55'),
(34, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 07:55:03'),
(35, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 08:02:15'),
(36, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 08:07:54'),
(37, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 08:08:03'),
(38, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 08:08:06'),
(39, 5, 'Your booking for \'Hazrat Stay Inn\' is confirmed.', 'booking', '2025-10-15 08:08:40'),
(40, 5, 'Your booking for \'Hazrat Stay Inn\' is confirmed.', 'booking', '2025-10-15 08:09:27'),
(41, 5, 'Your booking for \'Divine Kashi Inn\' is confirmed.', 'booking', '2025-10-15 08:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `popular_places`
--

CREATE TABLE `popular_places` (
  `id` int(11) DEFAULT NULL,
  `religion_id` int(11) DEFAULT NULL,
  `place_name` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `image_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `popular_places`
--

INSERT INTO `popular_places` (`id`, `religion_id`, `place_name`, `state`, `image_url`) VALUES
(1, 1, 'Kashi Vishwanath', 'Uttar Pradesh', 'images/destinations/kashi.jpg'),
(4, 2, 'Jama Masjid', 'Delhi', 'images/destinations/jama_masjid.jpg'),
(7, 3, 'Velankanni Church', 'Tamil Nadu', 'images/destinations/velankanni.jpg'),
(10, 4, 'Mahabodhi Temple', 'Bihar', 'images/destinations/mahabodhi.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `recent_searches`
--

CREATE TABLE `recent_searches` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `search_query` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `religions`
--

CREATE TABLE `religions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `religion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `religions`
--

INSERT INTO `religions` (`id`, `name`, `image_url`, `religion_id`) VALUES
(1, 'Hinduism', 'images/religions/hinduism.jpg', 1),
(2, 'Islam', 'images/religions/islam.jpg', 2),
(3, 'Christianity', 'images/religions/christianity.jpg', 3),
(4, 'Buddhism', 'images/religions/buddhism.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `timestamp`) VALUES
(4, 'sajin', 'akash', 'sajinchriz@gmail.com', '$2y$10$8sMZhfi1zLktXnb.EZJI/eFj4kHkLHrMs1nbA2BO.1xdpFHszTLwa', '9585840730', '2025-08-08 09:47:35'),
(5, 'User', 'demo', 'user@gmail.com', '$2y$10$J2YknYZ5ylSfMPyVNIts0OPaBw5WCFygK8Iyt.AELI8vB5Hg835Fi', '9876543210', '2025-10-13 10:42:01'),
(6, 'suresh', 'kannan', 'suresh@yahoo.com', '$2y$10$HFUYpphxQHQQd4VycZBl.ug1.uLbosyq7jKIwAf61gJRs6yW8sdra', '1234560045', '2025-10-15 06:23:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `religion_id` (`religion_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recent_searches`
--
ALTER TABLE `recent_searches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `religions`
--
ALTER TABLE `religions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `recent_searches`
--
ALTER TABLE `recent_searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `destinations`
--
ALTER TABLE `destinations`
  ADD CONSTRAINT `destinations_ibfk_1` FOREIGN KEY (`religion_id`) REFERENCES `religions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recent_searches`
--
ALTER TABLE `recent_searches`
  ADD CONSTRAINT `recent_searches_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
