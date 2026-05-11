<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domaine;
use Illuminate\Support\Facades\Log;

class DomaineController extends Controller
{
    public function index()
    {
        $domaines = Domaine::withCount('associations')->orderBy('nom_domaine')->get();
        return view('domaine_list', compact('domaines'));
    }

    public function create()
    {
        try {
            return view('domaine_add');
        } catch (\Throwable $th) {
            Log::error("Erreur dans create domaine : " . $th->getMessage());
            return redirect()->back()->with('error', "Impossible d'ouvrir le formulaire.");
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nom_domaine' => 'required|string|max:255|unique:domaine,nom_domaine',
            ]);

            Domaine::create(['nom_domaine' => $request->nom_domaine]);

            return redirect()->route('domaine.index')->with('success', "Domaine ajouté avec succès.");
        } catch (\Throwable $th) {
            Log::error("Erreur dans store domaine : " . $th->getMessage());
            return redirect()->back()->with('error', "Erreur lors de l'ajout du domaine.");
        }
    }

    public function destroy($id)
    {
        $domaine = Domaine::findOrFail($id);

        if ($domaine->associations()->count() > 0) {
            return redirect()->route('domaine.index')
                ->with('error', __('messages.domain_in_use'));
        }

        $domaine->delete();
        return redirect()->route('domaine.index')->with('success', "Domaine supprimé avec succès.");
    }
}
