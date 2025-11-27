<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novi projekt
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('projects.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium mb-1">Naziv projekta</label>
                        <input type="text" name="naziv_projekta"
                               value="{{ old('naziv_projekta') }}"
                               class="border rounded w-full px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Opis projekta</label>
                        <textarea name="opis_projekta" rows="3"
                                  class="border rounded w-full px-3 py-2">{{ old('opis_projekta') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Cijena projekta</label>
                        <input type="number" step="0.01" name="cijena_projekta"
                               value="{{ old('cijena_projekta') }}"
                               class="border rounded w-full px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Obavljeni poslovi</label>
                        <textarea name="obavljeni_poslovi" rows="3"
                                  class="border rounded w-full px-3 py-2">{{ old('obavljeni_poslovi') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">Datum početka</label>
                            <input type="date" name="datum_pocetka"
                                   value="{{ old('datum_pocetka') }}"
                                   class="border rounded w-full px-3 py-2">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Datum završetka</label>
                            <input type="date" name="datum_zavrsetka"
                                   value="{{ old('datum_zavrsetka') }}"
                                   class="border rounded w-full px-3 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Članovi tima</label>
                        <select name="members[]" multiple
                                class="border rounded w-full px-3 py-2 h-40">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ collect(old('members', []))->contains($user->id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">
                            Drži CMD (na Macu) ili CTRL (na Windowsu) za odabir više članova.
                        </p>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('projects.index') }}"
                           class="px-4 py-2 border rounded">
                            Odustani
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Spremi projekt
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
