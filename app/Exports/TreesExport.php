<?php

namespace App\Exports;

use App\Models\Tree;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TreesExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tree::select('treeid', 'name', 'location', 'longitude', 'latitude', 'species', 'date', 'age', 'height', 'diameter', 'carbon')->get();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["TreeID", "Name", "Location", "Longitude", "Latitude", "Species", "Date", "Age", "Height", "Diameter", "Carbon"];
    }
}
