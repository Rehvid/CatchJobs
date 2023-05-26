<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Location;
use App\Models\SocialNetwork;
use Illuminate\View\View;


class CompanyController extends Controller
{
    public function list(): View
    {
        $companies = Company::paginate(16);

        return view('admin.company.list', compact('companies'));
    }

    public function create(): View
    {
        $locations = Location::all();
        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        return view('admin.company.form', compact('locations', 'socialNetworks'));
    }

    public function edit(Company $company): View
    {
        $company->load('benefits', 'socials', 'files');
        $locations = Location::byUserId($company->user_id)->get();
        $socialNetworks = SocialNetwork::all()->pluck('name', 'id');

        return view('admin.company.form', compact([
            'company',
            'locations',
            'socialNetworks'
        ]));
    }
}
