@extends('layouts.admin-modules')

@section('module')
    <div class="container">
        <div class="card shadow mb-4 text-dark">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary d-inline-block py-2">Importar base de datos</h6>    
            </div>

            <div class="card-body">            
            <form action="{{route('upload.db')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="file">Seleccionar archivo:</label>
                                <input type="file" class="@error('file') is-invalid @enderror" name="file" id="file" required>
                                
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <div class="modal-footer justify-content-center">
                                    <input type="submit" name="submit" class="btn btn-primary" value="Importar">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4 text-dark">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary d-inline-block py-2">Importar base de datos</h6>    
            </div>

            <div class="card-body">            
                <a href="{{route('export.csv')}}" class="btn btn-success">Export</a>
            </div>
        </div>
    </div>
@endsection