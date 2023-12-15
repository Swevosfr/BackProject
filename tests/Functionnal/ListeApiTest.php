<?php

namespace App\tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListeApiTest extends WebTestCase
{
    public function testGetAllListeApi()
{
    
    $client = static::createClient();
    $client->request('GET', '/listeapi');
    $response = $client->getResponse();

    // voir si on reçoit bien un status 200 de la réponse
    $this->assertEquals(200, $response->getStatusCode(), "La réponse doit avoir un statut 200");

    $this->assertJson($response->getContent());
    $this->assertNotEmpty($response->getContent());
}

public function testGetListeApi() {

        $client = static::createClient();
        $client->request('GET', '/listeapi/657b08fa18c9f6466adb81e8');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertStringContainsString('id', $client->getResponse()->getContent());
    }

     public function testDeleteListeApi() {

        $client = static::createClient();
        $client->request('DELETE', '/listeapi/657b08fa18c9f6466adb81e8');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertStringContainsString('id', $client->getResponse()->getContent());
    }
}
