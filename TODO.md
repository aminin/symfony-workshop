Разработать небольшое Symfony 2 приложение, которое будет отображать страницы
магазина с продуктами из каталога.
 
Требования:
1) Пользователь должен иметь возможность просматривать каталог продуктов
с картинками (можно внешний url), названиями, ценой (для каждого продукта);
 
2) Продукты должны быть сгруппированы по категориям. Магазин должен иметь
возможность фильтрации продуктов по категории. Существует много продуктов
и много категорий. Каждому продукту может соответствовать много категорий,
каждая категория содержит много продуктов;
 
3) Каждый продукт соответствует поставщику. Существует много продуктов
и поставщиков, каждый поставщик имеет много продуктов, каждый продукт
соответствует одному поставщику;
 
4) Список продуктов должен выводиться постранично (по 12 продуктов на
странице)
 
5) Реализовать поиск по имени продуктов;
 
* Плюсом будет реализация REST API на сервере и использование его с помощью ajax на клиенте
