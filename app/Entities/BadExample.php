<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="badexamples")
 */
class BadExample
{
    /**
     * @ORM\id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     * @var int это для idea, не для доктрины!
     */
    protected $id;


    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $badExample;

    /**
     * @param $id
     * @param $badExample
     */
    public function __construct(string $badExample)
    {
        $this->badExample = $badExample;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBadExample(): string
    {
        return $this->badExample;
    }
}