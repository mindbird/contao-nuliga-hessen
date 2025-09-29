<?php

declare(strict_types=1)

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

$GLOBALS['TL_DCA']['tl_content']['palettes']['game_plan'] = '
    {type_legend},type,headline;
    {nuliga_hessen_legend},nuliga_hessen_group_id
';

$GLOBALS['TL_DCA']['tl_content']['palettes']['result_table'] = '
    {type_legend},type,headline;
    {nuliga_hessen_legend},nuliga_hessen_group_id
';