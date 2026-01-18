<?php

// Possible to add more in depth rules here, but for now we'll keep it simple.
return [
    'price_types' => [
        '1' => [
            'cost_percentage' => 0.4,
        ],
        '10000' => [
            'cost_percentage' => 0.5,
        ],
        '10001' => [
            'cost_percentage' => 0.5,
        ],
        '10002' => [
            'cost_percentage' => 0.6,
        ],
        '10003' => [
            'cost_percentage' => 0.7,
        ],
    ],
    'default' => [
        'cost_percentage' => 0.3,
    ],
];
