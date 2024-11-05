<?php

namespace App\Http\Controllers\prescription;

use App\Models\Client;
use App\Models\Opticien;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['client', 'opticien'])->get();
        $clients = Client::all();
        $opticiens = Opticien::all();

        return view('prescription.index', compact('prescriptions', 'clients', 'opticiens'));
    }

    // Stocke une nouvelle prescription dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'opticien_id' => 'required|exists:opticiens,id',
            'spherique_od' => 'required|decimal:1,2',
            'spherique_og' => 'required|decimal:1,2',
            'distance_pupillaire' => 'required|decimal:1,2',
            'notes' => 'nullable|string|max:500',
        ]);

        Prescription::create([
            'client_id' => $request->client_id,
            'opticien_id' => $request->opticien_id,
            'spherique_od' => $request->spherique_od,
            'spherique_og' => $request->spherique_og,
            'distance_pupillaire' => $request->distance_pupillaire,
            'date_examen' => now(),
            'notes' => $request->notes,
        ]);

        return redirect()->route('prescription.index')->with('success', 'Prescription ajoutée avec succès.');
    }

    // Met à jour une prescription existante
    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'opticien_id' => 'required|exists:opticiens,id',
            'spherique_od' => 'required|decimal:1,2',
            'spherique_og' => 'required|decimal:1,2',
            'distance_pupillaire' => 'required|decimal:1,2',
            'notes' => 'nullable|string|max:500',
        ]);

        $prescription->update([
            'client_id' => $request->client_id,
            'opticien_id' => $request->opticien_id,
            'spherique_od' => $request->spherique_od,
            'spherique_og' => $request->spherique_og,
            'distance_pupillaire' => $request->distance_pupillaire,
            'date_examen' => now(),
            'notes' => $request->notes,
        ]);

        return redirect()->route('prescription.index')->with('success', 'Prescription mise à jour avec succès.');
    }

    // Supprime une prescription
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return redirect()->route('prescription.index')->with('success', 'Prescription supprimée avec succès.');
    }

    public function downloadPDF($id)
{
    $prescription = Prescription::findOrFail($id);

    // Générer la vue PDF avec les données de la prescription
    $pdf = PDF::loadView('prescription.pdf', compact('prescription'));

    // Télécharger le PDF
    return $pdf->download('prescription_'.$prescription->client->nom.'_'.$prescription->id.'.pdf');
}
}
