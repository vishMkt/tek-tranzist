<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
      $data['nav']= "Dashboard";
      return view('company.dashboard');
    }
}
?>