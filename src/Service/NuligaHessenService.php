<?php

namespace Mindbird\ContaoNuligaHessen\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NuligaHessenService
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly HttpClientInterface $client, private readonly CacheInterface $appCache, private readonly string $nuligaApiToken, private readonly string $nuligaClubId)
    {

    }
    public function getUsedGroupIds(): array
    {
        $conn = $this->entityManager->getConnection();
        $sql = 'SELECT DISTINCT(nuliga_hessen_group_id) AS group_id FROM tl_content';
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery();
        return $result->fetchAllAssociative();
    }

    public function fetchGroupDataFromApi(int $groupId): string
    {
        $url = 'https://rs.handball.app/api.php/v1/federation/hhv/club/' . $this->nuligaClubId . '/group/' . $groupId;
        $response = $this->client->request('GET', $url, [
            'auth_bearer' => $this->nuligaApiToken,
        ]);
        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Failed to fetch data from NuLiga API for group ID ' . $groupId);
        }

        return $response->getContent();
    }

    public function fetchGroupData(string $groupId): array
    {
        $this->appCache->withSubNamespace('nuliga-hessen');
        return $this->appCache->get('group-' . $groupId, function(ItemInterface $item) use ($groupId) {
            $item->expiresAfter(60*10); // Cache for 10 minutes
            return json_decode($this->fetchGroupDataFromApi($groupId), true);
        });
    }
}