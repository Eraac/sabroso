<?php

namespace KLS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KLS\CoreBundle\Entity\Image;

/**
 * Gallery
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KLS\AdminBundle\Entity\GalleryRepository")
 */
class Gallery
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var file
     *
     * @ORM\OneToOne(targetEntity="KLS\CoreBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

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
     * Set name
     *
     * @param string $name
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Gallery
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set image
     *
     * @param \KLS\CoreBundle\Entity\Image $image
     * @return Gallery
     */
    public function setImage(\KLS\CoreBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \KLS\CoreBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
