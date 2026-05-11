<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Domaine;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * GET /api/domaines
     * Retourne tous les domaines.
     */
    public function domaines(): JsonResponse
    {
        try {
            $domaines = Domaine::all(['id_domaine', 'nom_domaine']);
            return response()->json($domaines);
        } catch (\Throwable $th) {
            Log::error('API domaines : ' . $th->getMessage());
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    /**
     * GET /api/domaines/{id}/associations
     * Retourne toutes les associations d'un domaine.
     */
    public function associationsByDomaine(int $id): JsonResponse
    {
        try {
            $domaine = Domaine::with('associations')->findOrFail($id);
            return response()->json([
                'domaine' => [
                    'id_domaine'   => $domaine->id_domaine,
                    'nom_domaine'  => $domaine->nom_domaine,
                ],
                'associations' => $domaine->associations,
            ]);
        } catch (\Throwable $th) {
            Log::error('API associationsByDomaine : ' . $th->getMessage());
            return response()->json(['error' => 'Domaine introuvable'], 404);
        }
    }

    /**
     * GET /api/associations
     * Retourne toutes les associations avec leur domaine.
     */
    public function associations(): JsonResponse
    {
        try {
            $associations = Association::with('domaine')->get();
            return response()->json($associations);
        } catch (\Throwable $th) {
            Log::error('API associations : ' . $th->getMessage());
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }

    /**
     * GET /api/associations/{id}
     * Retourne le détail d'une association.
     */
    public function association(int $id): JsonResponse
    {
        try {
            $association = Association::with('domaine')->findOrFail($id);
            return response()->json($association);
        } catch (\Throwable $th) {
            Log::error('API association : ' . $th->getMessage());
            return response()->json(['error' => 'Association introuvable'], 404);
        }
    }

    /**
     * GET /api/emails
     * Retourne tous les emails des associations (nom + email).
     */
    public function emails(): JsonResponse
    {
        try {
            $emails = Association::whereNotNull('email_asso')
                ->where('email_asso', '!=', '')
                ->get(['id_asso', 'nom_asso', 'email_asso']);
            return response()->json($emails);
        } catch (\Throwable $th) {
            Log::error('API emails : ' . $th->getMessage());
            return response()->json(['error' => 'Erreur serveur'], 500);
        }
    }
}
