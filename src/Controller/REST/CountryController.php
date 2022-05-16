<?php

namespace App\Controller\REST;

use App\Repository\CountryRepositoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/countries")
 */
class CountryController extends AbstractFOSRestController
{
    private CountryRepositoryInterface $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @Route("", name="getCountries", methods={"GET"})
     * @Rest\View(serializerGroups={"Country"})
     */
    public function getCountries(): array
    {
        return $this->countryRepository->findAll();
    }
}