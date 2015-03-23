<?php

namespace KLS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;

/**
 * Planning
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KLS\AdminBundle\Entity\PlanningRepository")
 */
class Planning
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", unique=true)
     * @Assert\Date()
     * @Assert\NotBlank(message="La date ne peut être vide.")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float")
     * @Assert\NotBlank()
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float")
     * @Assert\NotBlank()
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @Assert\NotBlank(message="L'adresse ne peut être vide.")
     * @Assert\Length(
     *      min = "1",
     *      max = "255",
     *      minMessage = "L'adresse doit faire au moins {{ limit }} caractères",
     *      maxMessage = "L'adresse ne peut pas être plus longue que {{ limit }} caractères"
     * )
     */
    private $address;


    public function __construct()
    {
        $this->date = new \DateTime();
    }

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
     * Set date
     *
     * @param \DateTime $date
     * @return Planning
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Planning
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param float $lng
     * @return Planning
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return float 
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Planning
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function setLatLng($latlng)
    {
        $this->setLat($latlng['lat']);
        $this->setLng($latlng['lng']);

        return $this;
    }

    /**
     * @Assert\NotBlank()
     * @OhAssert\LatLng()
     */
    public function getLatLng()
    {
        return array('lat'=>$this->getLat(),'lng'=>$this->getLng());
    }
}
