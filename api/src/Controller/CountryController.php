<?php

namespace App\Controller;

use App\service\CountryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/countries', name: 'countries_')]
final class CountryController extends AbstractController
{

    private CountryService $countryService;
    public function __construct(CountryService $countryService){
        $this->countryService = $countryService;
    }

    #[Route('/', name: 'list', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->json(
            [
                'page' => $request->query->getInt('page', 1),
                'data' => $this->countryService->getCountries(),
            ]
        );
    }

    #[Route('/{id}',
        name: 'show',
        requirements: ['id'=>'\d+'],
        methods: ['GET'])
    ]
    public function showOne(int $id): Response {
        return $this->json(
            $this->countryService->getOneById($id)
        );
    }

    #[Route('/search', name: 'search', methods: ['GET'])]
    public function search(Request $request): Response {

        $term = $request->query->get('term');
        $data = [];

        if($term){
           $data = $this->countryService->search($term);
        }

        if(!$data || (is_array($data) && count($data) === 0)){
            return $this->json(
                ['message' => 'Aucun résultats'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json(
            ['data' => $data],
            Response::HTTP_OK
        );
    }
}
