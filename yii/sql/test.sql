-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 06 2020 г., 21:41
-- Версия сервера: 10.0.38-MariaDB
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access`
--

CREATE TABLE `access` (
  `id` int(11) NOT NULL,
  `taxon_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', NULL),
('nonactive', '2', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, NULL, NULL),
('canAdmin', 2, NULL, NULL, NULL, NULL, NULL),
('canEdit', 2, NULL, NULL, NULL, NULL, NULL),
('canEditUser', 2, NULL, 'canEdit', NULL, NULL, NULL),
('canOwnProfile', 2, NULL, 'isOwner', NULL, NULL, NULL),
('canProfile', 2, NULL, NULL, NULL, NULL, NULL),
('guest', 1, NULL, NULL, NULL, NULL, NULL),
('nonactive', 1, NULL, NULL, NULL, NULL, NULL),
('user', 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'canAdmin'),
('admin', 'canEdit'),
('admin', 'canProfile'),
('canEditUser', 'canEdit'),
('canOwnProfile', 'canProfile'),
('user', 'canEditUser'),
('user', 'canOwnProfile');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('canEdit', 0x4f3a32303a22636f6d6d6f6e5c726261635c4564697452756c65223a333a7b733a343a226e616d65223b733a373a2263616e45646974223b733a393a22637265617465644174223b693a313538373731363331353b733a393a22757064617465644174223b693a313538373731363331353b7d, 1587716315, 1587716315),
('isOwner', 0x4f3a32333a22636f6d6d6f6e5c726261635c50726f66696c6552756c65223a333a7b733a343a226e616d65223b733a373a2269734f776e6572223b733a393a22637265617465644174223b693a313538373632363132363b733a393a22757064617465644174223b693a313538373632363132363b7d, 1587626126, 1587626126);

-- --------------------------------------------------------

--
-- Структура таблицы `collection`
--

CREATE TABLE `collection` (
  `id` int(11) NOT NULL,
  `sample_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `container`
--

CREATE TABLE `container` (
  `containerId` varchar(255) NOT NULL,
  `containerType` varchar(255) DEFAULT NULL,
  `prepType` varchar(255) DEFAULT NULL,
  `fixative` varchar(255) DEFAULT NULL,
  `storage` int(11) DEFAULT NULL,
  `containerStatus` tinyint(1) NOT NULL DEFAULT '1',
  `date` date DEFAULT NULL,
  `comment` varchar(2000) DEFAULT NULL,
  `parId` varchar(255) DEFAULT NULL,
  `isDeleted` tinyint(1) DEFAULT '0',
  `createdBy` int(11) DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `createdAt` int(11) DEFAULT NULL,
  `editedAt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `host`
--

CREATE TABLE `host` (
  `occurrenceID` varchar(30) NOT NULL,
  `sciName` int(11) NOT NULL DEFAULT '0',
  `sex` int(4) DEFAULT NULL,
  `age` int(4) DEFAULT NULL,
  `natureOfRecord` int(4) DEFAULT NULL,
  `placeName` int(11) DEFAULT '0',
  `occurenceDate` date DEFAULT NULL,
  `sAIAB_Catalog_Number` varchar(20) DEFAULT NULL,
  `idConfidence` int(3) DEFAULT '0',
  `comments` varchar(2000) DEFAULT NULL,
  `determiner` int(11) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL DEFAULT '0',
  `updatedBy` int(11) NOT NULL DEFAULT '0',
  `createdAt` int(11) NOT NULL DEFAULT '0',
  `editedAt` int(11) NOT NULL DEFAULT '0',
  `isDeleted` int(1) DEFAULT '0',
  `isEmpty` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `oldName` varchar(250) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL DEFAULT '0',
  `updatedBy` int(5) NOT NULL DEFAULT '0',
  `createdBy` int(5) NOT NULL DEFAULT '0',
  `createdAt` int(11) NOT NULL DEFAULT '0',
  `editedAt` int(11) NOT NULL DEFAULT '0',
  `parId` varchar(30) NOT NULL DEFAULT '0',
  `md5` varchar(32) NOT NULL DEFAULT '0',
  `isDeleted` bit(1) NOT NULL DEFAULT b'0',
  `table_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `locality`
--

CREATE TABLE `locality` (
  `id` int(11) NOT NULL,
  `localityName` varchar(255) DEFAULT NULL,
  `province` int(7) DEFAULT NULL,
  `country` int(4) DEFAULT NULL,
  `decimalLatitude` int(8) DEFAULT NULL,
  `decimalLongitude` int(8) DEFAULT NULL,
  `typeHabitate` varchar(255) DEFAULT NULL,
  `island` int(5) DEFAULT NULL,
  `cordMethod` varchar(100) DEFAULT NULL,
  `datum` varchar(100) DEFAULT NULL,
  `elevation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1584897800),
('m130524_201442_init', 1584897823),
('m140506_102106_rbac_init', 1584960817),
('m150122_115959_activerecordhistory_init', 1586708183),
('m151013_131405_add_user_field', 1586708183),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1584960817),
('m180523_151638_rbac_updates_indexes_without_prefix', 1584960817),
('m190124_110200_add_verification_token_column_to_user_table', 1584897823);

