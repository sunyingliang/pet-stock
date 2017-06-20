<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Exception\InvalidParameterException;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Author")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;
    
    /**
    * @var string $title
    *
    * @ORM\Column(name="title", type="string", length=255, nullable=false)
    */
    private $title;
 
    /**
    * @var string $url
    *
    * @ORM\Column(name="url", type="string", length=128, unique=true)
    */
    private $url;

    /**
    * @var text $content
    *
    * @ORM\Column(name="content", type="text", nullable=false)
    */
    private $content;

    /**
    * @var datetime $createdAt
    *
    * @ORM\Column(name="createdAt", type="datetime", nullable=false)
    */
    private $createdAt;

    /**
    * @var datetime $updatedAt
    *
    * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
    */
    private $updatedAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        if (!is_string($title) || strlen($title) > 255) {
            throw new InvalidParameterException('Error: passed in parameter {title} is not legal');
        }

        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Article
     */
    public function setUrl($url)
    {
        if (!is_string($url) || strlen($url) > 128) {
            throw new InvalidParameterException('Error: passed in parameter {url} is not legal');
        }
        
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        if (!is_string($content)) {
            throw new InvalidParameterException('Error: passed in parameter {content} is not legal');
        }

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        if (!$this->validateDateTime($createdAt)) {
            throw new InvalidParameterException('Error: passed in parameter {createdAt} is not legal');
        }

        $this->createdAt = new \DateTime($createdAt);

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Article
     */
    public function setUpdatedAt($updatedAt)
    {
        if (!$this->validateDateTime($updatedAt)) {
            throw new InvalidParameterException('Error: passed in parameter {updatedAt} is not legal');
        }

        $this->updatedAt = new \DateTime($updatedAt);

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt->format('Y-m-d H:i:s');
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\Author $author
     *
     * @return Article
     */
    public function setAuthor(\AppBundle\Entity\Author $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\Author
     */
    public function getAuthor()
    {
        return $this->author->getName();
    }


    #region Utils
    private function validateDateTime($dateTime)
    {
        $regexp = '@\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}@';

        return preg_match($regexp, $dateTime) === 1;
    }
    #endregion
}
