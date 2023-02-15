<?php

namespace App\Nova\Actions;

use Afriq\CharCount\CharCount;
use App\Http\Controllers\Api\SendSmsController;
use App\Models\Sms;
use Exception;
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

class SendSmsAction extends Action implements ShouldQueue
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

        collect($models)->map(function($model){  
            try{
                    
                $response = new SendSmsController();
                $data = $response->sendSms($model->type, $model->source, $model->destination,$model->message, $model->schedule, $model->scheduled);
                // Sms::create(
                //     [
                //         'type' => $model->type,
                //         'source' => $model->source,
                //         'destination' => $model->destination,
                //         'message' => $model->message,
                //         'schedule' => $model->schedule,
                //         'scheduled' => $model->scheduled
                //     ]
                // );
                
               
                $result=$data->getData();
                return $result->{'message'};
                //  if($result->{'status'} == 'success'){
                //     return Action::message("SMS sent successfully");

                // }
                // else{
                //     $this->markAsFailed($model, $result->{'status'});

                //     return Action::danger("Failed: ".$result->{'status'});
                // }
            }
            catch (Exception $e) {
                $this->markAsFailed($model, $e);
            }
        });
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
        ];
    }
}
