<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersAddressRequest;
use App\Http\Resources\UserAddressResource;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
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
    public function store(UsersAddressRequest $request)
    {
        $addr = UserAddress::create([
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
            ->with('success', "User Address for user: " . $addr->user()->select('id', 'name', 'email')->get()->first() . " stored Successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userAddress = UserAddress::findOrFail($id);
        return Inertia::render('UsersInfo/UsersAddress/UsersAddressEdit', array(
            'userAddress' => new UserAddressResource($userAddress),
            'user' => $userAddress->user()->select('id', 'name', 'email')->get()->first(),
            'users' => User::all()->select('id', 'name', 'email'),
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersAddressRequest $request, string $userAddress)
    {

        $addr = UserAddress::findOrFail($userAddress);

        $addr->update([
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
            ->with('success', "User Address for user: " . $addr->user()->select('id', 'name', 'email')->get()->first() . " updated Successfully");

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id): RedirectResponse
    {
        $userAddress = UserAddress::findOrFail($id);
        $user = $userAddress->user()->select('id', 'name', 'email')->get()->first();
        $userAddress->delete();
        return to_route('usersAddress.index')
            ->with('danger', "User address of user : '" . $user . "' is deleted successfully");
    }
}
