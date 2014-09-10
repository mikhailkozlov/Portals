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

        // Portals routes
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

        // Page routes
        \Route::get(
            'pages',
            array(
                'as' => 'admin.pages.view',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@index'
            )
        );
        \Route::post(
            'pages',
            array(
                'as' => 'admin.pages.store',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@store'
            )
        );
        \Route::get(
            'pages/create',
            array(
                'as' => 'admin.pages.create',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@create'
            )
        );
        \Route::get(
            'pages/{id}/edit',
            array(
                'as' => 'admin.pages.edit',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@edit'
            )
        );
        \Route::put(
            'pages/{id}/update',
            array(
                'as' => 'admin.pages.update',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@update'
            )
        );

    }
);