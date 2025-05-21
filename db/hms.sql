-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 03:09 PM
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
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(10) NOT NULL,
  `doctor_id` varchar(10) NOT NULL,
  `dept_id` int(7) NOT NULL,
  `app_date` date NOT NULL,
  `app_start_time_id` int(7) NOT NULL,
  `app_end_time` time NOT NULL,
  `duration` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `notes` longtext DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `patient_id`, `doctor_id`, `dept_id`, `app_date`, `app_start_time_id`, `app_end_time`, `duration`, `type`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(12, 'PT0000002', 'D0000002', 1, '2024-06-29', 1, '12:00:00', '2', 'Check Up', NULL, 'Completed', '2024-06-20 21:36:06', '2024-07-29 07:10:48'),
(13, 'PT0000003', 'D0000001', 6, '2024-06-27', 3, '13:00:00', '2', 'Consultation', NULL, 'Scheduled', '2024-06-20 21:53:22', '2024-06-20 22:35:52'),
(14, 'PT0000001', 'D0000002', 1, '2024-06-30', 1, '12:00:00', '2', 'Check Up', NULL, 'Completed', '2024-06-20 23:21:18', '2024-07-21 05:59:41'),
(18, 'PT0000003', 'D0000002', 1, '2024-06-29', 6, '16:00:00', '2', 'Check Up', NULL, 'Completed', '2024-06-20 23:48:55', '2024-07-29 07:10:25'),
(19, 'PT0000003', 'D0000002', 1, '2024-06-28', 4, '11:00:00', '2', 'Check Up', NULL, 'Cancelled', '2024-06-20 23:53:52', '2024-06-20 23:54:03'),
(21, 'PT0000001', 'D0000002', 1, '2024-06-30', 4, '10:00:00', '1', 'Consultation', NULL, 'Completed', '2024-06-21 04:14:58', '2024-07-29 07:10:16'),
(22, 'PT0000001', 'D0000001', 6, '2024-06-28', 4, '10:00:00', '1', 'Consultation', NULL, 'Completed', '2024-06-21 04:31:39', '2024-06-28 04:17:27'),
(24, 'PT0000004', 'D0000002', 1, '2024-06-28', 4, '10:00:00', '1', 'Consultation', NULL, 'Completed', '2024-06-21 22:59:38', '2024-07-29 07:10:07'),
(25, 'PT0000005', 'D0000002', 1, '2024-06-24', 1, '11:00:00', '1', 'Consultation', 'test', 'Completed', '2024-06-22 21:46:29', '2024-07-29 07:10:00'),
(26, 'PT0000001', 'D0000002', 1, '2024-07-31', 1, '12:00:00', '2', 'Check Up', NULL, 'Scheduled', '2024-07-21 05:58:58', '2024-07-24 01:01:27'),
(27, 'PT0000005', 'D0000002', 1, '2024-07-31', 4, '10:00:00', '1', 'Consultation', NULL, 'Scheduled', '2024-07-21 06:03:31', '2024-07-21 06:03:31'),
(28, 'PT0000001', 'D0000001', 6, '2024-07-31', 4, '10:00:00', '1', 'Check Up', NULL, 'Scheduled', '2024-07-21 06:06:58', '2024-07-21 06:06:58'),
(30, 'PT0000001', 'D0000002', 1, '2024-08-06', 4, '11:00:00', '2', 'Check Up', NULL, 'Scheduled', '2024-07-24 00:52:35', '2024-07-24 00:52:35'),
(31, 'PT0000007', 'D0000002', 1, '2024-07-24', 1, '11:00:00', '1', 'Consultation', NULL, 'Completed', '2024-07-24 07:59:32', '2024-07-29 07:10:39'),
(33, 'PT0000008', 'D0000001', 6, '2024-07-31', 1, '12:00:00', '2', 'Check Up', NULL, 'Scheduled', '2024-07-29 07:16:05', '2024-07-29 07:16:05'),
(34, 'PT0000008', 'D0000002', 1, '2024-07-29', 6, '16:00:00', '2', 'Check Up', NULL, 'Scheduled', '2024-07-29 07:17:16', '2024-07-29 07:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_time`
--

CREATE TABLE `appointment_time` (
  `id` int(7) NOT NULL,
  `app_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_time`
--

INSERT INTO `appointment_time` (`id`, `app_time`, `created_at`, `updated_at`) VALUES
(1, '10:00:00', '2024-06-19 23:02:47', '2024-06-19 23:02:47'),
(3, '11:00:00', '2024-06-19 23:10:05', '2024-06-19 23:24:32'),
(4, '09:00:00', '2024-06-19 23:24:46', '2024-06-19 23:24:46'),
(6, '14:00:00', '2024-06-19 23:25:12', '2024-06-19 23:25:12'),
(7, '15:00:00', '2024-06-19 23:25:31', '2024-06-19 23:25:31'),
(8, '16:00:00', '2024-06-19 23:25:41', '2024-06-19 23:25:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(7) NOT NULL,
  `country_code` char(3) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `country_code`, `country_name`, `created_at`, `updated_at`) VALUES
(1, 'US', 'United States', NULL, NULL),
(2, 'CA', 'Canada', NULL, NULL),
(3, 'MX', 'Mexico', NULL, NULL),
(4, 'BR', 'Brazil', NULL, NULL),
(5, 'AR', 'Argentina', NULL, NULL),
(6, 'GB', 'United Kingdom', NULL, NULL),
(7, 'FR', 'France', NULL, NULL),
(8, 'DE', 'Germany', NULL, NULL),
(9, 'IT', 'Italy', NULL, NULL),
(10, 'ES', 'Spain', NULL, NULL),
(11, 'RU', 'Russia', NULL, NULL),
(12, 'CN', 'China', NULL, NULL),
(13, 'JP', 'Japan', NULL, NULL),
(14, 'IN', 'India', NULL, NULL),
(15, 'AU', 'Australia', NULL, NULL),
(16, 'ZA', 'South Africa', NULL, NULL),
(17, 'EG', 'Egypt', NULL, NULL),
(18, 'NG', 'Nigeria', NULL, NULL),
(19, 'KE', 'Kenya', NULL, NULL),
(20, 'KR', 'South Korea', NULL, NULL),
(21, 'ID', 'Indonesia', NULL, NULL),
(22, 'SA', 'Saudi Arabia', NULL, NULL),
(23, 'TR', 'Turkey', NULL, NULL),
(24, 'IR', 'Iran', NULL, NULL),
(25, 'PK', 'Pakistan', NULL, NULL),
(26, 'TH', 'Thailand', NULL, NULL),
(27, 'MY', 'Malaysia', NULL, NULL),
(28, 'SG', 'Singapore', NULL, NULL),
(29, 'PH', 'Philippines', NULL, NULL),
(30, 'VN', 'Vietnam', NULL, NULL),
(31, 'IL', 'Israel', NULL, NULL),
(32, 'AE', 'United Arab Emirates', NULL, '2024-06-11 00:32:12'),
(33, 'NZ', 'New Zealand', NULL, NULL),
(34, 'SE', 'Sweden', NULL, NULL),
(35, 'NO', 'Norway', NULL, NULL),
(36, 'FI', 'Finland', NULL, NULL),
(37, 'DK', 'Denmark', NULL, NULL),
(38, 'IE', 'Ireland', NULL, NULL),
(39, 'CH', 'Switzerland', NULL, NULL),
(40, 'NL', 'Netherlands', NULL, NULL),
(41, 'BE', 'Belgium', NULL, NULL),
(42, 'AT', 'Austria', NULL, NULL),
(43, 'PL', 'Poland', NULL, NULL),
(44, 'CZ', 'Czech Republic', NULL, NULL),
(45, 'GR', 'Greece', NULL, NULL),
(46, 'PT', 'Portugal', NULL, NULL),
(47, 'HU', 'Hungary', NULL, NULL),
(48, 'UA', 'Ukraine', NULL, NULL),
(49, 'RO', 'Romania', NULL, NULL),
(50, 'CL', 'Chile', NULL, NULL),
(51, 'CO', 'Colombia', NULL, NULL),
(52, 'PE', 'Peru', NULL, NULL),
(53, 'VE', 'Venezuela', NULL, NULL),
(54, 'CU', 'Cuba', NULL, NULL),
(55, 'JM', 'Jamaica', NULL, NULL),
(56, 'CR', 'Costa Rica', NULL, NULL),
(57, 'PA', 'Panama', NULL, NULL),
(58, 'UY', 'Uruguay', NULL, NULL),
(59, 'PY', 'Paraguay', NULL, NULL),
(60, 'EC', 'Ecuador', NULL, NULL),
(61, 'BO', 'Bolivia', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(7) NOT NULL,
  `dept_name` varchar(150) NOT NULL,
  `dept_description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dept_name`, `dept_description`, `created_at`, `updated_at`) VALUES
(1, 'Cardiology', 'Provides medical care to patients who have heart and circulation problems', '2024-06-14 00:12:08', '2024-06-14 00:12:08'),
(2, 'Gastroenterology', 'Treats digestive and upper and lower gastrointestinal diseases', '2024-06-14 00:12:28', '2024-06-14 00:12:28'),
(3, 'Radiotherapy', 'Treatment of cancer and other diseases with ionizing radiation', '2024-06-14 00:12:45', '2024-06-14 00:12:45'),
(4, 'Nephrology', 'Monitors and assesses patients with various kidney (renal) problems and conditions', '2024-06-14 00:13:23', '2024-06-14 00:15:05'),
(5, 'Maternity', 'Provide antenatal care, delivery of babies and care during childbirth, and postnatal support', '2024-06-14 00:13:46', '2024-06-14 00:13:46'),
(6, 'Otolaryngology', 'Provides specialized care covering both medical and surgical conditions related to the ear, nose, and throat', '2024-06-14 00:14:30', '2024-06-14 00:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `diagnosis_id` varchar(10) NOT NULL,
  `medical_record_id` varchar(10) NOT NULL,
  `diagnosis_name` varchar(255) NOT NULL,
  `diagnosis_description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`diagnosis_id`, `medical_record_id`, `diagnosis_name`, `diagnosis_description`, `created_at`, `updated_at`) VALUES
('DX0000001', 'MR0000001', 'Diabetes Mellitus', 'Elevated blood sugar levels', '2024-06-23 01:39:20', '2024-06-23 01:39:20'),
('DX0000002', 'MR0000001', 'Hypertension', 'High blood pressure', '2024-06-23 01:42:19', '2024-06-23 02:13:15'),
('DX0000003', 'MR0000002', 'Healthy', 'No issues found', '2024-06-23 21:35:49', '2024-07-21 10:12:24'),
('DX0000004', 'MR0000003', 'Pharyngitis', 'Inflammation of the pharynx', '2024-06-23 21:49:09', '2024-06-23 21:49:09'),
('DX0000005', 'MR0000004', 'Otitis Media', 'Infection of the middle ear', '2024-06-23 22:02:42', '2024-06-23 22:02:42'),
('DX0000006', 'MR0000005', 'Tonsillitis', 'Inflammation of the tonsils', '2024-06-23 22:10:10', '2024-06-23 22:10:10'),
('DX0000007', 'MR0000006', 'Pharyngitis', 'Inflammation of the pharynx', '2024-06-23 22:11:57', '2024-06-23 22:11:57'),
('DX0000008', 'MR0000007', 'Angina', 'Chest pain due to reduced blood flow', '2024-06-23 22:30:51', '2024-06-23 22:30:51'),
('DX0000009', 'MR0000008', 'Myocardial Infarction', 'Heart attack', '2024-06-27 22:44:00', '2024-06-27 22:44:00'),
('DX0000013', 'MR0000013', 'Atrial Fibrillation', 'Irregular and often rapid heart rate', '2024-07-24 02:10:53', '2024-07-24 02:10:53'),
('DX0000014', 'MR0000014', 'Angina', 'Chest pain due to reduced blood flow', '2024-07-29 07:35:53', '2024-07-29 07:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` varchar(10) NOT NULL,
  `dept_id` int(7) NOT NULL,
  `years_of_experience` int(3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `dept_id`, `years_of_experience`, `created_at`, `updated_at`) VALUES
('D0000001', 6, 5, '2024-06-19 03:50:40', '2024-06-19 03:50:40'),
('D0000002', 1, 8, '2024-06-20 01:21:42', '2024-06-20 01:21:42'),
('D0000003', 3, 5, '2024-07-24 00:18:34', '2024-07-24 00:18:34'),
('D0000004', 4, 10, '2024-07-24 00:22:06', '2024-07-24 00:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `medicine_id` varchar(10) NOT NULL,
  `batch_no` varchar(20) NOT NULL,
  `expiry_date` date NOT NULL,
  `quantity` int(7) NOT NULL,
  `reorder_level` int(7) NOT NULL,
  `reorder_quantity` int(7) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `medicine_id`, `batch_no`, `expiry_date`, `quantity`, `reorder_level`, `reorder_quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 'M0000001', 'B12345', '2025-01-15', 100, 20, 50, 'Active', '2024-06-25 01:04:19', '2024-06-25 01:16:44'),
(2, 'M0000003', 'C91011', '2025-07-09', 199, 50, 100, 'Active', '2024-06-25 01:05:09', '2024-07-29 08:00:42'),
(3, 'M0000002', 'A5678', '1917-12-21', 30, 30, 75, 'Active', '2024-06-25 01:16:19', '2024-06-28 23:17:17'),
(4, 'M0000004', 'D121314', '2025-07-17', 80, 10, 40, 'Active', '2024-06-25 01:17:29', '2024-06-25 01:17:29'),
(6, 'M0000005', 'E151617', '2025-10-06', 120, 25, 60, 'Active', '2024-06-25 01:29:44', '2024-06-25 01:29:44'),
(7, 'M0000006', 'F181920', '2026-01-04', 50, 15, 30, 'Active', '2024-06-25 01:30:29', '2024-06-25 01:30:29'),
(8, 'M0000016', 'AZI001', '1908-10-11', 0, 100, 200, 'Active', '2024-06-28 22:55:25', '2024-06-28 23:12:04'),
(10, 'M0000011', 'B1244', '2025-11-20', 59, 30, 100, 'Active', '2024-07-29 07:57:00', '2024-07-29 08:00:42'),
(11, 'M0000005', 'H1234', '2027-06-09', 80, 50, 100, 'Active', '2024-07-29 08:03:35', '2024-07-29 08:03:35');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medical_record`
--

CREATE TABLE `medical_record` (
  `medical_record_id` varchar(10) NOT NULL,
  `patient_id` varchar(10) NOT NULL,
  `doctor_id` varchar(10) NOT NULL,
  `medical_record_date` date NOT NULL,
  `notes` longtext DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_record`
--

INSERT INTO `medical_record` (`medical_record_id`, `patient_id`, `doctor_id`, `medical_record_date`, `notes`, `status`, `created_at`, `updated_at`) VALUES
('MR0000001', 'PT0000001', 'D0000002', '2024-05-23', 'Follow up in 2 weeks', 'Open', '2024-06-22 23:29:25', '2024-06-22 23:29:25'),
('MR0000002', 'PT0000002', 'D0000002', '2024-06-23', 'Physical annual examinations', 'Closed', '2024-06-23 01:42:46', '2024-07-22 06:10:09'),
('MR0000003', 'PT0000004', 'D0000001', '2024-06-24', 'Sore throat and difficulty swallowing', 'Open', '2024-06-23 21:46:39', '2024-06-23 21:48:32'),
('MR0000004', 'PT0000005', 'D0000001', '2024-06-24', 'Ear infection', 'Open', '2024-06-23 22:02:14', '2024-06-23 22:02:14'),
('MR0000005', 'PT0000005', 'D0000001', '2024-06-24', 'Tonsillitis', 'Open', '2024-06-23 22:09:42', '2024-06-23 22:09:42'),
('MR0000006', 'PT0000002', 'D0000001', '2024-06-24', 'Sore throat and difficulty swallowing', 'Open', '2024-06-23 22:11:31', '2024-06-23 22:11:31'),
('MR0000007', 'PT0000004', 'D0000002', '2024-06-24', 'Patient complains of chest pain', 'Open', '2024-06-23 22:30:27', '2024-07-22 07:32:10'),
('MR0000008', 'PT0000005', 'D0000002', '2024-06-28', 'Follow-up after myocardial infarction', 'Open', '2024-06-27 22:27:40', '2024-06-27 22:27:40'),
('MR0000013', 'PT0000007', 'D0000002', '2024-07-24', 'Annual check up', 'Open', '2024-07-24 02:10:10', '2024-07-24 02:10:10'),
('MR0000014', 'PT0000008', 'D0000002', '2024-07-29', 'Chest pain', 'Open', '2024-07-29 07:35:30', '2024-07-29 07:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicine_id` varchar(10) NOT NULL,
  `medicine_name` varchar(150) NOT NULL,
  `medicine_description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `dosage_form` varchar(50) NOT NULL,
  `strength` varchar(50) NOT NULL,
  `package_size` varchar(50) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `manufacturer` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_id`, `medicine_name`, `medicine_description`, `category_id`, `dosage_form`, `strength`, `package_size`, `price`, `manufacturer`, `created_at`, `updated_at`) VALUES
('M0000001', 'Amoxicillin', 'Antibiotic used to treat bacterial infections', 1, 'Capsule', '500 mg', '30', 12.50, 'Pfizer', '2024-06-24 22:35:00', '2024-07-21 10:48:18'),
('M0000002', 'Lisinopril', 'Medication for high blood pressure', 3, 'Tablet', '20 mg', '60', 15.00, 'AstraZeneca', '2024-06-24 22:51:14', '2024-06-24 22:51:14'),
('M0000003', 'Metformin', 'Medication to control blood sugar in diabetes', 9, 'Tablet', '500 mg', '100', 8.75, 'Merck', '2024-06-24 23:18:58', '2024-06-24 23:18:58'),
('M0000004', 'Ibuprofen', 'Pain reliever and anti-inflammatory', 2, 'Tablet', '200 mg', '50', 7.00, 'Johnson & Johnson', '2024-06-24 23:20:21', '2024-06-24 23:20:21'),
('M0000005', 'Cetirizine', 'Antihistamine for allergy relief', 11, 'Tablet', '10 mg', '30', 10.00, 'GlaxoSmithKline', '2024-06-24 23:22:12', '2024-06-24 23:22:12'),
('M0000006', 'Insulin Glargine', 'Long-acting insulin for diabetes management', 4, 'Injection', '100 units/ml', '1 vial', 50.00, 'Sanofi', '2024-06-24 23:23:59', '2024-06-24 23:23:59'),
('M0000007', 'Atorvastatin', 'Medication to lower cholesterol', 5, 'Tablet', '40 mg', '90', 20.00, 'Pfizer', '2024-06-24 23:25:07', '2024-06-24 23:25:07'),
('M0000008', 'Sertraline', 'Antidepressant used to treat depression', 8, 'Tablet', '50 mg', '30', 25.00, 'Pfizer', '2024-06-24 23:26:12', '2024-06-24 23:26:12'),
('M0000009', 'Oseltamivir', 'Antiviral medication for flu treatment', 10, 'Capsule', '75 mg', '10', 35.00, 'Roche', '2024-06-24 23:27:10', '2024-06-24 23:27:10'),
('M0000010', 'Hepatitis B Vaccine', 'Vaccine for hepatitis B prevention', 7, 'Injection', '10 mcg/ml', '1 vial', 80.00, 'GlaxoSmithKline', '2024-06-24 23:28:15', '2024-06-24 23:28:15'),
('M0000011', 'Insulin Lispro', 'Fast-acting insulin used to treat diabetes', 9, 'Injection', '10 units/ml', '1 vial', 52.00, 'RapidActInsulin', '2024-06-25 23:40:26', '2024-06-25 23:40:26'),
('M0000012', 'Pioglitazone', 'Thiazolidinedione class medication used to control blood sugar levels', 4, 'Tablet', '15 mg', '30', 32.00, 'ThiazoPharm', '2024-06-25 23:41:58', '2024-06-25 23:41:58'),
('M0000013', 'Nitroglycerin', 'Medication used to relieve chest pain (angina)', 12, 'Tablet', '0.4 mg', '25', 20.00, 'PharmaCo', '2024-06-27 06:25:04', '2024-06-27 06:30:53'),
('M0000014', 'Metoprolol', 'Beta-blocker used to treat high blood pressure', 13, 'Tablet', '50 mg', '30', 25.00, 'BetaCare', '2024-06-27 06:31:55', '2024-06-27 06:31:55'),
('M0000015', 'Aspirin', 'NSAID used to reduce pain and prevent blood clots', 14, 'Tablet', '81 mg', '100', 10.00, 'PainRelief', '2024-06-27 06:33:08', '2024-06-27 06:33:08'),
('M0000016', 'Azithromycin', 'Antibiotic for bacterial infections', 1, 'Tablet', '250 mg', '6', 30.00, 'PharmaMed', '2024-06-28 01:32:40', '2024-06-28 01:32:40'),
('M0000017', 'Amiodarone', 'Antiarrhythmic medication for arrhythmia', 16, 'Tablet', '100 mg', '30', 60.00, 'MedPharma', '2024-06-28 04:59:23', '2024-06-28 05:00:01');

-- --------------------------------------------------------

--
-- Table structure for table `medicine_category`
--

CREATE TABLE `medicine_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine_category`
--

INSERT INTO `medicine_category` (`id`, `category_name`, `category_description`, `created_at`, `updated_at`) VALUES
(1, 'Antibiotics', 'Medications used to treat bacterial infections', '2024-06-24 21:38:50', '2024-06-24 21:38:50'),
(2, 'Analgesics', 'Medications used to relieve pain', '2024-06-24 21:39:12', '2024-06-24 23:37:53'),
(3, 'Antihypertensives', 'Medications used to treat high blood pressure', '2024-06-24 21:39:37', '2024-06-24 21:45:47'),
(4, 'Insulin', 'Hormone therapy used to manage blood sugar levels in patients with diabetes mellitus', '2024-06-24 21:41:18', '2024-06-24 21:41:18'),
(5, 'Statin', 'Medications used to lower cholesterol levels and reduce the risk of cardiovascular disease', '2024-06-24 21:41:36', '2024-06-24 21:41:36'),
(7, 'Vaccines', 'Biological preparations that provide immunity against specific diseases', '2024-06-24 22:31:50', '2024-06-24 22:31:50'),
(8, 'Antidepressants', 'Medications used to treat depression and anxiety disorders', '2024-06-24 22:32:08', '2024-06-24 22:32:08'),
(9, 'Antidiabetics', 'Medications used to manage diabetes by controlling blood sugar', '2024-06-24 22:32:31', '2024-06-24 22:32:31'),
(10, 'Antivirals', 'Medications used to treat viral infections', '2024-06-24 22:32:58', '2024-06-24 22:32:58'),
(11, 'Antihistamines', 'Medications used to treat allergic reactions and symptoms', '2024-06-24 22:33:23', '2024-06-24 22:33:23'),
(12, 'Vasodilators', 'Medications that dilate blood vessels', '2024-06-27 06:29:30', '2024-06-27 06:29:30'),
(13, 'Beta Blockers', 'Medications that reduce blood pressure', '2024-06-27 06:29:48', '2024-06-27 06:29:48'),
(14, 'NSAIDs', 'Nonsteroidal anti-inflammatory drugs', '2024-06-27 06:30:14', '2024-06-27 06:30:14'),
(15, 'Antiplatelets', 'Medications that prevent blood clots', '2024-06-27 06:30:32', '2024-06-27 06:30:32'),
(16, 'Antiarrhythmic', 'Medications used to treat irregular heartbeats and maintain normal heart rhythm', '2024-06-28 04:59:46', '2024-06-28 04:59:46'),
(17, 'Hormones', 'Hormones', '2024-07-29 08:04:10', '2024-07-29 08:04:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '0001_01_01_000000_create_users_table', 1),
(10, '0001_01_01_000001_create_cache_table', 1),
(11, '0001_01_01_000002_create_jobs_table', 1),
(12, '2024_06_19_061810_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 16),
(5, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` varchar(10) NOT NULL,
  `patient_name` varchar(150) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `gender` char(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `ic` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip_code` varchar(5) NOT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `emergency_contact_relationship` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `patient_name`, `username`, `gender`, `email`, `phone`, `ic`, `dob`, `street`, `city`, `state`, `zip_code`, `emergency_contact`, `emergency_contact_relationship`, `created_at`, `updated_at`) VALUES
('PT0000001', 'Ivy Lim Hui Yi', 'ivy', 'M', 'ivy@gmail.com', '0193524623', '001008070912', '2000-10-08', 'No. 10, Jalan Damai Perdana 1/9B, Bandar Damai Perdana', 'Cheras', 'Kuala Lumpur', '56000', '0128975345', 'Mother', '2024-06-20 17:48:21', '2024-06-27 00:02:29'),
('PT0000002', 'Alex Low', 'alex', 'M', 'alexlow@gmail.com', '0125363488', '750815070863', '1975-08-15', '30, Jalan Delima 2, Taman Bukit Delima', 'Ampang', 'Selangor', '68000', '0124508882', 'Wife', '2024-06-20 21:22:07', '2024-07-23 23:59:46'),
('PT0000003', 'Jack Goh', 'jack', 'M', 'jackgoh@gmail.com', '0125657878', '990405070899', '1999-04-05', '9, Lorong Bukit Setongkol 88', 'Kuantan', 'Pahang', '25200', '0126760033', 'Mother', '2024-06-20 21:44:09', '2024-06-24 23:12:05'),
('PT0000004', 'Tan Wei Ling', 'weiling', 'F', 'weiling66@gmail.com', '0127878543', '950404101234', '1995-04-04', '1No. 23, Jalan Pahlawan, Taman Tun Dr Ismail', 'Putrajaya', 'Kuala Lumpur', '50000', '0123456789', 'Father', '2024-06-21 22:50:09', '2024-06-21 23:22:18'),
('PT0000005', 'John Lim Wei Kang', 'john', 'M', 'johnlim@gmail.com', '0187625437', '001010070893', '2000-10-10', 'No. 78, Jalan SS2/75, SS2', 'Petaling Jaya', 'Selangor', '47300', '0187654372', 'Father', '2024-06-21 23:01:58', '2024-06-21 23:01:58'),
('PT0000007', 'Cindy Tan', NULL, 'F', 'cindy1010@gmail.com', '0198255253', '001010070123', '2000-10-10', '12, Jalan Permaisuri, Taman Santuari 12', 'Cheras', 'Kuala Lumpur', '55000', '0182365689', 'Mother', '2024-07-23 23:43:09', '2024-07-29 07:58:18'),
('PT0000008', 'Jane Lim', 'jane', 'F', 'jane@gmail.com', '0198767283', '001010070808', '2000-10-10', '17, Jalan Ampang', 'Ampang', 'Kuala Lumpur', '45000', '0198723672', 'Mother', '2024-07-29 07:15:43', '2024-07-29 07:15:43');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view appointment', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(2, 'view staff', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(3, 'create staff', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(4, 'edit staff', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(5, 'delete staff', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(6, 'view masterdata', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(7, 'create masterdata', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(8, 'edit masterdata', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(9, 'delete masterdata', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `treatment_id` varchar(10) NOT NULL,
  `medicine_id` varchar(10) NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `instructions` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `treatment_id`, `medicine_id`, `dosage`, `frequency`, `duration`, `instructions`, `created_at`, `updated_at`) VALUES
(1, 'TX0000008', 'M0000003', '500 mg', 'Twice daily', '3 months', 'Take with meals', '2024-06-25 22:44:04', '2024-06-25 22:55:05'),
(9, 'TX0000008', 'M0000011', '10 units/ml', 'Before meals', 'Ongoing', 'Inject subcutaneously', '2024-06-25 23:44:10', '2024-06-25 23:44:10'),
(10, 'TX0000007', 'M0000013', '0.4 mg', 'As needed', '1 month', 'Place tablet under the tongue', '2024-06-27 06:33:45', '2024-07-21 10:26:25'),
(11, 'TX0000002', 'M0000014', '50 mg', 'Twice daily', '1 month', 'Take with meals', '2024-06-28 00:29:04', '2024-06-28 00:58:33'),
(12, 'TX0000002', 'M0000002', '20 mg', 'Once daily', '1 month', 'Take in the morning', '2024-06-28 00:29:50', '2024-06-28 00:29:50'),
(14, 'TX0000003', 'M0000001', '500 mg', 'Thrice daily', '10 days', 'Take with or without food', '2024-06-28 01:30:09', '2024-06-28 01:30:09'),
(15, 'TX0000003', 'M0000016', '250 mg', 'Once daily', '5 days', 'Take with food', '2024-06-28 01:33:28', '2024-07-29 08:00:07'),
(16, 'TX0000006', 'M0000016', '250 mg', 'Once daily', '5 days', 'Take with or without food', '2024-06-28 01:34:47', '2024-06-28 01:34:47'),
(20, 'TX0000014', 'M0000014', '50 mg', 'Twice a day', '1 month', 'Take with food', '2024-07-29 07:36:57', '2024-07-29 07:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(2, 'doctor', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(3, 'normal user', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(4, 'admin', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34'),
(5, 'pharmacist', 'web', '2024-06-18 23:11:34', '2024-06-18 23:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `running_no`
--

CREATE TABLE `running_no` (
  `id` int(7) NOT NULL,
  `type` varchar(50) NOT NULL,
  `prefix` char(3) NOT NULL,
  `running_no` int(7) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `running_no`
--

INSERT INTO `running_no` (`id`, `type`, `prefix`, `running_no`, `created_at`, `updated_at`) VALUES
(2, 'doctor', 'D', 5, '2024-06-11 23:30:40', '2024-07-29 08:26:30'),
(5, 'pharmacist', 'P', 2, '2024-06-13 02:54:01', '2024-06-25 01:26:50'),
(6, 'admin', 'A', 3, '2024-06-13 02:54:46', '2024-07-24 08:34:05'),
(7, 'patient', 'PT', 9, '2024-06-19 05:16:15', '2024-07-29 07:15:43'),
(8, 'medical record', 'MR', 15, '2024-06-22 00:18:01', '2024-07-29 07:35:30'),
(9, 'diagnosis', 'DX', 15, '2024-06-22 00:19:13', '2024-07-29 07:35:53'),
(10, 'treatment', 'TX', 15, '2024-06-22 00:19:45', '2024-07-29 07:36:32'),
(11, 'medicine', 'M', 19, '2024-06-24 19:49:34', '2024-07-29 08:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9YAGfiuvPuDrIIqfLhwjelVEvAhjuHpYCsDgcgs0', 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVWpDNDBDQ0pQUU5sN1loTkR3UEJKN2ZwcE95bTdCRlVTcFVyWno0SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3QvaG1zL21lZGljYWxyZWNvcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMDtzOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM0OiJodHRwOi8vbG9jYWxob3N0L2htcy9tZWRpY2FscmVjb3JkIjt9fQ==', 1722270048),
('eN3XCTNGCkEQICvrVgVLsMxkZKrrC0Fv3picpmhG', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTm9MUlNydmRBQVhPUHlzNUd4ZVVuVnVIS0RNcncxVHJ2WU1pM1JGTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHA6Ly9sb2NhbGhvc3QvaG1zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1722269654),
('SScriEA2zXYXAtQOUN1td21lUs65qCOgG1oQhWE8', 21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQTFNbzNPREg5N2FkZllnbmVKUVB0dWtiZ3hvbXk5T3NiemlSUWlyUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3QvaG1zL2RvY3Rvci9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyMTt9', 1722270277),
('sUHZiiLTwl4OLLoeCSbXkfUXWpYIfwQH0z6BZSvF', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVkFZaTJqVXJrZlRoWDNWYzhqb21KUGNacFhKNHdaUHNvZzJ6NEg5NSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly9sb2NhbGhvc3QvaG1zL3N0YWZmbWFuYWdlbWVudC9kZXRhaWxzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1722270398);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` varchar(10) NOT NULL,
  `role` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `username` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip_code` varchar(5) NOT NULL,
  `hired_date` date NOT NULL,
  `terminated_date` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `role`, `name`, `username`, `gender`, `email`, `phone`, `dob`, `street`, `city`, `state`, `zip_code`, `hired_date`, `terminated_date`, `salary`, `status`, `created_at`, `updated_at`) VALUES
('A0000001', 'super admin', 'Goh Shieh Rou', 'shiehrou', 'F', 'kylie4568@gmail.com', '0174128166', '2001-09-05', '8, Lorong Hijauan Valdor 3823', 'Sungai Jawi', 'Penang', '14200', '2024-06-04', NULL, NULL, 'Active', NULL, '2024-07-29 06:46:14'),
('A0000002', 'admin', 'Amy Lee Sin Tian', 'amy', 'F', 'amy@gmail.com', '0126753509', '1994-07-07', '3 Jalan Raja Chulan', 'Bukit Bintang', 'Kuala Lumpur', '50200', '2024-06-27', NULL, 8000.00, 'Active', '2024-06-27 01:38:15', '2024-06-27 01:38:15'),
('D0000001', 'doctor', 'Michael Wilson', 'michael', 'M', 'michael@gmail.com', '0172436277', '1990-03-15', 'No. 25, Jalan Ampang, Kampung Datuk Keramat', 'KL', 'Kuala Lumpur', '52000', '2024-06-19', NULL, 10500.00, 'Active', '2024-06-19 03:50:39', '2024-06-19 03:50:39'),
('D0000002', 'doctor', 'Emily Tan', 'emily', 'F', 'emily@gmail.com', '0122353473', '1988-12-07', '123, Jalan Ampang, Taman U Thant', 'Cheras', 'Kuala Lumpur', '55000', '2024-06-20', NULL, 18000.00, 'Active', '2024-06-20 01:21:41', '2024-06-27 01:26:01'),
('D0000003', 'doctor', 'Ken Chua', 'ken', 'M', 'ken@gmail.com', '0126758928', '1989-06-14', '9A, Lorong Floral 5, Taman Floral', 'Petaling Jaya', 'Kuala Lumpur', '47000', '2024-07-24', NULL, 12000.00, 'Active', '2024-07-24 00:18:34', '2024-07-24 00:18:34'),
('D0000004', 'doctor', 'Chendy Ng', 'chendy', 'F', 'chendy@gmail.com', '0126738620', '1894-11-22', '3A, Lorong Damansara', 'Damansara', 'Kuala Lumpur', '50000', '2024-07-24', NULL, 22000.00, 'Active', '2024-07-24 00:22:06', '2024-07-24 00:22:06'),
('P0000001', 'pharmacist', 'Tea Yuan Yuan', 'yuan', 'F', 'yuan2@gmail.com', '0127863452', '1988-03-17', '56, Jalan Bukit Bintang 12', 'Bukit Bintang', 'Kuala Lumpur', '55100', '2024-06-25', NULL, 15800.00, 'Active', '2024-06-25 01:26:49', '2024-07-22 08:44:45');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `treatment_id` varchar(10) NOT NULL,
  `diagnosis_id` varchar(10) NOT NULL,
  `treatment_name` varchar(255) NOT NULL,
  `treatment_description` text NOT NULL,
  `type_id` int(7) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`treatment_id`, `diagnosis_id`, `treatment_name`, `treatment_description`, `type_id`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
('TX0000001', 'DX0000001', 'Insulin Therapy', 'Insulin injections', 3, '2024-06-24', NULL, 'Scheduled', '2024-06-23 21:33:00', '2024-06-23 21:33:00'),
('TX0000002', 'DX0000002', 'Antihypertensive', 'Medication to lower blood pressure', 1, '2024-06-24', '2024-06-28', 'Approved', '2024-06-23 21:34:00', '2024-06-28 01:12:51'),
('TX0000003', 'DX0000004', 'Antibiotics Therapy', 'Medication to treat bacterial pharyngitis', 1, '2024-06-24', '2024-06-28', 'Pending', '2024-06-23 21:50:14', '2024-06-28 01:29:16'),
('TX0000004', 'DX0000005', 'Ear Drops', 'Medication drops for ear infection', 1, '2024-06-24', '2024-06-27', 'Rejected', '2024-06-23 22:03:23', '2024-06-28 01:22:38'),
('TX0000005', 'DX0000006', 'Tonsillectomy', 'Surgical removal of tonsils', 2, '2024-06-24', NULL, 'Completed', '2024-06-23 22:10:38', '2024-06-23 22:26:33'),
('TX0000006', 'DX0000007', 'Antibiotics', 'Medication to treat bacterial pharyngitis', 1, '2024-06-24', '2024-06-28', 'Approved', '2024-06-23 22:12:29', '2024-06-28 23:09:03'),
('TX0000007', 'DX0000008', 'Nitroglycerin Therapy', 'Medication to relieve chest pain.', 1, '2024-06-24', '2024-06-28', 'Approved', '2024-06-23 22:31:33', '2024-06-28 01:15:59'),
('TX0000008', 'DX0000001', 'Diabetes Control', 'Oral medication to lower blood sugar levels', 1, '2024-06-24', '2024-09-24', 'Approved', '2024-06-24 03:21:59', '2024-07-29 08:00:42'),
('TX0000009', 'DX0000009', 'Angioplasty', 'Procedure to open blocked arteries', 2, '2024-07-02', NULL, 'Scheduled', '2024-06-27 22:46:45', '2024-06-27 22:47:15'),
('TX0000013', 'DX0000013', 'Therapy', 'Therapy', 3, '2024-07-24', '2024-08-14', 'In Progress', '2024-07-24 02:11:24', '2024-07-24 02:11:24'),
('TX0000014', 'DX0000014', 'Medication', 'Prescription of beta-blockers', 1, '2024-07-29', '2024-08-29', 'Rejected', '2024-07-29 07:36:32', '2024-07-29 08:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_type`
--

CREATE TABLE `treatment_type` (
  `id` int(7) NOT NULL,
  `type` varchar(50) NOT NULL,
  `type_description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment_type`
--

INSERT INTO `treatment_type` (`id`, `type`, `type_description`, `created_at`, `updated_at`) VALUES
(1, 'Medication', 'Administration of prescribed medications', '2024-06-22 01:13:06', '2024-06-24 23:39:35'),
(2, 'Surgery', 'Surgical procedure performed in an operating room', '2024-06-22 01:13:30', '2024-06-22 01:13:30'),
(3, 'Physical Therapy', 'Therapy sessions to improve physical function', '2024-06-22 01:13:48', '2024-06-22 01:13:48'),
(4, 'Counseling', 'Counseling sessions with a mental health professional', '2024-06-22 01:14:11', '2024-06-22 01:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'shiehrou', 'kylie4568@gmail.com', NULL, '$2y$12$6f3J.xKsKqWsCWw.mZqbGOIZH0TBWJ5VgY13ok3D0eYccrOKQg/Tu', NULL, NULL, '2024-07-29 06:46:42'),
(2, 'ivy', 'ivy@gmail.com', NULL, '$2y$12$0uAxwXTtzjMtOLzduy1n4uTTAkbc0RthPnR7/nxszOpNOMIW/zBR.', NULL, '2024-06-19 03:00:55', '2024-06-27 00:22:54'),
(3, 'michael', 'michael@gmail.com', NULL, '$2y$12$vitwgQeRg4Zr65D718F8jusdt9JVzCESH88sDYtFHChRW1T9hB.X6', NULL, '2024-06-19 03:50:40', '2024-06-19 03:50:40'),
(4, 'emily', 'emily@gmail.com', NULL, '$2y$12$EN1ZYCxxjT6WhCcvnbh.YeapLnGNc05VAwOebirzLgATslyYetbgm', NULL, '2024-06-20 01:21:42', '2024-06-27 01:27:07'),
(5, 'alex', 'alexlow@gmail.com', NULL, '$2y$12$cwK9GMiIAu58Ovd8Gi7ODuCgoy2xH/qlfBAm/xWsSUYLGS7IgfHpe', NULL, '2024-06-20 20:57:48', '2024-06-20 20:57:48'),
(6, 'jack', 'jackgoh@gmail.com', NULL, '$2y$12$rzbGJzpflokJUwHAAJYZNe9UCyl0kqjQ6XW1uoKhbEUNA7iTW0bAO', NULL, '2024-06-20 21:40:28', '2024-06-20 21:40:28'),
(7, 'weiling', 'weiling66@gmail.com', NULL, '$2y$12$XEhB9x0cF8/IfYpXeh2eUuIJ3mjZ4Z5F.J0VvBibl/xikqkHk.QkS', NULL, '2024-06-21 22:56:10', '2024-06-21 22:56:10'),
(8, 'john', 'johnlim@gmail.com', NULL, '$2y$12$1tRQLZf6uErYGl1o9GS9IOT7NRBwW3RmV39ohSMhS8ylB519daiZa', NULL, '2024-06-21 23:00:34', '2024-06-21 23:00:34'),
(9, 'yuan', 'yuan2@gmail.com', NULL, '$2y$12$5uZS4oS9C9qvclkchCu/L.3CHaiTUIt3rSqHJ6tasxxPTRGLJdgXu', NULL, '2024-06-25 01:26:50', '2024-07-22 08:58:44'),
(10, 'amy', 'amy@gmail.com', NULL, '$2y$12$Ar4NLw3wR8FafEUmygVFq.HGff11Q7xqvaNa8WJsYOdna0GhTkTgq', NULL, '2024-06-27 01:38:15', '2024-06-27 01:38:15'),
(11, 'cynthia', 'cynthia@gmail.com', NULL, '$2y$12$J78cLzkPBioOqftpJWdnl.54jv46HNcqhGkLg6q95zfGyamjPSY6S', NULL, '2024-07-21 03:46:01', '2024-07-21 03:46:01'),
(12, 'yanpeng', 'yanpeng0214@gmail.com', NULL, '$2y$12$IYhcm7FCEiB/OSM0KAH43..jC7nOYNrnkjTRru7cJG/lUWLDuHMTO', NULL, '2024-07-22 01:00:27', '2024-07-22 01:00:27'),
(13, 'bryan', 'bryan123@gmail.com', NULL, '$2y$12$bMGt7zNAIEbzI7YeCxYBUOxklWGtnK.8plOrCKDSz7s4aFcNHZ3TS', NULL, '2024-07-23 22:55:52', '2024-07-23 22:55:52'),
(14, 'ken', 'ken@gmail.com', NULL, '$2y$12$2eroj/X3YaDQ0jsRjT5c5uhzpJj.ttwjUK0LwYtBCV8AsQnUSTtO2', NULL, '2024-07-24 00:18:34', '2024-07-24 00:18:34'),
(15, 'chendy', 'chendy@gmail.com', NULL, '$2y$12$aE6g9R3j8mX/MwRTjwFsqOvG1i4l7EmjQkwpCABwRCcdiXequKchu', NULL, '2024-07-24 00:22:06', '2024-07-24 00:22:06'),
(17, 'elise', 'eliseteo@gmail.com', NULL, '$2y$12$B4xjsykKfsjiE3btijhYN.sFJVWG9FQ7ndY9H4.7KLFZ6DH75Bjqe', NULL, '2024-07-24 09:23:05', '2024-07-24 09:23:05'),
(18, 'rannie', 'rannie@gmail.com', NULL, '$2y$12$9lHpELsy5gidDFV/SYtUseQj53mWJKQ/3mGFRVZ0SDjeTnasbjwba', NULL, '2024-07-29 06:28:36', '2024-07-29 06:28:36'),
(19, 'jane', 'jane@gmail.com', NULL, '$2y$12$stw68sfVJnF0oXjuWmZ9xuuAMbCLdsz4Nvr0au56koMws411m9tlC', NULL, '2024-07-29 06:47:57', '2024-07-29 06:47:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_time`
--
ALTER TABLE `appointment_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`diagnosis_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical_record`
--
ALTER TABLE `medical_record`
  ADD PRIMARY KEY (`medical_record_id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `medicine_category`
--
ALTER TABLE `medicine_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `running_no`
--
ALTER TABLE `running_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`treatment_id`),
  ADD KEY `FK_TREATMENT_DIAGNOSIS` (`diagnosis_id`);

--
-- Indexes for table `treatment_type`
--
ALTER TABLE `treatment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `appointment_time`
--
ALTER TABLE `appointment_time`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_category`
--
ALTER TABLE `medicine_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `running_no`
--
ALTER TABLE `running_no`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `treatment_type`
--
ALTER TABLE `treatment_type`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `FK_TREATMENT_DIAGNOSIS` FOREIGN KEY (`diagnosis_id`) REFERENCES `diagnosis` (`diagnosis_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
