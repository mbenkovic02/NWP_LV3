<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // lista svih projekata na kojima user sudjeluje (kao voditelj ili član)
    public function index()
    {
        $user = Auth::user();

        $projects = Project::where('user_id', $user->id)
            ->orWhereHas('members', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            })
            ->distinct()
            ->get();

        return view('projects.index', compact('projects'));
    }

    // forma za novi projekt
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('projects.create', compact('users'));
    }

    // spremanje novog projekta
    public function store(Request $request)
    {
        $data = $request->validate([
            'naziv_projekta'    => 'required|string|max:255',
            'opis_projekta'     => 'nullable|string',
            'cijena_projekta'   => 'nullable|numeric',
            'obavljeni_poslovi' => 'nullable|string',
            'datum_pocetka'     => 'nullable|date',
            'datum_zavrsetka'   => 'nullable|date|after_or_equal:datum_pocetka',
            'members'           => 'array',
            'members.*'         => 'exists:users,id',
        ]);

        $data['user_id'] = Auth::id(); // voditelj je prijavljeni korisnik

        $project = Project::create($data);

        if (!empty($data['members'])) {
            $project->members()->sync($data['members']);
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Projekt je uspješno kreiran.');
    }

    // prikaz jednog projekta
    public function show(Project $project)
    {
        $project->load('leader', 'members');

        return view('projects.show', compact('project'));
    }

    // forma za edit projekta
    public function edit(Project $project)
    {
        [$isLeader, $isMember] = $this->checkAccess($project);

        $users = User::where('id', '!=', Auth::id())->get();
        $selectedMembers = $project->members->pluck('id')->toArray();

        return view('projects.edit', [
            'project'         => $project,
            'users'           => $users,
            'selectedMembers' => $selectedMembers,
            'isLeader'        => $isLeader,
            'isMember'        => $isMember,
        ]);
    }

    // spremanje izmjena
    public function update(Request $request, Project $project)
    {
        [$isLeader, $isMember] = $this->checkAccess($project);

        if ($isLeader) {
            $data = $request->validate([
                'naziv_projekta'    => 'required|string|max:255',
                'opis_projekta'     => 'nullable|string',
                'cijena_projekta'   => 'nullable|numeric',
                'obavljeni_poslovi' => 'nullable|string',
                'datum_pocetka'     => 'nullable|date',
                'datum_zavrsetka'   => 'nullable|date|after_or_equal:datum_pocetka',
                'members'           => 'array',
                'members.*'         => 'exists:users,id',
            ]);

            $project->update($data);

            if (isset($data['members'])) {
                $project->members()->sync($data['members']);
            }
        } elseif ($isMember) {
            // član tima smije mijenjati samo obavljeni_poslovi
            $data = $request->validate([
                'obavljeni_poslovi' => 'required|string',
            ]);

            $project->update($data);
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Projekt je ažuriran.');
    }

    // brisanje projekta - samo voditelj
    public function destroy(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Samo voditelj može obrisati projekt.');
        }

        $project->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Projekt je obrisan.');
    }

    // pomoćna metoda: provjera je li korisnik voditelj ili član
    private function checkAccess(Project $project): array
    {
        $user = Auth::user();

        $isLeader = $project->user_id === $user->id;
        $isMember = $project->members->contains($user->id);

        if (!$isLeader && !$isMember) {
            abort(403, 'Nemaš pristup ovom projektu.');
        }

        return [$isLeader, $isMember];
    }
}
