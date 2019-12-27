@extends('home')

@section('title')
    {{ __('Import Graduates') }}
@endsection

@section('alert')
@if ($errors->any())
    <div class="float">
        <div class="alert alert-danger py-0" role="alert">
            <div class="list-group">
            @foreach ($errors->all() as $message)
                <div class="list-group-item">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle fa-lg"></i>
                    </div>
                    {{ $message }}
                </div>
            @endforeach
            </div>
        </div>
    </div>
@else
    @if ($message = Session::get('success'))
        <div class="float">
            <div class="alert alert-success py-0" role="alert">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="alert-icon">
                            <i class="fas fa-check fa-lg"></i>
                        </div>
                        {{ $message }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
@endsection

@section('main')
<div class="card">
    <div class="card-body">
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4 p-2">
                    <label for="_school">School:</label>
                    <select class="form-control border border-success rounded" name="school" id="school" required>
                        <option value="{{ $admin->schools->first()->name }}">{{ $admin->schools->first()->name }}</option>
                    </select>
                </div>
                <div class="form-group col-md-4 p-2">
                    <label for="_dept">Department:</label>
                    <select class="form-control border border-success rounded" name="dept" id="department" required>
                        <option value="{{ $admin->departments->first()->name }}">{{ $admin->departments->first()->name }}</option>
                    </select>
                </div>
                <div class="form-group col-md-4 p-2">
                    <label for="_sy">School Year:</label>
                    <select class="form-control border border-success rounded" name="sy" id="schoolYear" required>
                        @foreach ($schoolYears as $sy)
                            <option value="{{ $sy->school_year }}">{{ $sy->school_year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-4 p-2">
                    <label for="_batch">{{ __('Batch:') }}</label>
                    <select class="form-control border border-success rounded" name="batch" id="batch" required>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->name }}">{{ $batch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-file-upload form-file-simple col-6 px-2">
                    <label for="_dept">{{ __('Graduate List (.csv)') }}</label>
                    <input type="text" class="form-control form-control-file border border-success rounded inputFileVisible" placeholder="Browse files...">
                    <input type="file" accept=".csv" class="inputFileHidden" name="file" required>
                </div>
                <div class="form-inline col-2 pt-4">
                    <button type="submit" class="btn btn-success">
                        <span class="fas fa-upload fa-fw"></span>
                        <span>{{ __('Upload') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@yield('field_list')
@endsection
