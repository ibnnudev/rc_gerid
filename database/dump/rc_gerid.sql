-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Mar 2023 pada 08.21
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rc_gerid`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `authors`
--

-- CREATE TABLE `authors` (
--   `id` bigint(20) UNSIGNED NOT NULL,
--   `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
--   `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `member` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
--   `institutions_id` bigint(20) UNSIGNED DEFAULT NULL,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL,
--   `is_active` tinyint(1) NOT NULL DEFAULT 1
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `authors`
--

INSERT INTO `authors` (`id`, `name`, `address`, `phone`, `member`, `institutions_id`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Fiki', 'Probolinggo', '081515144982', 'Armand, Ibnu, Jhon', 4, '2023-03-11 16:15:03', '2023-03-11 16:15:03', 1),
(2, 'Ibnu Sutio', 'Jember', '081515144981', 'Hariono, Satya, Wijaya', 8, '2023-03-11 17:31:40', '2023-03-11 18:02:13', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cases`
--

CREATE TABLE `cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no` int(11) DEFAULT NULL,
  `idkd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idkd_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subdistrict` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count_of_cases` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `age_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transmission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `citations`
--

CREATE TABLE `citations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `samples_id` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `genotipes`
--

CREATE TABLE `genotipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `viruses_id` bigint(20) UNSIGNED DEFAULT NULL,
  `genotipe_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `genotipes`
--

INSERT INTO `genotipes` (`id`, `viruses_id`, `genotipe_code`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 2, 'CRF01_AE', '2023-03-12 23:26:27', '2023-03-12 23:26:38', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `institutions`
--

CREATE TABLE `institutions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `institutions`
--

