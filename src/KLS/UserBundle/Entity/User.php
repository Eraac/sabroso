<?php
/**
 * User: @LabesseKevin
 * Date: 28/02/15
 * Time: 18:18
 */

namespace KLS\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUSer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admin")
 */
class User extends BaseUSer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}