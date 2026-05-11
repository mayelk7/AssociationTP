<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Association;
use App\Models\Domaine;
use Illuminate\Support\Facades\Log;

class AssociationController extends Controller
{
    public function listAsso()
    {
        try {
            $associations = Association::with('domaine')->get();
            return view('association', compact('associations'));
        } catch (\Throwable $th) {
            Log::error('Erreur dans listAsso : '.$th->getMessage());
            return redirect()->back()->with('error', 'Impossible de charger la liste des associations.');
        }
    }

    public function detail($id)
    {
        try {
            $association = Association::with('domaine')->findOrFail($id);
            return view('association_detail', compact('association'));
        } catch (\Throwable $th) {
            Log::error('Erreur dans detail : '.$th->getMessage());
            return redirect()->route('association')->with('error', 'Association introuvable.');
        }
    }

    public function edit($id)
    {
        try {
            $association = Association::with('domaine')->findOrFail($id);
            $domaines = Domaine::all();
            return view('association_edit', compact('association', 'domaines'));
        } catch (\Throwable $th) {
            Log::error('Erreur dans edit : '.$th->getMessage());
            return redirect()->route('association')->with('error', 'Erreur lors de l’édition de l’association.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $association = Association::findOrFail($id);

            $request->validate([
                'nom_asso' => 'required|string|max:255',
                'email_asso' => 'required|email',
                'ville_asso' => 'required|string|max:255',
                'description_asso' => 'nullable|string|max:255',
                'domaine_id' => 'required|exists:domaine,id_domaine',
            ]);

            $association->update($request->only([
                'nom_asso', 'email_asso', 'ville_asso', 'description_asso', 'domaine_id'
            ]));

            return redirect()->route('association')
                ->with('success', 'Association mise à jour avec succès.');
        } catch (\Throwable $th) {
            Log::error('Erreur dans update : '.$th->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour de l’association.');
        }
    }

    public function destroy($id)
    {
        try {
            $association = Association::findOrFail($id);
            $association->delete();

            return redirect()->route('association')
                ->with('success', 'Association supprimée avec succès.');
        } catch (\Throwable $th) {
            Log::error('Erreur dans destroy : '.$th->getMessage());
            return redirect()->route('association')->with('error', 'Erreur lors de la suppression.');
        }
    }

    // Correction ici : "create"
    public function create()
    {
        try {
            $domaines = Domaine::all();
            return view('association_add', compact('domaines'));
        } catch (\Throwable $th) {
            Log::error('Erreur dans create : '.$th->getMessage());
            return redirect()->route('association')->with('error', 'Erreur lors de l’ouverture du formulaire.');
        }
    }

    // Correction : store et utilisation de create()
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nom_asso' => 'required|string|max:255',
                'email_asso' => 'required|email|unique:associations,email_asso',
                'ville_asso' => 'required|string|max:255',
                'description_asso' => 'nullable|string',
                'domaine_id' => 'required|exists:domaine,id_domaine',
            ]);

            Association::create([
                'nom_asso' => $request->nom_asso,
                'email_asso' => $request->email_asso,
                'ville_asso' => $request->ville_asso,
                'description_asso' => $request->description_asso,
                'domaine_id' => $request->domaine_id,
            ]);

            return redirect()->route('association')
                ->with('success', 'Association ajoutée avec succès.');
        } catch (\Throwable $th) {
            Log::error('Erreur dans store : '.$th->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l’ajout de l’association.');
        }
    }
}
