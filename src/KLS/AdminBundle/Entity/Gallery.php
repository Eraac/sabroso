<?php

namespace KLS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KLS\CoreBundle\Entity\Image;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Le nom ne peut être vide.")
     * @Assert\Length(
     *      min = "1",
     *      max = "255",
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     * @Assert\NotBlank(message="La position ne peut être vide.")
     */
    private $position;

    /**
     * @var file
     *
     * @ORM\OneToOne(targetEntity="KLS\CoreBundle\Entity\Image", cascade={"persist", "remove"})
     * @Assert\Valid
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
