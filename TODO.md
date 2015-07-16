# Полиморфные комментарии

## Полиморфная связь

Пусть в приложении есть 2 сущности *товар* и *коммент*

Запросы на выборку этих сущностей выглядят так:

```sql
-- Выбрать все комменты вместе с товаром
SELECT *
FROM comments AS c 
INNER JOIN good AS g ON c.good_id = g.id
```

```sql
-- Выбрать комменты товара
SELECT * FROM comments AS c 
WHERE c.entity_id = 123
```
это обычная связь.

Добавим сущность *поставщик* сделаем её комментируемой.

Запросы на выборку сущностей станут такими:

```sql
-- Выбрать все комменты вместе с товаром или поставщиком
SELECT *
FROM comments AS c 
INNER JOIN good AS g ON c.commentable_id = g.id AND c.commentable_type IN ('Good', 'Vendor')
```

```sql
-- Выбрать комменты товара
SELECT * FROM comments AS c 
WHERE c.commentable_id = 123 AND c.commentable_type = 'Good'
```

```sql
-- Выбрать комменты поставщика
SELECT * FROM comments AS c 
WHERE c.commentable_id = 123 AND c.commentable_type = 'Vendor'
```

это полиморфная связь.

DDL таблицы комментариев:

```sql
CREATE TABLE comments (
  id               INT AUTO_INCREMENT NOT NULL,
  commentable_id   INT DEFAULT NULL,
  commentable_tyoe VARCHAR(255)       NOT NULL,
  author           VARCHAR(255)       NOT NULL,
  content          LONGTEXT           NOT NULL,
  PRIMARY KEY (id)
);
```

## Задание

Создать симфони-бандл, который добавляет в модели Доктрины полиморфные связи.
И реализовать с его помощью комментирование товаров и поставщиков.

## Как это должно работать

### (0) Установка и запуск приложения

Для установки бандла надо добавить его в `AppKernel`.

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            //...
            new Foo\PolymorphicBundle\PolymorphicBundle(),
            //...
        ];

        //...

        return $bundles;
    }

    //...
}

```

Все стандартные команды должны работать:

* `composer install`
* `php app/console doctrine:schema:create`
* `php app/console server:run`

### (1) Аннотации

```php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Foo\PolymorphicBundle\Mapping\Annotation as Polymorphic;

/**
 * @ORM\Table("comment")
 * @ORM\Entity
 */
class Comment
{
// ...
    /**
     * Эта аннотация аналогична ORM\ManyToOne за исключением поля targetEntity,
     * которое в данном сулчае означает название полиморфной сущности.
     *
     * @Polymorphic\ManyToOne(targetEntity="Commentable", cascade={"all"}, inversedBy="comments")
     *
     * Следующие 2 аннотации показаны со значениями по-умолчанию и могут быть опущены
     *
     * @Polymorphic\DiscriminatorColumn(name="commentable_type", type="string")
     * @Polymorphic\JoinColumn(name="commentable_id", referencedColumnName="id")
     */
    private $commentable;
// ...
}
```

```php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Foo\PolymorphicBundle\Mapping\Annotation as Polymorphic;

/**
 * @ORM\Table("good")
 * @ORM\Entity
 */
class Good
{
// ...
    /**
     * Название полиморфной сущности задаётся через поле polymorphicEntity
     * Не обязательно реализовывать интерфейс-маркер Commentable, можно добавить в аннотацию поле polymorphicEntity
     * @Polymorphic\OneToMany(targetEntity="Comment", cascade={"all"}, mappedBy="commentable", polymorphicEntity="Commentable")
     */
    private $comments;
// ...
}
```

```php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Foo\PolymorphicBundle\Mapping\Annotation as Polymorphic;

/**
 * Название полиморфной сущности задаётся через интерфейс-маркер
 * этот способ хорош тем, что интерфейс можно использовать ещё и в док-блоках
 * 
 * @ORM\Table("vendor")
 * @ORM\Entity
 */
class Vendor implements Commentable
{
// ...
    /**
     * Не обязательно делать поддержку поля polymorphicEntity в аннотации, можно использовать интерфейс-маркер
     * @Polymorphic\OneToMany(targetEntity="Comment", cascade={"all"}, mappedBy="commentable")
     */
    private $comments;
// ...
}
```

Команда `php app/console doctrine:generate:entities` должна работать без ошибок.

### (2) Сохранение коммента

```php
/** @var EntityManager $em */
$good = $em->find('AppBundle:Good', 1);
$em->persist(
    (new Comment())
    ->setAuthor('John Doe')
    ->setContent('Foo bar Baz')
    ->setCommentable($good)
);
$em->flush();
```

### (3) Получение всех комментов к товару

```php
/** @var EntityManager $em */
$good = $em->find('AppBundle:Good', 1);
$good->getComments();
```

### (4) Получение всех комментов вместе с комментируемыми сущностями

```php
/** @var EntityManager $em */
$comments = $em->getRepository('AppBundle:Good')
    ->createQueryBuilder('c');
    ->leftJoin('c.commentable', 'e')
    ->setMaxResults(100)
    ->getQuery()
    ->getResult();

// Этот код не делает 100 запросов
foreach ($comments as $comment) {
    $comment->getCommentable();
}
```

## Ссылки

1. [Полиморфные связи в Rails](http://guides.rubyonrails.org/association_basics.html#polymorphic-associations)
