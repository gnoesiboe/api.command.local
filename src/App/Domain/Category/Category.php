<?php

namespace App\Domain\Category;

/**
 * Category
 */
class Category
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @param CategoryTitle $title
     */
    public function __construct(CategoryTitle $title)
    {
        $this->title = $title->getValue();
    }

    /**
     * @return CategoryTitle
     */
    public function getTitle()
    {
        return new CategoryTitle($this->title);
    }

    /**
     * @return CategoryId
     */
    public function getId()
    {
        return new CategoryId($this->id);
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
