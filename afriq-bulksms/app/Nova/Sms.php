<?php

namespace App\Nova;

use Afriq\CharCount\CharCount;
use App\Http\Controllers\Api\CheckCreditController;
use App\Nova\Actions\SendSmsAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;

class Sms extends Resource
{
    public static function createButtonLabel()
    {
        return 'Save SMS';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Sms>
     */
    public static $model = \App\Models\Sms::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'message';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'source', 'destination'
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
            Select::make('Type')->options(
                [
                    0 => 'Plain Text (GSM)',
                    1 => 'Flash (GSM)',
                    2 => 'Unicode',
                    3 => 'Reserved',
                    5 => 'Plain Text (ISO-8559-1)',
                    6 => 'Unicode Flash',
                    7 => 'Flash (IS0-8559-1)'
                ]
            )->rules('required')->required()->displayUsingLabels()->hideFromIndex(),
            Select::make('Source')
                ->options(\App\Models\SenderId::pluck('sender_id', 'sender_id'))
                ->rules('required', 'max:20')
                ->sortable(),
            Text::make('Send to', 'destination')->sortable()->rules('max:12',  'starts_with:254', 'nullable')->nullable()->hideFromIndex(),
            File::make('Upload contacts to send', 'destination_file')
                ->acceptedTypes('.csv, .xlsx')
                ->storeAs(function (Request $request) {
                    return $request->destination_file->getClientOriginalName();
                })
                ->nullable()->help('Ensure your file has a column with header "phone_number"'),
            CharCount::make('Message')
                ->withData($this->myData())
                ->rules('required')
                ->required(),
            DateTime::make('Scheduled'),
            Text::make('Status', 'dlr_status')->nullable()->hideWhenCreating()->hideWhenUpdating(),
            Textarea::make('Message Field')
                ->withMeta([
                    'component' => 'message-component',
                    'props' => [
                        'myData' => $this->myData(),
                    ],
                ])
        ];
    }

    public function myData()
    {
        $credits = new CheckCreditController();
        $curr_balance = $credits->checkCredit();
        // Return the data of the user to send to component
        return [
            'balance' => $curr_balance,
            // '' => 'qux',
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
            Actions\CreateAndSendSms::make()->standalone()->confirmButtonText('Send SMS')->confirmText('Create and save a message to send to your customers below'),
            Actions\SendBulkSms::make()->confirmButtonText('Send SMS')->confirmText('Do you want to send SMS to the selected row(s)?')
        ];
    }
}
