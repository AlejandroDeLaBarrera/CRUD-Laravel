
@extends('layouts.app')

@section('content')
<div>
    <h1>Lista de Customers</h1>
    <a href="{{ route('customers.create') }}">Crear Nuevo Customer</a>

    @if($customers->isEmpty())
        <p>No hay customers registrados</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Hobbies</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->surname }}</td>
                    <td>
                        <!-- Mostrar los hobbies del customer -->
                        @if($customer->hobbies->isNotEmpty())
                            @foreach($customer->hobbies as $hobbie)
                                <span>{{ $hobbie->name }}</span>
                            @endforeach
                        @else
                            <span>Sin hobbies</span>
                        @endif
                    </td>
                    <td>
                        <!-- Enlaces editar y eliminar -->
                        <a href="{{ route('customers.edit', $customer->id) }}">Editar</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
