<?php

declare(strict_types=1);

namespace Mindbird\ContaoNuligaHessen\Controller\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Mindbird\ContaoNuligaHessen\Service\NuligaHessenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AsContentElement(ResultTableController::TYPE, category: 'nuliga-hessen')]
class ResultTableController extends AbstractContentElementController
{
    public const string TYPE = 'result_table';

    public function __construct(private readonly ScopeMatcher $scopeMatcher, private readonly NuligaHessenService $nuligaHessenService, private readonly string $nuligaClubId)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ($this->scopeMatcher->isBackendRequest($request)) {
            $template = new BackendTemplate('be_wildcard');
            $template->title = 'Tabelle für Gruppe ' . $model->nuliga_hessen_group_id;

            return $template->getResponse();
        }

        if ('' === $model->nuliga_hessen_group_id) {
            throw new \RuntimeException('No NuLiga Hessen Group ID set.');
        }

        $template->clubId = $this->nuligaClubId;
        $template->noData = false;
        try {
            $template->data = $this->nuligaHessenService->fetchGroupData($model->nuliga_hessen_group_id);
        } catch (\Exception) {
            $template->noData = true;
        }

        return $template->getResponse();
    }
}
