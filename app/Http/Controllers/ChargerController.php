<?php

namespace App\Http\Controllers;

use App\Models\Charger;
use Illuminate\Http\Request;

class ChargerController extends Controller
{

    public function getCharge($type)
    {
        $charge = Charger::where('applicable_to', $type)->value('amount');
        return response()->json(['charge' => $charge ?? 0]);
    }

    // Return all chargers (for your table)
    public function index()
    {
        $chargers = Charger::all();
        return view('chargers.index', compact('chargers'));
    }

    // Store new charger (Add)
    public function store(Request $request)
    {
        $request->validate([
            'applicable_to' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        Charger::create([
            'applicable_to' => $request->applicable_to,
            'amount' => $request->amount,
        ]);

        return response()->json(['success' => true]);
    }

    // Update charger (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'applicable_to' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $charger = Charger::findOrFail($id);
        $charger->update([
            'applicable_to' => $request->applicable_to,
            'amount' => $request->amount,
        ]);

        return response()->json(['success' => true]);
    }

    // Delete charger
    public function destroy($id)
    {
        $charger = Charger::findOrFail($id);
        $charger->delete();

        return response()->json(['success' => true]);
    }





}
