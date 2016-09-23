-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Хост: mysql.db.astu
-- Время создания: Сен 10 2016 г., 17:47
-- Версия сервера: 5.5.27
-- Версия PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `14190182`
--

-- --------------------------------------------------------

--
-- Структура таблицы `ad`
--

CREATE TABLE `ad` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `published_at` int(11) NOT NULL,
  `salary` int(11) DEFAULT NULL,
  `details` text NOT NULL,
  `company` varchar(255) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `sphere` varchar(255) NOT NULL,
  `is_confirmed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `ad`
--

INSERT INTO `ad` (`id`, `name`, `published_at`, `salary`, `details`, `company`, `person_id`, `sphere`, `is_confirmed`) VALUES
(3, 'Банк', 1473487486, 15000, 'Разностороння занятость в разных сферах ИКТ', '', 7, 'system_admin,security_admin,web_designer,web_developer', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `city` varchar(30) NOT NULL,
  `street` varchar(80) DEFAULT NULL,
  `house_number` varchar(7) DEFAULT NULL,
  `apartment_number` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `address`
--

INSERT INTO `address` (`id`, `city`, `street`, `house_number`, `apartment_number`) VALUES
(1, 'Барнаул', 'Комсомольский проспект', '65а', NULL),
(2, 'Барнаул', NULL, NULL, NULL),
(3, 'Moscow', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `websites` text,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contact`
--

INSERT INTO `contact` (`id`, `address_id`, `websites`, `phone`) VALUES
(1, 1, 'https://vk.com/ib201104289, https://twitter.com/feurjarx', '89227148511'),
(2, 2, 'vk.com', '123456789'),
(3, 3, 'mai.lru', '99995555');

-- --------------------------------------------------------

--
-- Структура таблицы `cv`
--

CREATE TABLE `cv` (
  `id` int(11) NOT NULL,
  `sphere` varchar(255) DEFAULT NULL,
  `access_type` enum('public','private') NOT NULL DEFAULT 'public',
  `hobbies` varchar(200) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `skills` varchar(1024) NOT NULL,
  `work_experience` enum('nope','<1','1-3','3-5','5>') NOT NULL,
  `education` varchar(255) DEFAULT NULL,
  `ext_education` varchar(200) DEFAULT NULL,
  `desire_salary` int(11) DEFAULT NULL,
  `schedule` enum('full','remote','elastic','shift') DEFAULT NULL,
  `foreign_languages` varchar(200) DEFAULT NULL,
  `is_drivers_license` tinyint(1) DEFAULT NULL,
  `is_smoking` tinyint(1) DEFAULT NULL,
  `is_married` tinyint(1) DEFAULT NULL,
  `about` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cv`
--

INSERT INTO `cv` (`id`, `sphere`, `access_type`, `hobbies`, `created_at`, `person_id`, `skills`, `work_experience`, `education`, `ext_education`, `desire_salary`, `schedule`, `foreign_languages`, `is_drivers_license`, `is_smoking`, `is_married`, `about`) VALUES
(1, 'system_admin,security_admin', 'public', NULL, 1473420367, 1, 'A,B,C', '<1', 'Alstu', NULL, 1100, 'full', 'en,ua,russsss', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `gender` enum('man','foman') DEFAULT NULL,
  `organisation` varchar(70) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `father_name` varchar(30) DEFAULT NULL,
  `date_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person`
--

INSERT INTO `person` (`id`, `user_id`, `contact_id`, `gender`, `organisation`, `last_name`, `first_name`, `father_name`, `date_birth`) VALUES
(1, 1, 1, 'man', 'АлтГТУ им.И.И.Ползунова', 'Яковенко', 'Роман', 'Алексеевич', '2016-07-05'),
(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, 2, 'man', 'Company', 'test', 'test', 'test', '2013-01-01'),
(8, 8, 3, 'man', 'Googlа', 'Пупкин', 'Вася', 'Unnamed', '2016-12-01');

-- --------------------------------------------------------

--
-- Структура таблицы `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `cv_id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `status` enum('waiting','accepted','ignored') NOT NULL DEFAULT 'waiting'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `published_at` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `review`
--

INSERT INTO `review` (`id`, `title`, `description`, `published_at`, `rating`, `user_id`) VALUES
(1, 'Здесь заголовок отзыва', 'Здесь описание отзыва ', 1473430858, 5, 8),
(2, 'test1', 'test1', 1473487289, 1, 7),
(3, 'Сайт тестируется пока', 'Интересно, откуда на отзыве изображение взялось? Это аватар?', 1473501232, 1, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `role` enum('student','employer','root') NOT NULL,
  `img_url` varchar(2048) DEFAULT NULL,
  `is_confirmed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `created_at`, `role`, `img_url`, `is_confirmed`) VALUES
(1, 'feurjarx@gmail.com', '0dfac77aae45a9593ea53fef3a88dcd1', 1467737128, 'root', '3590d20551dd52b317df1b836c18c65c.jpg', 1),
(2, 'pushnina.julia@yandex.ru', '098f6bcd4621d373cade4e832627b4f6', 1467771166, 'employer', 'worker.jpg', 1),
(3, 'almpas1@list.ru', '827ccb0eea8a706c4c34a16891f84e7b', 1473419393, 'student', '620e3a63afb77c19eb207970ed25bbd3.jpg', 1),
(4, 'pushnina.julija@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1467771712, 'student', NULL, 1),
(5, 'sirotkina1993@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1467772000, 'employer', NULL, 1),
(6, 'lerik1895@gmail.com', '098f6bcd4621d373cade4e832627b4f6', 1467772700, 'employer', NULL, 1),
(7, 'almpas@list.ru', '098f6bcd4621d373cade4e832627b4f6', 1473419393, 'root', 'test.png', 1),
(8, 'yakunin@agtu.secna.ru', '827ccb0eea8a706c4c34a16891f84e7b', 1473430279, 'employer', '78805a221a988e79ef3f42d7c5bfd418.jpg', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `ad`
--
ALTER TABLE `ad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `salary` (`salary`),
  ADD KEY `sphere` (`sphere`);

--
-- Индексы таблицы `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_id` (`address_id`);

--
-- Индексы таблицы `cv`
--
ALTER TABLE `cv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `person_id` (`person_id`);

--
-- Индексы таблицы `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `contact_id` (`contact_id`);

--
-- Индексы таблицы `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cv_id` (`cv_id`),
  ADD KEY `ad_id` (`ad_id`);

--
-- Индексы таблицы `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `published_at` (`published_at`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `ad`
--
ALTER TABLE `ad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `cv`
--
ALTER TABLE `cv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ad`
--
ALTER TABLE `ad`
  ADD CONSTRAINT `ad_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cv`
--
ALTER TABLE `cv`
  ADD CONSTRAINT `cv_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `person_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `cv` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`ad_id`) REFERENCES `ad` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