INSERT INTO `institutions` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, '031001', 'Universitas Ibnu Chaldun', NULL, NULL),
(2, '031003', 'Universitas Islam Jakarta', NULL, NULL),
(3, '031005', 'Universitas Jakarta', NULL, NULL),
(4, '031006', 'Universitas Jayabaya', NULL, NULL),
(5, '031007', 'Universitas Katolik Indonesia Atma Jaya', NULL, NULL),
(6, '031008', 'Universitas Krisnadwipayana', NULL, NULL),
(7, '031009', 'Universitas Kristen Indonesia', NULL, NULL),
(8, '031010', 'Universitas Kristen Krida Wacana', NULL, NULL),
(9, '031011', 'Universitas Muhammadiyah Jakarta', NULL, NULL),
(10, '031012', 'Universitas Nasional', NULL, NULL),
(11, '031013', 'Universitas Pancasila', NULL, NULL),
(12, '031014', 'Universitas Prof Dr Moestopo (Beragama)', NULL, NULL),
(13, '031015', 'Universitas Tarumanagara', NULL, NULL),
(14, '031016', 'Universitas Trisakti', NULL, NULL),
(15, '031017', 'Universitas 17 Agustus 1945 Jakarta', NULL, NULL),
(16, '031018', 'Universitas Borobudur', NULL, NULL),
(17, '031019', 'Universitas Mercu Buana', NULL, NULL),
(18, '031020', 'Universitas Persada Indonesia Yai', NULL, NULL),
(19, '031021', 'Universitas Islam As-syafiiyah', NULL, NULL),
(20, '031022', 'Universitas Wiraswasta Indonesia', NULL, NULL),
(21, '031023', 'Universitas Darma Persada', NULL, NULL),
(22, '031024', 'Universitas Mpu Tantular', NULL, NULL),
(23, '031025', 'Universitas Satya Negara Indonesia', NULL, NULL),
(24, '031026', 'Universitas Yarsi', NULL, NULL),
(25, '031027', 'Universitas Respati Indonesia', NULL, NULL),
(26, '031029', 'Universitas Surapati', NULL, NULL),
(27, '031030', 'Universitas Sahid', NULL, NULL),
(28, '031031', 'Universitas Satyagama', NULL, NULL),
(29, '031033', 'Universitas Esa Unggul', NULL, NULL),
(30, '031034', 'Universitas Pelita Harapan', NULL, NULL),
(31, '031036', 'Universitas Bhayangkara Jakarta Raya', NULL, NULL),
(32, '031037', 'Universitas Gunadarma', NULL, NULL),
(33, '031038', 'Universitas Bina Nusantara', NULL, NULL),
(34, '031039', 'Universitas Muhammadiyah Prof Dr Hamka', NULL, NULL),
(35, '031040', 'Universitas Azzahra', NULL, NULL),
(36, '031041', 'Universitas Paramadina', NULL, NULL),
(37, '031042', 'Universitas Bung Karno', NULL, NULL),
(38, '031043', 'Universitas Dirgantara Marsekal Suryadarma', NULL, NULL),
(39, '031044', 'Universitas Al-azhar Indonesia', NULL, NULL),
(40, '031045', 'Universitas Budi Luhur', NULL, NULL),
(41, '031048', 'Universitas Bunda Mulia', NULL, NULL),
(42, '031049', 'Universitas Indraprasta PGRI', NULL, NULL),
(43, '031050', 'Universitas Tama Jagakarsa', NULL, NULL),
(44, '031051', 'Universitas Multimedia Nusantara Jakarta', NULL, NULL),
(45, '031053', 'Universitas Bakrie', NULL, NULL),
(46, '031054', 'Universitas Tanri Abeng', NULL, NULL),
(47, '031055', 'Universitas Trilogi', NULL, NULL),
(48, '031056', 'Universitas Sampoerna', NULL, NULL),
(49, '031057', 'Universitas Agung Podomoro', NULL, NULL),
(50, '031059', 'Universitas Mohammad Husni Thamrin Jakarta', NULL, NULL),
(51, '031060', 'Universitas Matana', NULL, NULL),
(52, '031061', 'Universitas Nahdlatul Ulama Indonesia', NULL, NULL),
(53, '031062', 'Universitas Pertamina', NULL, NULL),
(54, '031063', 'Universitas Prasetiya Mulya', NULL, NULL),
(55, '031064', 'Universitas Binawan', NULL, NULL),
(56, '031065', 'Universitas Bina Sarana Informatika', NULL, NULL),
(57, '031066', 'Universitas Dian Nusantara', NULL, NULL),
(58, '031067', 'Universitas Pradita', NULL, NULL),
(59, '031068', 'Universitas Siber Asia', NULL, NULL),
(60, '031069', 'Universitas Nusa Mandiri', NULL, NULL),
(61, '031070', 'Universitas Insan Cita Indonesia', NULL, NULL),
(62, '031071', 'Universitas Media Nusantara Citra', NULL, NULL),
(63, '031072', 'Universitas Indonesia Maju', NULL, NULL),
(64, '031073', 'Universitas Saintek Muhammadiyah', NULL, NULL),
(65, '031074', 'Universitas Darunnajah', NULL, NULL),
(66, '031075', 'Universitas IPWIJA', NULL, NULL),
(67, '031076', 'Universitas ASA Indonesia', NULL, NULL),
(68, '031077', 'Universitas Teknologi Muhammadiyah Jakarta', NULL, NULL),
(69, '032002', 'Institut Kesenian Jakarta', NULL, NULL),
(70, '032004', 'Institut Sains Dan Teknologi Nasional', NULL, NULL),
(71, '032005', 'Institut Ilmu Sosial Dan Ilmu Politik Jakarta', NULL, NULL),
(72, '032006', 'Institut Teknologi Indonesia', NULL, NULL),
(73, '032007', 'Institut Teknologi Budi Utomo', NULL, NULL),
(74, '032008', 'Institut Sains Dan Teknologi Al-Kamal', NULL, NULL),
(75, '032009', 'Institut Bisnis Dan Informatika Kwik Kian Gie', NULL, NULL),
(76, '032011', 'Institut Keuangan-Perbankan Dan Informatika Asia Perbanas', NULL, NULL),
(77, '032012', 'Institut Bisnis Nusantara', NULL, NULL),
(78, '032013', 'Institut Teknologi dan Bisnis Kalbis', NULL, NULL),
(79, '032014', 'Institut Bisnis dan Multimedia Asmi Jakarta', NULL, NULL),
(80, '032015', 'Institut Bisnis dan Informatika (IBI) Kosgoro 1957', NULL, NULL),
(81, '032016', 'Institut Bio Scientia Internasional Indonesia', NULL, NULL),
(82, '032017', 'Institut Ilmu Sosial dan Manajemen STIAMI', NULL, NULL),
(83, '032018', 'Institut Kesehatan Indonesia', NULL, NULL),
(84, '032020', 'Institut Transportasi&nbsp; dan Logistik Trisakti', NULL, NULL),
(85, '032021', 'Institut Teknologi Calvin', NULL, NULL),
(86, '032022', 'Institut Teknologi dan Bisnis Bank Rakyat Indonesia', NULL, NULL),
(87, '032023', 'Institut Teknologi dan Bisnis Ahmad Dahlan', NULL, NULL),
(88, '032025', 'Institut Komunikasi Dan Bisnis LSPR', NULL, NULL),
(89, '032026', 'Institut Teknologi Perusahaan Listrik Negara', NULL, NULL),
(90, '032027', 'Institut Teknologi dan Bisnis Swadharma', NULL, NULL),
(91, '032029', 'Institut Kesehatan dan Teknologi Pondok Karya Pembangunan', NULL, NULL),
(92, '032030', 'Institut Teknologi dan Bisnis Jakarta', NULL, NULL),
(93, '033001', 'Sekolah Tinggi Filsafat Driyarkara', NULL, NULL),
(94, '033004', 'STISIP Widuri', NULL, NULL),
(95, '033009', 'Sekolah Tinggi Filsafat Theologi Jakarta', NULL, NULL),
(96, '033012', 'Sekolah Tinggi Ilmu Ekonomi Indonesia Jakarta', NULL, NULL),
(97, '033014', 'STKIP Kusumanegara', NULL, NULL),
(98, '033015', 'Sekolah Tinggi Ilmu Ekonomi Swadaya', NULL, NULL),
(99, '033022', 'Sekolah Tinggi Manajemen Informatika dan Komputer Jakarta STI&amp;K', NULL, NULL),
(100, '033024', 'Sekolah Tinggi Ilmu Ekonomi YAI', NULL, NULL),
(101, '033032', 'Sekolah Tinggi Ilmu Ekonomi Kusuma Negara', NULL, NULL),
(102, '033034', 'STMIK Kuwera', NULL, NULL),
(103, '033038', 'Sekolah Tinggi Ilmu Ekonomi Bhakti Pembangunan', NULL, NULL),
(104, '033040', 'Sekolah Tinggi Ilmu Ekonomi Tri Dharma Widya', NULL, NULL),
(105, '033044', 'Sekolah Tinggi Ilmu Ekonomi Nasional Indonesia', NULL, NULL),
(106, '033046', 'Sekolah Tinggi Teknologi Indonesia', NULL, NULL),
(107, '033059', 'Sekolah Tinggi Ilmu Ekonomi Jayakarta', NULL, NULL),
(108, '033060', 'Sekolah Tinggi Ilmu Ekonomi Bisnis Indonesia', NULL, NULL),
(109, '033064', 'Sekolah Tinggi Manajemen Labora', NULL, NULL),
(110, '033066', 'Sekolah Tinggi Ilmu Ekonomi Trisakti', NULL, NULL),
(111, '033068', 'Sekolah Tinggi Manajemen Ipmi', NULL, NULL),
(112, '033069', 'Sekolah Tinggi Manajemen Ppm', NULL, NULL),
(113, '033070', 'Sekolah Tinggi Penerbangan Aviasi', NULL, NULL),
(114, '033072', 'Sekolah Tinggi Ilmu Ekonomi IGI', NULL, NULL),
(115, '033073', 'Sekolah Tinggi Ilmu Hukum IBLAM', NULL, NULL),
(116, '033076', 'Sekolah Tinggi Ilmu Ekonomi Ganesha', NULL, NULL),
(117, '033077', 'Sekolah Tinggi Manajemen Immi', NULL, NULL),
(118, '033080', 'STMIK Jayakarta', NULL, NULL),
(119, '033082', 'STIE Jakarta International College', NULL, NULL),
(120, '033086', 'Sekolah Tinggi Ilmu Ekonomi Taman Siswa', NULL, NULL),
(121, '033087', 'Sekolah Tinggi Ilmu Ekonomi Trianandra', NULL, NULL),
(122, '033094', 'Sekolah Tinggi Perpajakan Indonesia', NULL, NULL),
(123, '033106', 'Sekolah Tinggi Ilmu Komunikasi Inter Studi', NULL, NULL),
(124, '033107', 'Sekolah Tinggi Ilmu Ekonomi Tunas Nusantara', NULL, NULL),
(125, '033111', 'Sekolah Tinggi Bahasa Asing LIA', NULL, NULL),
(126, '033114', 'Sekolah Tinggi Pariwisata Trisakti', NULL, NULL),
(127, '033115', 'STIE Pengembangan Bisnis Dan Manajemen', NULL, NULL),
(128, '033117', 'Sekolah Tinggi Ilmu Kesehatan Sint Carolus', NULL, NULL),
(129, '033119', 'Sekolah Tinggi Ilmu Ekonomi Jayakusuma', NULL, NULL),
(130, '033120', 'Sekolah Tinggi Ilmu Ekonomi Kasih Bangsa', NULL, NULL),
(131, '033121', 'Sekolah Tinggi Ilmu Ekonomi Dharma Bumi Putra', NULL, NULL),
(132, '033125', 'Sekolah Tinggi Ilmu Ekonomi Maiji', NULL, NULL),
(133, '033126', 'Sekolah Tinggi Ilmu Ekonomi Wiyatamandala', NULL, NULL),
(134, '033128', 'Sekolah Tinggi Ilmu Ekonomi YPBI', NULL, NULL),
(135, '033136', 'Sekolah Tinggi Teknologi 10 November', NULL, NULL),
(136, '033137', 'Sekolah Tinggi Bahasa Asing IEC Jakarta', NULL, NULL),
(137, '033138', 'Sekolah Tinggi Ilmu Maritim Ami', NULL, NULL),
(138, '033139', 'Sekolah Tinggi Ilmu Kesehatan Pamentas', NULL, NULL),
(139, '033140', 'STMIK Widuri', NULL, NULL),
(140, '033143', 'Sekolah Tinggi Manajemen Transportasi Malahayati', NULL, NULL),
(141, '033147', 'Sekolah Tinggi Ilmu Kesehatan Istara Nusantara', NULL, NULL),
(142, '033150', 'St Ilmu Komputer Cipta Karya Informatika', NULL, NULL),
(143, '033151', 'Sekolah Tinggi Ilmu Komunikasi ITKP', NULL, NULL),
(144, '033152', 'Sekolah Tinggi Manajemen Asuransi Trisakti', NULL, NULL),
(145, '033154', 'Sekolah Tinggi Ilmu Komunikasi Profesi Indonesia', NULL, NULL),
(146, '033156', 'Sekolah Tinggi Ilmu Kesehatan Medistra Indonesia', NULL, NULL),
(147, '033157', 'Sekolah Tinggi Ilmu Ekonomi Widya Persada', NULL, NULL),
(148, '033160', 'Sekolah Tinggi Teknologi Sapta Taruna', NULL, NULL),
(149, '033167', 'STIKES Kesetiakawanan Sosial Indonesia', NULL, NULL),
(150, '033168', 'STIE Indonesia Banking School', NULL, NULL),
(151, '033170', 'STIKES Persada Husada Indonesia', NULL, NULL),
(152, '033171', 'Sekolah Tinggi Ilmu Kesehatan Mitra Ria Husada Jakarta', NULL, NULL),
(153, '033173', 'Sekolah Tinggi Ilmu Kesehatan Abdi Nusantara', NULL, NULL),
(154, '033175', 'Sekolah Tinggi Teknologi Informasi NIIT', NULL, NULL),
(155, '033176', 'Sekolah Tinggi Manajemen Risiko Dan Asuransi', NULL, NULL),
(156, '033177', 'Sekolah Tinggi Ilmu Pemerintahan Abdi Negara', NULL, NULL),
(157, '033182', 'STIBA Indonesia LPI', NULL, NULL),
(158, '033183', 'Sekolah Tinggi Ilmu Ekonomi Santa Ursula', NULL, NULL),
(159, '033184', 'Sekolah Tinggi Desain Interstudi', NULL, NULL),
(160, '033188', 'STIE Unisadhuguna', NULL, NULL),
(161, '033189', 'Sekolah Tinggi Internasional Konservatori Musik Indonesia', NULL, NULL),
(162, '033190', 'Sekolah Tinggi Ilmu Kesehatan Pertamedika', NULL, NULL),
(163, '033192', 'Sekolah Tinggi Ilmu Kesehatan Sismadi', NULL, NULL),
(164, '033194', 'Sekolah Tinggi Ilmu Komunikasi dan Sekretari Tarakanita', NULL, NULL),
(165, '033195', 'Sekolah Tinggi Media Komunikasi Trisakti', NULL, NULL),
(166, '033198', 'STMIK Islam Internasional', NULL, NULL),
(167, '033199', 'Sekolah Tinggi Desain LaSalle', NULL, NULL),
(168, '033200', 'STIKES Bhakti Pertiwi Indonesia', NULL, NULL),
(169, '033203', 'Sekolah Tinggi Ilmu Ekonomi BPKP', NULL, NULL),
(170, '033205', 'Sekolah Tinggi Kepemerintahan dan Kebijakan Publik', NULL, NULL),
(171, '033206', 'Sekolah Tinggi Ilmu Manajemen dan Ilmu Komputer ESQ', NULL, NULL),
(172, '033208', 'STIH Indonesia Jentera', NULL, NULL),
(173, '033209', 'Sekolah Tinggi Ilmu Kesehatan Mitra Keluarga', NULL, NULL),
(174, '033210', 'STIH Litigasi', NULL, NULL),
(175, '033211', 'Sekolah Tinggi Ilmu Manajemen Saint Mary', NULL, NULL),
(176, '033214', 'Sekolah Tinggi Ilmu Kesehatan Tarumanagara', NULL, NULL),
(177, '033215', 'Sekolah Tinggi Ilmu Kesehatan Budi Kemuliaan', NULL, NULL),
(178, '033216', 'Sekolah Tinggi Manajemen Informatika dan Komputer Indo Daya Suvan', NULL, NULL),
(179, '033217', 'Sekolah Tinggi Ilmu Kesehatan RS Husada', NULL, NULL),
(180, '033219', 'Sekolah Tinggi Ilmu Kesehatan IKIFA', NULL, NULL),
(181, '033220', 'Sekolah Tinggi Ilmu Kesehatan RSPAD Gatot Soebroto', NULL, NULL),
(182, '033221', 'Sekolah Tinggi Ilmu Kesehatan Fatmawati', NULL, NULL),
(183, '033222', 'Sekolah Tinggi Ilmu Hukum Profesor Gayus Lumbuun', NULL, NULL),
(184, '033223', 'Sekolah Tinggi Ilmu Hukum Adhyaksa', NULL, NULL),
(185, '033224', 'Sekolah Tinggi Ilmu Kesehatan Sumber Waras', NULL, NULL),
(186, '034004', 'Akademi Akuntansi Borobudur', NULL, NULL),
(187, '034006', 'Akademi Akuntansi Artawiyata Indo-lpi', NULL, NULL),
(188, '034008', 'Akademi Akuntansi Jayabaya', NULL, NULL),
(189, '034011', 'Akademi Akuntansi YAI Jakarta', NULL, NULL),
(190, '034013', 'Akademi Bahasa Asing Borobudur', NULL, NULL),
(191, '034019', 'Akademi Keuangan Dan Perbankan LPI', NULL, NULL),
(192, '034024', 'Akademi Teknologi Grafika Indonesia Jakarta', NULL, NULL),
(193, '034030', 'Akademi Maritim Nasional Jaya', NULL, NULL),
(194, '034032', 'Akademi Manajemen Perusahaan Jayabaya', NULL, NULL),
(195, '034033', 'Akademi Keuangan Dan Perbankan Borobudur', NULL, NULL),
(196, '034036', 'Akademi Perawatan RS PGI Cikini', NULL, NULL),
(197, '034050', 'Akademi Bahasa Asing Nasional Jakarta', NULL, NULL),
(198, '034058', 'Akademi Maritim Djadajat', NULL, NULL),
(199, '034083', 'Akademi Seni Rupa Dan Desain ISWI Jakarta', NULL, NULL),
(200, '034091', 'Akademi Bahasa Asing Saint Mary', NULL, NULL),
(201, '034095', 'Akademi Kimia Analis Caraka Nusantara', NULL, NULL),
(202, '034099', 'Akademi Bahasa Asing Santa Ursula', NULL, NULL),
(203, '034102', 'Akademi Pariwisata Nusantara Jaya', NULL, NULL),
(204, '034103', 'Akademi Pariwisata Paramitha Jakarta', NULL, NULL),
(205, '034105', 'Akademi Sekretari Dan Manajemen Don Bosco', NULL, NULL),
(206, '034109', 'Akademi Pariwisata Patria Indonesia', NULL, NULL),
(207, '034112', 'Akademi Komunikasi Media Radio Dan TV Jakarta', NULL, NULL),
(208, '034118', 'Akademi Televisi Indonesia', NULL, NULL),
(209, '034119', 'Akademi Telekomunikasi Indonesia Gemilang', NULL, NULL),
(210, '034120', 'Akademi Pariwisata Jakarta', NULL, NULL),
(211, '034121', 'Akademi Maritim Pembangunan Jakarta', NULL, NULL),
(212, '034129', 'AMIK Mpu Tantular', NULL, NULL),
(213, '034130', 'Akademi Pariwisata Gsp Internasional', NULL, NULL),
(214, '034134', 'Akademi Pariwisata Saint Mary', NULL, NULL),
(215, '034135', 'Akademi Sekretari Interstudi', NULL, NULL),
(216, '034136', 'Akademi Sekretari &amp; Manajemen Dharma Budhi Bhakti', NULL, NULL),
(217, '034139', 'Akademi Kebidanan Keris Husada', NULL, NULL),
(218, '034140', 'Akademi Keperawatan Keris Husada', NULL, NULL),
(219, '034141', 'AMIK Laksi-31', NULL, NULL),
(220, '034142', 'Akademi Kebidanan Al-Fathonah', NULL, NULL),
(221, '034145', 'Akademi Sekretari Saint Theresia', NULL, NULL),
(222, '034147', 'Akademi Teknik Informatika Tunas Bangsa', NULL, NULL),
(223, '034154', 'Akademi Kebidanan Pelita Persada', NULL, NULL),
(224, '034157', 'Akademi Kebidanan Suluh Bangsa', NULL, NULL),
(225, '034160', 'Akademi Kebidanan Sismadi', NULL, NULL),
(226, '034163', 'Akademi Kebidanan YPDR', NULL, NULL),
(227, '034167', 'Akademi Kebidanan Prestasi Agung', NULL, NULL),
(228, '034168', 'Akademi Komunikasi SAE Indonesia', NULL, NULL),
(229, '034169', 'Akademi Kebidanan Mitra Persahabatan', NULL, NULL),
(230, '034170', 'Akademi Kebidanan Yaspen Tugu Ibu', NULL, NULL),
(231, '034175', 'Akademi Kebidanan Farama Mulya', NULL, NULL),
(232, '034178', 'Akademi Keperawatan Pasar Rebo Jakarta', NULL, NULL),
(233, '034179', 'Akademi Keperawatan Yaspen Jakarta', NULL, NULL),
(234, '034180', 'Akademi Keperawatan RSP TNI-AU Jakarta', NULL, NULL),
(235, '034186', 'Akademi Keperawatan Hermina Manggala Husada', NULL, NULL),
(236, '034187', 'Akademi Keperawatan Berkala Widya Husada', NULL, NULL),
(237, '034191', 'Akademi Keperawatan Harum', NULL, NULL),
(238, '034194', 'Akademi Pariwisata Sinar Surya', NULL, NULL),
(239, '034195', 'Akademi Perekam Medis Dan Infokes Bhumi Husada', NULL, NULL),
(240, '034197', 'Akademi Farmasi Bhumi Husada', NULL, NULL),
(241, '034199', 'Akademi Refraksi Optisi Kartika Indera Persada', NULL, NULL),
(242, '034202', 'Akademi Farmasi Mahadhika', NULL, NULL),
(243, '034206', 'Akademi Audiologi Indonesia Jakarta', NULL, NULL),
(244, '034208', 'Akademi Terapi Wicara', NULL, NULL),
(245, '034209', 'Akademi Keperawatan Bina Insan Jakarta', NULL, NULL),
(246, '034210', 'Akademi Keperawatan POLRI', NULL, NULL),
(247, '034211', 'Akademi Keperawatan Husada Karya Jaya', NULL, NULL),
(248, '034213', 'Akademi Pariwisata Bhakti Nusantara', NULL, NULL),
(249, '034223', 'Akademi Keperawatan Pelni', NULL, NULL),
(250, '034225', 'Akademi Kesehatan Gigi Ditkesad Jakarta', NULL, NULL),
(251, '034226', 'Akademi Keperawatan Andalusia Jakarta', NULL, NULL),
(252, '034227', 'Akademi Kesehatan Lingkungan Andalusia', NULL, NULL),
(253, '034228', 'Akademi Gizi Andalusia', NULL, NULL),
(254, '034229', 'Akademi Keperawatan YPDR', NULL, NULL),
(255, '034230', 'Akademi Refraksi Optisi dan Optometry Gapopin', NULL, NULL),
(256, '034231', 'Akademi Keperawatan Antariksa', NULL, NULL),
(257, '034234', 'Akademi Teknik Radiodiagnostik dan Radioterapi Nusantara', NULL, NULL),
(258, '034235', 'Akademi Keperawatan Yayasan Dharma Bhakti Jakarta', NULL, NULL),
(259, '034237', 'Akademi Refraksi Optisi Leprindo Jakarta', NULL, NULL),
(260, '034239', 'Akademi Keperawatan Andakara', NULL, NULL),
(261, '034240', 'Akademi Teknik Elektromedik Andakara', NULL, NULL),
(262, '034241', 'Akademi Bakti Kemanusiaan Palang Merah Indonesia', NULL, NULL),
(263, '034242', 'Akademi Olahraga Prestasi Nasional', NULL, NULL),
(264, '034243', 'Akademi Kesehatan Yayasan Rumah Sakit Jakarta', NULL, NULL),
(265, '035004', 'Politeknik Bunda Kandung', NULL, NULL),
(266, '035006', 'Politeknik Tugu Jakarta', NULL, NULL),
(267, '035008', 'Politeknik LP3I Jakarta', NULL, NULL),
(268, '035010', 'Politeknik Karya Husada', NULL, NULL),
(269, '035012', 'Politeknik Soca', NULL, NULL),
(270, '035013', 'Politeknik Orang Tua', NULL, NULL),
(271, '035014', 'Politeknik Bentara Citra Bangsa', NULL, NULL),
(272, '035015', 'Politeknik Bisnis dan Pasar Modal', NULL, NULL),
(273, '035016', 'Politeknik Sahid', NULL, NULL),
(274, '035017', 'Politeknik Hang Tuah Jakarta', NULL, NULL),
(275, '035018', 'Politeknik Jakarta Internasional', NULL, NULL),
(276, '035019', 'Politeknik Kesehatan Hermina', NULL, NULL),
(277, '035020', 'Politeknik Tempo', NULL, NULL),
(278, '035021', 'Politeknik Astra', NULL, NULL),
(279, '035022', 'Politeknik Multimedia Nusantara', NULL, NULL),
(280, '035023', 'Politeknik Kartini Jakarta', NULL, NULL),
(281, '035024', 'Politeknik Kreatif Indonesia', NULL, NULL),
(282, '036001', 'Akademi Komunitas Kosmetik Ristra', NULL, NULL),
(283, '036002', 'Akademi Komunitas Bisnis Internasional', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_11_071935_create_visitor_table', 1),
(6, '2023_03_11_072147_create_cases_table', 1),
(7, '2023_03_11_073259_create_samples_table', 1),
(8, '2023_03_11_073856_create_viruses_table', 1),
(9, '2023_03_11_074131_create_authors_table', 1),
(10, '2023_03_11_074428_create_genotipes_table', 1),
(11, '2023_03_11_075332_add_foreign_key_samples', 1),
(12, '2023_03_11_075638_add_foreign_key_genotipes', 1),
(13, '2023_03_11_111736_update_sequence_date_samples', 1),
(14, '2023_03_11_112608_add_virus_code_samples', 1),
(15, '2023_03_11_212457_create_citations_table', 1),
(16, '2023_03_11_225736_create_institutions_table', 1),
(17, '2023_03_11_230421_add_foreign_authors', 1),
(18, '2023_03_12_003759_add_is_active_column_author', 2),
(19, '2023_03_12_011538_add_is_active_column_viruses', 3),
(20, '2023_03_12_235839_add_is_active_column_genotipe', 4),
(21, '2023_03_13_062821_create_transmission_table', 5),
(23, '2023_03_13_070931_update_name_transmission', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `samples`
--

CREATE TABLE `samples` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sample_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viruses_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gene_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sequence_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subdistrict` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `authors_id` bigint(20) UNSIGNED DEFAULT NULL,
  `genotipes_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `virus_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transmissions`
--

CREATE TABLE `transmissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transmissions`
--

INSERT INTO `transmissions` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sexual Activities', 1, '2023-03-12 23:48:42', '2023-03-12 23:56:25'),
(2, 'Injected Drugs', 1, '2023-03-12 23:49:58', '2023-03-12 23:49:58'),
(3, 'Perinatal', 0, '2023-03-12 23:50:08', '2023-03-12 23:59:02'),
(9, 'Perinatal', 1, '2023-03-13 00:19:11', '2023-03-13 00:19:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google_id`, `role`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Fiki', 'fiki@gmail.com', NULL, '$2y$10$2nCOPj3dOvC82XUoPeZRCOu8Vn.rozM4Oe6DxFrVYWcot4q2ODZEO', NULL, 'user', NULL, NULL, '2023-03-11 16:11:39', '2023-03-11 16:11:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `viruses`
--

CREATE TABLE `viruses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `viruses`
--

INSERT INTO `viruses` (`id`, `image`, `name`, `latin_name`, `description`, `created_at`, `updated_at`, `is_active`) VALUES
(1, '1678589383.jpg', 'HIV', 'Human Immunodeficiency Virus', '<p>The first 2-4 weeks after being infected with HIV, you may feel&nbsp;<strong>feverish, achy, and sick</strong>. These flu-like symptoms are your body&#39;s first reaction to the HIV infection. During this time, there&#39;s a lot of the virus in your system, so it&#39;s really easy to spread HIV to other people</p>\r\n\r\n<p>The human immunodeficiency viruses are two species of Lentivirus that infect humans. Over time, they cause acquired immunodeficiency syndrome, a condition in which progressive failure of the immune system allows life-threatening opportunistic infections and cancers to thrive.</p>', NULL, '2023-03-11 19:49:43', 1),
(2, NULL, 'Hepatitis B', 'Hepatitis B Virus', 'Hepatitis B is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(3, NULL, 'Hepatitis C', 'Hepatitis C Virus', 'Hepatitis C is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(4, NULL, 'Hepatitis D', 'Hepatitis D Virus', 'Hepatitis D is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(5, NULL, 'Hepatitis E', 'Hepatitis E Virus', 'Hepatitis E is a virus that causes inflammation of the liver. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(6, NULL, 'Influenza', 'Influenza Virus', 'Influenza is a virus that causes an infection of the nose, throat, and lungs. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(7, NULL, 'Mumps', 'Mumps Virus', 'Mumps is a virus that causes an infection of the salivary glands. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(8, NULL, 'Measles', 'Measles Virus', 'Measles is a virus that causes an infection of the nose, throat, and lungs. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(9, NULL, 'Meningitis', 'Meningitis Virus', 'Meningitis is a virus that causes an infection of the nose, throat, and lungs. It is spread through contact with infected blood or body fluids.', NULL, NULL, 1),
(10, '1678587635.jpg', 'Zombie', 'Pithovirus Sibericum', '<p>Even death won&rsquo;t stop this virus from replicating! Learn all about this fascinating virus that attacks other microbes, bends them to their will and starts using them as replication labs. This adorable plush representation of a real virus discovery, provides a fun, hands-on-way to learn science and explore the wonderful world of microbiology.</p>\r\n\r\n<p>A unique, memorable and exciting gift for scientists, educators, students, family and anyone who is obsessed with all things Zombies. Features detailed stitching, unique design and an educational printed card with fascinating facts about this incredible virus.</p>', '2023-03-11 19:20:36', '2023-03-11 20:03:02', 0),
(11, '1678587831.jpg', 'Virus fiki', 'Fikination', '<p>Asal usul wabah zombi biasanya berupa&nbsp;<strong>kontaminasi radioaktif, bahan beracun yang membuat mati otak, ilmu hitam, voodoo, makhluk angkasa luar, infeksi virus dan berbagai macam sebab lain</strong></p>', '2023-03-11 19:23:51', '2023-03-11 19:23:51', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `visitors`
--

CREATE TABLE `visitors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `user_agent`, `date`, `created_at`, `updated_at`) VALUES
(1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-03-12', '2023-03-11 18:03:50', '2023-03-11 18:03:50'),
(2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-03-12', '2023-03-11 18:49:27', '2023-03-11 18:49:27'),
(3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-03-13', '2023-03-12 23:21:06', '2023-03-12 23:21:06'),
(4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36', '2023-03-13', '2023-03-12 23:21:15', '2023-03-12 23:21:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `authors_name_unique` (`name`),
  ADD KEY `authors_institutions_id_foreign` (`institutions_id`);

--
-- Indeks untuk tabel `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `citations`
--
ALTER TABLE `citations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citations_samples_id_foreign` (`samples_id`),
  ADD KEY `citations_users_id_foreign` (`users_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `genotipes`
--
ALTER TABLE `genotipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genotipes_viruses_id_foreign` (`viruses_id`);

--
-- Indeks untuk tabel `institutions`
--
ALTER TABLE `institutions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `samples`
--
ALTER TABLE `samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `samples_viruses_id_foreign` (`viruses_id`),
  ADD KEY `samples_authors_id_foreign` (`authors_id`),
  ADD KEY `samples_genotipes_id_foreign` (`genotipes_id`);

--
-- Indeks untuk tabel `transmissions`
--
ALTER TABLE `transmissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `viruses`
--
ALTER TABLE `viruses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `viruses_name_unique` (`name`),
  ADD UNIQUE KEY `viruses_latin_name_unique` (`latin_name`);

--
-- Indeks untuk tabel `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `cases`
--
ALTER TABLE `cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `citations`
--
ALTER TABLE `citations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `genotipes`
--
ALTER TABLE `genotipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `institutions`
--
ALTER TABLE `institutions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `samples`
--
ALTER TABLE `samples`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transmissions`
--
ALTER TABLE `transmissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `viruses`
--
ALTER TABLE `viruses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `authors_institutions_id_foreign` FOREIGN KEY (`institutions_id`) REFERENCES `institutions` (`id`);

--
-- Ketidakleluasaan untuk tabel `citations`
--
ALTER TABLE `citations`
  ADD CONSTRAINT `citations_samples_id_foreign` FOREIGN KEY (`samples_id`) REFERENCES `samples` (`id`),
  ADD CONSTRAINT `citations_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `genotipes`
--
ALTER TABLE `genotipes`
  ADD CONSTRAINT `genotipes_viruses_id_foreign` FOREIGN KEY (`viruses_id`) REFERENCES `viruses` (`id`);

--
-- Ketidakleluasaan untuk tabel `samples`
--
ALTER TABLE `samples`
  ADD CONSTRAINT `samples_authors_id_foreign` FOREIGN KEY (`authors_id`) REFERENCES `authors` (`id`),
  ADD CONSTRAINT `samples_genotipes_id_foreign` FOREIGN KEY (`genotipes_id`) REFERENCES `genotipes` (`id`),
  ADD CONSTRAINT `samples_viruses_id_foreign` FOREIGN KEY (`viruses_id`) REFERENCES `viruses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
