<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Persistence\ObjectRepository;

interface CountryRepositoryInterface extends ObjectRepository
{
    public function add(Country $entity, bool $flush = false): void;

    public function remove(Country $entity, bool $flush = false): void;

}