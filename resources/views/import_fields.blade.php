@extends('import')

@section('js_code')
    $(document).ready(function () {
        var deptOldValue = '{{ old('departments') }}';

        if (deptOldValue !== '')
            $('#departments').val(deptOldValue);

        $('#departments').change();
    });
@endsection

@section('content_list')
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
@endsection
