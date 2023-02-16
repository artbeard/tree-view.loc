CREATE DATABASE `treeview` COLLATE 'utf8_general_ci';

-- Создание таблицы пользователей
CREATE TABLE `user` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `login` varchar(15) NOT NULL,
    `password` varchar(256) NOT NULL
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';

-- Добавление демоучетки admin:admin
INSERT INTO user
    (login, password)
VALUES
    ('admin', '$2y$10$65.QH5OR.d3bgoVtzgi7i.nMebFvIdV82dW4j4VF4n6MjsdcwzRua');

CREATE TABLE `part` (
     `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `title` varchar(128) NOT NULL,
     `desc` varchar(512) NOT NULL,
     `pid` int NULL
) ENGINE='InnoDB';

-- Добавление демо данных
INSERT INTO `part`
    (`id`, `title`, `desc`, `pid`)
VALUES
    (1, 'Каталог', 'Каталог документов о языках программирования', null),
    (2, 'PHP', 'Раздел о PHP', 1),
    (3, 'JavaScript', 'Раздел о JavaScript', 1),
    (4, 'Cи', 'Раздел о Си', 1),
    (5, 'Фреймворки Php', 'Раздел о фреймоврках', 2),
    (6, 'Стандарты кодирования PHP', 'Раздел о стандартах PSR', 2),
    (7, 'Фреймворки JavaScript', 'Раздел о фреймворках', 3),
    (8, 'Версии языка JS', 'Раздел о версиях', 3),
    (9, 'Указатели и ссылки в языке CИ', 'Раздел об указателях', 4),
    (10, 'Типы данных в Си', 'Раздел о типах данных', 4),
    (11, 'Работа с памятью в Си', 'раздел о работе с памятью', 4),
    (12, 'PSR-1', 'Basic Coding Standard', 6),
    (13, 'Разное', 'Дополнительный раздел', null);
