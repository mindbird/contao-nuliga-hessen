<?php

declare(strict_types=1)

// Add new fields
$GLOBALS['TL_DCA']['tl_content']['fields']['nu_liga_hessen_group_id'] = [
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