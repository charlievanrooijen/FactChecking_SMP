<?php

namespace App\Controller\checkers;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class postCheckerController extends AbstractController
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/checkPost', name: 'check_post')]
    public function index() : string
    {
        $apiKey = "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";
        $test = "camels are not real";

        $res = $this->client->request(
            'GET',
            'https://api.github.com/repos/symfony/symfony-docs'
        );

        return "res";
    }
}
