<?php

declare(strict_types=1);

namespace Mindbird\ContaoNuligaHessen\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AsContentElement(GamePlanController::TYPE, category: 'nuliga-hessen')]
class GamePlanController extends AbstractContentElementController
{
    public const string TYPE = 'game_plan';

    public function __construct(private readonly ScopeMatcher $scopeMatcher, private readonly string $nuligaClubId)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ($this->scopeMatcher->isBackendRequest($request)) {
            $template = new BackendTemplate('be_wildcard');
            $template->title = 'Spielplan für Gruppe ' . $model->nuliga_hessen_group_id;
            $template->headline = $model->headline;

            return $template->getResponse();
        }

        if ('' === $model->nuliga_hessen_group_id) {
            throw new \RuntimeException('No NuLiga Hessen Group ID set.');
        }

        $template->noData = false;
        if (!file_exists(__DIR__ . '/../../../json/' . $model->nuliga_hessen_group_id . '.json')) {
            $template->noData = true;
            return $template->getResponse();
        }

        $data = file_get_contents(__DIR__ . '/../../../json/' . $model->nuliga_hessen_group_id . '.json');
        $template->data = json_decode($data, true);
        $template->clubId = $this->nuligaClubId;

        return $template->getResponse();
    }
}
