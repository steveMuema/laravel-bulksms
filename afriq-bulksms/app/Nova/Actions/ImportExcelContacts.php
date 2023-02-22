<?php

namespace App\Nova\Actions;

use App\Models\Contact;
use App\Models\Sms;
use App\Models\UploadContact;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportExcelContacts extends Action
{
    use InteractsWithQueue, Queueable;

    public $model = Sms::class;
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        // $contacts = [];
        // foreach($models as $model){
            echo $filePath = Storage::putFile('', $fields->destination_file);
            // dd($filePath);
            $reader = SimpleExcelReader::create($filePath)->getRows();
            foreach($reader as $row){
                Contact::create(
                    [
                        'name' => $row['name'],
                        'phone_number' => $row['phone_number'],
                        // 'destination' => $row['destination'],
                        // 'message' => $row['message'],
                        // 'schedule' => $row['schedule'],
                        // 'scheduled' => $row['scheduled'],
                ]);
            // }
        }
        // UploadContact::create([
        //     'file_path' => $fields->destination_file
        // ]);

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
            File::make('Destination File', 'destination_file')
                ->acceptedTypes('.csv, .xlsx')
                ->storeAs(function (Request $request) {
                    return $request->destination_file->getClientOriginalName();
                })
                ->nullable()
        ];
    }
}
