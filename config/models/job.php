<?php

return [
    
    /**
     * Available statuses
     */
    'statuses' => [
        'pending'    => 'pending',
        'moderation' => 'moderation',
        'active'     => 'active',
        'rejected'   => 'rejected',
    ],

    /**
     * Available status moves for jobs
     */
    'status_moves' => [
        'pending' => ['moderation', 'active'],
        'moderation' => ['active', 'rejected'],
    ],
];