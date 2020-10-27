
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ntt_resonant`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_lock`
--

CREATE TABLE `account_lock` (
  `error_max_count` tinyint(2) NOT NULL DEFAULT 0,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `admin_user_seq` tinyint(3) NOT NULL,
  `admin_user_id` varchar(10) NOT NULL,
  `admin_user_name` varchar(100) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未削除、1：削除',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `article_id` int(10) UNSIGNED NOT NULL,
  `wb_book_seq` int(11) NOT NULL COMMENT 'w_bookstoreの同項目',
  `title` varchar(255) NOT NULL,
  `wrap_up` text DEFAULT NULL,
  `wb_book_seq_wrap_up` int(11) DEFAULT NULL COMMENT 'w_bookstoreの同項目（要約）',
  `letter_body` text DEFAULT NULL,
  `issue_date` date NOT NULL,
  `page` tinyint(3) NOT NULL,
  `booklet_class_id` tinyint(3) DEFAULT NULL,
  `article_type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：個別の論稿、1：1冊のブック（紹介ページでの表示対象',
  `search_target_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：検索対象外、1：1検索対象',
  `not_viewable_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：閲覧可、1：閲覧不可',
  `release_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：公開不可、1：公開可',
  `access_count_1` tinyint(6) NOT NULL DEFAULT 0 COMMENT 'Wisebookからバッチで持ってくる',
  `access_count_2` tinyint(6) NOT NULL DEFAULT 0 COMMENT 'Wisebookからバッチで持ってくる',
  `access_count_3` tinyint(6) NOT NULL DEFAULT 0 COMMENT 'Wisebookからバッチで持ってくる',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未削除、1：削除',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_access`
--

CREATE TABLE `article_access` (
  `article_access_id` int(10) UNSIGNED NOT NULL,
  `wb_book_seq` int(11) NOT NULL COMMENT 'w_bookstoreの同項目',
  `access_date` date NOT NULL,
  `access_count` tinyint(6) NOT NULL,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_article_class`
--

CREATE TABLE `article_article_class` (
  `article_article_class_id` int(10) UNSIGNED NOT NULL,
  `article_id` int(10) UNSIGNED NOT NULL,
  `article_class_id` int(3) UNSIGNED NOT NULL,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_author`
--

CREATE TABLE `article_author` (
  `article_author_id` int(10) UNSIGNED NOT NULL,
  `article_id` int(10) UNSIGNED NOT NULL,
  `author_id` int(6) UNSIGNED NOT NULL,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_class`
--

CREATE TABLE `article_class` (
  `article_class_id` int(3) UNSIGNED NOT NULL,
  `article_class_name` varchar(100) NOT NULL,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `article_topics`
--

CREATE TABLE `article_topics` (
  `article_topics_id` int(10) UNSIGNED NOT NULL,
  `article_id` int(10) UNSIGNED NOT NULL,
  `topics_id` int(6) UNSIGNED NOT NULL,
  `manual_input_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：自動生成、1：手入力（検索データ登録画面で登録）',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `author_id` int(6) UNSIGNED NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_alp` varchar(128) DEFAULT NULL COMMENT 'アルファベット併記用。将来実装見越して。',
  `author_phonetic` varchar(100) NOT NULL COMMENT '検索時の50音並びなどで仕様するため必須',
  `author_type` int(3) UNSIGNED DEFAULT NULL COMMENT '司会、評者などの分類が発生した場合に使用する。',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未削除、1：削除',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `booklet_class`
--

CREATE TABLE `booklet_class` (
  `booklet_class_id` int(3) UNSIGNED NOT NULL,
  `booklet_class_name` varchar(100) NOT NULL,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `committee_member`
--

CREATE TABLE `committee_member` (
  `committee_member_seq` tinyint(3) NOT NULL,
  `committee_member_id` varchar(10) NOT NULL,
  `committee_member_name` varchar(100) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `contact_information` varchar(100) DEFAULT NULL,
  `acount_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：非ロック、1：ロック中',
  `acount_lock_date` datetime DEFAULT NULL COMMENT 'アカウントがロックされた日時',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未削除、1：削除',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `contents_id` int(10) UNSIGNED NOT NULL,
  `publish_year` varchar(4) NOT NULL,
  `publish_month` varchar(2) NOT NULL,
  `publish_volume` varchar(4) DEFAULT NULL,
  `publish_issue` varchar(16) DEFAULT NULL,
  `order_no` tinyint(3) DEFAULT NULL,
  `contents_classification` varchar(2) DEFAULT NULL COMMENT '見出しの装飾区分',
  `caption` varchar(500) DEFAULT NULL,
  `author_name` varchar(500) DEFAULT NULL,
  `page` tinyint(3) DEFAULT NULL,
  `article_id` int(10) UNSIGNED DEFAULT NULL,
  `issue_date` date NOT NULL COMMENT '公開を判定する日付',
  `release_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：公開不可、1：公開可',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `journal_user`
--

CREATE TABLE `journal_user` (
  `journal_user_id` int(10) UNSIGNED NOT NULL,
  `member_id` varchar(128) NOT NULL,
  `member_classification` tinyint(1) NOT NULL COMMENT '1:会員２:委員会',
  `first_login_chk` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未ログイン、1：ログイン済み。1度1を入れた場合は上書きしない',
  `last_login_date` datetime NOT NULL COMMENT '最終ログイン日時を記録する',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `journal_user_topics`
--

CREATE TABLE `journal_user_topics` (
  `journal_user_topics_id` int(10) UNSIGNED NOT NULL,
  `journal_user_id` int(10) UNSIGNED NOT NULL,
  `topics_id` int(6) UNSIGNED NOT NULL,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `read_article`
--

CREATE TABLE `read_article` (
  `read_article_seq` int(10) UNSIGNED NOT NULL,
  `journal_user_id` int(10) UNSIGNED NOT NULL,
  `article_id` int(10) UNSIGNED NOT NULL,
  `read_flag` tinyint(1) NOT NULL COMMENT '未読:0　既読:1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `related_keywords`
--

CREATE TABLE `related_keywords` (
  `related_keyword_id` tinyint(6) UNSIGNED NOT NULL,
  `topics_id` tinyint(6) NOT NULL,
  `related_keywords_name` varchar(100) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未削除、1：削除',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topics_id` int(6) UNSIGNED NOT NULL,
  `topics_name` varchar(100) NOT NULL,
  `topics_phonetic` varchar(100) NOT NULL COMMENT 'GSS検索',
  `display_order` tinyint(3) NOT NULL,
  `cutline` tinyint(3) DEFAULT NULL COMMENT '論稿が該当のトピックスに属するかの閾値',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0：未削除、1：削除',
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`admin_user_seq`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `article_access`
--
ALTER TABLE `article_access`
  ADD PRIMARY KEY (`article_access_id`);

--
-- Indexes for table `article_article_class`
--
ALTER TABLE `article_article_class`
  ADD PRIMARY KEY (`article_article_class_id`);

--
-- Indexes for table `article_author`
--
ALTER TABLE `article_author`
  ADD PRIMARY KEY (`article_author_id`);

--
-- Indexes for table `article_class`
--
ALTER TABLE `article_class`
  ADD PRIMARY KEY (`article_class_id`);

--
-- Indexes for table `article_topics`
--
ALTER TABLE `article_topics`
  ADD PRIMARY KEY (`article_topics_id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `booklet_class`
--
ALTER TABLE `booklet_class`
  ADD PRIMARY KEY (`booklet_class_id`);

--
-- Indexes for table `committee_member`
--
ALTER TABLE `committee_member`
  ADD PRIMARY KEY (`committee_member_seq`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`contents_id`);

--
-- Indexes for table `journal_user`
--
ALTER TABLE `journal_user`
  ADD PRIMARY KEY (`journal_user_id`,`member_id`,`member_classification`);

--
-- Indexes for table `journal_user_topics`
--
ALTER TABLE `journal_user_topics`
  ADD PRIMARY KEY (`journal_user_topics_id`);

--
-- Indexes for table `read_article`
--
ALTER TABLE `read_article`
  ADD PRIMARY KEY (`read_article_seq`);

--
-- Indexes for table `related_keywords`
--
ALTER TABLE `related_keywords`
  ADD PRIMARY KEY (`related_keyword_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topics_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `article_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_access`
--
ALTER TABLE `article_access`
  MODIFY `article_access_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_article_class`
--
ALTER TABLE `article_article_class`
  MODIFY `article_article_class_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_author`
--
ALTER TABLE `article_author`
  MODIFY `article_author_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_class`
--
ALTER TABLE `article_class`
  MODIFY `article_class_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_topics`
--
ALTER TABLE `article_topics`
  MODIFY `article_topics_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `author_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booklet_class`
--
ALTER TABLE `booklet_class`
  MODIFY `booklet_class_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `contents_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_user_topics`
--
ALTER TABLE `journal_user_topics`
  MODIFY `journal_user_topics_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `read_article`
--
ALTER TABLE `read_article`
  MODIFY `read_article_seq` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `related_keywords`
--
ALTER TABLE `related_keywords`
  MODIFY `related_keyword_id` tinyint(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topics_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- 2020/10/02

CREATE TABLE `member_session` (
  `member_session_id` int(10) UNSIGNED NOT NULL,
  `journal_user_id` int(10) UNSIGNED NOT NULL,
  `assoc_token` varchar(30) NOT NULL,
  `id_token` varchar(30) NOT NULL,
  `linked_flag` tinyint(1) NOT NULL COMMENT '0：未連携、1：連携済み',
  `created_at` datetime NULL DEFAULT NULL ,
  `updated_at` datetime NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `member_session`
  ADD PRIMARY KEY (`member_session_id`);
ALTER TABLE `member_session`
  MODIFY `member_session_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
