<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Moji projekti
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Projekti na kojima sudjelujem</h3>
                    <a href="{{ route('projects.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Novi projekt
                    </a>
                </div>

                @if ($projects->isEmpty())
                    <p>Još nemaš nijedan projekt.</p>
                @else
                    <ul class="space-y-2">
                        @foreach ($projects as $project)
                            <li class="border-b pb-2">
                                <a href="{{ route('projects.show', $project) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $project->naziv_projekta }}
                                </a>
                                <span class="text-sm text-gray-500">
                                    (voditelj: {{ $project->leader->name ?? 'N/A' }})
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
