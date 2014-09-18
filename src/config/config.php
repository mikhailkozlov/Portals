<?php

/**
 *  Portals Config
 *
 *
 */
return array(
    'layouts'        => array(
        'master' => 'portals::layouts.master',
        'navbar' => 'portals::layouts.partials.nav',
    ),

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