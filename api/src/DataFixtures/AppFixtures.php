<?php

namespace App\DataFixtures;

use App\Enum\City;
use App\Enum\PriceCategory;
use App\Model\Dto\ApartmentDto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder([])]);

        $apartments = [];

        for ($i = 0; $i < 100; $i++) {
            $apartment = new ApartmentDto();
            $apartment->id = $i + 1;
            $apartment->nbWindows = random_int(1, 100);
            $apartment->nbRooms = random_int(1, 100);
            $apartment->surface = random_int(5, 600);

            $cities = ApartmentDto::getCities();
            shuffle($cities);
            $apartment->city = $cities[0];

            $price = 0;
            if ($apartment->city === City::PARIS) {
                $price = $apartment->surface / 6 * 10034;

                if ($price > 1000000) {
                    $apartment->priceCategory = PriceCategory::SCAM->value;
                } elseif ($price > 500000) {
                    $apartment->priceCategory = PriceCategory::HIGH->value;
                } elseif ($price > 350000) {
                    $apartment->priceCategory = PriceCategory::NORMAL->value;
                } else {
                    $apartment->priceCategory = PriceCategory::LOW->value;
                }
            } elseif ($apartment->city === City::LYON) {
                $price = $apartment->surface / 6 * 4717;

                if ($price > 250000) {
                    $apartment->priceCategory = PriceCategory::SCAM->value;
                } elseif ($price > 200000) {
                    $apartment->priceCategory = PriceCategory::HIGH->value;
                } elseif ($price > 100000) {
                    $apartment->priceCategory = PriceCategory::NORMAL->value;
                } else {
                    $apartment->priceCategory = PriceCategory::LOW->value;
                }
            } else {
                $price = $apartment->surface / 6 * 3341;

                if ($price > 200000) {
                    $apartment->priceCategory = PriceCategory::SCAM->value;
                } elseif ($price > 150000) {
                    $apartment->priceCategory = PriceCategory::HIGH->value;
                } elseif ($price > 75000) {
                    $apartment->priceCategory = PriceCategory::NORMAL->value;
                } else {
                    $apartment->priceCategory = PriceCategory::LOW->value;
                }
            }

            $apartment->price = $price;
            $apartment->year = random_int(2005, 2024);
            $apartment->balcony = boolval(random_int(0, 1));
            $apartment->garage = boolval(random_int(0, 1));
            $apartment->note = random_int(1, 5);

            $apartments[] = (array)$apartment;
        }

        file_put_contents("public/apartment.csv", $serializer->encode((array)$apartments, 'csv'));
    }
}
