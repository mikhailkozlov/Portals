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
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PortalsController@index'
            )
        );

        \Route::post(
            'portals',
            array(
                'as' => 'admin.portals.store',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PortalsController@store'
            )
        );

        \Route::get(
            'portals/create',
            array(
                'as' => 'admin.portals.create',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PortalsController@create'
            )
        );

        \Route::get(
            'portals/{id}/edit',
            array(
                'as' => 'admin.portals.edit',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PortalsController@edit'
            )
        );
        \Route::put(
            'portals/{id}/update',
            array(
                'as' => 'admin.portals.update',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PortalsController@update'
            )
        );

    }
);