@extends('layouts.app')
@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Gestión de Delegados</h1>
    <a href="{{ route('admin.delegados.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">+ Nuevo Delegado</a>
    @if(session('ok')) <p class="text-green-700 mt-2">{{ session('ok') }}</p> @endif

    <table class="w-full border mt-4">
        <thead class="bg-gray-100">
            <tr><th>CI</th><th>Nombre</th><th>Partido</th><th>Mesa</th><th>Rol</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            @foreach($delegados as $d)
            <tr class="border-b">
                <td>{{ $d->persona->ci }}</td>
                <td>{{ $d->persona->nombre }} {{ $d->persona->apellido_paterno }}</td>
                <td>{{ $d->partido->sigla }}</td>
                <td>{{ $d->mesa->numero ?? 'N/A' }}</td>
                <td>{{ $d->rol_delegado ?? 'N/A' }}</td>
                <td>
                    <form action="{{ route('admin.delegados.destroy',$d) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
