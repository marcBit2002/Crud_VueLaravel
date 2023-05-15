@extends('layouts.principal')

@section('title')
    Politècnics ABP - Curs
@endsection

@section('content')
    @include('partials.mensajes')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header bg-light">
                <p class="card-text">Curs</p>
            </div>
            <div class="card-body">
                @if ($insert == false)
                    {{-- FORM CREATE --}}
                    <form
                        action="{{ action([App\Http\Controllers\CursController::class, 'update'], ['curso' => $curso->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mb-2">
                            <label for="sigles" class="col-sm-2 col-form-label">Sigles</label>
                            <div class="col-sm-10">
                                <input type="text" name="sigles" id="sigles" value="{{ $curso->sigles }}"
                                    class="form-control form-control-inline" autofocus required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" name="nom" id="nom" value="{{ $curso->nom }}"
                                    class="form-control form-control-inline" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="cicles" class="col-sm-2 col-form-label">Cicle</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="cicles_id">
                                    <option>Tots els cicles</option>
                                    @foreach ($cicles as $cicle)
                                        @if ($cicle->id == $curso->cicles_id)
                                            <option id="cicles_id" name="cicles_id" selected value="{{ $cicle->id }}">
                                                {{ $cicle->nom }}</option>
                                        @else
                                            <option id="cicles_id" name="cicles_id" value="{{ $cicle->id }}">
                                                {{ $cicle->nom }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-check-label col-sm-2" for="actiu">Actiu</label>
                            <div class="col-sm-10">
                                <input class="custom-control-input" type="checkbox" id="actiu" name="actiu"
                                    value="actiu" @checked($curso->actiu)>
                                <label class="custom-control-label" for="actiu"></label>
                            </div>
                        </div>
                        <div class="botons">
                            <button type="submit" class="btn btn-sm btn-primary"><i
                                    class="bi bi-check"></i>Acceptar</button>
                            <a href="{{ route('cursos.index') }}" class="btn btn-sm btn-secondary ml-1 float-right"><i
                                    class="bi bi-x"></i>Cancel·lar</a>
                        </div>
                    </form>
                @else
                    {{-- FORM EDIT --}}
                    <form action="{{ action([App\Http\Controllers\CursController::class, 'store']) }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <label for="sigles" class="col-sm-2 col-form-label">Sigles</label>
                            <div class="col-sm-10">
                                <input type="text" name="sigles" id="sigles" value="{{ old('sigles') }}"
                                    class="form-control form-control-inline" autofocus required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                                    class="form-control form-control-inline" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="cicles" class="col-sm-2 col-form-label">Cicle</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="cicles_id">
                                    <option>Tots els cicles</option>
                                    @foreach ($cicles as $cicle)
                                        <option id="cicles_id" name="cicles_id" value="{{ $cicle->id }}">
                                            {{ $cicle->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-check-label col-sm-2" for="actiu">Actiu</label>
                            <div class="col-sm-10">
                                @if (old('actiu') == 'actiu')
                                    <input class="custom-control-input" type="checkbox" id="actiu" name="actiu"
                                        value="actiu" checked>
                                    <label class="custom-control-label" for="actiu"></label>
                                @else
                                    <input class="custom-control-input" type="checkbox" id="actiu" name="actiu"
                                        value="actiu">
                                    <label class="custom-control-label" for="actiu"></label>
                                @endif
                            </div>
                        </div>
                        <div class="botons">
                            <button type="submit" class="btn btn-sm btn-primary"><i
                                    class="bi bi-check"></i>Acceptar</button>
                            <a href="{{ route('cursos.index') }}" class="btn btn-sm btn-secondary ml-1 float-right"><i
                                    class="bi bi-x"></i>Cancel·lar</a>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection
