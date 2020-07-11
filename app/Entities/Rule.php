<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name='rules')
 */
class Rule
{
    /**
     * @id @ORM\Column(type="integer" @ORM\GeneratedValue())
     */
    protected $id;
    /**
     *  @ORM\Column(type="string")
     */
    protected $name;
    /**
     *  @ORM\Column(type="text")
     */
    protected $description;
    /**
     *  @ORM\Column(type="string")
     */
    protected $source;
    /**
     *  @ORM\OneToOne(targetEntity="Scheme"
     * @JoinColumn(name="link", referencedColumnName="id")
     */
    protected $scheme;
    /**
     *  @ORM\OneToOne(targetEntity="BadExample"
     *  @JoinColumn(name="bad_example", referencedColumnName="id")
     */
    protected $badExample;
    /**
     *  @ORM\OneToOne(targetEntity="GoodExample"
     *  @JoinColumn(name="good_example", referencedColumnName="id")
     */
    protected $goodExample;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

}