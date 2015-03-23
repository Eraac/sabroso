<?php

namespace KLS\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Press
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KLS\AdminBundle\Entity\PressRepository")
 */
class Press
{
    const PRESS_VARIABLE_NAME = "press_is_enable";

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
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message="Le contenu de l'article ne peut être vide.")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     * @Assert\NotBlank(message="La source de l'article ne peut être vide.")
     * @Assert\Length(
     *      min = "1",
     *      max = "255",
     *      minMessage = "La source doit faire au moins {{ limit }} caractères",
     *      maxMessage = "La source ne peut pas être plus longue que {{ limit }} caractères"
     * )
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "L'url ne peut pas être plus longue que {{ limit }} caractères"
     * )
     */
    private $url;


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
     * Set content
     *
     * @param string $content
     * @return Press
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
     * Set source
     *
     * @param string $source
     * @return Press
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Press
     */
    public function setUrl($url)
    {
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
}
