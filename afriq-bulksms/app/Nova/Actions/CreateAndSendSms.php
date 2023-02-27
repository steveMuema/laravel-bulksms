<?php

namespace App\Nova\Actions;

use Afriq\CharCount\CharCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\SendSmsController;
use App\Models\Contact;
use App\Models\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreateAndSendSms extends Action
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
        $data = $response->sendSms($fields->type, $fields->source, $fields->destination, $fields->message, $fields->scheduled, $fields->destination_file);
        // Sms::create(
        //     [
        //         'type' => $fields->type,
        //         'source' => $fields->source,
        //         'destination' => $fields->destination,
        //         'message' => $fields->message,
        //         'scheduled' => $fields->scheduled,
        //         'destination_file' => $fields->destination_file
        //     ]
        // );
        if($data == 'success'){
            return Action::message("SMS sent successfully");;

        }else{
            return Action::danger('Error: ' .$data);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $list_contacts = Contact::pluck('phone_number')->toArray();
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
            Select::make('Source')
                ->options(\App\Models\SenderId::pluck('sender_id', 'sender_id'))
                ->rules('required', 'max:20')
                ->sortable(),
            Text::make('Destination')->sortable()->rules('max:12',  'starts_with:254', 'nullable')->nullable()->help(
                'seperate multiple mobile numbers using a comma (,) or upload csv file'
            )->placeholder('e.g 254712345678')->suggestions($list_contacts),
            // File::make('Destination File', 'destination_file')
            //     ->acceptedTypes('.csv, .xlsx')
            //     ->storeAs(function (Request $request) {
            //         return $request->destination_file->getClientOriginalName();
            //     })
            //     ->nullable()->help('Ensure your file has a column with header "phone_number"'),

            DateTime::make('Scheduled'),
            CharCount::make('Message')
                ->rules('required')
                ->required(),
        ];
    }
}
