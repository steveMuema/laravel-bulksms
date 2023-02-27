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

class SendBulkSms extends Action implements ShouldQueue
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

        $responses = collect();
        foreach($models as $model){  
                    
            $result = new SendSmsController();
            $data = $result->sendSms($model->type, $model->source, $model->destination,$model->message, $model->schedule, $model->scheduled, $model->destination_file);
             if($data == 'success'){
                $response = Action::message("SMS sent successfully");
            }
            else{
                // $model->markAsFailed();
                $this->markAsFailed($model, $data);
                $response = Action::danger("Error: ".$data);
            }            
             // Add the response to the collection
            $responses->push($response);
        }
        return $responses;
    }
    /**
     * Handle chunk results.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  array  $results
     *
     * @return mixed
     */
    // public function handleResult(ActionFields $fields, $results)
    // {
    //     $models = collect($results)->flatten();

    //     // dispatch(new GenerateReport($models));
    //     // dd($results);

    //     return Action::message($models->count());
    // }

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
