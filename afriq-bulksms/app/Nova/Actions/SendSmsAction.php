<?php

namespace App\Nova\Actions;

use Afriq\CharCount\CharCount;
use App\Http\Controllers\Api\SendSmsController;
use App\Models\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendSmsAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        
        // foreach($models as $model){

            $response = new SendSmsController();
            $response->sendSms($fields->type, $fields->source, $fields->destination,$fields->message, $fields->schedule);
            Sms::create(
                [
                    'type' => $fields->type,
                    'source' => $fields->source,
                    'destination' => $fields->destination,
                    'message' => $fields->message,
                    'schedule' => $fields->schedule,
                    'scheduled' => $fields->scheduled
                ]
            );
            return Action::message("SMS was sent succesfully");
        // }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            // ID::make()->sortable(),
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
            )->rules('required')->required()->displayUsingLabels(),
            Text::make('Source')->sortable()->rules('required', 'max:20')->required(),
            Text::make('Destination')->sortable()->rules('required', 'max:12',  'starts_with:254')->required()->help(
                'seperate multiple mobile numbers using a comma (,) or upload csv file'
            )->placeholder('e.g 254712345678'),
            File::make('Destination File')
                ->disk('public')
                ->acceptedTypes('.csv')
                ->nullable(),
            Boolean::make('Schedule', 'schedule'),
            DateTime::make('Scheduled'),
            CharCount::make('Message')
            ->rules('required')
            ->required(),
        ];
    }
}
