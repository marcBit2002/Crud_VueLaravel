@extends('layouts.principal')

@section('title')
    Curso
@endsection

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header bg-light">   
            <p class="card-text">Cicle</p>
        </div>
        <div class="card-body">
            <form action="{{ action([App\Http\Controllers\CicleController::class, 'store']) }}" method="post">
                @csrf
                <div class="row mb-2">
                    <label for="id" class="col-sm-2 col-form-label">Identificador</label>
                    <div class="col-sm-10">
                        <input type="number" name="id" id="id" class="form-control form-control-inline" autofocus required>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="sigla" class="col-sm-2 col-form-label">Sigla</label>
                    <div class="col-sm-10">
                        <input type="text" name="sigla" id="sigla" class="form-control form-control-inline" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                    <div class="col-sm-10">
                        <input type="text" name="nom" id="nom" class="form-control form-control-inline" required>
                    </div>
                </div>
                <div class="botons">
                    <button type="submit" class="btn btn-primary">Acceptar</button>
                    <a href="{{ url('/cicles') }}" class="btn btn-secondary">Cancel·lar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection