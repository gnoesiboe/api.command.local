<?php

namespace Gn\Api\FirewallAdapter;

use Doctrine\ORM\EntityManager;
use Gn\Api\Domain\Client\ClientInterface;
use Gn\Api\Domain\Client\ClientKey;
use Gn\Api\Domain\Client\ClientRepositoryInterface;
use Gn\Api\Domain\Permission\PermissionIdentifier;
use Gn\Api\Exception\UnauthorizedException;
use Gn\Api\FirewallAdapterInterface;
use Gn\Api\Request;
use Gn\Api\Route;
use Gn\Api\Token\ClientToken;
use Gn\Api\TokenInterface;

/**
 * ClientKey
 */
class ClientKeyAdapter implements FirewallAdapterInterface
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @param Request $request
     * @return TokenInterface
     *
     * @throws UnauthorizedException
     */
    public function authenticate(Request $request)
    {
        $clientKeyHeader = $request->headers->get('client-key', null);

        if (is_string($clientKeyHeader) === false) {
            throw new UnauthorizedException('Missing required client-key header');
        }

        try {
            $clientKey = new ClientKey($clientKeyHeader);
        } catch (\Exception $e) {
            throw new UnauthorizedException($e->getMessage(), 0, $e);
        }

        $client = $this->getClientRepository()->findOneByKeyWithPermissions($clientKey);

        if (($client instanceof ClientInterface) === false) {
            throw new UnauthorizedException(sprintf('No client found with key: \'%s\'', $clientKeyHeader));
        }

        return new ClientToken($client);
    }

    /**
     * @return ClientRepositoryInterface
     * @throws \UnexpectedValueException
     */
    protected function getClientRepository()
    {
        $clientRepository = $this->entityManager->getRepository('Gn\Api\Domain\Client\Client');

        if (($clientRepository instanceof ClientRepositoryInterface) === false) {
            throw new \UnexpectedValueException('ClientRepository should implement the Gn\Api\Domain\Client\ClientRepositoryInterface');
        }

        return $clientRepository;
    }

    /**
     * @param TokenInterface $token
     * @param Route $route
     *
     * @throws \UnexpectedValueException
     * @throws UnauthorizedException
     */
    public function authorize(TokenInterface $token, Route $route)
    {
        $client = $token->getSubject();

        if (($client instanceof ClientInterface) === false) {
            throw new \UnexpectedValueException('Token subject should implement the Gn\Api\Domain\Client\ClientInterface');
        }

        /** @var ClientInterface $client */

        foreach ($route->getRequiredPermissionsIdentifiers() as $requiredPermissionIdentifier) {
            /** @var PermissionIdentifier $requiredPermissionIdentifier */

            if ($client->hasPermission($requiredPermissionIdentifier) === false) {
                throw new UnauthorizedException(sprintf('Client does not have the required \'%s\' permission', $requiredPermissionIdentifier->getValue()));
            }
        }
    }

    /**
     * @return array
     */
    public function getRequiredHeaders()
    {
        return array(
            'client-key'
        );
    }
}
