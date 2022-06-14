<?php

namespace App\Imports;

use App\Models\Result;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;


class ResultsImport implements ToCollection, WithHeadingRow
{
   /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $race;

    //   public function startRow(): int
    // {
    //     return 2;
    // }

    public function __construct($race)
    {
        $this->race = $race;
    }
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.fullname' => 'required|string|max:255',
            '*.distance' => 'required|in:long,medium',
            '*.time' => 'date_format:H:i:s'
        ])->validate();
 
       foreach ($rows as $row) {
           Result::create([
               'fullName' => $row['fullname'],
               'distance' => $row['distance'],
               'raceTime' => $row['time'],
               'race_id' => $this->race,
           ]);
       }
    }

    
}