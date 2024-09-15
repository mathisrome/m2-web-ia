<?php

namespace App\Service;

use App\Model\Dto\ApartmentDto;

class ApartmentManager
{
    public function rowToDto(array $row)
    {
        $apartmentDto = new ApartmentDto();
        $apartmentDto->id = intval($row["id"]);
        $apartmentDto->nbRooms = floatval($row["nbRooms"]);
        $apartmentDto->surface = floatval($row["surface"]);
        $apartmentDto->nbWindows = floatval($row["nbWindows"]);
        $apartmentDto->price = floatval($row["price"]);
        $apartmentDto->year = intval($row["year"]);
        $apartmentDto->balcony = boolval($row["balcony"]);
        $apartmentDto->garage = boolval($row["garage"]);
        $apartmentDto->note = intval($row["note"]);
        $apartmentDto->priceCategory = $row["priceCategory"];
        $apartmentDto->city = $row["city"];

        return $apartmentDto;
    }
}