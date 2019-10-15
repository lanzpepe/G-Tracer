@extends('layout')

@section('title')
    Upload Graduates
@endsection

@section('js_code')
    $('.dropdown-toggle').dropdown();
    $(document).ready(function () {
        var deptOldValue = '{{ old('departments') }}';

        if (deptOldValue !== '')
            $('#departments').val(deptOldValue);

        $('#departments').change();
    });
@endsection

@section('content_form')
    <form action="{{ route('import_parse') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="form-inline">
            <section class="form-group">
                <label for="departments">COLLEGE:</label>
                <select class="form-control mx-sm-3" id="departments" name="departments" required>
                    @foreach ($departments as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </section>
            <section class="form-group">
                <label for="example3">BATCH:</label>
                <select class="form-control mx-sm-3" name="batch" required>
                    @foreach ($batches as $batch)
                        <option value="{{ $batch }}">{{ $batch }}</option>
                    @endforeach
                </select>
            </section>
            <section class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                <label for="file">GRADUATE LIST (.csv)</label>
                <input accept=".csv" class="form-control mx-sm-3" name="file" type="file" required>

                @if ($errors->has('file'))
                    <span class="help-block">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @endif
            </section>
            <button type="submit" class="btn btn-primary" id="btn-submit">
                <i class="fa fa-check"></i> Upload
            </button>
        </section>
    </form>
@endsection

{{-- @section('list')
    <form class="form-horizontal" method="POST" action="{{ route('import_process') }}">
        @csrf

        <table class="table">
            @foreach ($csv_data as $row)
                <tr>
                @foreach ($row as $key => $value)
                    <td>{{ $value }}</td>
                @endforeach
                </tr>
            @endforeach
        </table>

        <button type="submit" class="btn btn-primary">
            Import Data
        </button>
    </form>
@endsection --}}
