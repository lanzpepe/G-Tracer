@extends('department.import')

@section('js_code')
<script type="text/javascript">
    $(function(){var a='{{ $schoolYear }}';var b='{{ $batch }}';if(a!=='')$('#schoolYear').val(a);
    if(b!=='')$('#batch').val(b);$('#schoolYear').change();$('#batch').change()});
</script>
@endsection

@section('field_list')
<div class="card">
    <div class="card-body">
        <form action="{{ route('import_process') }}" method="POST" class="form-horizontal">
            @csrf
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Last Name</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Middle Name</th>
                        <th scope="col">Suffix</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Degree</th>
                        <th scope="col">Major</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($csvData as $row)
                        <tr>
                            @foreach ($row as $key => $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <input name="data" value="{{ encrypt($csvFile->id) }}" hidden>
            <input name="school" value="{{ $admin->schools->first()->name }}" hidden>
            <input name="dept" value="{{ $admin->departments->first()->name }}" hidden>
            <input name="sy" value="{{ $schoolYear }}" hidden>
            <input name="batch" value="{{ $batch }}" hidden>
            <button type="submit" role="button" class="btn btn-success">
                {{ __('Import Data') }}
            </button>
        </form>
    </div>
</div>
@endsection
