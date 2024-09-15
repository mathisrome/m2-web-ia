<?php

namespace App\Controller\Api;

use App\Model\Dto\ApartmentDto;
use App\Service\ApartmentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api/apartments', name: 'api_apartments_')]
class ApartmentController extends AbstractController
{
    #[Route('', name: 'index', methods: ["GET"])]
    public function index(
        ApartmentManager $apartmentManager
    ): Response
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $data = $serializer->decode(file_get_contents("apartment.csv", "r"), 'csv');

        $apartements = [];

        foreach ($data as $datum) {
            $apartements[] = $apartmentManager->rowToDto($datum);
        }

        return $this->json($apartements);
    }

    #[Route('/{id}', name: 'detail', methods: ["GET"])]
    public function detail(
        int $id,
        ApartmentManager $apartmentManager
    ): Response
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $data = $serializer->decode(file_get_contents("apartment.csv", "r"), 'csv');

        $elem = null;
        foreach ($data as $datum) {
            if ($datum["id"] == $id) {
                $elem = $datum;
            }
        }

        $apartment = $apartmentManager->rowToDto($elem);

        return $this->json($apartment);
    }

    #[Route('', name: 'create', methods: ["POST"])]
    public function create(
        #[MapRequestPayload] ApartmentDto $object
    ): Response
    {

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder([
            "no_headers" => true
        ])]);
        $data = $serializer->decode(file_get_contents("apartment.csv", "r"), 'csv');

        $object->id = count($data) - 1;
        $data[] = (array)$object;

        file_put_contents("apartment.csv", $serializer->encode((array)$object, 'csv'), FILE_APPEND);

        return $this->json($object, 201);
    }

    #[Route('/{id}', name: 'update', methods: ["PUT"])]
    public function update(
        int                               $id,
        #[MapRequestPayload] ApartmentDto $object
    ): Response
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        $data = $serializer->decode(file_get_contents("apartment.csv", "r"), 'csv');

        foreach ($data as $key => $datum) {
            if ($datum["id"] == $id) {
                $data[$key] = (array)$object;
            }
        }

        file_put_contents("apartment.csv", $serializer->encode($data, 'csv'));

        return $this->json($object);
    }
}
