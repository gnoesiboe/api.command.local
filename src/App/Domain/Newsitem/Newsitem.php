<?php

namespace App\Domain\Newsitem;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryId;

/**
 * Newsitem
 */
class Newsitem
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @param NewsitemTitle $title
     * @param Category $category
     */
    public function __construct(NewsitemTitle $title, Category $category)
    {
        $this->title = $title->getValue();
        $this->category = $category;

        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @param NewsitemDescription $description
     * @return $this
     */
    public function setDescription(NewsitemDescription $description)
    {
        $this->description = $description->getValue();

        return $this;
    }

    /**
     * @return string
     */
    public static function getClass()
    {
        return __CLASS__;
    }

    /**
     * @return NewsitemTitle
     */
    public function getTitle()
    {
        return new NewsitemTitle($this->title);
    }

    /**
     * @return NewsitemId
     */
    public function getId()
    {
        return new NewsitemId((int) $this->id);
    }
    
    /**
     * 
     * @return bool
     */
    public function hasDescription()
    {
        return is_string($this->description) === true;
    }

    /**
     * @return NewsitemDescription|null
     */
    public function getDescription()
    {
        return $this->hasDescription() === true ? new NewsitemDescription($this->description) : null;
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

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