-- --------------------------------------------------------

--
-- Структура таблицы `modelhistory`
--

CREATE TABLE `modelhistory` (
  `id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `table` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8_unicode_ci,
  `new_value` text COLLATE utf8_unicode_ci,
  `type` smallint(6) NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sample`
--

CREATE TABLE `sample` (
  `id` int(11) NOT NULL,
  `scienName` int(11) NOT NULL,
  `individualCount` int(5) DEFAULT NULL,
  `site` int(4) DEFAULT NULL,
  `parId` varchar(30) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `basisOfRecord` int(4) DEFAULT NULL,
  `typeStatus` int(4) DEFAULT NULL,
  `remarks` varchar(2000) DEFAULT NULL,
  `identifiedBy` int(11) NOT NULL,
  `qualifier` varchar(30) DEFAULT NULL,
  `confidence` int(3) DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdAt` int(11) DEFAULT NULL,
  `editedAt` int(11) DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `_table` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id`, `value`, `target`, `_table`) VALUES
(1, 'Adult', 'age', 'host'),
(2, 'Juvenile', 'age', 'host'),
(3, 'Tadpole', 'age', 'host'),
(4, 'Metamorph', 'age', 'host'),
(5, 'egg', 'age', 'host'),
(6, 'N/A', 'sex', 'host'),
(7, 'male', 'sex', 'host'),
(8, 'female', 'sex', 'host'),
(9, 'Voucher', 'natureOfRecord', 'host'),
(10, 'Observation', 'natureRecord', 'container'),
(11, 'Allolectotype', 'typeStatus', 'container'),
(12, 'None', 'typeStatus', 'container'),
(13, 'Specimen: Complete adult', 'featureOrBasis', 'container'),
(14, 'permanent slide', 'containerType', 'container'),
(15, 'temporary slide', 'containerType', 'container'),
(16, 'vial', 'containerType', 'container'),
(17, 'helminth', 'prepType', 'container'),
(18, 'EtOH (70%)', 'fixative', 'container'),
(19, 'EtOH (96%)', 'fixative', 'container'),
(20, 'EtOH (absolute)', 'fixative', 'container'),
(21, 'tissue', 'prepType', 'container'),
(22, 'protozoan', 'prepType', 'container'),
(24, 'Specimen: Complete adult', 'basisOfRecord', 'sample'),
(25, 'None', 'typeStatus', 'sample'),
(26, 'North West', 'province', 'locality'),
(27, 'South Africa', 'country', 'locality'),
(28, 'Zmiiinyy', 'island', 'locality'),
(29, 'nosample', 'prepType', 'container'),
(30, 'intestine', 'site', 'sample'),
(31, 'gut', 'site', 'locality');

-- --------------------------------------------------------

--
-- Структура таблицы `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `item1` varchar(255) NOT NULL DEFAULT '0',
  `item2` varchar(255) NOT NULL DEFAULT '0',
  `item3` varchar(255) NOT NULL DEFAULT '0',
  `item4` varchar(255) NOT NULL DEFAULT '0',
  `item5` varchar(255) NOT NULL DEFAULT '0',
  `item6` varchar(255) NOT NULL DEFAULT '0',
  `item7` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `taxonomy`
--

CREATE TABLE `taxonomy` (
  `id` int(11) NOT NULL,
  `scientificName` varchar(255) NOT NULL,
  `parId` int(11) NOT NULL,
  `rank` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `taxonomy`
--

INSERT INTO `taxonomy` (`id`, `scientificName`, `parId`, `rank`) VALUES
(1, 'root', 1, 1),
(7, 'nohelminth', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `name`, `surname`) VALUES
(1, 'root', 'ktoOeEcyDaYdoebUN5s6CNclOi9LGFKj', '$2y$13$S6DOVzNr7Y6ZQoFqIzr9UeqXSXttREfv2XWShhd0rxYeXAKg/6BHm', NULL, 'email@email.com', 10, 1584897992, 1584998557, '-4Y6N930d7rFi64gn2_5uG1tanyeTEpo_1584897992', 'root', 'root'),
(17, 'Anonymous', '2xq68o97MqkuA1dLAnumdO4h7y_BpSGg', '$2y$13$/peTWUSTix3UBIwSJo/MZOhVYidSH9B3o3BieycVPh/1gypOrjAei', NULL, '', 10, 1596739121, 1596739121, 'yp2RX5QaPFtV0wYb26ubxgtUbYwur1hy_1596739121', 'Anonymous', 'Anonymous');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taxon_id` (`taxon_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_collection_user` (`user_id`),
  ADD KEY `FK_collection_sample` (`sample_id`);

--
-- Индексы таблицы `container`
--
ALTER TABLE `container`
  ADD PRIMARY KEY (`containerId`),
  ADD KEY `parId` (`parId`),
  ADD KEY `storage` (`storage`);

--
-- Индексы таблицы `host`
--
ALTER TABLE `host`
  ADD PRIMARY KEY (`occurrenceID`),
  ADD KEY `placeName` (`placeName`),
  ADD KEY `scientificName` (`sciName`),
  ADD KEY `determiner` (`determiner`),
  ADD KEY `FK_host_user_2` (`createdBy`),
  ADD KEY `updatedBy` (`updatedBy`);

--
-- Индексы таблицы `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parId` (`parId`);

--
-- Индексы таблицы `locality`
--
ALTER TABLE `locality`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `localityName` (`localityName`),
  ADD KEY `province` (`province`),
  ADD KEY `country` (`country`),
  ADD KEY `island` (`island`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `modelhistory`
--
ALTER TABLE `modelhistory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-table` (`table`),
  ADD KEY `idx-field_name` (`field_name`),
  ADD KEY `idx-type` (`type`),
  ADD KEY `idx-user_id` (`user_id`);

--
-- Индексы таблицы `sample`
--
ALTER TABLE `sample`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parId` (`parId`),
  ADD KEY `identifiedBy` (`identifiedBy`),
  ADD KEY `FK_sample_taxonomy` (`scienName`);

--
-- Индексы таблицы `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `taxonomy`
--
ALTER TABLE `taxonomy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scientificName` (`scientificName`),
  ADD KEY `parId` (`parId`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `collection`
--
ALTER TABLE `collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `locality`
--
ALTER TABLE `locality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `modelhistory`
--
ALTER TABLE `modelhistory`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sample`
--
ALTER TABLE `sample`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `taxonomy`
--
ALTER TABLE `taxonomy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `FK_access_taxonomy` FOREIGN KEY (`taxon_id`) REFERENCES `taxonomy` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_access_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `FK_collection_sample` FOREIGN KEY (`sample_id`) REFERENCES `sample` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `container`
--
ALTER TABLE `container`
  ADD CONSTRAINT `FK_container_host` FOREIGN KEY (`parId`) REFERENCES `host` (`occurrenceID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_container_storage` FOREIGN KEY (`storage`) REFERENCES `storage` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `host`
--
ALTER TABLE `host`
  ADD CONSTRAINT `FK_host_locality` FOREIGN KEY (`placeName`) REFERENCES `locality` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_host_taxonomy` FOREIGN KEY (`sciName`) REFERENCES `taxonomy` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_host_user` FOREIGN KEY (`determiner`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_host_user_2` FOREIGN KEY (`createdBy`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_host_user_3` FOREIGN KEY (`updatedBy`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_image_host` FOREIGN KEY (`parId`) REFERENCES `host` (`occurrenceID`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `locality`
--
ALTER TABLE `locality`
  ADD CONSTRAINT `FK_locality_service` FOREIGN KEY (`province`) REFERENCES `service` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_locality_service_2` FOREIGN KEY (`country`) REFERENCES `service` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_locality_service_3` FOREIGN KEY (`island`) REFERENCES `service` (`id`);

--
-- Ограничения внешнего ключа таблицы `sample`
--
ALTER TABLE `sample`
  ADD CONSTRAINT `FK_sample_container` FOREIGN KEY (`parId`) REFERENCES `container` (`containerId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sample_taxonomy` FOREIGN KEY (`scienName`) REFERENCES `taxonomy` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sample_user` FOREIGN KEY (`identifiedBy`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `taxonomy`
--
ALTER TABLE `taxonomy`
  ADD CONSTRAINT `FK_taxonomy_taxonomy` FOREIGN KEY (`parId`) REFERENCES `taxonomy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
