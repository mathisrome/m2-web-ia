<?php

namespace App\Model\Dto;

use App\Enum\City;
use App\Enum\PriceCategory;
use Symfony\Component\Validator\Constraints as Assert;

class ApartmentDto
{
    public ?int $id = null;

    #[Assert\Range(min: 1, max: 100)]
    #[Assert\NotBlank]
    public ?int $nbWindows = null;

    #[Assert\Range(min: 1, max: 100)]
    #[Assert\NotBlank]
    public ?int $nbRooms = null;

    #[Assert\Range(min: 5, max: 600)]
    #[Assert\NotBlank]
    public ?float $surface = null;

    #[Assert\Range(min: 50000, max: 1000000)]
    #[Assert\NotBlank]
    public ?float $price = null;

    #[Assert\Range(min: 2005, max: 2024)]
    #[Assert\NotBlank]
    public ?int $year = null;

    public bool $balcony = false;

    public bool $garage = false;

    #[Assert\Range(min: 1, max: 5)]
    #[Assert\NotBlank]
    public ?int $note = null;

    #[Assert\Choice(callback: 'getPriceCategories')]
    #[Assert\NotNull]
    public ?string $priceCategory = null;

    #[Assert\Choice(callback: 'getCities')]
    #[Assert\NotNull]
    public ?string $city = null;

    public static function getPriceCategories()
    {
        $priceCategories = [];
        foreach (PriceCategory::cases() as $case) {
            $priceCategories[] = $case->value;
        }

        return $priceCategories;
    }

    public static function getCities()
    {
        $cities = [];
        foreach (City::cases() as $case) {
            $cities[] = $case->value;
        }

        return $cities;
    }
}