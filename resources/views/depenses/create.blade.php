@extends('layouts.app')
@section('title', 'Ajouter une dépense')
@section('breadcrumb', 'Accueil / Dépenses / Ajouter')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-8">
    <h3 class="text-lg font-semibold text-gray-700 mb-6">
        <i class="fas fa-plus-circle text-orange-500 mr-2"></i>Nouvelle dépense
    </h3>

    <form action="{{ route('depenses.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Immeuble <span class="text-red-500">*</span>
            </label>
            <select name="immeuble_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('immeuble_id') border-red-400 @enderror">
                <option value="">-- Sélectionner un immeuble --</option>
                @foreach($immeubles as $imm)
                    <option value="{{ $imm->id }}" {{ old('immeuble_id') == $imm->id ? 'selected' : '' }}>
                        {{ $imm->nom }}
                    </option>
                @endforeach
            </select>
            @error('immeuble_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Date <span class="text-red-500">*</span>
                </label>
                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('date') border-red-400 @enderror">
                @error('date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Montant (MAD) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="montant" value="{{ old('montant') }}"
                       step="0.01" min="0.01"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('montant') border-red-400 @enderror"
                       placeholder="Ex: 500.00">
                @error('montant')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Catégorie <span class="text-red-500">*</span>
            </label>
            <select name="categorie"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('categorie') border-red-400 @enderror">
                <option value="">-- Sélectionner --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>
                        {{ ucfirst($cat) }}
                    </option>
                @endforeach
            </select>
            @error('categorie')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                      placeholder="Détails de la dépense...">{{ old('description') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg transition">
                <i class="fas fa-save mr-1"></i> Enregistrer
            </button>
            <a href="{{ route('depenses.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition">
                Annuler
            </a>
        </div>
    </form>
</div>

@endsection