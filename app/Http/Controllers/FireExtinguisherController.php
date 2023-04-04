<?php

namespace App\Http\Controllers;

use App\Http\Requests\FireExtinguisher\StoreRequest;
use App\Http\Requests\FireExtinguisher\UpdateRequest;
use App\Models\FireExtinguisher;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

class FireExtinguisherController extends Controller
{

    function index(){
        return FireExtinguisher::with('maintenance')->get();
    }

    function add(StoreRequest $request){
        $validated = $request->validated();
        $date = $validated['year'].'-'.$validated['month'].'-'.$validated['day'].' 00:00:00';
        for($i =0; $i < $validated['multiplication'];$i++){
            FireExtinguisher::create([
                'place' => $validated['place'],
                'internal_identifier' => $validated['internal_identifier'],
                'standby_location'=> $validated['standby_location'],
                'device_type'=> $validated['device_type'],
                'serial_number'=> $validated['serial_number'],
                'date_of_manufacture' => date('Y-m-d H:i:s', strtotime($date)),
                'comment'=> @$validated['comment'],
            ]);
        }
    }

    function update_service(Request $request){
        $fireExtinguisher = FireExtinguisher::find($request->id);
        $exists = $fireExtinguisher->maintenance()->exists();
        
        $year = explode('-',$request->service_date)[0];
        $month = explode('-',$request->service_date)[1];
        $day = explode('-',$request->service_date)[2];

        if($request->service == 'basic_service'){
            $date = $year.' '.sprintf("%02d",$month).'.'.sprintf("%02d", $day).'. A';

            if($exists){
                $fireExtinguisher->maintenance()->update(['service_date' =>$date, 'comment' => $request->comment]);
            }else{
                $fireExtinguisher->maintenance()->create(['service_date' =>$date, 'comment' => $request->comment]);                   
            }
        }else if($request->service == 'operator_control'){
            $date = sprintf("%02d",$month).'.'.sprintf("%02d", $day).'. Ü';

            $quarters = ['first_qt', 'second_qt', 'third_qt', 'fourth_qt'];
            $quarter_index = ceil($month / 3) - 1;
            $quarter_key = $quarters[$quarter_index];

            if($exists){
                $fireExtinguisher->maintenance()->update([$quarter_key => $date, 'comment' => $request->comment]);
            }else{
                $fireExtinguisher->maintenance()->create([$quarter_key => $date, 'comment' => $request->comment]);
            }
        }

    }

    function generate_pdf()
    {
        $data = FireExtinguisher::with('maintenance')->get();
        $pdf = Pdf::loadView('pdf', ['data'=>$data])->setPaper('a3', 'landscape')->setOptions(['isHtml5ParserEnabled'=> true]);
        return $pdf->stream();
    }

    function update_fe(FireExtinguisher $fireExtinguisher, StoreRequest $request){
        $validated = $request->validated();
        $date = $validated['year'].'-'.$validated['month'].'-'.$validated['day'].' 00:00:00';

        $fireExtinguisher->update([
            'place' => $validated['place'],
            'internal_identifier' => $validated['internal_identifier'],
            'standby_location'=> $validated['standby_location'],
            'device_type'=> $validated['device_type'],
            'serial_number'=> $validated['serial_number'],
            'date_of_manufacture' => date('Y-m-d H:i:s', strtotime($date)),
            'comment'=> @$validated['comment'],
        ]);

        if($validated['multiplication']){
            for($i =0; $i < $validated['multiplication'];$i++){
                FireExtinguisher::create([
                    'place' => $validated['place'],
                    'internal_identifier' => $validated['internal_identifier'],
                    'standby_location'=> $validated['standby_location'],
                    'device_type'=> $validated['device_type'],
                    'serial_number'=> $validated['serial_number'],
                    'date_of_manufacture' => date('Y-m-d H:i:s', strtotime($date)),
                    'comment'=> @$validated['comment'],
                ]);
            }
        }
    }

    function delete(FireExtinguisher $fireExtinguisher){
        $fireExtinguisher->delete();
    }

}
