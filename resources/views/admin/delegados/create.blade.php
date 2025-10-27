@extends('layouts.app')
@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Nuevo Delegado</h1>
    <form method="POST" action="{{ route('admin.delegados.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Persona *</label>
                <select name="persona_id" class="w-full border rounded p-2" required>
                    <option value="">Seleccionar persona</option>
                    @foreach($personas as $persona)
                        <option value="{{ $persona->id }}">{{ $persona->ci }} - {{ $persona->nombre }} {{ $persona->apellido_paterno }}</option>
                    @endforeach
                </select>
                @error('persona_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Partido *</label>
                <select name="partido_id" class="w-full border rounded p-2" required>
                    <option value="">Seleccionar partido</option>
                    @foreach($partidos as $partido)
                        <option value="{{ $partido->id }}">{{ $partido->sigla }} - {{ $partido->nombre }}</option>
                    @endforeach
                </select>
                @error('partido_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Mesa *</label>
                <select name="mesa_id" class="w-full border rounded p-2" required>
                    <option value="">Seleccionar mesa</option>
                    @foreach($mesas as $mesa)
                        <option value="{{ $mesa->id }}">Mesa {{ $mesa->numero }}</option>
                    @endforeach
                </select>
                @error('mesa_id') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Rol Delegado</label>
                <input type="text" name="rol_delegado" class="w-full border rounded p-2" placeholder="Nacional, Departamental, De Mesa">
            </div>
            <div>
                <label>Habilitado</label>
                <select name="habilitado" class="w-full border rounded p-2">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('admin.delegados.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
        </div>
    </form>
</div>
@endsection
