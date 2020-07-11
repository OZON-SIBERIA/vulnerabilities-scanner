<?php


namespace App\Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name='schemes')
 */
class Scheme
{
    /**
     * @id @ORM\Column(type="integer" @ORM\GeneratedValue())
     */
    protected $id;
    /**
     *  @ORM\Column(type="string")
     */
    protected $link;
}