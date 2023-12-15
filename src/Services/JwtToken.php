<?php

namespace App\Services;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use DateTimeImmutable;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;

class JwtToken
{
    private $config;
    private $signingKey;

    public function __construct(string $secretKey)
    {
        $this->config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($secretKey)
        );

            //signature avec le secretkey
        $this->signingKey = InMemory::plainText($secretKey);
    }

    public function createToken(): string
    {
        $now = new DateTimeImmutable();

        $token = $this->config->builder(ChainedFormatter::default(), new JoseEncoder())
            // Configurer les claims
            ->relatedTo('component1')
            ->identifiedBy('4f1g23a12aa')
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('uid', 1)
            // Configurer les en-têtes
            ->withHeader('foo', 'bar')
            // Construire le token
            ->getToken($this->config->signer(), $this->signingKey);

        return $token->toString();
    }
}
