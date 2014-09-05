<?php

// try to resolve file download
\Route::get(
    'files/{file}',
    array('as' => 'portals.files.download', 'uses' => 'FilesController@get')
);

/********************************
 *
 * Admin system
 *
 ********************************/
\Route::group(
    array('prefix' => 'admin'),
    function () {

        \Route::get(
            'portals',
            array(
                'as'   => 'admin.portals.view',
                'uses' => 'Admin\PortalsController@index'
            )
        );

    }
);