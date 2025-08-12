-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2025 at 09:32 PM
-- Server version: 10.5.29-MariaDB
-- PHP Version: 8.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectr_learn`
--

-- --------------------------------------------------------

--
-- Table structure for table `ln_affiliate_products`
--

CREATE TABLE `ln_affiliate_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(450) NOT NULL,
  `product_id` varchar(4500) NOT NULL,
  `affiliate_link` varchar(450) NOT NULL,
  `affiliate_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_affiliate_products`
--

INSERT INTO `ln_affiliate_products` (`id`, `user_id`, `product_id`, `affiliate_link`, `affiliate_id`) VALUES
(4, '5', 'TH563330', 'http://text/learnora/events?slug=testing&affiliate=QUZGLTYwRUZERjI2MTgxQw==', 'AFF-60EFDF26181C'),
(5, '5', 'TH371730', 'http://text/learnora/events?slug=diploma-in-caregiving&affiliate=QUZGLTYwRUZERjI2MTgxQw==', 'AFF-60EFDF26181C');

-- --------------------------------------------------------

--
-- Table structure for table `ln_affliate_purchases`
--

CREATE TABLE `ln_affliate_purchases` (
  `s` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `affliate` varchar(500) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_affliate_purchases`
--

INSERT INTO `ln_affliate_purchases` (`s`, `order_no`, `amount`, `affliate`, `date`) VALUES
(8, 8, 800, 'AFF-60EFDF26181C', '2025-07-05 16:36:50'),
(9, 11, 40000, 'AFF-60EFDF26181C', '2025-07-06 04:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `ln_aff_alerts`
--

CREATE TABLE `ln_aff_alerts` (
  `s` int(11) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `user` varchar(200) NOT NULL,
  `link` varchar(5000) NOT NULL,
  `date` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_aff_alerts`
--

INSERT INTO `ln_aff_alerts` (`s`, `message`, `user`, `link`, `date`, `type`, `status`) VALUES
(5, 'You have earned ?800 from Order ID: ORD68689a0358514', '5', 'wallet.php', '2025-07-05 16:36:50', 'wallet', 1),
(6, 'You have earned ?800 from Order ID: ORD68689a0358514', '5', 'wallet.php', '2025-07-05 16:36:50', 'wallet', 1),
(7, 'You have earned ?40000 from Order ID: ORDER_987445097', '5', 'wallet.php', '2025-07-06 04:28:09', 'wallet', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ln_alerts`
--

CREATE TABLE `ln_alerts` (
  `s` int(11) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `link` varchar(5000) NOT NULL,
  `date` varchar(500) NOT NULL,
  `type` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_alerts`
--

INSERT INTO `ln_alerts` (`s`, `message`, `link`, `date`, `type`, `status`) VALUES
(43, 'A new user has been registered(Akande bade)', 'users.php', '', 'New User', 1),
(44, 'A new user has been registered(Akande bade)', 'users.php', '', 'New User', 1),
(45, 'A new user has been registered(Akande bade)', 'users.php', '', 'New User', 1),
(46, 'A new user has been registered(Akande bade)', 'users.php', '', 'New User', 1),
(47, 'A new user has been registered(Ibrahim Fopefoluwa Favour)', 'users.php', '', 'New User', 1),
(48, 'Admin Commission of ?10000 from Order ID: ORD6867fb23a5cfc', 'profits.php', '2025-07-05 04:18:31', 'profits', 0),
(49, 'Admin Commission of ?10000 from Order ID: ORD6867fb23a5cfc', 'profits.php', '2025-07-05 04:18:31', 'profits', 0),
(50, 'Admin Commission of ?10000 from Order ID: ORD68689a0358514', 'profits.php', '2025-07-05 16:36:50', 'profits', 0),
(51, 'Admin Commission of ?500000 from Order ID: ORDER_987445097', 'profits.php', '2025-07-06 04:28:09', 'profits', 0),
(52, 'Admin Commission of ?10000 from Subscription Plan', 'profits.php', '', 'profits', 0),
(53, 'A new dispute has been submitted (TKT1751810204)', 'ticket.php?ticket_number=TKT1751810204', '2025-07-06 14:56:44', 'New Dispute', 1),
(54, 'A new dispute has been submitted (TKT1751810548)', 'ticket.php?ticket_number=TKT1751810548', '2025-07-06 15:02:28', 'New Dispute', 1),
(55, 'A new dispute has been submitted (TKT1751813971)', 'ticket.php?ticket_number=TKT1751813971', '2025-07-06 15:59:31', 'New Dispute', 1),
(56, 'Admin Commission of ?10000 from Order ID: ORD6867e0a9b70d9', 'profits.php', '2025-07-04 16:07:18', 'profits', 0),
(57, 'New Withdrawal Request - &#8358;7000', 'withdrawals.php', '2025-07-07 09:41:55', 'New Withdrawal', 1),
(58, 'Admin Commission of ?0 from Order ID: ORD6869d955d938b', 'profits.php', '2025-07-08 05:24:58', 'profits', 0),
(59, 'Admin Commission of ?7500 from Order ID: ORD6869d955d938b', 'profits.php', '2025-07-08 05:22:23', 'profits', 0),
(60, 'A new user has been registered(Olayemi Foluwa)', 'users.php', '2025-07-10 09:42:46', 'New User', 1),
(61, 'A new user has been registered(Boola bade)', 'users.php', '2025-07-10 09:54:43', 'New User', 1),
(62, 'Admin Commission of ?15000 from Order ID: ORDER_899083781', 'profits.php', '2025-07-10 18:17:17', 'profits', 0),
(63, 'A new user has been registered(Ojo-Olayinka Kanyinsola)', 'users.php', '', 'New User', 1),
(64, 'A new user has been registered(Ike Ike)', 'users.php', '2025-07-24 08:20:33', 'New User', 1),
(65, 'A new user has been registered(Ike Ike)', 'users.php', '2025-07-24 08:29:05', 'New User', 1),
(66, 'Admin Commission of â‚¦10000 from Order ID: ORD6881e189a5726', 'profits.php', '2025-07-24 08:36:25', 'profits', 0),
(67, 'Admin Commission of â‚¦10000 from Subscription Plan', 'profits.php', '', 'profits', 0),
(68, 'A new user has been registered(Ike Ike)', 'users.php', '', 'New User', 1),
(69, 'Admin Commission of â‚¦7500 from Order ID: ORD6881e300611af', 'profits.php', '2025-07-25 11:30:07', 'profits', 0),
(70, 'Admin Commission of â‚¦7500 from Order ID: ORD688ea96b6abb3', 'profits.php', '2025-08-03 01:12:39', 'profits', 0),
(71, 'Admin Commission of â‚¦7500 from Order ID: ORD688ea9ad01b05', 'profits.php', '2025-08-03 04:17:57', 'profits', 0),
(72, 'Admin Commission of â‚¦60000 from Order ID: ORDER_568377597', 'profits.php', '2025-08-07 07:49:07', 'profits', 0),
(73, 'A new user has been registered(Everistus Anaekwe)', 'users.php', '2025-08-07 12:13:04', 'New User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ln_blog_likes`
--

CREATE TABLE `ln_blog_likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `blog_id` varchar(45) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `liked_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ln_blog_likes`
--

INSERT INTO `ln_blog_likes` (`id`, `blog_id`, `user_ip`, `liked_at`) VALUES
(1, '149', '102.215.57.233', ''),
(2, '150', '102.89.83.125', '');

-- --------------------------------------------------------

--
-- Table structure for table `ln_categories`
--

CREATE TABLE `ln_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `category_name` varchar(450) NOT NULL,
  `slug` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_categories`
--

INSERT INTO `ln_categories` (`id`, `parent_id`, `category_name`, `slug`) VALUES
(1, NULL, 'Academic', 'academic'),
(2, NULL, 'Business & Professional', 'business-professional'),
(3, NULL, 'Personal Development', 'personal-development'),
(4, NULL, 'Vocational & Technical Skills', 'vocational-technical-skills'),
(5, NULL, 'Languages & Communication', 'languages-communication'),
(6, NULL, 'Sports & Physical', 'sports-physical'),
(7, NULL, 'Creative & Artistic', 'creative-artistic'),
(8, NULL, 'Technology & IT', 'technology-it'),
(9, NULL, 'Certifications & Exams', 'certifications-exams'),
(10, 1, 'JAMB / WAEC / NECO Prep', 'jamb-waec-neco-prep'),
(11, 1, 'SAT / IELTS / TOEFL Prep', 'sat-ielts-toefl-prep'),
(12, 1, 'Mathematics Support', 'mathematics-support'),
(13, 1, 'Science (Physics, Chemistry, Biology)', 'science-physics-chemistry-biology'),
(14, 1, 'Social Studies / Government', 'social-studies-government'),
(15, 1, 'Economics & Accounting', 'economics-accounting'),
(16, 1, 'Literature & English', 'literature-english'),
(17, 1, 'Study Skills & Academic Writing', 'study-skills-academic-writing'),
(18, 1, 'Adult Education & Literacy', 'adult-education-literacy'),
(19, 1, 'Research Methods & Thesis Writing', 'research-methods-thesis-writing'),
(20, 1, 'Nursing and Midwifery', 'nursing-and-midwifery'),
(21, 2, 'Leadership & Management', 'leadership-management'),
(22, 2, 'Human Resource Management', 'human-resource-management'),
(23, 2, 'Business Strategy & Planning', 'business-strategy-planning'),
(24, 2, 'Project Management (PMP, Agile)', 'project-management-pmp-agile'),
(25, 2, 'Sales & Negotiation Skills', 'sales-negotiation-skills'),
(26, 2, 'Customer Service & Client Relations', 'customer-service-client-relations'),
(27, 2, 'Marketing & Branding', 'marketing-branding'),
(28, 2, 'Financial Literacy & Business Accounting', 'financial-literacy-business-accounting'),
(29, 2, 'Business Communication & Etiquette', 'business-communication-etiquette'),
(30, 2, 'Entrepreneurship & Startup Development', 'entrepreneurship-startup-development'),
(31, 2, 'Accounting', 'accounting'),
(32, 2, 'Actuary and Insurance', 'actuary-insurance'),
(33, 2, 'Administrative and Secretarial', 'administrative-secretarial'),
(34, 2, 'Agriculture and Rural Development', 'agriculture-rural-development'),
(35, 2, 'Art and Craft', 'art-craft'),
(36, 2, 'Aviation and Maritime', 'aviation-maritime'),
(37, 2, 'Banking and Finance', 'banking-finance'),
(38, 2, 'Catering and Hotel Management', 'catering-hotel-management'),
(39, 2, 'Conferences AGM Seminars', 'conferences-agm-seminars'),
(40, 2, 'Corporate Governance', 'corporate-governance'),
(41, 2, 'Corporate Social Responsibility', 'corporate-social-responsibility'),
(42, 2, 'Drivers and Driving', 'drivers-driving'),
(43, 2, 'E-Learning', 'e-learning'),
(44, 2, 'Economic Management', 'economic-management'),
(45, 2, 'Education', 'education'),
(46, 2, 'Energy and Power', 'energy-power'),
(47, 2, 'Engineering and Technical Skills', 'engineering-technical-skills'),
(48, 2, 'Entrepreneurship and Business', 'entrepreneurship-business'),
(49, 2, 'Event Planning and Management', 'event-planning-management'),
(50, 2, 'Executive Education', 'executive-education'),
(51, 2, 'General Management', 'general-management'),
(52, 2, 'Health, Safety and Environment', 'health-safety-environment'),
(53, 2, 'Information and Communications', 'information-communications'),
(54, 2, 'Internal Audit and Fraud', 'internal-audit-fraud'),
(55, 2, 'International Training', 'international-training'),
(56, 2, 'Leadership', 'leadership'),
(57, 2, 'Legal and Legislative', 'legal-legislative'),
(58, 2, 'Logistics and Supply Chain', 'logistics-supply-chain'),
(59, 2, 'Management Consulting', 'management-consulting'),
(60, 2, 'Marketing and Sales Management', 'marketing-sales-management'),
(61, 2, 'Media and Communication', 'media-communication'),
(62, 2, 'NGOs and Donor Funded Projects', 'ngos-donor-funded-projects'),
(63, 2, 'Oil and Gas', 'oil-gas'),
(64, 2, 'Operations Management', 'operations-management'),
(65, 2, 'Pre-Retirement and New Beginnings', 'pre-retirement-new-beginnings'),
(66, 2, 'Project Management', 'project-management'),
(67, 2, 'Protocol, Travel and Tourism', 'protocol-travel-tourism'),
(68, 2, 'Public Sector and PPP', 'public-sector-ppp'),
(69, 2, 'Quality Management', 'quality-management'),
(70, 2, 'Real Estate Management', 'real-estate-management'),
(71, 2, 'Report and Speech Writing', 'report-speech-writing'),
(72, 2, 'Research Methodology and Analytics', 'research-methodology-analytics'),
(73, 2, 'Risk Management', 'risk-management'),
(74, 2, 'Security and Crime Prevention', 'security-crime-prevention'),
(75, 2, 'Strategic Management', 'strategic-management'),
(76, 2, 'Telecommunications', 'telecommunications'),
(77, 3, 'Public Speaking & Presentation', 'public-speaking-presentation'),
(78, 3, 'Emotional Intelligence (EQ)', 'emotional-intelligence-eq'),
(79, 3, 'Time Management & Productivity', 'time-management-productivity'),
(80, 3, 'Personal Finance & Budgeting', 'personal-finance-budgeting'),
(81, 3, 'Confidence & Self-Esteem Building', 'confidence-self-esteem-building'),
(82, 3, 'Stress Management & Mental Wellness', 'stress-management-mental-wellness'),
(83, 3, 'Goal Setting & Motivation', 'goal-setting-motivation'),
(84, 3, 'Mindfulness & Self-Awareness', 'mindfulness-self-awareness'),
(85, 3, 'Personal Branding', 'personal-branding'),
(86, 3, 'Career Planning & Coaching', 'career-planning-coaching'),
(87, 4, 'Fashion Design & Tailoring', 'fashion-design-tailoring'),
(88, 4, 'Hairdressing & Beauty Therapy', 'hairdressing-beauty-therapy'),
(89, 4, 'Culinary Arts & Catering', 'culinary-arts-catering'),
(90, 4, 'Electrical Installation & Maintenance', 'electrical-installation-maintenance'),
(91, 4, 'Plumbing & Pipefitting', 'plumbing-pipefitting'),
(92, 4, 'Welding & Fabrication', 'welding-fabrication'),
(93, 4, 'Automotive Repair', 'automotive-repair'),
(94, 4, 'Solar & Renewable Energy Systems', 'solar-renewable-energy-systems'),
(95, 4, 'Carpentry & Furniture Making', 'carpentry-furniture-making'),
(96, 4, 'Home Appliance Repair', 'home-appliance-repair'),
(97, 5, 'English Proficiency', 'english-proficiency'),
(98, 5, 'French Language', 'french-language'),
(99, 5, 'Spanish Language', 'spanish-language'),
(100, 5, 'German Language', 'german-language'),
(101, 5, 'Yoruba / Hausa / Igbo (Local Languages)', 'yoruba-hausa-igbo'),
(102, 5, 'Business English', 'business-english'),
(103, 5, 'Communication Skills', 'communication-skills'),
(104, 5, 'Academic Writing', 'academic-writing'),
(105, 5, 'Sign Language', 'sign-language'),
(106, 5, 'Translation & Interpretation', 'translation-interpretation'),
(107, 6, 'Fitness & Aerobics', 'fitness-aerobics'),
(108, 6, 'Strength Training & Bodybuilding', 'strength-training-bodybuilding'),
(109, 6, 'Yoga & Meditation', 'yoga-meditation'),
(110, 6, 'Dance & Choreography', 'dance-choreography'),
(111, 6, 'Sports Coaching (Football, Basketball, etc.)', 'sports-coaching'),
(112, 6, 'Nutrition & Wellness', 'nutrition-wellness'),
(113, 6, 'First Aid & Safety Training', 'first-aid-safety-training'),
(114, 6, 'Self-Defense & Martial Arts', 'self-defense-martial-arts'),
(115, 6, 'Physical Education for Schools', 'physical-education-schools'),
(116, 6, 'Wellness Retreats', 'wellness-retreats'),
(117, 7, 'Drawing & Painting', 'drawing-painting'),
(118, 7, 'Graphic Design (Photoshop, Illustrator)', 'graphic-design-photoshop-illustrator'),
(119, 7, 'Photography & Editing', 'photography-editing'),
(120, 7, 'Video Production & Cinematography', 'video-production-cinematography'),
(121, 7, 'Music Production & DJing', 'music-production-djing'),
(122, 7, 'Interior Decoration', 'interior-decoration'),
(123, 7, 'Acting & Drama', 'acting-drama'),
(124, 7, 'Fashion Illustration', 'fashion-illustration'),
(125, 7, 'Creative Writing', 'creative-writing'),
(126, 7, 'Craft Making (Beads, Paper Art, etc.)', 'craft-making-beads-paper-art'),
(127, 8, 'Web Development (HTML, CSS, JavaScript)', 'web-development-html-css-js'),
(128, 8, 'App & Software Development', 'app-software-development'),
(129, 8, 'UI/UX Design', 'ui-ux-design'),
(130, 8, 'Cybersecurity', 'cybersecurity'),
(131, 8, 'Data Science & Machine Learning', 'data-science-machine-learning'),
(132, 8, 'Artificial Intelligence', 'artificial-intelligence'),
(133, 8, 'Cloud Computing (AWS, Azure)', 'cloud-computing-aws-azure'),
(134, 8, 'Networking & IT Support', 'networking-it-support'),
(135, 8, 'Digital Marketing & SEO', 'digital-marketing-seo'),
(136, 8, 'Blockchain & Cryptocurrency', 'blockchain-cryptocurrency'),
(137, 9, 'Project Management Certifications (PMP, Scrum)', 'project-management-certifications'),
(138, 9, 'IT Certifications (CompTIA, Cisco, Microsoft)', 'it-certifications-comptia-cisco-microsoft'),
(139, 9, 'Accounting Certifications (ICAN, ACCA, CFA)', 'accounting-certifications-ican-acca-cfa'),
(140, 9, 'Health & Safety (HSE)', 'health-safety-hse'),
(141, 9, 'First Aid & CPR', 'first-aid-cpr'),
(142, 9, 'Teaching Certifications (PGDE, TRCN)', 'teaching-certifications-pgde-trcn'),
(143, 9, 'Business Analysis Certifications (CBAP, CCBA)', 'business-analysis-certifications-cbap-ccba'),
(144, 9, 'Agile & Scrum Certifications', 'agile-scrum-certifications'),
(145, 9, 'Digital Skills Certification', 'digital-skills-certification'),
(146, 9, 'Language Proficiency Exams (IELTS, TOEFL)', 'language-proficiency-exams-ielts-toefl');

-- --------------------------------------------------------

--
-- Table structure for table `ln_comments`
--

CREATE TABLE `ln_comments` (
  `s` int(10) UNSIGNED NOT NULL,
  `blog_id` varchar(45) NOT NULL,
  `comments` varchar(4500) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `commented_time` varchar(45) NOT NULL,
  `parent_comment_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_comments`
--

INSERT INTO `ln_comments` (`s`, `blog_id`, `comments`, `user_id`, `commented_time`, `parent_comment_id`) VALUES
(149, '154', 'hi', '4', '2025-08-07 12:59:50', '');

-- --------------------------------------------------------

--
-- Table structure for table `ln_contact_messages`
--

CREATE TABLE `ln_contact_messages` (
  `s` int(10) UNSIGNED NOT NULL,
  `name` varchar(450) NOT NULL,
  `email` varchar(450) NOT NULL,
  `subject` varchar(450) NOT NULL,
  `message` varchar(4500) NOT NULL,
  `created_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ln_country`
--

CREATE TABLE `ln_country` (
  `id` int(11) NOT NULL,
  `iso` char(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `nicename` varchar(80) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numcode` smallint(6) DEFAULT NULL,
  `phonecode` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_country`
--

INSERT INTO `ln_country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, 93),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, 355),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, 213),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, 1684),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, 376),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, 244),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, 1264),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, 0),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, 1268),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, 54),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, 374),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, 297),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, 61),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, 43),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, 994),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, 1242),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, 973),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, 880),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, 1246),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, 375),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, 32),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, 501),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, 229),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, 1441),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, 975),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, 591),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, 387),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, 267),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, 0),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, 55),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, 246),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', 96, 673),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, 359),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, 226),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, 257),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, 855),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, 237),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, 1),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, 238),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, 1345),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, 236),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, 235),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, 56),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, 86),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, 61),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, 672),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, 57),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, 269),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, 242),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, 242),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, 682),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, 506),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, 225),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, 385),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, 53),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, 357),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, 420),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, 45),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, 253),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, 1767),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, 1809),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, 593),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, 20),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, 503),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, 240),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, 291),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, 372),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, 251),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, 500),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, 298),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, 679),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, 358),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, 33),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, 594),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, 689),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, 0),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, 241),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, 220),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, 995),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, 49),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, 233),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, 350),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, 30),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, 299),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, 1473),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, 590),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, 1671),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, 502),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, 224),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, 245),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, 592),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, 509),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, 0),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, 39),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, 504),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, 852),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, 36),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, 354),
(99, 'IN', 'INDIA', 'India', 'IND', 356, 91),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, 62),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, 98),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, 964),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, 353),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, 972),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, 39),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, 1876),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, 81),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, 962),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, 7),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, 254),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, 686),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, 850),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, 82),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, 965),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, 996),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, 856),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, 371),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, 961),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, 266),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, 231),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, 218),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, 423),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, 370),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, 352),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, 853),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, 389),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, 261),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, 265),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, 60),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, 960),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, 223),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, 356),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, 692),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, 596),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, 222),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, 230),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, 269),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, 52),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, 691),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, 373),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, 377),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, 976),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, 1664),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, 212),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, 258),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, 95),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, 264),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, 674),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, 977),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, 31),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, 599),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, 687),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, 64),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, 505),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, 227),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, 683),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, 672),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, 1670),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, 47),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, 968),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, 92),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, 680),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, 970),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, 507),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, 675),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, 595),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, 51),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, 63),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, 0),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, 48),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, 351),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, 1787),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, 974),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, 262),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, 40),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, 70),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, 250),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, 290),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, 1869),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, 1758),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, 508),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, 1784),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, 684),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, 378),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, 239),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, 966),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, 221),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, 381),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, 248),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, 232),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, 65),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, 421),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, 386),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, 677),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, 252),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, 27),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, 0),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, 34),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, 94),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, 249),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, 597),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, 47),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, 268),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, 46),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, 41),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, 963),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, 886),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, 992),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, 255),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, 66),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, 670),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, 228),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, 690),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, 676),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, 1868),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, 216),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, 90),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, 7370),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, 1649),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, 688),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, 256),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, 380),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, 971),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, 44),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, 1),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, 1),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, 598),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, 998),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, 678),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, 58),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, 84),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, 1284),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, 1340),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, 681),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, 212),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, 967),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, 260),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, 263);

