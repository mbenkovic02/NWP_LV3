<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalji projekta: {{ $project->naziv_projekta }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">

                @if (session('success'))
                    <div class="mb-3 text-green-600 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <h3 class="text-lg font-semibold mb-1">Osnovne informacije</h3>
                    <p><strong>Naziv:</strong> {{ $project->naziv_projekta }}</p>
                    <p><strong>Opis:</strong> {{ $project->opis_projekta ?? '-' }}</p>
                    <p><strong>Cijena:</strong> {{ $project->cijena_projekta ?? '-' }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-1">Voditelj</h3>
                    <p>{{ $project->leader->name ?? 'N/A' }} ({{ $project->leader->email ?? '' }})</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-1">Članovi tima</h3>
                    @if ($project->members->isEmpty())
                        <p>Nema dodanih članova.</p>
                    @else
                        <ul class="list-disc ml-6">
                            @foreach ($project->members as $member)
                                <li>{{ $member->name }} ({{ $member->email }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-1">Obavljeni poslovi</h3>
                    <p>{{ $project->obavljeni_poslovi ?? '-' }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <strong>Datum početka:</strong>
                        <p>{{ $project->datum_pocetka ?? '-' }}</p>
                    </div>
                    <div>
                        <strong>Datum završetka:</strong>
                        <p>{{ $project->datum_zavrsetka ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex justify-between mt-4">
                    <a href="{{ route('projects.index') }}"
                       class="px-4 py-2 border rounded">
                        Natrag na projekte
                    </a>

                    @if (auth()->id() === $project->user_id)
                        <div class="flex space-x-2">
                            <a href="{{ route('projects.edit', $project) }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Uredi
                            </a>

                            <form method="POST" action="{{ route('projects.destroy', $project) }}"
                                  onsubmit="return confirm('Jesi siguran da želiš obrisati ovaj projekt?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Obriši
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('projects.edit', $project) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Uredi obavljene poslove
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
