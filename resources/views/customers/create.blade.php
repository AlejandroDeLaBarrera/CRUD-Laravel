@extends('layouts.app')

@section('content')
<div>
    <h1>Crear Nuevo Customer</h1>

    @if ($errors->any())
    <div class="">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="surname">Apellido</label>
            <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname') }}" required>
        </div>

        <div>
            <label for="hobbies">Hobbies</label>
            <select name="hobbies[]" id="hobbies" class="form-control" multiple>
                @foreach($hobbies as $hobbie)
                    <option value="{{ $hobbie->id }}">{{ $hobbie->name}}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Guardar</button>
        <a href="{{ route('customers.index') }}">Cancelar</a>

    </form>
</div>
@endsection
