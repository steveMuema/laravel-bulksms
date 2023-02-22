<?php

namespace App\Nova;

use App\Nova\Actions\ImportExcelContacts;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class UploadContact extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\UploadContact>
     */
    public static $model = \App\Models\UploadContact::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            File::make('File Path')
                ->acceptedTypes('.csv, .xlsx')
                ->storeAs(function (Request $request) {
                    return $request->file_path->getClientOriginalName();
                })->showOnIndex()
                ->nullable(),
            // Action::make('Import CSV')->onlyOnDetail()->action(new ImportExcelContacts),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            Actions\ImportExcelContacts::make()->standalone()->confirmButtonText('Import Contacts'),
        ];
    }
}
