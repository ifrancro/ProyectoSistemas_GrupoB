@extends('layouts.app')
@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Editar Persona</h1>
    <form method="POST" action="{{ route('admin.personas.update', $persona) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>CI</label>
                <input type="number" name="ci" class="w-full border rounded p-2" value="{{ $persona->ci }}" readonly>
            </div>
            <div>
                <label>Nombre *</label>
                <input type="text" name="nombre" class="w-full border rounded p-2" value="{{ $persona->nombre }}" required>
                @error('nombre') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Apellido *</label>
                <input type="text" name="apellido" class="w-full border rounded p-2" value="{{ $persona->apellido }}" required>
                @error('apellido') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Fecha Nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="w-full border rounded p-2" value="{{ $persona->fecha_nacimiento }}">
            </div>
            <div>
                <label>Teléfono</label>
                <input type="text" name="telefono" class="w-full border rounded p-2" value="{{ $persona->telefono }}">
            </div>
            <div>
                <label>Correo</label>
                <input type="email" name="correo" class="w-full border rounded p-2" value="{{ $persona->correo }}">
            </div>
            <div>
                <label>Ciudad</label>
                <input type="text" name="ciudad" class="w-full border rounded p-2" value="{{ $persona->ciudad }}">
            </div>
            <div>
                <label>Estado *</label>
                <select name="estado" class="w-full border rounded p-2" required>
                    <option value="">Seleccionar</option>
                    <option value="VIVO" {{ $persona->estado == 'VIVO' ? 'selected' : '' }}>VIVO</option>
                    <option value="FALLECIDO" {{ $persona->estado == 'FALLECIDO' ? 'selected' : '' }}>FALLECIDO</option>
                </select>
                @error('estado') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Foto de Carnet</label>
                <input type="file" name="foto_carnet" class="w-full border rounded p-2" accept="image/*">
                @if($persona->foto_carnet)
                    <p class="text-sm text-gray-600 mt-1">Archivo actual: {{ $persona->foto_carnet }}</p>
                @endif
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
            <a href="{{ route('admin.personas.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
        </div>
    </form>
</div>
@endsection
