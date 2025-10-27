@extends('layouts.app')
@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Editar Partido</h1>
    <form method="POST" action="{{ route('admin.partidos.update', $partido->id_partido) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Sigla *</label>
                <input type="text" name="sigla" class="w-full border rounded p-2" value="{{ old('sigla', $partido->sigla) }}" required>
                @error('sigla') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Estado *</label>
                <select name="estado" class="w-full border rounded p-2" required>
                    <option value="">Seleccionar</option>
                    <option value="ACTIVO" {{ old('estado', $partido->estado) == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="INACTIVO" {{ old('estado', $partido->estado) == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                </select>
                @error('estado') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="col-span-2">
                <label>Nombre *</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" value="{{ old('nombre', $partido->nombre) }}" required>
                @error('nombre') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="col-span-2">
                <label>Logo Actual</label>
                @if($partido->logo_url)
                    <div class="mb-3">
                        <img src="{{ asset($partido->logo_url) }}" alt="Logo actual" class="w-24 h-24 object-cover rounded border">
                        <p class="text-sm text-gray-600 mt-1">Logo actual</p>
                    </div>
                @else
                    <p class="text-gray-400 text-sm mb-3">Sin logo</p>
                @endif
            </div>
            <div class="col-span-2">
                <label>Nuevo Logo</label>
                <input type="file" name="logo" class="w-full border rounded p-2" accept="image/*">
                <p class="text-sm text-gray-600 mt-1">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo: 2MB</p>
                @error('logo') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            <a href="{{ route('admin.partidos.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
        </div>
    </form>
</div>
@endsection
