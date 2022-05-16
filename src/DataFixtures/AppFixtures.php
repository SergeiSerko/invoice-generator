<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Product;
use App\Entity\ProductTax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const COUNTRIES = [
        'FI' => 'Finland',
        'PL' => 'Poland',
    ];

    public function load(ObjectManager $manager): void
    {
        $products = [];
        for ($i = 1; $i < 21; $i++) {
            $product = new Product();
            $product->setName('product ' . $i);
            $product->setPrice(mt_rand(10, 1000));
            $manager->persist($product);
            $products[] = $product;
        }

        $countries = [];
        foreach (self::COUNTRIES as $code => $name) {
            $country = new Country();
            $country->setCode($code);
            $country->setName($name);
            $manager->persist($country);
            $countries[] = $country;
        }

        foreach ($countries as $country) {
            foreach ($products as $product) {
                $tax = new ProductTax();
                $tax->setProduct($product);
                $tax->setCountry($country);
                $tax->setTaxRate(round(mt_rand(100, 10000) / 100, 2));
                $manager->persist($tax);
            }
        }

        $manager->flush();
    }
}
