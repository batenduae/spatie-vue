<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAddressResource;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('UsersInfo/UsersAddress/UsersAddressIndex', [
            'usersAddress' => UserAddressResource::collection(UserAddress::all()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('UsersInfo/UsersAddress/UsersAddressCreate', [
            'users' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $address = UserAddress::create([
            'user_id' => $request->user_id,
            'addressType' => $request->addressType,
            'district' => $request->district,
            'typeVillageMunicipalityCity' => $request->typeVillageMunicipalityCity,
            'upazillaCity' => $request->upazillaCity,
            'policeStation' => $request->policeStation,
            'unionMunicipality' => $request->unionMunicipality,
            'wardCouncil' => $request->wardCouncil,
            'villageMohokuma' => $request->villageMohokuma,
            'roadNo' => $request->roadNo,
            'houseNo' => $request->houseNo,
            'otherDetails' => $request->otherDetails,
        ]);
        return to_route('usersAddress.index')
            ->with('success', "User Address for :  Created Successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
