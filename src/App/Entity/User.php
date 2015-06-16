<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use vierbergenlars\Bundle\AuthClientBundle\Entity\User as BaseUser;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $wikiName;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getWikiName()
    {
        return $this->wikiName;
    }

    /**
     * @param string $wikiName
     */
    public function setWikiName($wikiName)
    {
        $this->wikiName = $wikiName;
    }
}
