<?php

// try to resolve file download
\Route::get(
    'files/{file}',
    array('as' => 'portals.files.download', 'uses' => 'FilesController@get')
);

/********************************
 * Admin system
 ********************************/
\Route::group(
    array('prefix' => 'admin'),
    function () {

        \Route::get(
            'portals',
            array(
                'as' => 'admin.portals.view',
                'uses' => 'Admin\PortalsController@index'
            )
        );

        \Route::get(
            'portals/create',
            array(
                'as' => 'admin.portals.create',
                'uses' => 'Admin\PortalsController@create'
            )
        );

        \Route::get(
            'portals/{id}/edit',
            array(
                'as' => 'admin.portals.edit',
                'uses' => 'Admin\PortalsController@edit'
            )
        );
        \Route::put(
            'portals/{id}/update',
            array(
                'as' => 'admin.portals.update',
                'uses' => 'Admin\PortalsController@update'
            )
        );

    }
);