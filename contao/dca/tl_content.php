<?php

declare(strict_types=1);

use Mindbird\ContaoNuligaHessen\Controller\ContentElement\GamePlanController;
use Mindbird\ContaoNuligaHessen\Controller\ContentElement\ResultTableController;


// Add new fields
$GLOBALS['TL_DCA']['tl_content']['fields']['nuliga_hessen_group_id'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'w50'
    ],
    'sql' => [
        'type' => 'string',
        'length' => 8,
        'default' => ''
    ]
];

$GLOBALS['TL_DCA']['tl_content']['palettes'][GamePlanController::TYPE] = '{type_legend},type,headline;{nuliga_hessen_legend},nuliga_hessen_group_id';

$GLOBALS['TL_DCA']['tl_content']['palettes'][ResultTableController::TYPE] = '{type_legend},type,headline;{nuliga_hessen_legend},nuliga_hessen_group_id';