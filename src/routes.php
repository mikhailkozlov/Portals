<?php

// try to resolve file download
\Route::get(
    'files/{id}/{name?}',
    array('as' => 'portals.files.download', 'uses' => 'Sugarcrm\Portals\Controllers\FilesController@get')
)->where(array('id' => '[0-9]+'));


/********************************
 * Admin system
 ********************************/
\Route::group(
    array('prefix' => 'admin', 'before' => 'auth.admin'),
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
            'portals/{portal_id}/pages',
            array(
                'as' => 'admin.pages.view',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@index'
            )
        );
        \Route::post(
            'portals/{portal_id}/pages',
            array(
                'as' => 'admin.pages.store',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@store'
            )
        );
        \Route::get(
            'portals/{portal_id}/pages/create',
            array(
                'as' => 'admin.pages.create',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@create'
            )
        );
        \Route::get(
            'portals/{portal_id}/pages/{id}/edit',
            array(
                'as' => 'admin.pages.edit',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@edit'
            )
        );
        \Route::put(
            'portals/{portal_id}/pages/{id}/update',
            array(
                'as' => 'admin.pages.update',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\PagesController@update'
            )
        );

        // Files routes
        \Route::get(
            'files',
            array(
                'as' => 'admin.files.view',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\FilesController@index'
            )
        );
        \Route::post(
            'files',
            array(
                'as' => 'admin.files.store',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\FilesController@store'
            )
        );
        \Route::get(
            'files/create',
            array(
                'as' => 'admin.files.create',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\FilesController@create'
            )
        );
        \Route::get(
            'files/{id}/edit',
            array(
                'as' => 'admin.files.edit',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\FilesController@edit'
            )
        );
        \Route::get(
            'files/{id}/download',
            array(
                'as' => 'admin.files.download',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\FilesController@download'
            )
        );
        \Route::put(
            'files/{id}/update',
            array(
                'as' => 'admin.files.update',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\FilesController@update'
            )
        );

        \Route::get(
            'files/manager',
            array(
                'as'   => 'admin.files.manager',
                'uses' => 'Sugarcrm\Portals\Controllers\Admin\FilesController@manager'
            )
        );
    }
);