<?php

namespace App\Controller;

use App\Entity\Series;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Guns\ProductIntegration\DTO\ProductDirty;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class SearchController extends AbstractController
{
    public $finder;

    public $serializer;

    /**
     * IndexController constructor.
     */
    public function __construct(RepositoryManagerInterface $finder, SerializerInterface $serializer)
    {
        $this->finder = $finder;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request)
    {
        $query = $request->get('q') ?? '';
        $compelation = [
            "query" => [
                "fuzzy" => [
                    "title" => [
                        "value" => $query,
                        "boost" => 1.0,
                        "fuzziness" => 2,
                        "max_expansions" => 100,
                        "prefix_length" => 0,
                    ],
                ],
            ],
        ];

        $results = $this->finder->getRepository(Series::class)->find($compelation);
        $data = $this->serialize($results);

        return JsonResponse::create($data, 200);
    }

    public function serialize($data): string
    {
        return $this->serializer->serialize($data, JsonEncoder::FORMAT, [
            'circular_reference_handler' => function ($object) {
                if (!method_exists($object, 'getId')) {
                    return $object;
                }

                return $object->getId();
            },
        ]);
    }
}
