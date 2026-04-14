@extends('layouts.app')
@section('title', 'Modifier la dépense')
@section('breadcrumb', 'Accueil / Dépenses / Modifier')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-edit text-yellow-500 mr-2"></i>Modifier la dépense
    </h3>

    <form action="{{ route('depenses.update', $depense) }}" method="POST" class="space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Immeuble <span class="text-red-500">*</span>
            </label>
            <select name="immeuble_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($immeubles as $imm)
                    <option value="{{ $imm->id }}"
                        {{ old('immeuble_id', $depense->immeuble_id) == $imm->id ? 'selected' : '' }}>
                        {{ $imm->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" name="date"
                       value="{{ old('date', $depense->date->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant (MAD)</label>
                <input type="number" name="montant"
                       value="{{ old('montant', $depense->montant) }}"
                       step="0.01" min="0.01"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
            <select name="categorie"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($categories as $cat)
                    <option value="{{ $cat }}"
                        {{ old('categorie', $depense->categorie) == $cat ? 'selected' : '' }}>
                        {{ ucfirst($cat) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $depense->description) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Mettre à jour
            </button>
            <a href="{{ route('depenses.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection