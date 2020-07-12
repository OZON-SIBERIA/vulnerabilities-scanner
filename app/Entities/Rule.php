<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity
 * @ORM\Table(name="rules")
 */
class Rule
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    /**
     * @ORM\Column(type="string")
     */
    protected $source;
    protected $scheme;
    protected $badExample;
    protected $goodExample;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source): void
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param mixed $scheme
     */
    public function setScheme($scheme): void
    {
        $this->scheme = $scheme;
    }

    /**
     * @return mixed
     */
    public function getBadExample()
    {
        return $this->badExample;
    }

    /**
     * @param mixed $badExample
     */
    public function setBadExample($badExample): void
    {
        $this->badExample = $badExample;
    }

    /**
     * @return mixed
     */
    public function getGoodExample()
    {
        return $this->goodExample;
    }

    /**
     * @param mixed $goodExample
     */
    public function setGoodExample($goodExample): void
    {
        $this->goodExample = $goodExample;
    }

}