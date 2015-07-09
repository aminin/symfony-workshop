REPLACE INTO category (id, name)
VALUES
(1, 'Новые'),
(2, 'Популярные'),
(3, 'Акции'),
(4, 'Тракторы'),
(5, 'Кошки')
;


REPLACE INTO vendor (id, name)
VALUES
(1, 'БМВ'),
(2, 'Ямаха'),
(3, 'МТЗ'),
(4, 'Мурка')
;

REPLACE INTO good (id, name, image, description, price, vendor_id)
VALUES
(1, 'Трактор МТЗ 80', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.25, 3),
(2, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(3, 'Рыжий котёнок', 'http://cs614617.vk.me/v614617756/10a6a/zeqE2VFDJdA.jpg', '', 0.55, 4),
(4, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(5, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(6, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(7, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(8, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(9, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(10, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(11, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(12, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(13, 'Трактор МТЗ 80-2', 'http://глобалрес.рф/files/images/kabina5.jpg', '', 1.23, 3),
(14, 'Рыжий котёнок 1', 'http://cs614617.vk.me/v614617756/10a6a/zeqE2VFDJdA.jpg', '', 0.55, 4),
(15, 'Рыжий котёнок 2', 'http://cs614617.vk.me/v614617756/10a6a/zeqE2VFDJdA.jpg', '', 0.55, 4),
(16, 'Рыжий котёнок 3', 'http://cs614617.vk.me/v614617756/10a6a/zeqE2VFDJdA.jpg', '', 0.55, 4)
;

REPLACE INTO good_category (good_id, category_id) VALUES
(1, 1),
(3, 1),
(3, 5),
(2, 2),
(1, 4),
(2, 4)
;
