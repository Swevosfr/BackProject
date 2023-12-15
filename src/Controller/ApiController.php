<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use App\Document\ListeApi;
use App\Services\JwtToken;
use App\Entity\Salutation;

class ApiController extends AbstractController
{

    private $documentManager;

    public function __construct(DocumentManager $documentManager){
        $this->documentManager = $documentManager;

    }
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        $id='6540212614c21b0d06284a7f';
        $listeApi = $this->documentManager->getRepository(ListeApi::class)->find($id);
        //$station = $this->documentManager->getRepository(Station::class)->findAll($id);
        return $this->json($listeApi);
    }
    

    #[Route('/listeapi', name: 'create_listeapi', methods: ['POST'])]
    public function createListeApi(Request $request, JwtToken $jwtToken): Response {
        $listeApi = new ListeApi();
    
        $data = json_decode($request->getContent(), true);
    
        $listeApi->setTitle($data['title'] ?? '');
        $listeApi->setTagline($data['tagline'] ?? '');
        $listeApi->setPath($data['path'] ?? '');
        $listeApi->setSlug($data['slug'] ?? '');
        $listeApi->setOpenness($data['openness'] ?? '');
        $listeApi->setOwner($data['owner'] ?? '');
        $listeApi->setOwnerAcronym($data['owner_acronym'] ?? '');
        $listeApi->setLogo($data['logo'] ?? '');
        $listeApi->setDatapassLink($data['datapass_link'] ?? '');
        $listeApi->setDatagouvUuid($data['datagouv_uuid'] ?? []);
    
        // on sauvegarde la bdd
        $this->documentManager->persist($listeApi);
        $this->documentManager->flush();
    
        $token = $jwtToken->createToken();

    //json reponse
    $response = $this->json(['message' => 'Nouveau document ListeApi créé', 'id' => $listeApi->getId()]);

    // creation et ajout cookie
    $cookie = new Cookie(
        'JWT', $token, time() + 20, '/', null, false, true
    );
    $response->headers->setCookie($cookie);
    return $response;
}


#[Route('/listeapi/{id}', name: 'listeapi_show', methods: ['GET'])]
public function getListeApi($id, JwtToken $jwtToken): Response {
    $listeApi = $this->documentManager->getRepository(ListeApi::class)->find($id);

    if (!$listeApi) {
        throw $this->createNotFoundException(
            'Aucun document trouvé pour l\'id '.$id
        );
    }
    $token = $jwtToken->createToken();
    $response = $this->json($listeApi);

    $cookie = new Cookie(
        'JWT', $token, time() + 20, '/', null, false, true
    );
    $response->headers->setCookie($cookie);
    return $response;
}


#[Route('/listeapi', name: 'listeapi_showall', methods: ['GET'])]
public function getListeApiAll(JwtToken $jwtToken): Response {
    $listeApi = $this->documentManager->getRepository(ListeApi::class)->findAll();
    
    if (!$listeApi) {
        throw $this->createNotFoundException('Aucun document trouvé');
    }

    $token = $jwtToken->createToken();
    $response = $this->json(['listeApis' => $listeApi]);

    $cookie = new Cookie(
        'JWT', $token, time() + 20, '/', null, false, true
    );
    $response->headers->setCookie($cookie);
    return $response;
}


    #[Route('/listeapi/{id}', name: 'listeapi_update', methods: ['PUT'])]
    public function updateListeApi($id, Request $request): Response {
        $listeApi = $this->documentManager->getRepository(ListeApi::class)->find($id);
    
        if (!$listeApi) {
            throw $this->createNotFoundException(
                'Aucun document trouvé pour l\'id '.$id
            );
        }

        $data = json_decode($request->getContent(), true);
    
        $listeApi->setTitle($data['title'] ?? '');
        $listeApi->setTagline($data['tagline'] ?? '');
        $listeApi->setPath($data['path'] ?? '');
        $listeApi->setSlug($data['slug'] ?? '');
        $listeApi->setOpenness($data['openness'] ?? '');
        $listeApi->setOwner($data['owner'] ?? '');
        $listeApi->setOwnerAcronym($data['owner_acronym'] ?? '');
        $listeApi->setLogo($data['logo'] ?? '');
        $listeApi->setDatapassLink($data['datapass_link'] ?? '');
        $listeApi->setDatagouvUuid($data['datagouv_uuid'] ?? []);
    
        // on sauvegarde dans la bdd
        $this->documentManager->persist($listeApi);
        $this->documentManager->flush();
    
        return $this->json(['message' => 'Document ListeApi mis à jour', 'id' => $listeApi->getId()]);
    }

    #[Route('/listeapi/{id}', name: 'listeapi_delete', methods: ['DELETE'])]
    public function deleteListeApi($id): Response {
        $listeApi = $this->documentManager->getRepository(ListeApi::class)->find($id);
    
        if (!$listeApi) {
            throw $this->createNotFoundException(
                'Aucun document trouvé pour l\'id '.$id
            );
        }
    
        $this->documentManager->remove($listeApi);
        $this->documentManager->flush();
    
        return $this->json(['message' => 'Document ListeApi supprimé', 'id' => $listeApi->getId()]);
    }

   
    #[Route('/token', name: '')]
    public function testJwt(JwtToken $jwtToken)
    {
        $token = $jwtToken->createToken();
        return new JsonResponse(['token' => $token]);
    }
}