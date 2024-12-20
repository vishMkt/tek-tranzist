<?php

namespace App\Imports;

use App\Models\Tree;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TreeImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tree([
            'treeid'     => $row['treeid'],
            'name'     => $row['name'],
            'location'     => $row['location'],
            'longitude'     => $row['longitude'],
            'latitude'     => $row['latitude'],
            'species'     => $row['species'],
            'date'     => $row['date'],
            'age'     => $row['age'],
            'height'     => $row['height'],
            'diameter'     => $row['diameter'],
            'carbon'     => $row['carbon'],
            'status'     => 1,
        ]);
    }
}