-- --------------------------------------------------------

--
-- Table structure for table `ln_disputes`
--

CREATE TABLE `ln_disputes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) NOT NULL,
  `ticket_number` varchar(20) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `order_reference` varchar(255) DEFAULT NULL,
  `issue` text DEFAULT NULL,
  `status` enum('pending','under-review','resolved','awaiting-response') DEFAULT 'under-review',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ln_disputes`
--

INSERT INTO `ln_disputes` (`id`, `user_id`, `recipient_id`, `ticket_number`, `category`, `order_reference`, `issue`, `status`, `created_at`) VALUES
(5, 4, 3, 'TKT1751810204', 'Product Quality Issues', 'ORDER_603649042', 'wow', 'under-review', '2025-07-06 13:56:44'),
(6, 4, 3, 'TKT1751810548', 'Product Quality Issues', 'ORDER_603649042', 'wow', 'under-review', '2025-07-06 14:02:28'),
(7, 4, 0, 'TKT1751813971', 'Product Quality Issues', 'ORDER_603649042', 'wow', 'resolved', '2025-07-08 14:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `ln_dispute_messages`
--

CREATE TABLE `ln_dispute_messages` (
  `id` int(11) NOT NULL,
  `dispute_id` varchar(110) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `file` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ln_dispute_messages`
--

INSERT INTO `ln_dispute_messages` (`id`, `dispute_id`, `sender_id`, `message`, `file`, `created_at`) VALUES
(6, 'TKT1751810204', 4, 'wow', '', '2025-07-06 13:56:44'),
(7, 'TKT1751810548', 4, 'wow', '', '2025-07-06 14:02:28'),
(8, 'TKT1751813971', 4, 'wow', '', '2025-07-06 14:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `ln_event_types`
--

CREATE TABLE `ln_event_types` (
  `s` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(450) NOT NULL,
  `images` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_event_types`
--

INSERT INTO `ln_event_types` (`s`, `name`, `slug`, `images`) VALUES
(1, 'Workshops', 'workshops', 'workshop.jpg'),
(2, 'Webinars', 'webinars', 'webinar.jpg'),
(3, 'Seminars', 'seminars', 'seminar.jpg'),
(4, 'Bootcamps', 'bootcamps', 'bootcamp.jpg'),
(5, 'Conferences & Summits', 'conferences-summits', 'conference.jpg'),
(6, 'Masterclasses', 'masterclasses', 'masterclass.jpg'),
(7, 'Retreats', 'retreats', 'retreat.jpg'),
(8, 'Short Courses', 'short-courses', 'short.jpg'),
(9, 'Certificate Programs', 'certificate-programs', 'certificate.jpg'),
(10, 'Hands-On Practical Sessions', 'hands-on-practical-sessions', 'handss.jpg'),
(11, 'Panel Discussions / Fireside Chats', 'panel-discussions-fireside-chats', 'panel.jpg'),
(12, 'Hackathons / Innovation Challenges', 'hackathons-innovation-challenges', 'hack.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ln_evidence`
--

CREATE TABLE `ln_evidence` (
  `id` int(11) NOT NULL,
  `dispute_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ln_evidence`
--

INSERT INTO `ln_evidence` (`id`, `dispute_id`, `file_path`, `uploaded_at`) VALUES
(4, 5, '686a809c656fe.pdf', '2025-07-06 13:56:44'),
(5, 6, '686a81f488349.pdf', '2025-07-06 14:02:28'),
(6, 7, '686a8f5372be7.pdf', '2025-07-06 14:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `ln_followers`
--

CREATE TABLE `ln_followers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `seller_id` varchar(45) NOT NULL,
  `followed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `category_id` varchar(450) NOT NULL,
  `subcategory_id` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_followers`
--

INSERT INTO `ln_followers` (`id`, `user_id`, `seller_id`, `followed_at`, `category_id`, `subcategory_id`) VALUES
(1, '152', '', '2025-08-07 11:27:16', '1', ''),
(2, '4', '', '2025-08-08 16:45:18', '2', ''),
(3, '153', '', '2025-08-10 22:23:25', '1', ''),
(4, '153', '4', '2025-08-10 22:23:58', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ln_forum_posts`
--

CREATE TABLE `ln_forum_posts` (
  `s` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `title` varchar(450) NOT NULL,
  `article` mediumtext NOT NULL,
  `categories` varchar(450) NOT NULL,
  `featured_image` varchar(650) NOT NULL,
  `created_at` varchar(45) NOT NULL,
  `views` varchar(45) NOT NULL,
  `slug` varchar(4500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_forum_posts`
--

INSERT INTO `ln_forum_posts` (`s`, `user_id`, `title`, `article`, `categories`, `featured_image`, `created_at`, `views`, `slug`) VALUES
(149, '3', 'Enter Forum TitleEnter Forum TitleEnter Forum TitleEnter Forum Title', 'While competition in Nigeriaâ€™s industrial mineral sector is intensifying, it remains a fertile ground for innovation and investment. By focusing on quality, vertical integration, and market alignment, new and existing companies can build sustainable competitive advantages and tap into the growing local and export demand for feldspar, quartz, talc, and kaolin.\\r\\n\\r\\nWhile competition in Nigeriaâ€™s industrial mineral sector is intensifying, it remains a fertile ground for innovation and investment. By focusing on quality, vertical integration, and market alignment, new and existing companies can build sustainable competitive advantages and tap into the growing local and export demand for feldspar, quartz, talc, and kaolin.\\r\\n\\r\\nWhile competition in Nigeriaâ€™s industrial mineral sector is intensifying, it remains a fertile ground for innovation and investment. By focusing on quality, vertical integration, and market alignment, new and existing companies can build sustainable competitive advantages and tap into the growing local and export demand for feldspar, quartz, talc, and kaolin.', '1,2', '68832200062c2_bread3.jpeg', '2025-07-25 07:19:43', '5', 'enter-forum-titleenter-forum-titleenter-forum-titleenter-forum-title'),
(150, '3', 'Financial Models Store', '<p>https://learnora.projectreporthub.ng/view-blog/enter-forum-titleenter-forum-titleenter-forum-titleenter-forum-title</p>', '1', '68947a996d99a_1000x500-foraminiferalogo.png', '2025-08-07 11:06:17', '2', 'financial-models-store'),
(151, '3', 'Bread Production in Nigeria', '<p>https://learnora.projectreporthub.ng/view-blog/enter-forum-titleenter-forum-titleenter-forum-titleenter-forum-title</p>', '1', '68947ac6c5969_bread3.jpeg', '2025-08-07 11:07:02', '1', 'bread-production-in-nigeria'),
(152, '3', 'Classis Plan and Agin', '<p>https://learnora.projectreporthub.ng/view-blog/enter-forum-titleenter-forum-titleenter-forum-titleenter-forum-title</p>', '1', '68947b064db0d_classicplanimage222.png', '2025-08-07 11:08:06', '4', 'classis-plan-and-agin'),
(153, '3', 'Learnora Platform', '<p>https://learnora.projectreporthub.ng/view-blog/enter-forum-titleenter-forum-titleenter-forum-titleenter-forum-title</p>', '1', '68947b426d18a_enterpriseplanbanner.png', '2025-08-07 11:09:06', '6', 'learnora-platform'),
(154, '3', 'Attach Featured Image', '<p>Attach Featured Image</p>', '1', '68947b8eaf4e9_CP3.png', '2025-08-07 11:10:22', '12', 'attach-featured-image');

-- --------------------------------------------------------

--
-- Table structure for table `ln_inhouse_proposals`
--

CREATE TABLE `ln_inhouse_proposals` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `seminar_title` varchar(450) NOT NULL,
  `days` varchar(45) NOT NULL,
  `participants` varchar(450) NOT NULL,
  `name` varchar(450) NOT NULL,
  `position` varchar(450) NOT NULL,
  `company` varchar(450) NOT NULL,
  `address` varchar(450) NOT NULL,
  `city` varchar(150) NOT NULL,
  `country` varchar(100) NOT NULL,
  `email` varchar(450) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `comment` varchar(4500) NOT NULL,
  `created_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_inhouse_proposals`
--

INSERT INTO `ln_inhouse_proposals` (`s`, `training_id`, `seminar_title`, `days`, `participants`, `name`, `position`, `company`, `address`, `city`, `country`, `email`, `phone`, `mobile`, `comment`, `created_at`) VALUES
(1, '', 'Safeguarding Children and Vulnerable Adults', 'Tuesday', '100', 'Ibrahim Fopefoluwa Favour', 'Instructor', 'Fopefoluwa', '38, Opeyemistreet wema, iwo road, Ibadan.', 'ibadan', 'Nigeria', 'fopsycute18@gmail.com', '(081) 227-9350', '08122793508', 'wow', '2025-07-07 20:49:05'),
(2, '', 'Safeguarding Children and Vulnerable Adults', 'Tuesday', '100', 'Ibrahim Fopefoluwa Favour', 'Instructor', 'Fopefoluwa', '38, Opeyemistreet wema, iwo road, Ibadan.', 'ibadan', 'Nigeria', 'fopsycute18@gmail.com', '(081) 227-9350', '08122793508', 'wow', '2025-07-07 20:52:34'),
(3, 'TH206142', 'Safeguarding Children and Vulnerable Adults', 'Tuesday', '100', 'Ibrahim Fopefoluwa Favour', 'Instructor', 'Fopefoluwa', '38, Opeyemistreet wema, iwo road, Ibadan.', 'ibadan', 'Nigeria', 'fopsycute18@gmail.com', '(081) 227-9350', '08122793508', 'wow', '2025-07-07 20:53:03'),
(149, 'TH371730', 'Diploma in Caregiving', 'Monday', '45', 'gsgh', 'mana', 'ikedike2002', 'yytt', 'Lagos', 'Nigeria', 'ikedike2002@yahoo.com', '(080) 337-8277', '08033782777', 'hrrr', '2025-07-25 08:02:00'),
(150, 'TH357692', 'Basics of Security Management', 'Monday', '30', 'Everistus Anaekwe', 'Manager', 'Foraminifera Market Research Limited', '10 Wale Ariwoola Street, Graceland Estate, Bucknor, Ejigbo, Lagos.', 'Ejigbo', 'Nigeria', 'ikedike2002@yahoo.com', '(080) 337-8277', '08033782777', 'tHis is s', '2025-08-07 11:45:03'),
(151, 'TH371730', 'Diploma in Caregiving', 'Thursday', '34', 'Ike Everistus Nnamdi Ike', 'mana', 'ikedike2002', 'yytt', 'Lagos', 'Nigeria', 'ikedike2002@yahoo.com', '(080) 337-8277', '', 'th', '2025-08-10 22:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `ln_instructors`
--

CREATE TABLE `ln_instructors` (
  `s` int(10) UNSIGNED NOT NULL,
  `name` varchar(4500) NOT NULL,
  `email_address` varchar(4500) NOT NULL,
  `bio` varchar(4500) NOT NULL,
  `photo` varchar(450) NOT NULL,
  `user` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_instructors`
--

INSERT INTO `ln_instructors` (`s`, `name`, `email_address`, `bio`, `photo`, `user`) VALUES
(3, 'Mr Ibrahim Fopefoluwa', 'fopsy@gmail.com', 'Fope is  is one of the leading online course providers in the UK with a strong reputation for success to date. At present, it offers a huge range of online courses - over 1 000 to learners from all over the world - aimed at facilitating professional development.', '686196cce799d_icons8-coach-100.png', ''),
(4, 'Olayemi David', 'davidola@gmail.com', 'well discipline', '6861e703a5685_teacher.png', ''),
(5, 'Mr Ibrahim Kunle', 'oladunni@gmail.com', 'good', '686c90e72b8d7_WhatsApp Image 2025-06-21 at 17.43.22_02921ed3.jpg.jpg', ''),
(6, 'Mr Ibrahim Kunle', 'oladunni@gmail.com', 'good', '686c9330566cf_WhatsApp Image 2025-06-21 at 17.43.22_02921ed3.jpg', ''),
(7, 'Mr Ibrahim Kunle', 'oladunni@gmail.com', 'good', '686c94d321bca_WhatsApp Image 2025-06-21 at 17.43.22_02921ed3.jpg', ''),
(8, 'Mr Ibrahim Kunle', 'oladunni@gmail.com', 'good', '686c951336498_WhatsApp Image 2025-06-21 at 17.43.22_02921ed3.jpg', ''),
(9, 'Mr Ibrahim Kunle', 'oladunni@gmail.com', 'good', '686c95897d417_WhatsApp Image 2025-06-21 at 17.43.22_02921ed3.jpg', ''),
(10, 'Olayemi David Wale', 'wale@gmail.com', 'good', '686c9743d0470_get-started-removebg-preview.png', ''),
(149, 'Mr Ibrahim Seyi', '', '<p>athletic and good man</p>', '6893accb502ae_download.jpeg', '3'),
(150, 'Anaekwe Everistus Nnamdi', '', '<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa, scientifically known as Theobroma cacao, holds a significant place in Nigeria\'s agricultural heritage. The cultivation of cocoa in Nigeria dates back to the late 19th century when it was introduced by colonial settlers. Over time, cocoa emerged as a major cash crop, driving economic growth and shaping the socio-economic fabric of regions where it is cultivated.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa production in Nigeria is concentrated primarily in the southern regions of the country, including Ondo, Osun, Ogun, Ekiti, and Cross River states. These regions offer suitable climatic conditions, including ample rainfall and well-drained soils, conducive to cocoa cultivation.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Nigeria ranks among the top cocoa-producing countries globally, consistently contributing a significant share to the world\'s cocoa output. Despite facing challenges such as aging cocoa trees and declining productivity in recent years, Nigeria remains a formidable player in the global cocoa market.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">The cocoa industry in Nigeria operates within a global market influenced by factors such as international demand, pricing trends, and trade regulations. Nigerian cocoa finds its way into various end products, including chocolate, beverages, and confectionery, catering to both domestic and international markets.</span></p>', '68948f3495b01_website image.jpg', '152'),
(151, 'Miss Kemi David', '', '<p>Founder of the Virgin Group, which has gone on to grow successful businesses in sectors including mobile telephony, travel and transportation, financial services, leisure and entertainment and health and wellness. Virgin is a leading international investment group and one of the world\'s most recognised and respected brands. Since starting youth culture magazine &ldquo;Student&rdquo; at aged 16, I have tried to find entrepreneurial ways to drive positive change in the world. In 2004 we established Virgin Unite, the non-profit foundation of the Virgin Group, which unites people and entrepreneurial ideas to create opportunities for a better world. Most of my time is now spent building businesses that will make a positive difference in the world and working with Virgin Unite and organisations it has incubated, such as The Elders, The Carbon War Room, The B Team and Ocean Unite. I also serve on the Global Commission on Drug Policy and supports ocean conservation with the Ocean Elders. I\'m a tie-loathing adventurer, philanthropist and troublemaker, who believes in turning ideas into reality. Otherwise known as Dr Yes!</p>', '6895090c475e9_finance.projectreporthub.ng_product_format-for-writing-architecture-undergraduate-project-reports(iPhone XR).png', '3'),
(152, 'Mr Ibrahim Moyin', '', '<p>kola</p>', '', '4'),
(153, 'Mr Ibrahim ', '', '', '68974f63809d0_image (10).png', '4'),
(154, 'Mr Ibrahim ', '', '', '68975001ee978_image (10).png', '4');

-- --------------------------------------------------------

--
-- Table structure for table `ln_loyalty_purchases`
--

CREATE TABLE `ln_loyalty_purchases` (
  `s` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `loyalty_id` varchar(45) NOT NULL,
  `amount` varchar(450) NOT NULL,
  `start_date` varchar(45) NOT NULL,
  `end_date` varchar(45) NOT NULL,
  `payment_reference` varchar(45) NOT NULL,
  `downloads` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_loyalty_purchases`
--

INSERT INTO `ln_loyalty_purchases` (`s`, `user_id`, `loyalty_id`, `amount`, `start_date`, `end_date`, `payment_reference`, `downloads`) VALUES
(2, '4', '21', '10000', '2025-07-06 09:50:27', '2026-07-06 09:50:27', 'PH-1751791816347-574', '40'),
(3, '152', '21', '10000', '2025-07-24 08:44:01', '2026-07-24 08:44:01', 'PH-1753342954692-866', '40');

-- --------------------------------------------------------

--
-- Table structure for table `ln_manual_payments`
--

CREATE TABLE `ln_manual_payments` (
  `s` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(45) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `amount` int(11) NOT NULL,
  `proof` varchar(4500) NOT NULL,
  `status` varchar(45) NOT NULL,
  `date_created` varchar(45) NOT NULL,
  `rejection_reason` varchar(4500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_manual_payments`
--

INSERT INTO `ln_manual_payments` (`s`, `order_id`, `user_id`, `amount`, `proof`, `status`, `date_created`, `rejection_reason`) VALUES
(5, 'ORD6867e0a9b70d9', '4', 10000, '6867fb206f96d.pdf', 'payment resend', '2025-07-04 17:02:40', 'fake payment'),
(6, 'ORD6881e300611af', '152', 7500, '68835cce342a8.jpeg', 'approved', '2025-07-25 11:30:38', ''),
(7, 'ORD68948b3f2d9e4', '153', 7000, '689913a44b451.png', 'pending', '2025-08-10 22:48:20', '');

-- --------------------------------------------------------

--
-- Table structure for table `ln_notifications`
--

CREATE TABLE `ln_notifications` (
  `s` int(11) NOT NULL,
  `user` varchar(500) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `date` varchar(500) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_notifications`
--

INSERT INTO `ln_notifications` (`s`, `user`, `message`, `date`, `status`) VALUES
(26, '3', 'You have received ?0 from Order ID: ORD6867fb23a5cfc', '2025-07-05 04:18:31', 0),
(27, '3', 'You have received ?0 from Order ID: ORD68689a0358514', '2025-07-05 16:36:50', 0),
(28, '3', 'You have received ?0 from Order ID: ORDER_987445097', '2025-07-06 04:28:09', 0),
(29, '3', 'A new dispute has been submitted with you as the recipient: TKT1751810548', '2025-07-06 15:02:28', 0),
(30, '3', 'You have received ?0 from Order ID: ORD6867e0a9b70d9', '2025-07-04 16:07:18', 0),
(31, '5', 'Your withdrawal requested made on Jul 07 2025 09:41:55 for an amount of ?7000 has been paid ', '2025-07-07 09:45:39', 1),
(32, '3', 'You have received ?0 from Order ID: ORD6869d955d938b', '2025-07-08 05:24:58', 0),
(33, '3', 'You have received ?0 from Order ID: ORD6869d955d938b', '2025-07-08 05:22:23', 0),
(34, '4', 'Dispute status updated to resolved: TKT1751813971', '2025-07-08 15:38:46', 0),
(35, '4', 'Dispute status updated to resolved: TKT1751813971', '2025-07-08 15:39:25', 0),
(36, '4', 'You have received ?35000 from Order ID: ORDER_899083781', '2025-07-10 18:17:17', 0),
(37, '3', 'You have received â‚¦0 from Order ID: ORD6881e189a5726', '2025-07-24 08:36:25', 0),
(38, '3', 'You have received â‚¦0 from Order ID: ORD6881e300611af', '2025-07-25 11:30:07', 0),
(39, '3', 'You have received â‚¦0 from Order ID: ORD688ea96b6abb3', '2025-08-03 01:12:39', 0),
(40, '3', 'You have received â‚¦0 from Order ID: ORD688ea9ad01b05', '2025-08-03 04:17:57', 0),
(41, '3', 'You have received â‚¦0 from Order ID: ORDER_568377597', '2025-08-07 07:49:07', 0),
(42, '4', 'New resource titled Build a Profitable Event Planner Business under category Business & Professional has been posted', '2025-08-08 16:46:11', 0),
(43, '152', 'New resource titled testing under category Academic has been posted', '2025-08-09 06:20:33', 0),
(44, '4', 'New resource titled testing under category Business & Professional has been posted', '2025-08-09 06:20:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ln_orders`
--

CREATE TABLE `ln_orders` (
  `s` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `total_amount` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_orders`
--

INSERT INTO `ln_orders` (`s`, `order_id`, `user`, `status`, `total_amount`, `date`) VALUES
(11, 'ORD686fbfc3d3838', '7', 'unpaid', '10000', '2025-07-10 14:27:31'),
(12, 'ORDER_899083781', '7', 'paid', '50000', '2025-07-10 18:17:17'),
(149, 'ORD6881e189a5726', '152', 'paid', '10000', '2025-07-24 08:36:48'),
(150, 'ORD6881e300611af', '152', 'paid', '7500', '2025-07-25 11:32:59'),
(151, 'ORD68835cd151750', '152', 'unpaid', '3750', '2025-07-25 11:30:41'),
(152, 'ORD688ea96b6abb3', '4', 'paid', '7500', '2025-08-03 01:13:12'),
(153, 'ORD688ea9ad01b05', '4', 'paid', '7500', '2025-08-03 04:38:52'),
(154, 'ORD688ed9f71fcb0', '4', 'unpaid', '13703', '2025-08-03 04:39:35'),
(155, 'ORDER_568377597', '4', 'paid', '60000', '2025-08-07 07:49:08'),
(156, 'ORD689463050f2c2', '151', 'unpaid', '0', '2025-08-07 09:25:41'),
(157, 'ORD68948b3f2d9e4', '153', 'pending', '7000', '2025-08-07 12:17:19'),
(158, 'ORD689913a9ded4d', '153', 'unpaid', '0', '2025-08-10 22:48:25');

-- --------------------------------------------------------

--
-- Table structure for table `ln_order_items`
--

CREATE TABLE `ln_order_items` (
  `s` int(10) UNSIGNED NOT NULL,
  `item_id` varchar(45) NOT NULL,
  `training_id` varchar(200) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `original_price` int(11) NOT NULL,
  `loyalty_id` int(11) NOT NULL,
  `affiliate_id` varchar(45) NOT NULL,
  `order_id` varchar(500) NOT NULL,
  `date` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_order_items`
--

INSERT INTO `ln_order_items` (`s`, `item_id`, `training_id`, `price`, `original_price`, `loyalty_id`, `affiliate_id`, `order_id`, `date`) VALUES
(5, '', 'TH371730', 10000, 10000, 0, '0', 'ORD6867e0a9b70d9', '2025-07-04 16:07:18'),
(6, '', 'TH371730', 10000, 10000, 0, '0', 'ORD6867fb23a5cfc', '2025-07-05 04:18:31'),
(8, '', 'TH371730', 10000, 10000, 0, 'AFF-60EFDF26181C', 'ORD68689a0358514', '2025-07-05 16:36:50'),
(9, '', 'TH563330', 4000, 4000, 0, '0', 'ORDER_603649042', '2025-07-06 03:18:45'),
(10, '', 'TH563330', 500000, 500000, 0, 'AFF-60EFDF26181C', 'ORDER_7075577', '2025-07-06 03:31:20'),
(11, '', 'TH563330', 500000, 500000, 0, 'AFF-60EFDF26181C', 'ORDER_987445097', '2025-07-06 04:28:09'),
(12, '', 'TH854626', 7500, 10000, 21, '0', 'ORD6869d955d938b', '2025-07-08 05:22:23'),
(13, '', 'TH357692', 0, 0, 21, '0', 'ORD6869d955d938b', '2025-07-08 05:24:58'),
(14, '', 'TH166516', 50000, 50000, 0, '0', 'ORDER_899083781', '2025-07-10 18:17:17'),
(15, '', 'TH371730', 10000, 10000, 0, '0', 'ORD686fbfc3d3838', '2025-07-11 07:18:49'),
(16, '', 'TH854626', 10000, 10000, 0, '0', 'ORD6881e189a5726', '2025-07-24 08:36:25'),
(17, '', 'TH371730', 7500, 10000, 21, '0', 'ORD6881e300611af', '2025-07-25 11:30:07'),
(18, '', 'TH854626', 7500, 10000, 21, '0', 'ORD688ea96b6abb3', '2025-08-03 01:12:39'),
(19, '', 'TH371730', 7500, 10000, 21, '0', 'ORD688ea9ad01b05', '2025-08-03 04:17:57'),
(21, 'donate', 'TH164522', 60000, 60000, 0, '0', 'ORDER_568377597', '2025-08-07 07:49:07'),
(25, '156', 'TH308284', 3750, 5000, 21, '0', 'ORD68835cd151750', '2025-08-08 08:38:35'),
(26, '158', 'TH597136', 4500, 6000, 21, '0', 'ORD688ed9f71fcb0', '2025-08-08 14:43:29'),
(28, '156', 'TH308284', 3750, 5000, 21, '0', 'ORD688ed9f71fcb0', '2025-08-10 00:11:51'),
(29, '160', 'TH854383', 53, 70, 21, '0', 'ORD688ed9f71fcb0', '2025-08-10 04:56:38'),
(30, '154', 'TH165122', 5250, 7000, 21, '0', 'ORD688ed9f71fcb0', '2025-08-10 05:57:37'),
(31, '151', 'TH165122', 150, 200, 21, '0', 'ORD688ed9f71fcb0', '2025-08-10 05:58:07'),
(33, '161', 'TH780861', 7000, 7000, 0, '0', 'ORD68948b3f2d9e4', '2025-08-10 22:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `ln_product_reports`
--

CREATE TABLE `ln_product_reports` (
  `s` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(45) NOT NULL,
  `user_id` varchar(4500) NOT NULL,
  `reason` varchar(4500) NOT NULL,
  `main_reason` varchar(8500) NOT NULL,
  `report_date` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_product_reports`
--

INSERT INTO `ln_product_reports` (`s`, `product_id`, `user_id`, `reason`, `main_reason`, `report_date`) VALUES
(1, 'TH166516', '4', 'give us more tickets', '', '2025-08-08 09:28:56'),
(2, 'TH164522', '153', 'Inappropriate Content', 'testing', '2025-08-10 22:07:13');

-- --------------------------------------------------------

--
-- Table structure for table `ln_profits`
--

CREATE TABLE `ln_profits` (
  `s` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `training_id` varchar(200) NOT NULL,
  `order_id` varchar(500) NOT NULL,
  `type` varchar(200) NOT NULL,
  `date` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_profits`
--

INSERT INTO `ln_profits` (`s`, `amount`, `training_id`, `order_id`, `type`, `date`) VALUES
(24, 10000, 'TH371730', 'ORD6867fb23a5cfc', 'Order Payment', '2025-07-05 04:18:31'),
(25, 10000, 'TH371730', 'ORD6867fb23a5cfc', 'Order Payment', '2025-07-05 04:18:31'),
(26, 10000, 'TH371730', 'ORD68689a0358514', 'Order Payment', '2025-07-05 16:36:50'),
(27, 500000, 'TH563330', 'ORDER_987445097', 'Order Payment', '2025-07-06 04:28:09'),
(28, 10000, '21', '21', 'Subscription Payment', '2025-07-06 09:50:27'),
(29, 10000, 'TH371730', 'ORD6867e0a9b70d9', 'Order Payment', '2025-07-04 16:07:18'),
(30, 0, 'TH357692', 'ORD6869d955d938b', 'Order Payment', '2025-07-08 05:24:58'),
(31, 7500, 'TH854626', 'ORD6869d955d938b', 'Order Payment', '2025-07-08 05:22:23'),
(32, 15000, '', 'ORDER_899083781', 'Order Payment', '2025-07-10 18:17:17'),
(33, 10000, 'TH854626', 'ORD6881e189a5726', 'Order Payment', '2025-07-24 08:36:25'),
(34, 10000, '21', '21', 'Subscription Payment', '2025-07-24 08:44:01'),
(35, 7500, 'TH371730', 'ORD6881e300611af', 'Order Payment', '2025-07-25 11:30:07'),
(36, 7500, 'TH854626', 'ORD688ea96b6abb3', 'Order Payment', '2025-08-03 01:12:39'),
(37, 7500, 'TH371730', 'ORD688ea9ad01b05', 'Order Payment', '2025-08-03 04:17:57'),
(38, 60000, 'TH164522', 'ORDER_568377597', 'Order Payment', '2025-08-07 07:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `ln_quiz_answers`
--

CREATE TABLE `ln_quiz_answers` (
  `s` int(10) UNSIGNED NOT NULL,
  `quiz_id` varchar(45) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `answer_file` varchar(450) NOT NULL,
  `answer_text` varchar(4500) NOT NULL,
  `score` varchar(45) NOT NULL,
  `submitted_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_quiz_answers`
--

INSERT INTO `ln_quiz_answers` (`s`, `quiz_id`, `user_id`, `answer_file`, `answer_text`, `score`, `submitted_at`) VALUES
(1, '12', '4', '', 'wow', '', '2025-07-09 17:31:47'),
(2, '12', '4', '', 'wow', '', '2025-07-09 17:34:44'),
(4, '7', '4', '', '', '0', '2025-07-09 19:27:08'),
(149, '5', '4', '', '', '0', '2025-08-09 06:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `ln_reviews`
--

CREATE TABLE `ln_reviews` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `rating` varchar(45) NOT NULL,
  `review` varchar(4500) NOT NULL,
  `date` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_reviews`
--

INSERT INTO `ln_reviews` (`s`, `training_id`, `user`, `rating`, `review`, `date`) VALUES
(1, 'TH371730', '4', '3', 'wow', '2025-07-05 04:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `ln_site_settings`
--

CREATE TABLE `ln_site_settings` (
  `s` int(11) NOT NULL,
  `site_name` varchar(2000) NOT NULL,
  `site_keywords` varchar(2000) NOT NULL,
  `site_url` varchar(2000) NOT NULL,
  `site_description` varchar(20000) NOT NULL,
  `site_logo` varchar(2000) NOT NULL,
  `site_mail` varchar(200) NOT NULL,
  `site_number` varchar(200) NOT NULL,
  `paystack_key` varchar(500) NOT NULL,
  `commision_fee` int(11) NOT NULL,
  `site_prefix` varchar(20) NOT NULL,
  `affliate_percentage` int(11) NOT NULL,
  `account_name` varchar(200) NOT NULL,
  `account_number` int(11) NOT NULL,
  `site_bank` varchar(600) NOT NULL,
  `google_map` varchar(200) NOT NULL DEFAULT 'AIzaSyBAz868BQ8JaQBr_a-osQLCgeNL6e7AZjs',
  `brevo_key` varchar(500) NOT NULL DEFAULT '',
  `payment_url` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_site_settings`
--

INSERT INTO `ln_site_settings` (`s`, `site_name`, `site_keywords`, `site_url`, `site_description`, `site_logo`, `site_mail`, `site_number`, `paystack_key`, `commision_fee`, `site_prefix`, `affliate_percentage`, `account_name`, `account_number`, `site_bank`, `google_map`, `brevo_key`, `payment_url`) VALUES
(1, 'LEARNORA', 'Financial Forecasting & Modelling in the World!', 'https://learnora.projectreporthub.ng/', 'The One Stop Shop for Trainings in Nigeria!', '689474208da79_learnora-logo.png.png', 'hello@learnora.projectreporthub.ng', '+234 (0) 8033782777 ', '916b35ac-6705-4769-ad2b-c4dc00d0d92f', 30, 'ln_', 8, 'Kyneli Business Support Services', 1014522865, 'Zenith Bank Plc', 'AIzaSyBAz868BQ8JaQBr_a-osQLCgeNL6e7AZjs', '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', 'https://dropin-sandbox.vpay.africa/dropin/v1/initialise.js');

-- --------------------------------------------------------

--
-- Table structure for table `ln_subscription_plans`
--

CREATE TABLE `ln_subscription_plans` (
  `s` int(10) UNSIGNED NOT NULL,
  `name` varchar(450) NOT NULL,
  `price` varchar(45) NOT NULL,
  `description` varchar(4500) NOT NULL,
  `discount` varchar(45) NOT NULL,
  `downloads` varchar(45) NOT NULL,
  `duration` varchar(45) NOT NULL,
  `no_of_duration` int(11) NOT NULL,
  `status` varchar(45) NOT NULL,
  `benefits` varchar(450) NOT NULL,
  `image` varchar(45) NOT NULL,
  `created_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_subscription_plans`
--

INSERT INTO `ln_subscription_plans` (`s`, `name`, `price`, `description`, `discount`, `downloads`, `duration`, `no_of_duration`, `status`, `benefits`, `image`, `created_at`) VALUES
(21, 'Enterprise Plan', '10000', 'Unlock exclusive savings with our Enterprise Plan! Enjoy a twenty-five percent (25%) off forty (40) downloads for one (1) year. Designed for high-volume users who want the best value while maximizing efficiency and cost savings.', '25', '40', 'Yearly', 1, 'active', 'Exclusive Training, Priority Support, Early Access Reports', '67fedc4ad2f37.jpeg', '2025-05-22 10:54:03'),
(22, 'Classic Plan', '5000', 'Enjoy twenty percent (20%) off twenty (20) purchases for one (1) year. Perfect for regular buyers looking for great value and consistent savings!', '20', '20', 'Yearly', 1, 'active', 'Exclusive Training, Priority Support, Early Access Reports', 'deafult5.jpg', '2025-05-22 10:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `ln_suspend`
--

CREATE TABLE `ln_suspend` (
  `s` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(450) NOT NULL,
  `suspend_date` varchar(450) NOT NULL,
  `suspend_reason` varchar(4500) NOT NULL,
  `suspend_end` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_suspend`
--

INSERT INTO `ln_suspend` (`s`, `user_id`, `suspend_date`, `suspend_reason`, `suspend_end`) VALUES
(1, '2', '2025-07-07 10:48:35', 'palagiarism', '2025-09-07 10:48:35'),
(2, '5', '2025-07-07 14:33:51', 'wow', '2025-07-10 14:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training`
--

CREATE TABLE `ln_training` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` mediumtext NOT NULL,
  `attendee` varchar(450) NOT NULL,
  `Language` varchar(45) NOT NULL,
  `certification` varchar(45) NOT NULL,
  `level` varchar(45) NOT NULL,
  `delivery_format` varchar(45) NOT NULL,
  `physical_address` varchar(450) NOT NULL,
  `physical_state` varchar(450) NOT NULL,
  `physical_lga` varchar(450) NOT NULL,
  `physical_country` varchar(450) NOT NULL,
  `foreign_address` varchar(450) NOT NULL,
  `web_address` varchar(450) NOT NULL,
  `hybrid_physical_address` varchar(150) NOT NULL,
  `hybrid_web_address` varchar(450) NOT NULL,
  `hybrid_state` varchar(100) NOT NULL,
  `hybrid_lga` varchar(150) NOT NULL,
  `hybrid_country` varchar(80) NOT NULL,
  `hybrid_foreign_address` varchar(800) NOT NULL,
  `course_description` longtext NOT NULL,
  `learning_objectives` longtext NOT NULL,
  `target_audience` varchar(1000) NOT NULL,
  `course_requirrement` longtext NOT NULL,
  `event_type` varchar(450) NOT NULL,
  `pricing` varchar(45) NOT NULL,
  `category` varchar(150) NOT NULL,
  `subcategory` varchar(150) NOT NULL,
  `instructors` varchar(45) NOT NULL,
  `additional_notes` mediumtext NOT NULL,
  `tags` varchar(100) NOT NULL,
  `quiz_method` varchar(45) NOT NULL,
  `created_at` varchar(45) NOT NULL,
  `alt_title` varchar(450) NOT NULL,
  `status` varchar(45) NOT NULL,
  `loyalty` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training`
--

INSERT INTO `ln_training` (`s`, `training_id`, `title`, `description`, `attendee`, `Language`, `certification`, `level`, `delivery_format`, `physical_address`, `physical_state`, `physical_lga`, `physical_country`, `foreign_address`, `web_address`, `hybrid_physical_address`, `hybrid_web_address`, `hybrid_state`, `hybrid_lga`, `hybrid_country`, `hybrid_foreign_address`, `course_description`, `learning_objectives`, `target_audience`, `course_requirrement`, `event_type`, `pricing`, `category`, `subcategory`, `instructors`, `additional_notes`, `tags`, `quiz_method`, `created_at`, `alt_title`, `status`, `loyalty`, `user`) VALUES
(2, 'TH139937', 'Safe Handling and Administration of Medicatio', 'Learn how health and safety guidelines can ensure the safe use of medication in this free online healthcare course.\r\nHealth professionals require training to safely handle and administer medications to protect the patients in their care from the dangers posed by mishandled medical drugs. This course explores the safety procedures used in medicine management to provide you with these important medical safety skills. We explain how to handle hazardous drugs and prevent prescription errors. We also describe how the Covid-19 pandemic affected the use of medicine.', 'Health practioner', 'English', 'yes', 'intermediate', 'physical', '', '', '', '', '', '', '', '', '', '', '', '', 'Allopathic (or ‘mainstream’) medicine treats diseases with drugs that could be potentially harmful or ineffective if not properly administered. It is essential that the health industry standardises the safe handling and administration of medication. This free medical health and safety course provides the knowledge required to safely administer drugs. We discuss the role of the government in establishing and maintaining the laws and policies that ensure that effective medicines are administered properly.\r\nThe course then traces the link between medical management and professional communication, which is essential to ensure that all healthcare professionals caring for a patient share the same information and that any potential problems associated with their care are resolved. Encouraging patients to take an active role in maintaining medication safety is one approach used to reduce incidents of medication error. Patient involvement can improve the health and quality of life of those in your care and lowers the risk of unintended harm.', 'Explain the importance of medicatio...\r\nDistinguish between policies and pr...\r\nState the standard operating proced...\r\nDiscuss the importance of personal .', 'Health people', 'Nurse', '1', '', '6', '112', '3', 'testing', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', '', '2025-06-29 20:41:00', 'safe-handling-administration-of-medication', 'approved', '', '3'),
(3, 'TH843118', 'tester', 'testing', 'Health practioner', 'English', 'yes', 'beginner', 'physical', '', '', '', '', 'Opeyemistreet wema,  iwo road, Ibadan.', '', '', '', '', '', '', '', 'testing', 'testing', 'Health people', 'testing', '2', 'paid', '7', '124', '2', 'testing', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', '', '2025-06-29 20:58:03', 'tester', 'approved', '', '3'),
(4, 'TH371730', 'Diploma in Caregiving', 'This course focuses on the practical, legal and ethical issues you face while providing care to the sick and elderly. We help you develop the skills required to become an effective caregiver, which involves assisting loved ones and clients with meals, personal care, transportation and other physical and emotional needs. We explain how to deal with dementia while managing the impact of age, disease and injury to bring comfort to those in need.', '', 'English', 'yes', 'beginner', 'hybrid', '', '', '', '', '', '', '38, Opeyemistreet wema, iwo road, Ibadan.', 'https://chatgpt.com/c/6861cdb0-4d3c-8003-a8c6-61c3904ebff2', '', '', '', '', 'This course begins by introducing you to the roles and responsibilities of caregivers. We study the legal and ethical issues involved in the caregiving process. You will also learn how to communicate with individuals with disabilities before covering stress management, body mechanics and organisational skills. This course also discusses the purpose of observing, reporting and documenting the condition of those in your care. We establish the importance of cultural awareness and cultural competency to create a respectful work environment. The course examines various ailments and illnesses you may encounter and describes their treatment and prevention.', 'Outline the fundamental roles and r...\r\nDescribe the various legal issues t...\r\nDescribe how to identify, treat and...\r\nIdentify the correct actions to tak...', 'Health people', 'Sharpen your caregiving skills in this free online course to provide professional care to clients or family members.', '11', 'paid', '2', '22', '1', 'testing', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', 'form', '2025-06-30 00:39:55', 'diploma-in-caregiving', 'approved', '1', '3'),
(5, 'TH206142', 'Safeguarding Children and Vulnerable Adults', 'Have you ever felt a personal calling to make a difference in the lives of others? Have you thought of safeguarding vulnerable individuals? This course explores the various forms of abuse, their immediate and long-term signs and how they impact the lives of vulnerable individuals. Discover how to ensure a safe environment for children and vulnerable adults using collaborative approaches and the fundamental principles of safety and well-being', 'Health practioner', 'English', 'yes', 'beginner', 'hybrid', '', '', '', '', '', '', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'https://chatgpt.com/c/6861cdb0-4d3c-8003-a8c6-61c3904ebff2', 'Oyo', 'Egbeda', 'Nigeria', '', 'Safeguarding is our collective responsibility to protect the rights of every individual, especially children and vulnerable adults, from abuse, neglect or any other kind of harm. Numerous factors can put an individual at risk of potential abuse or harm, including age, physical and mental health and socioeconomic conditions. In this course, you\'ll discover the causes and signs of physical, emotional and other types of abuse that children and vulnerable adults may encounter.', 'Discuss the need for safeguarding c...\r\nRecognize various signs of abuse in...\r\nDistinguish between different types...\r\nAnalyze various short-term and long', 'Health people', 'Discuss the need for safeguarding c...\r\nRecognize various signs of abuse in...\r\nDistinguish between different types...\r\nAnalyze various short-term and long', '1', 'donation', '1', '20', '2', '', '', '', '2025-06-30 00:54:01', '', 'approved', '', '3'),
(6, 'TH563330', 'testing', 'testng', 'Health practioner', 'English', 'no', 'intermediate', 'physical', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'Oyo', 'Egbeda', 'Nigeria', '', '', '', '', '', '', '', '', 'testing', 'testing', 'testing', 'testing', '4', 'donation', '9', '144', '4', 'testing', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', 'upload', '2025-06-30 02:23:15', 'testing', 'approved', '', '3'),
(7, 'TH357692', 'Basics of Security Management', 'his course delves into the world of security and security management at the workplace. We explain how security risks are identified and mitigated to ensure the complete safety of an organisation’s systems and personnel. Given today’s increase of cyber attacks and threats, we also establish the importance of information security. Sign up to explore the role of security management in reducing the risks posed by physical and cyber threats.', 'Cyber Security', 'English', 'yes', 'beginner', 'physical', '38, Opeyemistreet wema, iwo road, Ibadan.', 'Yobe', 'Egbeda', 'Nigeria', '', '', '', '', '', '', '', '', 'Are you an employee, manager or small business owner who wants to ensure the safety and security of systems at your workspace? This course on the basics of security management explains how to ensure not just the physical but also the cybersecurity of workplace systems. We begin with definitions of the terms ‘security’ and ‘security management’. We show you how to develop a robust security process for identifying and mitigating workplace risks.\r\nDo you find yourself fretting over a lack of physical security measures in your workspace? The course establishes the importance of leadership in creating and maintaining a safe work environment. We also discuss the role of regular risk assessments and demonstrate the importance of cooperation and teamwork in an organisation. Security management always starts off with physical security so we outline the strategies used to ensure physical safety in the workplace.', 'Define the terms ‘security’ and ‘security management’ within the context of workplace safety\r\nExplain how to assess, analyse and reduce security risks in the workplace\r\nDiscuss how to carry out a risk assessment and manage security in an organisation\r\nOutline the safety measures used to ensure physical security\r\nDiscuss the concepts of cyber security and the principles of information security management\r\nDescribe the role that procedures and policies play in ensuring organisational security', 'testing', 'All Alison courses are free to enrol study and complete. To successfully complete this certificate course and become an Alison Graduate, you need to achieve 80% or higher in each course assessment. Once you have completed this certificate course, you have the option to acquire an official certificate, which is a great way to share your achievement with the world.', '3', 'free', '4', '89', '9', 'good', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', 'form', '2025-07-08 04:50:33', 'basics-of-security-management', 'approved', '1', '3'),
(8, 'TH854626', ' Data Protection and Privacy Information Mana', 'This short course on ISO 27701 focuses on privacy management. It sets the framework for an Information Security Management System (ISMS), with its controls addressing risk management and security practices. ISO 27701 also adds privacy-specific controls that align with GDPR requirements. It outlines how to handle personal data, including data subject rights, data processing, and risk management, ensuring compliance with privacy regulations.', 'data security', 'English', 'yes', 'advanced', 'online', '', '', '', '', '', 'https://meet.google.com/landing?pli=1', '', '', '', '', '', '', 'This course provides a comprehensive overview of information security and privacy management, focusing on ISO standards such as ISO 27001, ISO 27701, and ISO 27018. As organizations increasingly rely on digital data, these standards are vital for the protection of sensitive information. Designed for regulatory professionals and students, this course enhances skills in implementing robust security and privacy practices in accordance with the ISO standards.\r\n\r\nParticipants will analyze ISO 27001, focusing on information security management systems (ISMS), and learn its requirements and strategies. The course then covers ISO 27701, which focuses on privacy through a Privacy Information Management System (PIMS). Additionally, ISO 27018 is discussed for its controls on protecting Personally Identifiable Information (PII) in the cloud.', 'Describe the responsibilities outlined in a contract for processing Personally Identifiable Information (PII)\r\nIndicate the relationship between ISO 27701 and ISO 2700\r\nExplain the ways in which Annex A provides privacy management controls and objectives for organizations', 'testing', 'Describe the responsibilities outlined in a contract for processing Personally Identifiable Information (PII)\r\nIndicate the relationship between ISO 27701 and ISO 2700\r\nExplain the ways in which Annex A provides privacy management controls and objectives for organizations', '3', 'paid', '4', '91', '10', 'wow', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', 'text', '2025-07-08 04:57:55', '-data-protection-and-privacy-information-management', 'approved', '1', '3'),
(9, 'TH551998', 'The Ultimate Digital Marketing Course 2025: 1', '<p>Learn market research, website creation, copywriting, SEO, Google ads, Facebook ads, email marketing, Twitter ads + more</p>', 'Entrepreneurs, business owners, bloggers, social media fans', 'English', 'yes', 'beginner', 'online', '', '', '', '', '', 'https://meet.google.com/landing?pli=1', '', '', '', '', '', '', '<p>Learn Digital Marketing from the UKï¿½s Award Winning Digital Marketing Agency Owner Joshua George! Iï¿½ll be revealing the exact Digital Marketing blueprints and strategies that we use ourself at the agency, to generate several hundreds thousands of dollars in revenue EVERY single year for our clients. These are all tried and tested strategies that are proven to actually work in the real world. I wonï¿½t just be showing you the theory behind these strategies, Iï¿½ll also be showing you how you can implement ALL of them in real-time ensuring everything you learn is super actionable!</p>', '<p>Learn Digital Marketing from the UK\'s Award Winning Digital Marketing Agency Owner How to carry out market research along with the 3 question survey that will position you for success How to build a website from scratch (without any coding skills) How to write effective sales copy &amp; grow your business &amp; career SEO - How to get any website onto page 1 of Google organically and generates tons of free traffic Create, Develop and Optimize Your Own Profitable Google Ads Campaigns Learn how to grow your very own email list and create revenue driving email marketing campaigns Master Facebook Ads and connect with new audiences and lower your ad costs</p>', '<p>Entrepreneur</p>', '<p>NO digital marketing experience is required!</p>', '4', 'paid', '6', '111', '153', '<p>work and acheive your goal</p>', 'good', 'form', '2025-07-10 16:31:19', 'the-ultimate-digital-marketing-course-2025:-11-courses-in-1', 'pending', '0', '4'),
(10, 'TH166516', 'Learn How To Ace Your Digital Marketing Job I', 'Learn How To Ace Job Interviews & Get Your Dream Digital Marketing Job. Learn How To Pitch Recruiters To Hire You Now!', 'Entrepreneurs, business owners, bloggers, social media fans', 'English', 'yes', 'intermediate', 'online', '', '', '', '', '', 'https://meet.google.com/landing?pli=1', '', '', '', '', '', '', '', 'Learn What Companies Are Looking For In A Digital Marketing Interview\r\nLearn General And Trick Questions Recruiters May Ask You And How To Answer Them\r\nLearn What To Do Before, During, And After A Digital Marketing Interview\r\nLearn To Craft A Pitch On How To Sell Yourself To The Recruiter As The Perfect Candidate For The Role', 'testing', 'There are no requirements or pre-requisites\r\nStudents will get the most benefit if they are preparing for an interview or anticipating being invited for an interview', '6', 'donation', '8', '133', '7', 'test', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', 'form', '2025-07-10 16:47:03', 'learn-how-to-ace-your-digital-marketing-job-interview', 'approved', '0', '4'),
(149, 'TH165122', 'The Complete Course on Sport Events and Facil', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">What sports event management involves and the key skills that an event or facility manager must have</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Why sports event and facility managers are so important for the sports industry</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">The differences between closed and open sports events</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">How the Olympic Games are o', 'Health practioner', 'English', 'yes', 'beginner', 'physical', '', 'Adamawa', 'Ganaye', 'Nigeria', '', '', '', '', '', '', '', '', '<p>The global sports industry is worth around $620 billion, and its current growth outstrips that of the GDP growth of most countries. Sports events are a major part of the industry, and as sports have grown, so too have the events. These days, events are bigger, more exciting and bring in more revenue than ever before. Fans from all over the world tune in to watch some of the biggest sports with mega events like the Olympics bringing in billions of viewers.</p>\r\n<p>These events all require dedicated teams of event managers, staff and volunteers to make sure they go to plan. With so many different moving parts, multiple teams of athletes, venues, and thousands of live spectators, a sporting event can be challenging to organise. That&rsquo;s why qualified professionals who understand the industry are so vital.</p>\r\n<p>Facility management and sports event management are more or less two sides of the same coin. Both roles are critical for the success of an event and will each have different responsibilities and duties, before, during and after the event. For an event to go to plan, all of the staff have to be aware of the aims of the event, and there needs to be a coherent plan for achieving those aims.</p>\r\n<p>This plan is formed long before the event takes place, and most of the work of the event manager goes into creating and optimising the plan. Any event will need a lot of care and attention to detail during the planning phase to ensure that the venue, hospitality, staff an', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">What sports event management involves and the key skills that an event or facility manager must have</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Why sports event and facility managers are so important for the sports industry</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">The differences between closed and open sports events</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">How the Olympic Games are o', 'Health people', '<p>The global sports industry is worth around $620 billion, and its current growth outstrips that of the GDP growth of most countries. Sports events are a major part of the industry, and as sports have grown, so too have the events. These days, events are bigger, more exciting and bring in more revenue than ever before. Fans from all over the world tune in to watch some of the biggest sports with mega events like the Olympics bringing in billions of viewers.</p>', '6', 'paid', '2,5', '26,28', '149', '<p>The global sports industry is worth around $620 billion, and its current growth outstrips that of the GDP growth of most countries. Sports events are a major part of the industry, and as sports have grown, so too have the events. These days, events are bigger, more exciting and bring in more revenue than ever before. Fans from all over the world tune in to watch some of the biggest sports with mega events like the Olympics bringing in billions', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE BUSINESS ORGANIZATION', 'text', '2025-08-06 20:28:11', 'the-complete-course-on-sport-events-and-facility-management', 'approved', '1', '3'),
(150, 'TH164522', 'testing', '', '', 'English', 'yes', 'intermediate', 'online', '', '', '', '', '', 'https://meet.google.com/landing?pli=1', '', '', '', '', '', '', '', '', '', '', '4', 'donation', '3', '79', '10', '', '', 'upload', '2025-08-06 23:31:24', 'testing-1', 'approved', '1', '3'),
(151, 'TH431436', 'Dry Cocoa Seed Export From Nigeria', '<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa, scientifically known as Theobroma cacao, holds a significant place in Nigeria\'s agricultural heritage. The cultivation of cocoa in Nigeria dates back to the late 19th century when it was introduced by colonial settlers. Over time, cocoa emerged as a major cash crop, driving economic growth and shaping the socio-economic fabric of regions where it is cultivated.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa production in Nigeria is concentrated primarily in the southern regions of the country, including Ondo, Osun, Ogun, Ekiti, and Cross River states. These regions offer suitable climatic conditions, including ample rainfall and well-drained soils, conducive to cocoa cultivation.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Nigeria ranks among the top cocoa-producing countries globally, consistently contributing a significant share to the world\'s cocoa output. Despite facing challenges such as aging cocoa trees and declining productivity in recent years, Nige', '', 'English', 'yes', 'beginner', 'physical', '10 Wale Ariwo-Ola St, Graceland Estate, Bucknor, Ejigbo, Lagos 102214, Lagos, Nigeria', 'Lagos', 'Ejigbo', 'Nigeria', '', '', '', '', '', '', '', '', '<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa, scientifically known as Theobroma cacao, holds a significant place in Nigeria\'s agricultural heritage. The cultivation of cocoa in Nigeria dates back to the late 19th century when it was introduced by colonial settlers. Over time, cocoa emerged as a major cash crop, driving economic growth and shaping the socio-economic fabric of regions where it is cultivated.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa production in Nigeria is concentrated primarily in the southern regions of the country, including Ondo, Osun, Ogun, Ekiti, and Cross River states. These regions offer suitable climatic conditions, including ample rainfall and well-drained soils, conducive to cocoa cultivation.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Nigeria ranks among the top cocoa-producing countries globally, consistently contributing a significant share to the world\'s cocoa output. Despite facing challenges such as aging cocoa trees and declining productivity in recent years, Nige', '<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa, scientifically known as Theobroma cacao, holds a significant place in Nigeria\'s agricultural heritage. The cultivation of cocoa in Nigeria dates back to the late 19th century when it was introduced by colonial settlers. Over time, cocoa emerged as a major cash crop, driving economic growth and shaping the socio-economic fabric of regions where it is cultivated.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa production in Nigeria is concentrated primarily in the southern regions of the country, including Ondo, Osun, Ogun, Ekiti, and Cross River states. These regions offer suitable climatic conditions, including ample rainfall and well-drained soils, conducive to cocoa cultivation.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Nigeria ranks among the top cocoa-producing countries globally, consistently contributing a significant share to the world\'s cocoa output. Despite facing challenges such as aging cocoa trees and declining productivity in recent years, Nige', 'Beginners Training for Cocoa Seed Export', '<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa, scientifically known as Theobroma cacao, holds a significant place in Nigeria\'s agricultural heritage. The cultivation of cocoa in Nigeria dates back to the late 19th century when it was introduced by colonial settlers. Over time, cocoa emerged as a major cash crop, driving economic growth and shaping the socio-economic fabric of regions where it is cultivated.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa production in Nigeria is concentrated primarily in the southern regions of the country, including Ondo, Osun, Ogun, Ekiti, and Cross River states. These regions offer suitable climatic conditions, including ample rainfall and well-drained soils, conducive to cocoa cultivation.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Nigeria ranks among the top cocoa-producing countries globally, consistently contributing a significant share to the world\'s cocoa output. Despite facing challenges such as aging cocoa trees and declining productivity in recent years, Nige', '1', 'paid', '1', '10', '150', '<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa, scientifically known as Theobroma cacao, holds a significant place in Nigeria\'s agricultural heritage. The cultivation of cocoa in Nigeria dates back to the late 19th century when it was introduced by colonial settlers. Over time, cocoa emerged as a', 'Mystery Shopping Services Providers Nigeria', '', '2025-08-07 12:34:12', 'dry-cocoa-seed-export-from-nigeria', 'pending', '0', '152'),
(152, 'TH437912', 'UNFORGETTABLE EVENTS: Event Planning, Marketi', '<p><strong>MASTER EVENT MARKETING TO PACK YOUR EVENTS AND BOOST REVENUE</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Learn the secrets and strategies behind successful event marketing that drive incredible attendance and revenue. This course gives you proven techniques to grow your audience, build excitement, and create a loyal fanbase.</p>\r\n<p>It works equally well for small gatherings or large-scale events. These strategies will save you time, money, and frustration while delivering results that benefit your business or cause.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>EVENT MARKETING AND GROWTH: STRATEGIES TO BUILD SUCCESSFUL, PROFITABLE EVENTS</strong></p>\r\n<p>&nbsp;</p>\r\n<p>You\'ll learn how to use Google search, popular event directories, Meetup, Eventbrite, and how to find big event websites popular in any part of the world where you are located. All these websites will drive traffic to your event listing, and generate a large attendance.</p>\r\n<p>I&nbsp;used this technique to get 100+ attendees per event without spending a single dollar on marketing, and you\'ll be able to do the same.</p>\r\n<p>We\'ll also cover how to intelligently pay for ads if you have a budget and want to boost your attendance further. But that\'s only optional. You\'ll be able to generate amazing attendance for free.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>YOU&rsquo;VE PROBABLY THOUGHT ABOUT PLANNING AN EVENT, BUT&hellip;</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Maybe the thought of juggling the details, costs, and turnout has held you back. Th', '', 'English', 'yes', 'beginner', 'physical', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'Enugu', 'Nkanu East', 'Nigeria', '', '', '', '', '', '', '', '', '<p><strong>MASTER EVENT MARKETING TO PACK YOUR EVENTS AND BOOST REVENUE</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Learn the secrets and strategies behind successful event marketing that drive incredible attendance and revenue. This course gives you proven techniques to grow your audience, build excitement, and create a loyal fanbase.</p>\r\n<p>It works equally well for small gatherings or large-scale events. These strategies will save you time, money, and frustration while delivering results that benefit your business or cause.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>EVENT MARKETING AND GROWTH: STRATEGIES TO BUILD SUCCESSFUL, PROFITABLE EVENTS</strong></p>\r\n<p>&nbsp;</p>\r\n<p>You\'ll learn how to use Google search, popular event directories, Meetup, Eventbrite, and how to find big event websites popular in any part of the world where you are located. All these websites will drive traffic to your event listing, and generate a large attendance.</p>\r\n<p>I&nbsp;used this technique to get 100+ attendees per event without spending a single dollar on marketing, and you\'ll be able to do the same.</p>\r\n<p>We\'ll also cover how to intelligently pay for ads if you have a budget and want to boost your attendance further. But that\'s only optional. You\'ll be able to generate amazing attendance for free.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>YOU&rsquo;VE PROBABLY THOUGHT ABOUT PLANNING AN EVENT, BUT&hellip;</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Maybe the thought of juggling the details, costs, and turnout has held you back. Th', '<p><strong>MASTER EVENT MARKETING TO PACK YOUR EVENTS AND BOOST REVENUE</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Learn the secrets and strategies behind successful event marketing that drive incredible attendance and revenue. This course gives you proven techniques to grow your audience, build excitement, and create a loyal fanbase.</p>\r\n<p>It works equally well for small gatherings or large-scale events. These strategies will save you time, money, and frustration while delivering results that benefit your business or cause.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>EVENT MARKETING AND GROWTH: STRATEGIES TO BUILD SUCCESSFUL, PROFITABLE EVENTS</strong></p>\r\n<p>&nbsp;</p>\r\n<p>You\'ll learn how to use Google search, popular event directories, Meetup, Eventbrite, and how to find big event websites popular in any part of the world where you are located. All these websites will drive traffic to your event listing, and generate a large attendance.</p>\r\n<p>I&nbsp;used this technique to get 100+ attendees per event without spending a single dollar on marketing, and you\'ll be able to do the same.</p>\r\n<p>We\'ll also cover how to intelligently pay for ads if you have a budget and want to boost your attendance further. But that\'s only optional. You\'ll be able to generate amazing attendance for free.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>YOU&rsquo;VE PROBABLY THOUGHT ABOUT PLANNING AN EVENT, BUT&hellip;</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Maybe the thought of juggling the details, costs, and turnout has held you back. Th', 'Entrepreneur', '<p><strong>MASTER EVENT MARKETING TO PACK YOUR EVENTS AND BOOST REVENUE</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Learn the secrets and strategies behind successful event marketing that drive incredible attendance and revenue. This course gives you proven techniques to grow your audience, build excitement, and create a loyal fanbase.</p>\r\n<p>It works equally well for small gatherings or large-scale events. These strategies will save you time, money, and frustration while delivering results that benefit your business or cause.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>EVENT MARKETING AND GROWTH: STRATEGIES TO BUILD SUCCESSFUL, PROFITABLE EVENTS</strong></p>\r\n<p>&nbsp;</p>\r\n<p>You\'ll learn how to use Google search, popular event directories, Meetup, Eventbrite, and how to find big event websites popular in any part of the world where you are located. All these websites will drive traffic to your event listing, and generate a large attendance.</p>\r\n<p>I&nbsp;used this technique to get 100+ attendees per event without spending a single dollar on marketing, and you\'ll be able to do the same.</p>\r\n<p>We\'ll also cover how to intelligently pay for ads if you have a budget and want to boost your attendance further. But that\'s only optional. You\'ll be able to generate amazing attendance for free.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>YOU&rsquo;VE PROBABLY THOUGHT ABOUT PLANNING AN EVENT, BUT&hellip;</strong></p>\r\n<p>&nbsp;</p>\r\n<p>Maybe the thought of juggling the details, costs, and turnout has held you back. Th', '2', 'paid', '3,4', '80,81', '151', '<p>Professional event planning is important for your event success because if the event runs smoothly and people enjoy it, they will become a part of your regular attendance base, and attend many future events.</p>\r\n<p>I\'ll show you how to create a great plan for what to do before, during, and after the events. You&rsquo;ll learn exactly how to choose the right location, manage costs effectively, and coordinate the people involved to ensure every', 'good,events', 'form', '2025-08-07 21:14:05', 'unforgettable-events-event-planning-marketing-management', 'approved', '1', '3'),
(153, 'TH308284', 'The Ultimate Guide to Professional Event Plan', '<p>Looking to translate your organizational skills into a new career as an&nbsp;<strong>Event Planner</strong>&nbsp;or&nbsp;<strong>Wedding Planner</strong>? Are you an Event Planner who wants to learn the tips and techniques that will make you top in your field?</p>\r\n<p>Then I welcome you to&nbsp;<strong>The Ultimate Guide to Professional Event Planning &amp; Management</strong></p>\r\n<p>In this course, we\'ll guide you through everything you need to successfully organize events for a living.</p>\r\n<p><strong>After completing this course, you&rsquo;ll know how to:</strong></p>\r\n<p>* Deal professionally with clients (even your first one!)</p>\r\n<p>* Get the most out of suppliers (and build lasting relationships)</p>\r\n<p>* Create a detailed budget (using my budget template)</p>\r\n<p>* Scout locations for the best venues (with my site inspection checklist)</p>\r\n<p>* Manage events and weddings so they run like clockwork (using my function form)</p>\r\n<p>* Adopt the work habits of an efficient, successful event planner</p>', '', 'English', 'yes', 'intermediate', 'hybrid', '', '', '', '', '', '', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'https://chatgpt.com/c/6861cdb0-4d3c-8003-a8c6-61c3904ebff2', 'Ekiti', 'Efon', 'Nigeria', '', '<p>Looking to translate your organizational skills into a new career as an&nbsp;<strong>Event Planner</strong>&nbsp;or&nbsp;<strong>Wedding Planner</strong>? Are you an Event Planner who wants to learn the tips and techniques that will make you top in your field?</p>\r\n<p>Then I welcome you to&nbsp;<strong>The Ultimate Guide to Professional Event Planning &amp; Management</strong></p>\r\n<p>In this course, we\'ll guide you through everything you need to successfully organize events for a living.</p>\r\n<p><strong>After completing this course, you&rsquo;ll know how to:</strong></p>\r\n<p>* Deal professionally with clients (even your first one!)</p>\r\n<p>* Get the most out of suppliers (and build lasting relationships)</p>\r\n<p>* Create a detailed budget (using my budget template)</p>\r\n<p>* Scout locations for the best venues (with my site inspection checklist)</p>\r\n<p>* Manage events and weddings so they run like clockwork (using my function form)</p>\r\n<p>* Adopt the work habits of an efficient, successful event planner</p>', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Event Management</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">wedding planning</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">How to become an amazing EVENT PLANNER</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">How to plan the perfect wedding</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\">&nbsp;</div>\r\n</li>\r\n</ul>', 'Entrepreneur', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Event Management</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">wedding planning</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">How to become an amazing EVENT PLANNER</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">How to plan the perfect wedding</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\">&nbsp;</div>\r\n</li>\r\n</ul>', '7', 'paid', '3,4', '81', '5', '<p>ooking to translate your organizational skills into a new career as an&nbsp;<strong>Event Planner</strong>&nbsp;or&nbsp;<strong>Wedding Planner</strong>? Are you an Event Planner who wants to learn the tips and techniques that will make you top in your field?</p>', 'Mystery Shopping Services Providers Nigeria', 'form', '2025-08-08 01:56:27', 'the-ultimate-guide-to-professional-event-planning-management', 'approved', '1', '3'),
(154, 'TH597136', 'Certification in Event Management', '<p>In this course, you will embark on a journey through the entire event management process, from conceptualization to post-event evaluation. You\'ll gain insights into the various types of events, including corporate meetings, weddings, festivals, conferences, and more. Through a combination of engaging lectures, practical assignments, case studies, and discussions, you will learn the following key concepts:</p>\r\n<p>Event management is a comprehensive process that involves planning, organizing, executing, and evaluating events of various types and scales. Here\'s an overview of the typical event management process:</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Conceptualization and Defining Objectives:</strong></p>\r\n<p>&middot; Identify the purpose and objectives of the event. What is the event meant to achieve? This could be anything from a business conference to a wedding celebration</p>\r\n<p>&middot; Define the target audience and the scale of the event</p>\r\n<p>&nbsp;</p>\r\n<p>Event Planning:</p>\r\n<p>&middot; Create a detailed event plan that outlines all aspects of the event, including logistics, budget, timeline, and resources</p>\r\n<p>&middot; Develop a concept or theme for the event</p>\r\n<p>&middot; Determine the event date and duration</p>\r\n<p>&middot; Select a suitable venue based on the event requirements</p>\r\n<p>Budgeting and Financial Management:</p>\r\n<p>&middot; Estimate the overall budget for the event</p>\r\n<p>&middot; Allocate funds to different aspects of the event, such as venu', '', 'English', 'yes', 'beginner', 'physical', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', 'Delta', 'Isoko south', 'Nigeria', '', '', '', '', '', '', '', '', '<p>In this course, you will embark on a journey through the entire event management process, from conceptualization to post-event evaluation. You\'ll gain insights into the various types of events, including corporate meetings, weddings, festivals, conferences, and more. Through a combination of engaging lectures, practical assignments, case studies, and discussions, you will learn the following key concepts:</p>\r\n<p>Event management is a comprehensive process that involves planning, organizing, executing, and evaluating events of various types and scales. Here\'s an overview of the typical event management process:</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Conceptualization and Defining Objectives:</strong></p>\r\n<p>&middot; Identify the purpose and objectives of the event. What is the event meant to achieve? This could be anything from a business conference to a wedding celebration</p>\r\n<p>&middot; Define the target audience and the scale of the event</p>\r\n<p>&nbsp;</p>\r\n<p>Event Planning:</p>\r\n<p>&middot; Create a detailed event plan that outlines all aspects of the event, including logistics, budget, timeline, and resources</p>\r\n<p>&middot; Develop a concept or theme for the event</p>\r\n<p>&middot; Determine the event date and duration</p>\r\n<p>&middot; Select a suitable venue based on the event requirements</p>\r\n<p>Budgeting and Financial Management:</p>\r\n<p>&middot; Estimate the overall budget for the event</p>\r\n<p>&middot; Allocate funds to different aspects of the event, such as venu', '<p>In this course, you will embark on a journey through the entire event management process, from conceptualization to post-event evaluation. You\'ll gain insights into the various types of events, including corporate meetings, weddings, festivals, conferences, and more. Through a combination of engaging lectures, practical assignments, case studies, and discussions, you will learn the following key concepts:</p>\r\n<p>Event management is a comprehensive process that involves planning, organizing, executing, and evaluating events of various types and scales. Here\'s an overview of the typical event management process:</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Conceptualization and Defining Objectives:</strong></p>\r\n<p>&middot; Identify the purpose and objectives of the event. What is the event meant to achieve? This could be anything from a business conference to a wedding celebration</p>\r\n<p>&middot; Define the target audience and the scale of the event</p>\r\n<p>&nbsp;</p>\r\n<p>Event Planning:</p>\r\n<p>&middot; Create a detailed event plan that outlines all aspects of the event, including logistics, budget, timeline, and resources</p>\r\n<p>&middot; Develop a concept or theme for the event</p>\r\n<p>&middot; Determine the event date and duration</p>\r\n<p>&middot; Select a suitable venue based on the event requirements</p>\r\n<p>Budgeting and Financial Management:</p>\r\n<p>&middot; Estimate the overall budget for the event</p>\r\n<p>&middot; Allocate funds to different aspects of the event, such as venu', 'Health people', '<p>In this course, you will embark on a journey through the entire event management process, from conceptualization to post-event evaluation. You\'ll gain insights into the various types of events, including corporate meetings, weddings, festivals, conferences, and more. Through a combination of engaging lectures, practical assignments, case studies, and discussions, you will learn the following key concepts:</p>\r\n<p>Event management is a comprehensive process that involves planning, organizing, executing, and evaluating events of various types and scales. Here\'s an overview of the typical event management process:</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Conceptualization and Defining Objectives:</strong></p>\r\n<p>&middot; Identify the purpose and objectives of the event. What is the event meant to achieve? This could be anything from a business conference to a wedding celebration</p>\r\n<p>&middot; Define the target audience and the scale of the event</p>\r\n<p>&nbsp;</p>\r\n<p>Event Planning:</p>\r\n<p>&middot; Create a detailed event plan that outlines all aspects of the event, including logistics, budget, timeline, and resources</p>\r\n<p>&middot; Develop a concept or theme for the event</p>\r\n<p>&middot; Determine the event date and duration</p>\r\n<p>&middot; Select a suitable venue based on the event requirements</p>\r\n<p>Budgeting and Financial Management:</p>\r\n<p>&middot; Estimate the overall budget for the event</p>\r\n<p>&middot; Allocate funds to different aspects of the event, such as venu', '9', 'paid', '2,4', '23,26', '10', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn complete Event management procedures and co', 'THE AUDITOR AS AN INDISPENSABLE PART OF A PROFITABLE', 'text', '2025-08-08 14:40:28', 'certification-in-event-management', 'approved', '1', '3');
INSERT INTO `ln_training` (`s`, `training_id`, `title`, `description`, `attendee`, `Language`, `certification`, `level`, `delivery_format`, `physical_address`, `physical_state`, `physical_lga`, `physical_country`, `foreign_address`, `web_address`, `hybrid_physical_address`, `hybrid_web_address`, `hybrid_state`, `hybrid_lga`, `hybrid_country`, `hybrid_foreign_address`, `course_description`, `learning_objectives`, `target_audience`, `course_requirrement`, `event_type`, `pricing`, `category`, `subcategory`, `instructors`, `additional_notes`, `tags`, `quiz_method`, `created_at`, `alt_title`, `status`, `loyalty`, `user`) VALUES
(155, 'TH854383', 'Build a Profitable Event Planner Business', '', '', 'English', 'yes', 'intermediate', 'physical', '38, Opeyemistreet wema, iwo road, Ibadan.', 'Anambra', 'Awka North', 'Nigeria', '', '', '', '', '', '', '', '', '<p>If you are thinking about getting into the events business or you are already in the industry, but you are struggling to find clients and make regular money from the events that you put on then this is the course for you. I will share with you the way that I made money in business with clever marketing that hardly cost me any money and how I ran the business so that I always had enough cash to pay the bills.</p>\r\n<p><strong>Are you worried that the events you are being asked to create don&rsquo;t generate enough income?</strong></p>\r\n<p><strong>Do you dream of finding your ideal clients that will pay you what you are worth?</strong></p>\r\n<p><strong>Are you looking for a marketing plan that will work?</strong></p>\r\n<p><strong>Do you have a grip on the business&rsquo; set-up and finances?</strong></p>\r\n<p>Whatever your background may be, if you&rsquo;ve ever thought about turning your knowledge, your skills and passion into a profitable event/wedding planning business then you are in the right place.</p>\r\n<p>You need a&nbsp;<em>plan</em>&nbsp;to succeed, to make things clear in your mind, so that you aren&rsquo;t running around like a headless chicken. Running events and running the business are two separate things. This course won&rsquo;t teach you how to run events, you know how to do that, and you are good at it, this course will walk you through how to create a marketing strategy that doesn&rsquo;t just rely on social media. I will show you how to find clients from unlikely sources and show you that not everyone is your client because they can&rsquo;t pay you what you are worth.</p>\r\n<p>From figuring out who you want your ideal client to be, to pricing and marketing. I\'ll walk you through everything you need to know based on my own experience. You won&rsquo;t find anything in this course that I haven&rsquo;t tried myself. There are resources that have been created for you to build a profitable business. This is a &ldquo;let&rsquo;s make it happen&rdquo; training.</p>', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Define your ideal client who will pay you what you are worth</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Understand how to reach your ideal target market with different forms of marketing.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Gain knowledge on how to get your business into magazines and on local radio</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn how to charge your clients and make a profit from every single event you do.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Find out how to make money from your suppliers.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Understand how to do simple accounting without being an accountant to keep cash flowing in the business</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn how to write a cracking proposal to get the client to say \"yes\".</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Recognise the different types of insurance that you may need to purchase to keep you and your business protected.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Be able to put together a contract without being a lawyer.</span></div>\r\n</div>\r\n</li>\r\n</ul>', 'Health people', '', '10', 'paid', '2,3,4', '22,23,24', '151', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Define your ideal client who will pay you what you are worth</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Understand how to reach your ideal target market with different forms of marketing.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Gain knowledge on how to get your business into magazines and on local radio</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn how to charge your clients and make a profit from every single event you do.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Find out how to make money from your suppliers.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Understand how to do simple accounting without being an accountant to keep cash flowing in the business</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn how to write a cracking proposal to get the client to say \"yes\".</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Recognise the different types of insurance that you may need to purchase to keep you and your business protected.</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Be able to put together a contract without being a lawyer.</span></div>\r\n</div>\r\n</li>\r\n</ul>', 'good', 'upload', '2025-08-08 16:46:14', 'build-a-profitable-event-planner-business', 'approved', '1', '3'),
(156, 'TH780861', 'testimg 2', '<p>testing</p>', '', 'English', 'yes', 'advanced', 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '<p>testing</p>', '<p>testing</p>', '<p>testing</p>', '8', 'paid', '1,2', '12,17', '149', '<p>test</p>', 'good', 'text', '2025-08-09 06:20:35', 'testing-2', 'approved', '1', '3'),
(157, 'TH511420', 'testing 3', '', '', 'English', 'no', 'intermediate', 'text', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '9', 'free', '4', '90', '151', '', 'pyhon,finance', '', '2025-08-09 10:30:55', 'my-testing', 'approved', '1', '3'),
(158, 'TH645727', 'tesr', '', '', 'English', 'yes', 'intermediate', 'video', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '10', 'donation', '2,4', '22', '5', '', 'test', 'text', '2025-08-09 12:50:29', 'test', 'pending', '1', '3'),
(159, 'TH892112', 'first video', '<p>test</p>', '', 'English', 'yes', 'beginner', 'video', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '12', 'free', '1,2,3', '11,12,13', '152', '<p>test</p>', 'test', '', '2025-08-09 13:32:55', 'test-1', 'pending', '0', '4');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_event_dates`
--

CREATE TABLE `ln_training_event_dates` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `event_date` varchar(45) NOT NULL,
  `start_time` varchar(45) NOT NULL,
  `end_time` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_event_dates`
--

INSERT INTO `ln_training_event_dates` (`s`, `training_id`, `event_date`, `start_time`, `end_time`) VALUES
(1, 'TH139937', '2025-08-30', '08:00', '19:50'),
(2, 'TH139937', '2025-11-01', '10:20', '20:18'),
(3, 'TH139937', '2025-08-30', '08:00', '19:50'),
(4, 'TH139937', '2025-11-01', '10:20', '20:18'),
(5, 'TH139937', '2025-08-30', '08:00', '19:50'),
(6, 'TH139937', '2025-11-01', '10:20', '20:18'),
(7, 'TH843118', '2025-06-12', '08:55', '20:55'),
(8, 'TH371730', '2025-07-30', '12:00', '16:00'),
(9, 'TH206142', '2025-07-05', '00:50', '14:52'),
(10, 'TH563330', '2025-07-12', '02:19', '14:20'),
(15, 'TH371730', '2025-07-30', '12:00', '16:00'),
(16, 'TH357692', '2025-07-25', '07:30', '18:30'),
(17, 'TH357692', '2025-07-25', '07:30', '18:30'),
(18, 'TH357692', '2025-07-25', '07:30', '18:30'),
(19, 'TH357692', '2025-07-25', '07:30', '18:30'),
(20, 'TH357692', '2025-07-25', '07:30', '18:30'),
(21, 'TH854626', '2025-08-09', '05:00', '19:54'),
(22, 'TH551998', '2025-07-18', '06:21', '16:21'),
(23, 'TH166516', '2025-07-31', '10:30', '17:30'),
(149, 'TH165122', '2025-08-28', '20:26', '20:22'),
(150, 'TH164522', '2025-08-21', '23:31', '14:27'),
(151, 'TH431436', '2025-08-21', '12:00', '14:00'),
(152, 'TH437912', '2025-08-29', '20:20', '12:25'),
(153, 'TH308284', '2025-08-29', '01:45', '10:45'),
(154, 'TH308284', '2025-08-30', '01:47', '06:46'),
(155, 'TH597136', '2025-08-31', '14:30', '16:30'),
(156, 'TH854383', '2025-08-22', '16:36', '21:36'),
(157, 'TH854383', '2025-08-29', '18:36', '21:36'),
(158, 'TH780861', '2025-08-22', '06:17', '06:18'),
(159, 'TH511420', '2025-08-16', '10:26', '10:28'),
(160, 'TH308284', '2025-09-21', '11:27', '04:22'),
(161, 'TH645727', '2025-08-30', '12:50', '16:46'),
(162, 'TH892112', '2025-08-22', '13:31', '19:28'),
(163, 'TH892112', '2025-08-23', '13:31', '17:28'),
(165, 'TH551998', '2025-08-22', '14:38', '19:34'),
(166, 'TH780861', '2025-08-23', '15:04', '15:03');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_images`
--

CREATE TABLE `ln_training_images` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `picture` varchar(450) NOT NULL,
  `updated_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_images`
--

INSERT INTO `ln_training_images` (`s`, `training_id`, `picture`, `updated_at`) VALUES
(1, 'TH139937', '686196b786c01.jpg', '2025-06-29 20:40:39'),
(2, 'TH139937', '686196cceccf0.jpg', '2025-06-29 20:41:00'),
(3, 'TH843118', '68619acb94f1b.png', '2025-06-29 20:58:03'),
(4, 'TH371730', '6861cecb0605a.jpg', '2025-06-30 00:39:55'),
(5, 'TH206142', '6861d21930cde.jpg', '2025-06-30 00:54:01'),
(6, 'TH563330', '6861e703a975e.png', '2025-06-30 02:23:15'),
(7, 'TH357692', 'default4.jpg', '2025-07-08 04:50:33'),
(8, 'TH854626', '686c9743d5265.png', '2025-07-08 04:57:55'),
(9, 'TH166516', '686fe07767a5d_adorss_678dd61b321102.18059190.mp4', '2025-07-10 16:47:03'),
(149, 'TH165122', '6894fbb7118b4_three-statement-financial-models-3-statement-financial-model-three-statement-model.jpg.jpg', '2025-08-07 20:17:11'),
(150, 'TH164522', '6893d7bc25b13_three-statement-financial-models-3-statement-financial-model-three-statement-model.jpg', '2025-08-06 23:31:24'),
(151, 'TH431436', '68948f3495f15_AI 2.jpg.jpg', '2025-08-07 12:34:12'),
(152, 'TH437912', '6895090d1c659_three-statement-financial-models-3-statement-financial-model-three-statement-model.jpg.jpg', '2025-08-07 21:14:05'),
(153, 'TH308284', 'default1.jpg', '2025-08-09 12:11:55'),
(154, 'TH597136', '6895fe4c6427d_financial-hero.jpg.jpg', '2025-08-08 14:40:28'),
(155, 'TH854383', '68961bc62a92b_financial-hero.jpg.jpg', '2025-08-08 16:46:14'),
(156, 'TH780861', '6896daa271acc_rolled-graduation-diploma-certificate.jpg.jpg', '2025-08-09 06:20:35'),
(158, 'TH308284', 'default1.jpg', '2025-08-09 12:11:55'),
(159, 'TH308284', '68972d5633e04.jpg', '2025-08-09 12:13:27'),
(160, 'TH308284', '68972d5728ef5.jpeg', '2025-08-09 12:13:27'),
(162, 'TH645727', '68973604a4363.jpg', '2025-08-09 12:50:29'),
(163, 'TH645727', '68973605a9d13.jpg', '2025-08-09 12:50:29'),
(164, 'TH892112', '68973ff61494d.jpg', '2025-08-09 13:32:55'),
(165, 'TH892112', '68973ff709ade.png', '2025-08-09 13:32:55'),
(166, 'TH551998', '68974f6374c7b.jpg', '2025-08-09 14:38:43'),
(167, 'TH551998', '68974f6374e46.webp', '2025-08-09 14:38:43'),
(168, 'TH551998', '68974f637d11d.jpeg', '2025-08-09 14:38:43'),
(169, 'TH551998', '68975001e3b01.jpg', '2025-08-09 14:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_quizzes`
--

CREATE TABLE `ln_training_quizzes` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `file_path` varchar(450) NOT NULL,
  `text_path` varchar(4500) NOT NULL,
  `instructions` varchar(4500) NOT NULL,
  `updated_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_quizzes`
--

INSERT INTO `ln_training_quizzes` (`s`, `training_id`, `type`, `file_path`, `text_path`, `instructions`, `updated_at`) VALUES
(1, 'TH139937', 'form', '', '', 'Follow this instructions carefully', '2025-06-29 20:25:17'),
(2, 'TH139937', 'form', '', '', 'Follow this instructions carefully', '2025-06-29 20:40:39'),
(3, 'TH139937', 'form', '', '', 'Follow this instructions carefully', '2025-06-29 20:41:00'),
(4, 'TH843118', 'upload', '68619acb8cbb0.docx', '', '', '2025-06-29 20:58:03'),
(5, 'TH371730', 'form', '', '', 'answer all this question', '2025-06-30 00:39:54'),
(6, 'TH563330', 'upload', '6861e703a3278.jpg', '', '', '2025-06-30 02:23:15'),
(7, 'TH357692', 'form', '', '', 'answer al', '2025-07-08 04:30:47'),
(8, 'TH357692', 'form', '', '', 'answer al', '2025-07-08 04:40:32'),
(9, 'TH357692', 'form', '', '', 'answer al', '2025-07-08 04:47:31'),
(10, 'TH357692', 'form', '', '', 'answer al', '2025-07-08 04:48:35'),
(11, 'TH357692', 'form', '', '', 'answer al', '2025-07-08 04:50:33'),
(12, 'TH854626', 'text', '', 'good', '', '2025-07-08 04:57:55'),
(13, 'TH551998', 'form', '', '', 'follow this instruction', '2025-07-10 16:31:19'),
(14, 'TH166516', 'form', '', '', 'Answer all this', '2025-07-10 16:47:03'),
(149, 'TH859236', 'text', '', '<p>The global sports industry is worth around $620 billion, and its current growth outstrips that of the GDP growth of most countries. Sports events are a major part of the industry, and as sports have grown, so too have the events. These days, events are bigger, more exciting and bring in more revenue than ever before. Fans from all over the world tune in to watch some of the biggest sports with mega events like the Olympics bringing in billions of viewers.</p>\r\n<p>These events all require dedicated teams of event managers, staff and volunteers to make sure they go to plan. With so many different moving parts, multiple teams of athletes, venues, and thousands of live spectators, a sporting event can be challenging to organise. That&rsquo;s why qualified professionals who understand the industry are so vital.</p>\r\n<p>Facility management and sports event management are more or less two sides of the same coin. Both roles are critical for the success of an event and will each have different responsibilities and duties, before, during and after the event. For an event to go to plan, all of the staff have to be aware of the aims of the event, and there needs to be a coherent plan for achieving those aims.</p>\r\n<p>This plan is formed long before the event takes place, and most of the work of the event manager goes into creating and optimising the plan. Any event will need a lot of care and attention to detail during the planning phase to ensure that the venue, hospitality, staff and risk assessment are all taken care of. Event managers have to create memorable experiences for the fans, but more importantly, they also have to ensure the safety of fans and participants.</p>', '', '2025-08-06 20:15:49'),
(150, 'TH859236', 'text', '', '<p>The global sports industry is worth around $620 billion, and its current growth outstrips that of the GDP growth of most countries. Sports events are a major part of the industry, and as sports have grown, so too have the events. These days, events are bigger, more exciting and bring in more revenue than ever before. Fans from all over the world tune in to watch some of the biggest sports with mega events like the Olympics bringing in billions of viewers.</p>\r\n<p>These events all require dedicated teams of event managers, staff and volunteers to make sure they go to plan. With so many different moving parts, multiple teams of athletes, venues, and thousands of live spectators, a sporting event can be challenging to organise. That&rsquo;s why qualified professionals who understand the industry are so vital.</p>\r\n<p>Facility management and sports event management are more or less two sides of the same coin. Both roles are critical for the success of an event and will each have different responsibilities and duties, before, during and after the event. For an event to go to plan, all of the staff have to be aware of the aims of the event, and there needs to be a coherent plan for achieving those aims.</p>\r\n<p>This plan is formed long before the event takes place, and most of the work of the event manager goes into creating and optimising the plan. Any event will need a lot of care and attention to detail during the planning phase to ensure that the venue, hospitality, staff and risk assessment are all taken care of. Event managers have to create memorable experiences for the fans, but more importantly, they also have to ensure the safety of fans and participants.</p>', '', '2025-08-06 20:17:25'),
(151, 'TH165122', 'text', '', '<p>The global sports industry is worth around $620 billion, and its current growth outstrips that of the GDP growth of most countries. Sports events are a major part of the industry, and as sports have grown, so too have the events. These days, events are bigger, more exciting and bring in more revenue than ever before. Fans from all over the world tune in to watch some of the biggest sports with mega events like the Olympics bringing in billions of viewers.</p>\r\n<p>These events all require dedicated teams of event managers, staff and volunteers to make sure they go to plan. With so many different moving parts, multiple teams of athletes, venues, and thousands of live spectators, a sporting event can be challenging to organise. That&rsquo;s why qualified professionals who understand the industry are so vital.</p>\r\n<p>Facility management and sports event management are more or less two sides of the same coin. Both roles are critical for the success of an event and will each have different responsibilities and duties, before, during and after the event. For an event to go to plan, all of the staff have to be aware of the aims of the event, and there needs to be a coherent plan for achieving those aims.</p>\r\n<p>This plan is formed long before the event takes place, and most of the work of the event manager goes into creating and optimising the plan. Any event will need a lot of care and attention to detail during the planning phase to ensure that the venue, hospitality, staff and risk assessment are all taken care of. Event managers have to create memorable experiences for the fans, but more importantly, they also have to ensure the safety of fans and participants.</p>', '', '2025-08-06 20:28:11'),
(152, 'TH164522', 'upload', '6893d7bb78f64.pdf', '', '', '2025-08-06 23:31:24'),
(153, 'TH437912', 'form', '', '', '<h2>100+ general knowledge questions and answers</h2>', '2025-08-07 21:14:04'),
(154, 'TH308284', 'form', '', '', '<h2>100+ general knowledge questions and answers</h2>', '2025-08-08 01:56:27'),
(155, 'TH597136', 'text', '', '<ul class=\"ud-unstyled-list ud-block-list what-you-will-learn--objectives-list--qsvE2 what-you-will-learn--objectives-list-two-column-layout--ED4as\">\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn complete Event management procedures and concept with its importance</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn how to Plan, Organize, Staff Management, and Conceptualize an event</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn Advertising of an event, Public relations process and Events team management skills</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn Evaluating event concept, Event feasibility, legal compliance, Risk feasibility, SWOT</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn Marketing and promotion, Event planning and promotion, Event planning training, Promotion and Advertising</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn Financial management, Event budget, Financial analysis, Financing the event, Break even analysis and Cash flow for an event</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn Risk management, Risk associated with event, Planning for events, Steps to plan and Tools for planning</span></div>\r\n</div>\r\n</li>\r\n<li>\r\n<div class=\"ud-block-list-item ud-block-list-item-small ud-block-list-item-tight ud-block-list-item-neutral ud-text-sm\" data-purpose=\"objective\">\r\n<div class=\"ud-block-list-item-content\"><span class=\"what-you-will-learn--objective-item--VZFww\">Learn Invitations, Online marketing,</span></div>\r\n</div>\r\n</li>\r\n</ul>', '', '2025-08-08 14:40:28'),
(156, 'TH854383', 'upload', '68961bc55e6bd.pdf', '', '', '2025-08-08 16:46:14'),
(157, 'TH780861', 'text', '', '<p>testing</p>', '', '2025-08-09 06:20:34'),
(158, 'TH645727', 'text', '', '<p>test</p>', '', '2025-08-09 12:50:28');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_quiz_questions`
--

CREATE TABLE `ln_training_quiz_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `quiz_id` varchar(45) NOT NULL,
  `question` varchar(4500) NOT NULL,
  `option_a` varchar(450) NOT NULL,
  `option_b` varchar(450) NOT NULL,
  `option_c` varchar(450) NOT NULL,
  `option_d` varchar(450) NOT NULL,
  `correct_answer` varchar(450) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_quiz_questions`
--

INSERT INTO `ln_training_quiz_questions` (`id`, `quiz_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, '1', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'b'),
(2, '1', 'whats your author', 'yes', 'no', 'nice', 'wow', 'd'),
(3, '2', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'b'),
(4, '2', 'whats your author', 'yes', 'no', 'nice', 'wow', 'd'),
(5, '3', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'b'),
(6, '3', 'whats your author', 'yes', 'no', 'nice', 'wow', 'd'),
(7, '5', 'The Fundamentals of Caregiving', 'yes', 'no', 'no', 'wow', 'c'),
(8, '7', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(9, '7', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(10, '8', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(11, '8', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(12, '9', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(13, '9', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(14, '10', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(15, '10', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(16, '11', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(17, '11', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'a'),
(18, '13', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'b'),
(19, '13', 'whats medicine', 'yes', 'no', 'nice', 'wow', 'c'),
(20, '14', 'The Fundamentals of Caregiving', 'yes', 'no', 'nice', 'wow', 'b'),
(149, '153', '<p>In what year did the Great October Socialist Revolution take place?</p>', '1917', '1967', '1918', '1923', 'a'),
(150, '153', '', 'Lake Superior', 'Baikal', 'Caspian Sea', 'Ontario', 'b'),
(151, '153', '<p>What is the largest lake in the world?</p>', '', '', '', '', ''),
(152, '154', '<p>Which planet in the solar system is known as the &ldquo;Red Planet&rdquo;?</p>', 'Earth', 'Jupiter', 'Venus', 'Mars', 'd'),
(153, '154', '', 'Beijing', 'Beijing', 'Tokyo', 'Seoul', 'c'),
(154, '154', '<p>What is the capital of Japan?</p>', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_texts_modules`
--

CREATE TABLE `ln_training_texts_modules` (
  `id` int(11) NOT NULL,
  `training_id` varchar(50) DEFAULT NULL,
  `module_number` varchar(40) DEFAULT NULL,
  `title` varchar(1155) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reading_time` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ln_training_texts_modules`
--

INSERT INTO `ln_training_texts_modules` (`id`, `training_id`, `module_number`, `title`, `description`, `reading_time`, `file_path`, `created_at`, `updated_at`) VALUES
(5, 'TH511420', '3', 'testing 3', '<p>testing</p>', '100', '../../documents/689717396effe.pdf', '2025-08-09 10:30:54', '2025-08-09 12:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_text_modules`
--

CREATE TABLE `ln_training_text_modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `file_path` varchar(450) NOT NULL,
  `updated_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_text_modules`
--

INSERT INTO `ln_training_text_modules` (`id`, `training_id`, `file_path`, `updated_at`) VALUES
(1, 'TH139937', '686192d36eea9.docx', '2025-06-29 20:24:03'),
(2, 'TH139937', '6861931d3f945.docx', '2025-06-29 20:25:17'),
(3, 'TH139937', '686196b76fcea.docx', '2025-06-29 20:40:39'),
(4, 'TH139937', '686196ccd8cff.docx', '2025-06-29 20:41:00'),
(5, 'TH843118', '68619acb8aee3.pdf', '2025-06-29 20:58:03'),
(6, 'TH371730', '6861cecaf0fe1.docx', '2025-06-30 00:39:54'),
(7, 'TH563330', '6861e703a15f0.docx', '2025-06-30 02:23:15'),
(8, 'TH357692', '686c90e723ab4.pdf', '2025-07-08 04:30:47'),
(9, 'TH357692', '686c93304de47.pdf', '2025-07-08 04:40:32'),
(10, 'TH357692', '686c94d318667.pdf', '2025-07-08 04:47:31'),
(11, 'TH357692', '686c95132f597.pdf', '2025-07-08 04:48:35'),
(12, 'TH357692', '686c958975325.pdf', '2025-07-08 04:50:33'),
(13, 'TH854626', '686c9743cb37d.docx', '2025-07-08 04:57:55'),
(14, 'TH551998', '686fdcc79a2cf.pdf', '2025-07-10 16:31:19'),
(15, 'TH166516', '686fe07763243.pdf', '2025-07-10 16:47:03'),
(149, 'TH437912', '6895090c4346e.txt', '2025-08-07 21:14:04'),
(150, 'TH308284', '68954b3a56fee.pdf', '2025-08-08 01:56:27'),
(151, 'TH597136', '6895fe4c60d39.docx', '2025-08-08 14:40:28'),
(152, 'TH854383', '68961bc55d16d.txt', '2025-08-08 16:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_tickets`
--

CREATE TABLE `ln_training_tickets` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `ticket_name` varchar(450) NOT NULL,
  `benefits` varchar(4500) NOT NULL,
  `price` varchar(45) NOT NULL,
  `seats` varchar(45) NOT NULL,
  `seatremain` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_tickets`
--

INSERT INTO `ln_training_tickets` (`s`, `training_id`, `ticket_name`, `benefits`, `price`, `seats`, `seatremain`) VALUES
(1, 'TH139937', 'Standard Ticket', 'food and drinks with handout', '50000', '50', ''),
(2, 'TH139937', 'Standard Ticket', 'food and drinks with handout', '50000', '50', ''),
(3, 'TH139937', 'Standard Ticket', 'food and drinks with handout', '50000', '50', ''),
(4, 'TH843118', 'vip', 'food and drinks with handout', '10000', '60', ''),
(5, 'TH371730', 'Standard Ticket', 'food and drinks with handout', '10000', '90', ''),
(6, 'TH854626', 'Standard Ticket', 'food and drinks with handout', '10000', '600', ''),
(7, 'TH551998', 'Standard Ticket', 'food and drinks with handout', '10000', '70', '70'),
(149, 'TH859236', 'Vip', 'free books', '5000', '40', '40'),
(150, 'TH859236', 'standard', 'free food, book, private tutoring', '4000', '50', '50'),
(151, 'TH165122', 'standard', 'free books', '200', '40', '40'),
(152, 'TH165122', 'Vip', 'free books', '500000', '50', '50'),
(153, 'TH431436', 'General Ticket', 'Certicate', '50000', '100', '100'),
(154, 'TH165122', 'vip2', 'food and drinks with handout', '7000', '20', '20'),
(155, 'TH437912', 'standard', 'food and drinks with handout', '8000', '70', '70'),
(156, 'TH308284', 'standard', 'food and drinks with handout', '5000', '40', '40'),
(157, 'TH308284', 'vip', 'food and drinks with handout', '6000', '40', '40'),
(158, 'TH597136', 'standard', 'food and drinks with handout', '6000', '70', '70'),
(159, 'TH854383', 'vip', 'food and drinks with handout', '80', '100', '100'),
(160, 'TH854383', 'standard', 'free books', '70', '80', '80'),
(161, 'TH780861', 'vip', '<p>food</p>', '7000', '40', '40');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_videos`
--

CREATE TABLE `ln_training_videos` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `video_type` varchar(45) NOT NULL,
  `video_path` varchar(450) NOT NULL,
  `updated_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_videos`
--

INSERT INTO `ln_training_videos` (`s`, `training_id`, `video_type`, `video_path`, `updated_at`) VALUES
(1, 'TH139937', 'promo', '686191e64658a_adorss_14961782.mov.mov', '2025-06-29 20:20:06'),
(2, 'TH139937', 'trailer', '686191e6489a0_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-29 20:20:06'),
(3, 'TH139937', 'promo', '686192d369a6f_adorss_14961782.mov.mov', '2025-06-29 20:24:03'),
(4, 'TH139937', 'trailer', '686192d36b586_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-29 20:24:03'),
(5, 'TH139937', 'promo', '6861931d332fa_adorss_14961782.mov.mov', '2025-06-29 20:25:17'),
(6, 'TH139937', 'trailer', '6861931d377d6_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-29 20:25:17'),
(7, 'TH139937', 'promo', '686196b763ad1_adorss_14961782.mov.mov', '2025-06-29 20:40:39'),
(8, 'TH139937', 'trailer', '686196b7669ed_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-29 20:40:39'),
(9, 'TH139937', 'promo', '686196ccd3721_adorss_14961782.mov.mov', '2025-06-29 20:41:00'),
(10, 'TH139937', 'trailer', '686196ccd5b43_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-29 20:41:00'),
(11, 'TH843118', 'promo', '68619acb7d0f1_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-29 20:58:03'),
(12, 'TH843118', 'trailer', '68619acb7f3b4_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-29 20:58:03'),
(13, 'TH371730', 'promo', '6861cecaebe46_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-30 00:39:54'),
(14, 'TH371730', 'trailer', '6861cecaed8d0_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-30 00:39:54'),
(15, 'TH563330', 'promo', '6861e70398d60_adorss_14961782.mov.mov', '2025-06-30 02:23:15'),
(16, 'TH563330', 'trailer', '6861e7039c9b6_adorss_678dd61b321102.18059190.mp4.mp4', '2025-06-30 02:23:15'),
(17, 'TH357692', 'promo', '686c90e71ea23_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-08 04:30:47'),
(18, 'TH357692', 'promo', '686c93304a97a_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-08 04:40:32'),
(19, 'TH357692', 'promo', '686c94d3120cb_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-08 04:47:31'),
(20, 'TH357692', 'promo', '686c95132b81b_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-08 04:48:35'),
(21, 'TH357692', 'promo', '686c95897109f_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-08 04:50:33'),
(22, 'TH854626', 'promo', '686c9743bc072_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-08 04:57:55'),
(23, 'TH854626', 'trailer', '686c9743c6097_adorss_14961782.mov.mov', '2025-07-08 04:57:55'),
(24, 'TH551998', 'promo', '686fdcc7956ad_adorss_14961782.mov.mov', '2025-07-10 16:31:19'),
(26, 'TH166516', 'promo', '686fe0775f268_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-10 16:47:03'),
(27, 'TH166516', 'trailer', '686fe07760725_adorss_678dd61b321102.18059190.mp4.mp4', '2025-07-10 16:47:03'),
(149, 'TH676468', 'trailer', '6893a74c6b3d1_adorss_678dd61b321102.18059190.mp4', '2025-08-06 20:04:44'),
(150, 'TH859236', 'promo', '6893a9e534372_adorss_678dd61b321102.18059190.mp4', '2025-08-06 20:15:49'),
(151, 'TH859236', 'promo', '6893aa454a78c_adorss_678dd61b321102.18059190.mp4', '2025-08-06 20:17:25'),
(152, 'TH165122', 'promo', '6894fbb717e70_adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-07 20:17:11'),
(153, 'TH165122', 'trailer', '6894fbb787c36_adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-07 20:17:12'),
(154, 'TH437912', 'trailer', '6895090b5de58_adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-07 21:14:03'),
(155, 'TH308284', 'promo', '68954b38c92ed_adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-08 01:56:25'),
(156, 'TH308284', 'trailer', '68954b395f0b3_adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-08 01:56:25'),
(157, 'TH597136', 'promo', '6895fe4aee69c_adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-08 14:40:27'),
(158, 'TH597136', 'trailer', '6895fe4b68870_adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-08 14:40:27'),
(159, 'TH854383', 'promo', 'adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-08 16:46:12'),
(160, 'TH854383', 'trailer', 'adorss_678dd61b321102.18059190.mp4.mp4', '2025-08-08 16:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_video_lessons`
--

CREATE TABLE `ln_training_video_lessons` (
  `s` int(10) UNSIGNED NOT NULL,
  `training_id` varchar(45) NOT NULL,
  `file_path` varchar(450) NOT NULL,
  `video_url` varchar(450) NOT NULL,
  `updated_at` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_training_video_lessons`
--

INSERT INTO `ln_training_video_lessons` (`s`, `training_id`, `file_path`, `video_url`, `updated_at`) VALUES
(1, 'TH139937', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-29 20:20:06'),
(2, 'TH139937', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-29 20:24:03'),
(3, 'TH139937', '686192d36d7ca.mp4', '', '2025-06-29 20:24:03'),
(4, 'TH139937', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-29 20:25:17'),
(5, 'TH139937', '6861931d3a907.mp4', '', '2025-06-29 20:25:17'),
(6, 'TH139937', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-29 20:40:39'),
(7, 'TH139937', '686196b76b1ef.mp4', '', '2025-06-29 20:40:39'),
(8, 'TH139937', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-29 20:41:00'),
(9, 'TH139937', '686196ccd7555.mp4', '', '2025-06-29 20:41:00'),
(10, 'TH843118', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-29 20:58:03'),
(11, 'TH843118', '68619acb850ae.mov', '', '2025-06-29 20:58:03'),
(12, 'TH371730', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-30 00:39:54'),
(13, 'TH371730', '6861cecaef7fe.mp4', '', '2025-06-30 00:39:54'),
(14, 'TH206142', '6861d2192ccdb.mp4', '', '2025-06-30 00:54:01'),
(15, 'TH563330', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-06-30 02:23:15'),
(16, 'TH563330', '6861e7039e61b.mp4', '', '2025-06-30 02:23:15'),
(17, 'TH357692', '686c90e721312.mp4', '', '2025-07-08 04:30:47'),
(18, 'TH357692', '686c93304c42f.mp4', '', '2025-07-08 04:40:32'),
(19, 'TH357692', '686c94d315201.mp4', '', '2025-07-08 04:47:31'),
(20, 'TH357692', '686c95132d734.mp4', '', '2025-07-08 04:48:35'),
(21, 'TH357692', '686c958972ebb.mp4', '', '2025-07-08 04:50:33'),
(22, 'TH854626', '686c9743c86b2.mov', '', '2025-07-08 04:57:55'),
(23, 'TH551998', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-08-09 14:43:56'),
(24, 'TH551998', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-08-09 14:43:56'),
(25, 'TH166516', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-07-10 16:47:03'),
(26, 'TH166516', '686fe07761da9.mp4', '', '2025-07-10 16:47:03'),
(149, 'TH859236', 'default1.jpg', '', '2025-08-06 20:15:49'),
(150, 'TH859236', 'default3.jpg', '', '2025-08-06 20:17:25'),
(151, 'TH165122', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-08-07 20:17:11'),
(152, 'TH165122', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-08-07 20:17:11'),
(153, 'TH164522', 'default5.jpg', '', '2025-08-06 23:31:23'),
(154, 'TH431436', 'default3.jpg', '', '2025-08-07 12:34:12'),
(155, 'TH165122', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-08-07 20:17:11'),
(156, 'TH165122', 'default1.jpg', '', '2025-08-07 20:17:11'),
(157, 'TH437912', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-07 21:14:03'),
(158, 'TH437912', '6895090bca18a.mp4', '', '2025-08-07 21:14:04'),
(159, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(160, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(161, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(162, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(163, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(164, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(165, 'TH597136', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-08 14:40:26'),
(166, 'TH597136', '6895fe4be582d.mp4', '', '2025-08-08 14:40:28'),
(167, 'TH854383', '68961bc4e39e5.mp4', '', '2025-08-08 16:46:13'),
(168, 'TH780861', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 15:03:50'),
(169, 'TH780861', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 15:03:50'),
(170, 'TH511420', 'default2.jpg', '', '2025-08-09 10:30:52'),
(171, 'TH511420', 'default5.jpg', '', '2025-08-09 10:39:05'),
(172, 'TH511420', 'default1.jpg', '', '2025-08-09 11:08:33'),
(173, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(174, 'TH308284', '', 'https://youtu.be/4xxvwsFi_is?si=iTBJ4vJv2NrFzBd2', '2025-08-09 12:13:27'),
(175, 'TH308284', 'default4.jpg', '', '2025-08-09 12:13:27'),
(176, 'TH511420', 'default3.jpg', '', '2025-08-09 12:20:26'),
(177, 'TH645727', 'default1.jpg', '', '2025-08-09 12:50:28'),
(179, 'TH551998', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-08-09 14:43:56'),
(180, 'TH551998', '', 'https://loadedfiles.org/48f966e94c1e8ef2', '2025-08-09 14:43:56'),
(181, 'TH551998', 'default5.jpg', '', '2025-08-09 14:43:56'),
(182, 'TH780861', 'default4.jpg', '', '2025-08-09 15:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `ln_training_video_modules`
--

CREATE TABLE `ln_training_video_modules` (
  `id` int(11) NOT NULL,
  `training_id` varchar(50) DEFAULT NULL,
  `module_number` varchar(10) DEFAULT NULL,
  `title` varchar(2550) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `video_link` varchar(1155) DEFAULT NULL,
  `video_quality` text DEFAULT NULL,
  `subtitles` enum('Yes','No') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ln_training_video_modules`
--

INSERT INTO `ln_training_video_modules` (`id`, `training_id`, `module_number`, `title`, `description`, `duration`, `file_path`, `video_link`, `video_quality`, `subtitles`, `created_at`, `updated_at`) VALUES
(1, 'TH645727', '1', 'tesr', '', '', '689736043832e.mp4', '', '720p', 'Yes', '2025-08-09 12:50:28', '2025-08-09 12:50:28'),
(2, 'TH892112', '1', 'first video', '<p>test</p>', '', '', 'https://www.instagram.com/wumitoriola/reel/DMsrnPxOE6f/', '1080p', 'Yes', '2025-08-09 13:32:54', '2025-08-09 13:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `ln_users`
--

CREATE TABLE `ln_users` (
  `s` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `middle_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_profile` text NOT NULL,
  `company_logo` varchar(255) NOT NULL,
  `biography` text NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(45) NOT NULL,
  `skills_hobbies` text NOT NULL,
  `language` varchar(150) NOT NULL,
  `proficiency` varchar(45) NOT NULL,
  `n_office_address` varchar(500) NOT NULL,
  `f_office_address` varchar(500) NOT NULL,
  `category` varchar(150) NOT NULL,
  `subcategory` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `state` varchar(150) NOT NULL,
  `lga` varchar(150) NOT NULL,
  `country` varchar(150) NOT NULL,
  `address` varchar(450) NOT NULL,
  `type` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `trainer` varchar(45) NOT NULL,
  `password` varchar(4500) NOT NULL,
  `last_login` varchar(45) NOT NULL,
  `created_date` varchar(450) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `affliate` varchar(45) NOT NULL,
  `loyalty` varchar(45) NOT NULL,
  `downloads` varchar(45) NOT NULL,
  `wallet` varchar(4500) NOT NULL,
  `bank_name` varchar(450) NOT NULL,
  `bank_accname` varchar(100) NOT NULL,
  `bank_number` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ln_users`
--

INSERT INTO `ln_users` (`s`, `title`, `display_name`, `first_name`, `middle_name`, `last_name`, `company_name`, `company_profile`, `company_logo`, `biography`, `profile_photo`, `age`, `gender`, `email_address`, `phone_number`, `skills_hobbies`, `language`, `proficiency`, `n_office_address`, `f_office_address`, `category`, `subcategory`, `facebook`, `instagram`, `twitter`, `linkedin`, `state`, `lga`, `country`, `address`, `type`, `status`, `trainer`, `password`, `last_login`, `created_date`, `reset_token`, `reset_token_expiry`, `affliate`, `loyalty`, `downloads`, `wallet`, `bank_name`, `bank_accname`, `bank_number`) VALUES
(2, 'Mr', 'Akande bade', 'Akande', 'james', 'bade', 'SCAMDAMP LIMITED', 'reviewing company', 'SCAMDAMP.jpg', 'good man', 'financial-modeling-icon-business-260nw-2212452673.webp', 45, 'Male', 'akanni@gmail.com', '(090) 815-5145', 'reading, writting', 'English', 'Conversational', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', '38, Opeyemistreet wema, iwo road, Ibadan.\r\nOpeyemistreet wema,  iwo road, Ibadan.', '7', '123', '', '', '', '', 'Oyo', 'Egbeda', 'Nigeria', '', '', 'suspended', '1', '$2y$10$hofxCh0hO8xcFSOBIx9IvOQ.uvSeENF939nF7iF4PZU4a4yQoC1eG', '2025-06-27 16:49:05', '2025-06-27 16:49:05', '', '0000-00-00 00:00:00', '', '', '', '', '', '', ''),
(3, 'Learnora', 'Learnora', 'Learnora', '', '', '', '', '', '', '6870d7f6284cc.png', 0, '', 'hello@learnora.ng', '+234 -1- 29 52 413', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'admin', 'active', '', '$2y$10$hofxCh0hO8xcFSOBIx9IvOQ.uvSeENF939nF7iF4PZU4a4yQoC1eG', '2025-08-09 06:15:32', '', NULL, NULL, '', '', '', '0', '', '', ''),
(4, 'mr', 'Ibrahim Fopefoluwa Favour', 'Ibrahim Fopefoluwa', 'james', 'Favour', 'Fopefoluwa', 'best company', 'alison_courseware_intro_6361.jpg.jpg', 'am good', 'royalwunderkindcount.png.png', 54, 'Male', 'fopsycute18@gmail.com', '(081) 227-9350', 'writting, reading', 'English', 'Basic', '38, Opeyemistreet wema, iwo road, Ibadan.\r\nOpeyemistreet wema,  iwo road, Ibadan.', '8, Ajasa street, Off Seriki Aro Street, Afriogun,', '8', '134', '', '', '', '', 'Oyo', 'Egbeda', 'Nigeria', '', 'user', 'active', '1', '$2y$10$qs3XcbxL6HdVHEZd5l2l3O.XgsuSiyebViaB7PgWFjidVS7J70nQW', '2025-08-09 14:35:31', '2025-07-02 16:41:27', '', '0000-00-00 00:00:00', '', '21', '31', '35000', '', '', ''),
(5, '', 'oladunni bade', 'oladunni', 'james', 'bade', '', '', '', '', '686b83186a337.png', 0, 'Male', 'oladunni@gmail.com', '09081551454', '', '', '', '38, Opeyemistreet wema, iwo road, Ibadan.', '', '', '- Select Subcategory -', '', '', '', '', '', '', '', '', 'affiliate', 'active', '0', '$2y$10$C9jnJ.8cMCc39KhOmsVsfezcur1wJ2.A2WjadwWGlZLtiS/acV3eG', '2025-07-07 07:22:15', '2025-07-03 03:18:18', '', '0000-00-00 00:00:00', 'AFF-60EFDF26181C', '', '', '34600.00', 'Opay', 'Ibrahim Fopefoluwa Favour', '8122793508'),
(6, 'Mr', 'Olayemi Foluwa', 'Olayemi', 'Bonola', 'Foluwa', '', '', '', '', 'class.png', 0, '', 'bobofolu@gmail.com', '(123) 456-7890', '', '', '', '', '', '', '', '', '', '', '', 'Oyo', 'Egbeda', 'Nigeria', '', 'user', '', '', '$2y$10$4iyPgQtnEuyE/yPCeDxMN.n7vMxpaZiP.Awrnc7VnErijPJdVKGke', '2025-07-10 09:42:46', '2025-07-10 09:42:46', '', '0000-00-00 00:00:00', '', '', '', '', '', '', ''),
(7, 'Yemiola', 'Boola bade', 'Boola', 'james', 'bade', '', '', '', '', 'graduation.png', 0, '', 'bola@gmail.com', '(090) 815-5145', '', '', '', '', '', '', '', '', '', '', '', 'Oyo', 'Egbeda', 'Nigeria', '', 'user', 'active', '', '$2y$10$lofC82DPF5droH6vrftpP.OAvxOtA3DKAWcIZYzknYIMJo.3pTHay', '2025-07-11 17:02:01', '2025-07-10 09:54:43', '', '0000-00-00 00:00:00', '', '', '', '', '', '', ''),
(149, 'Mr', 'Ojo-Olayinka Kanyinsola', 'Ojo-Olayinka', 'Kanyinsola', 'Kanyinsola', 'Kayd', 'Good good', 'IMG_2224.jpeg', 'Good person ', 'IMG_0855.jpeg', 20, 'Female', 'kanyin500@gmail.com', '(070) 199-6027', 'Global, football ', 'English, French ', 'Conversational', 'No 3,Olalere street,New airport, alakia ibadan.', '', '2', '32', 'https://facebook.com', 'https://facebook.com/', 'https://facebook.com/', 'https://facebook.com/', 'Oyo', 'Kayd', 'Nigeria', '', 'user', 'inactive', '1', '$2y$10$P4z7lVFXRN1pU1SMNleZCO7Iu710hgkYb7l3U98C.8G9v4rC27dsi', '2025-07-11 21:20:05', '2025-07-11 21:20:05', '', '0000-00-00 00:00:00', '', '', '', '', '', '', ''),
(151, 'Mr', 'Ikechukwu Nnamdi', 'Ikechukwu', 'Everistus', 'Nnamdi', '', '', '', '', 'bread 3.jpeg', 0, 'Male', 'ikedike2002@yahoo.com', '(080) 337-8277', '', '', '', '', '', '', '- Select Subcategory -', 'https://www.projectreporthub.ng/', 'https://www.projectreporthub.ng/', 'https://www.projectreporthub.ng/', '', 'Lagos', 'Ejigbo', 'Nigeria', '', 'user', 'active', '', '$2y$10$cfU.Db1cGhuivvFSVn.YMelQxvYOhlFLmb0inDJaJVo5Oof5MvdI.', '2025-08-07 09:25:40', '2025-07-24 08:20:33', '', '0000-00-00 00:00:00', '', '', '', '', '', '', ''),
(152, 'Mr', 'Ike Ike', 'Ike', 'Everistus Nnamdi', 'Ike', 'Foraminifera Ventures', 'testing', '1000x500- foraminifera logo.png.png', 'test', 'Cement Manufacturing Financial Model 2.JPG', 90, 'Male', 'six33fourng@gmail.com', '(080) 337-8277', 'test', '', '', '10 Wale Ariwo-Ola St, Graceland Estate, Bucknor, Ejigbo, Lagos 102214, Lagos, Nigeria', '10 Wale Ariwo-Ola St, Graceland Estate, Bucknor, Ejigbo, Lagos 102214, Lagos, Nigeria', '3', '77', 'https://www.projectreporthub.ng/', 'https://www.projectreporthub.ng/', 'https://www.projectreporthub.ng/', '', 'Lagos', 'Ejigbo', 'Nigeria', '', 'user', 'active', '1', '$2y$10$K9SZh2uTeWaDMkjmaaETKeuqeev9u7EuvzAy1O73Y0mEnn8IPKQMa', '2025-08-05 00:38:09', '2025-07-24 08:29:05', '', '0000-00-00 00:00:00', '', '21', '38', '', 'gt bank', 'Ike Everistus Nnamdi Ike', '1234567890'),
(153, 'Mr', 'Everistus Anaekwe', 'Everistus', 'Nnamdi', 'Anaekwe', '', '', '', '<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa, scientifically known as Theobroma cacao, holds a significant place in Nigeria\'s agricultural heritage. The cultivation of cocoa in Nigeria dates back to the late 19th century when it was introduced by colonial settlers. Over time, cocoa emerged as a major cash crop, driving economic growth and shaping the socio-economic fabric of regions where it is cultivated.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Cocoa production in Nigeria is concentrated primarily in the southern regions of the country, including Ondo, Osun, Ogun, Ekiti, and Cross River states. These regions offer suitable climatic conditions, including ample rainfall and well-drained soils, conducive to cocoa cultivation.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">Nigeria ranks among the top cocoa-producing countries globally, consistently contributing a significant share to the world\'s cocoa output. Despite facing challenges such as aging cocoa trees and declining productivity in recent years, Nigeria remains a formidable player in the global cocoa market.</span></p>\r\n<p class=\"MsoNormal\" style=\"mso-layout-grid-align: none; text-autospace: none;\"><span style=\"font-size: 12.0pt; line-height: 115%; font-family: \'Georgia\',serif; mso-bidi-font-family: Garamond;\">The cocoa industry in Nigeria operates within a global market influenced by factors such as international demand, pricing trends, and trade regulations. Nigerian cocoa finds its way into various end products, including chocolate, beverages, and confectionery, catering to both domestic and international markets.</span></p>', '68948a4003e79_1000x500- foraminifera logo.png.png', 0, 'Male', 'foraminiferaltd@gmail.com', '(080) 337-8277', '', '', '', '', '', '', '', 'https://web.facebook.com/people/Foraminifera-Market-Research/100057654391387/#', 'https://web.facebook.com/people/Foraminifera-Market-Research/100057654391387/#', 'https://web.facebook.com/people/Foraminifera-Market-Research/100057654391387/#', '', 'Lagos', 'Oshodi-Isolo', 'Nigeria', '61-65 Egbe- Isolo Road, Iyana Ejigbo Shopping Arcade, Block A, Suite 19, Iyana Ejigbo Bus Stop, Ejigbo, Lagos.', 'user', 'active', '', '$2y$10$xwGOCqgOh.jRbEAHxtdTp.zKkx4Wfc94aVohiS6cuoh.rzc9F0Fl2', '2025-08-07 12:17:18', '2025-08-07 12:13:04', '', '0000-00-00 00:00:00', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ln_wallet_history`
--

CREATE TABLE `ln_wallet_history` (
  `s` int(11) NOT NULL,
  `user` varchar(500) NOT NULL,
  `amount` int(11) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `status` varchar(600) NOT NULL,
  `date` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_wallet_history`
--

INSERT INTO `ln_wallet_history` (`s`, `user`, `amount`, `reason`, `status`, `date`) VALUES
(30, '3', 0, 'Payment from Order ID: ORD6867fb23a5cfc', 'credit', '2025-07-05 04:18:31'),
(31, '3', 0, 'Payment from Order ID: ORD6867fb23a5cfc', 'credit', '2025-07-05 04:18:31'),
(32, '5', 800, 'Affiliate Earnings from Order ID: ORD68689a0358514', 'credit', '2025-07-05 16:36:50'),
(33, '5', 800, 'Affiliate Earnings from Order ID: ORD68689a0358514', 'credit', '2025-07-05 16:36:50'),
(34, '3', 0, 'Payment from Order ID: ORD68689a0358514', 'credit', '2025-07-05 16:36:50'),
(35, '5', 50000, 'Affiliate Earnings from Order ID: ORDER_987445097', 'credit', '2025-07-06 04:28:09'),
(36, '3', 0, 'Payment from Order ID: ORDER_987445097', 'credit', '2025-07-06 04:28:09'),
(37, '3', 0, 'Payment from Order ID: ORD6867e0a9b70d9', 'credit', '2025-07-04 16:07:18'),
(38, '3', 0, 'Payment from Order ID: ORD6869d955d938b', 'credit', '2025-07-08 05:24:58'),
(39, '3', 0, 'Payment from Order ID: ORD6869d955d938b', 'credit', '2025-07-08 05:22:23'),
(40, '4', 35000, 'Payment from Order ID: ORDER_899083781', 'credit', '2025-07-10 18:17:17'),
(41, '3', 0, 'Payment from Order ID: ORD6881e189a5726', 'credit', '2025-07-24 08:36:25'),
(42, '3', 0, 'Payment from Order ID: ORD6881e300611af', 'credit', '2025-07-25 11:30:07'),
(43, '3', 0, 'Payment from Order ID: ORD688ea96b6abb3', 'credit', '2025-08-03 01:12:39'),
(44, '3', 0, 'Payment from Order ID: ORD688ea9ad01b05', 'credit', '2025-08-03 04:17:57'),
(45, '3', 0, 'Payment from Order ID: ORDER_568377597', 'credit', '2025-08-07 07:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `ln_wishlist`
--

CREATE TABLE `ln_wishlist` (
  `s` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `product` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_wishlist`
--

INSERT INTO `ln_wishlist` (`s`, `user`, `product`, `date`) VALUES
(99, 4, 'TH206142', '2025-07-06 09:20:28'),
(101, 4, 'TH854626', '2025-07-08 05:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `ln_withdrawal`
--

CREATE TABLE `ln_withdrawal` (
  `s` int(11) NOT NULL,
  `user` varchar(500) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `bank` varchar(2000) NOT NULL,
  `bank_name` varchar(2000) NOT NULL,
  `bank_number` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ln_withdrawal`
--

INSERT INTO `ln_withdrawal` (`s`, `user`, `amount`, `date`, `status`, `bank`, `bank_name`, `bank_number`) VALUES
(2, '5', 7000, '2025-07-07 09:41:55', 'paid', 'Opay', 'Ibrahim Fopefoluwa Favour', '8122793508');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ln_affiliate_products`
--
ALTER TABLE `ln_affiliate_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_affliate_purchases`
--
ALTER TABLE `ln_affliate_purchases`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_aff_alerts`
--
ALTER TABLE `ln_aff_alerts`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_alerts`
--
ALTER TABLE `ln_alerts`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_blog_likes`
--
ALTER TABLE `ln_blog_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_categories`
--
ALTER TABLE `ln_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_comments`
--
ALTER TABLE `ln_comments`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_contact_messages`
--
ALTER TABLE `ln_contact_messages`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_country`
--
ALTER TABLE `ln_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_disputes`
--
ALTER TABLE `ln_disputes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_dispute_messages`
--
ALTER TABLE `ln_dispute_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_event_types`
--
ALTER TABLE `ln_event_types`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_evidence`
--
ALTER TABLE `ln_evidence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_followers`
--
ALTER TABLE `ln_followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_forum_posts`
--
ALTER TABLE `ln_forum_posts`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_inhouse_proposals`
--
ALTER TABLE `ln_inhouse_proposals`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_instructors`
--
ALTER TABLE `ln_instructors`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_loyalty_purchases`
--
ALTER TABLE `ln_loyalty_purchases`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_manual_payments`
--
ALTER TABLE `ln_manual_payments`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_notifications`
--
ALTER TABLE `ln_notifications`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_orders`
--
ALTER TABLE `ln_orders`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_order_items`
--
ALTER TABLE `ln_order_items`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_product_reports`
--
ALTER TABLE `ln_product_reports`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_profits`
--
ALTER TABLE `ln_profits`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_quiz_answers`
--
ALTER TABLE `ln_quiz_answers`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_reviews`
--
ALTER TABLE `ln_reviews`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_site_settings`
--
ALTER TABLE `ln_site_settings`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_subscription_plans`
--
ALTER TABLE `ln_subscription_plans`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_suspend`
--
ALTER TABLE `ln_suspend`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training`
--
ALTER TABLE `ln_training`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training_event_dates`
--
ALTER TABLE `ln_training_event_dates`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training_images`
--
ALTER TABLE `ln_training_images`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training_quizzes`
--
ALTER TABLE `ln_training_quizzes`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training_quiz_questions`
--
ALTER TABLE `ln_training_quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_training_texts_modules`
--
ALTER TABLE `ln_training_texts_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_training_text_modules`
--
ALTER TABLE `ln_training_text_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_training_tickets`
--
ALTER TABLE `ln_training_tickets`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training_videos`
--
ALTER TABLE `ln_training_videos`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training_video_lessons`
--
ALTER TABLE `ln_training_video_lessons`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_training_video_modules`
--
ALTER TABLE `ln_training_video_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ln_users`
--
ALTER TABLE `ln_users`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_wallet_history`
--
ALTER TABLE `ln_wallet_history`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_wishlist`
--
ALTER TABLE `ln_wishlist`
  ADD PRIMARY KEY (`s`);

--
-- Indexes for table `ln_withdrawal`
--
ALTER TABLE `ln_withdrawal`
  ADD PRIMARY KEY (`s`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ln_affiliate_products`
--
ALTER TABLE `ln_affiliate_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ln_affliate_purchases`
--
ALTER TABLE `ln_affliate_purchases`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ln_aff_alerts`
--
ALTER TABLE `ln_aff_alerts`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ln_alerts`
--
ALTER TABLE `ln_alerts`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `ln_blog_likes`
--
ALTER TABLE `ln_blog_likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ln_categories`
--
ALTER TABLE `ln_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `ln_comments`
--
ALTER TABLE `ln_comments`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `ln_contact_messages`
--
ALTER TABLE `ln_contact_messages`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ln_country`
--
ALTER TABLE `ln_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `ln_disputes`
--
ALTER TABLE `ln_disputes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ln_dispute_messages`
--
ALTER TABLE `ln_dispute_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ln_event_types`
--
ALTER TABLE `ln_event_types`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `ln_evidence`
--
ALTER TABLE `ln_evidence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ln_followers`
--
ALTER TABLE `ln_followers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ln_forum_posts`
--
ALTER TABLE `ln_forum_posts`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `ln_inhouse_proposals`
--
ALTER TABLE `ln_inhouse_proposals`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `ln_instructors`
--
ALTER TABLE `ln_instructors`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `ln_loyalty_purchases`
--
ALTER TABLE `ln_loyalty_purchases`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ln_manual_payments`
--
ALTER TABLE `ln_manual_payments`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ln_notifications`
--
ALTER TABLE `ln_notifications`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `ln_orders`
--
ALTER TABLE `ln_orders`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `ln_order_items`
--
ALTER TABLE `ln_order_items`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ln_product_reports`
--
ALTER TABLE `ln_product_reports`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ln_profits`
--
ALTER TABLE `ln_profits`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `ln_quiz_answers`
--
ALTER TABLE `ln_quiz_answers`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `ln_reviews`
--
ALTER TABLE `ln_reviews`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `ln_site_settings`
--
ALTER TABLE `ln_site_settings`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ln_subscription_plans`
--
ALTER TABLE `ln_subscription_plans`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ln_suspend`
--
ALTER TABLE `ln_suspend`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ln_training`
--
ALTER TABLE `ln_training`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `ln_training_event_dates`
--
ALTER TABLE `ln_training_event_dates`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `ln_training_images`
--
ALTER TABLE `ln_training_images`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `ln_training_quizzes`
--
ALTER TABLE `ln_training_quizzes`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `ln_training_quiz_questions`
--
ALTER TABLE `ln_training_quiz_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `ln_training_texts_modules`
--
ALTER TABLE `ln_training_texts_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ln_training_text_modules`
--
ALTER TABLE `ln_training_text_modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `ln_training_tickets`
--
ALTER TABLE `ln_training_tickets`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `ln_training_videos`
--
ALTER TABLE `ln_training_videos`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `ln_training_video_lessons`
--
ALTER TABLE `ln_training_video_lessons`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `ln_training_video_modules`
--
ALTER TABLE `ln_training_video_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ln_users`
--
ALTER TABLE `ln_users`
  MODIFY `s` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `ln_wallet_history`
--
ALTER TABLE `ln_wallet_history`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ln_wishlist`
--
ALTER TABLE `ln_wishlist`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `ln_withdrawal`
--
ALTER TABLE `ln_withdrawal`
  MODIFY `s` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
