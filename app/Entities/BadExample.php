<?php


namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name='badexamples')
 */
class BadExample
{
    /**
     * @id @ORM\Column(type="integer" @ORM\GeneratedValue())
     */
    protected $id;
    /**
     *  @ORM\Column(type="string" name="bad_example")
     */
    protected $badExample;
}