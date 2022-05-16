<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Trait for generating UUIDs.
 * Requires calling `$this->uuid = Uuid::vX();` in the constructor.
 */
trait EntityIdTrait
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="uuid", unique=true)
     */
    protected ?Uuid $uuid = null;
}
