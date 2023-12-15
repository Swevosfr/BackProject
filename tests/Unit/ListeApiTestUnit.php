<?php

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Persistence\ObjectRepository;
use App\Controller\ApiController;
use App\Services\JwtToken;
use App\Document\ListeApi;

class ListeApiTestUnit extends KernelTestCase
{
    public function testGetListeApiAll()
    {
        // Créez un mock pour le gestionnaire de documents MongoDB
        $documentManagerMock = $this->createMock(DocumentManager::class);

        //pareil pour le jwt
        $jwtTokenMock = $this->createMock(JwtToken::class);

        // gestionnaire de documents
        $documentManagerMock
            ->method('getRepository')
            ->willReturn($this->createMock(ObjectRepository::class));

        $apiController = new ApiController($documentManagerMock);

        // on appelle la méthode
        $response = $apiController->getListeApiAll($jwtTokenMock);

        // les asserts
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());

        // on vérifie le jwt 
        $cookies = $response->headers->getCookies();
        $this->assertCount(1, $cookies);
        $this->assertInstanceOf(Cookie::class, $cookies[0]);
        $this->assertEquals('JWT', $cookies[0]->getName());
    }
}
