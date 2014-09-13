<?php

/**
 *  Portals Config
 *
 *
 */
return array(
    // auth method in use
    'auth'           => 'Sentry',
    'status_options' => array(
        'draft'     => 'draft',
        'published' => 'published'
    ),
    'filesystem'     => array(
        'default' => 'local',
        'local'   => array(
            'path' => 'app/storage',
        ),
        's3'      => array(
            'key'    => '',
            'secret' => '',
            'bucket' => '',
            'prefix' => '',
        ),
    )
);