<?php

namespace AppBundle\Entity;

//use Foo\PolymorphicBundle\Mapping\Annotation as Polymorphic;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table("comment")
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var Good
     *
     * @ORM\ManyToOne(targetEntity="Good", cascade={"all"}, inversedBy="comments")
     */
    private $commentable;

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
    //private $commentable;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set commentable
     *
     * @param \AppBundle\Entity\Good $commentable
     * @return Comment
     */
    public function setCommentable(\AppBundle\Entity\Good $commentable = null)
    {
        $this->commentable = $commentable;

        return $this;
    }

    /**
     * Get commentable
     *
     * @return \AppBundle\Entity\Good 
     */
    public function getCommentable()
    {
        return $this->commentable;
    }
}
