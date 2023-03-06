<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSmsLogRequest;
use App\Http\Requests\UpdateSmsLogRequest;
use App\Models\SmsLog;

class SmsLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSmsLogRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSmsLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function show(SmsLog $smsLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function edit(SmsLog $smsLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSmsLogRequest  $request
     * @param  \App\Models\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSmsLogRequest $request, SmsLog $smsLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmsLog  $smsLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmsLog $smsLog)
    {
        //
    }
}
