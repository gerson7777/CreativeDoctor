@extends('layouts.panel')

@section('content')
<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Agregar Nueva Especialidad</h3>
            </div>
            <div class="col text-right">
                <a href="{{url('specialties')}}" class="btn btn-sm btn-default">Cancelar</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        
            @if ($errors->any())
            <div class="alert alert-warning" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
            @endif
    

        
        <form action="{{ url('specialties')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Especialidad</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="name">Descripcion</label>
                <input type="text" name="description" class="form-control" value="{{ old('description') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
@endsection

<!--ctrl alt f-->