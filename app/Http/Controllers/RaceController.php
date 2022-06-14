<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvRequest;
use App\Models\Race;
use Illuminate\Http\Request;
use App\Http\Requests\RaceRequest;
use App\Http\Requests\ResultRequest;
use App\Imports\ResultsImport;
use App\Models\Result;
use Maatwebsite\Excel\Facades\Excel;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $races = Race::all();
        return view('races', ['race' => $races]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('race-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RaceRequest $request)
    {
        $validated = $request->validated();
        $race = Race::create($validated);
        $raceId = $race->id;
        $file = $validated['file'];
        Excel::import(new ResultsImport($raceId), $file);
        $this->place($raceId);
        return redirect()->route('race.index')->with('status', 'Race added');
    }

    private function place($raceId)
    {
        //Get all results
        $toBePlacedLong = Result::where('race_id', $raceId)->where('distance', 'long')->where('race_id', $raceId)->orderBy('raceTime', 'ASC')->get();
        $toBePlacedMedium = Result::where('race_id', $raceId)->where('distance', 'medium')->where('race_id', $raceId)->orderBy('raceTime', 'ASC')->get();

        foreach ($toBePlacedLong as $key => $value) {
            //placement is key+1 since key starts at 0
            $value->fill(['placement' => (+$key + 1)]);
            $value->save();
        }
        foreach ($toBePlacedMedium as $key => $value) {
            $value->fill(['placement' => (+$key + 1)]);
            $value->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $race = Race::findOrFail($id);
        $results = $race->results;
        if(count($results)>0){
        $sorted = $results->sortBy('placement')->groupBy('distance');
        $race = Race::findOrFail($id);
        $results = $race->results;
        $sorted = $results->sortBy('placement')->groupBy('distance');
        $medium = $sorted['medium']->pluck('raceTime')->toArray();
        $avgM = date('H:i:s', array_sum(array_map('strtotime', $medium)) / count($medium));
        $long = $sorted['long']->pluck('raceTime')->toArray();
        $avgL = date('H:i:s', array_sum(array_map('strtotime', $long)) / count($long));
        return view('check-race', ['race' => $race, 'results' => $sorted, 'l' => $avgL, 'm' => $avgM]);
        }
        else{
            return redirect()->route('race.add', ['race' => $race->id])->with('status', 'Please import the results for the race');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Race  $race
     * @return \Illuminate\Http\Response
     */

    public function add($id){
        $race = Race::findOrFail($id);
        return view('add-csv', ['race' => $race]);
    }
    public function csv(CsvRequest $request){
        $validated = $request->validated();
        $race = Race::findOrFail($validated['race']);
        $file = $validated['file'];
        Excel::import(new ResultsImport($race->id), $file);
        $this->place($race->id);
        return redirect()->route('race.show', ['race' => $race->id])->with('status', 'Csv imported');

    }
    public function edit($id)
    {
        $result = Result::findOrFail($id);

        return view('update-result', ['result' => $result]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function update(ResultRequest $request, $id)
    {
        $result = Result::findOrFail($id);
        $validated = $request->validated();
        $result->update(['fullName' => $validated['fullName'], 'raceTime' => $validated['raceTime']]);
        $this->place($result->race_id);
        return redirect()->route('race.show', ['race' => $result->race_id])->with('status', 'Result updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $race = Race::findOrFail($id);
        $results = Result::where('race_id', $race->id)->delete();
        $race->delete();
        return redirect()->route('race.index')->with('status', 'Sucessfully deleted');
    }
}
