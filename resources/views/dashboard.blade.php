<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
    <h2 class="text-xl font-semibold mb-2">Projekti koje vodim</h2>
    <ul class="list-disc ml-6">
        @forelse ($projectsLed as $project)
            <li>
                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 underline">
                    {{ $project->naziv_projekta }}
                </a>
            </li>
        @empty
            <li>Još ne vodiš nijedan projekt.</li>
        @endforelse
    </ul>
</div>

<div class="mt-8">
    <h2 class="text-xl font-semibold mb-2">Projekti na kojima sam član</h2>
    <ul class="list-disc ml-6">
        @forelse ($projectsMember as $project)
            <li>
                <a href="{{ route('projects.show', $project) }}" class="text-blue-500 underline">
                    {{ $project->naziv_projekta }}
                </a>
            </li>
        @empty
            <li>Nisi član ni jednog projekta.</li>
        @endforelse
    </ul>
</div>

</x-app-layout>
