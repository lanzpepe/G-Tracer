@extends('home')

@section('title')
    {{ __('Graduate List') }}
@endsection

@section('button')
    <button type="button" class="btn btn-lg btn-success btn-link add-graduate">
        <span class="fas fa-plus fa-fw"></span>
        <span>&emsp;{{ __('Add Graduate') }}</span>
    </button>
@endsection

@section('main')
<div class="card">
    <div class="card-body">
        <form action="{{ route('graduates') }}" method="GET">
            <div class="form-row">
                <div class="col-md-2 d-flex align-self-end justify-content-center">
                    <h5 class="text-success">{{ __('FILTER LIST') }}</h5>
                </div>
                <div class="form-group col-md-4 px-3">
                    <label for="sy">School Year</label>
                    <select class="form-control border border-success rounded" id="schoolYear" name="sy" required>
                        @foreach ($academicYears as $sy)
                            <option value="{{ $sy->school_year }}">{{ $sy->school_year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 px-3">
                    <label for="batch">Batch</label>
                    <select class="form-control border border-success rounded" id="batch" name="batch" required>
                        @foreach ($batches as $batch)
                            <option value="{{ $batch->name }}">{{ $batch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-self-end justify-content-center">
                    <button type="submit" class="btn btn-success px-3" id="btn-filter">
                        <span class="fas fa-filter fa-fw"></span>
                        <span>{{ __('Filter') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">{{ __('Last Name') }}</th>
                        <th scope="col">{{ __('First Name') }}</th>
                        <th scope="col">{{ __('Middle Name') }}</th>
                        <th scope="col">{{ __('Gender') }}</th>
                        <th scope="col">{{ __('Degree') }}</th>
                        <th scope="col">{{ __('Major') }}</th>
                        <th scope="col">{{ __('School Year') }}</th>
                        <th scope="col">{{ __('Batch') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($graduates as $graduate)
                    <tr>
                        <td>{{ $graduate->last_name }}</td>
                        <td>{{ $graduate->first_name }}</td>
                        <td>{{ $graduate->middle_name }}</td>
                        <td>{{ $graduate->gender }}</td>
                        <td>{{ $graduate->degree }}</td>
                        <td>{{ $graduate->major }}</td>
                        <td>{{ $graduate->school_year }}</td>
                        <td>{{ $graduate->batch }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('modal')
    <div class="modal fade" id="graduateModal" tabindex="-1" role="dialog" aria-labelledby="graduateModalLabel" aria-hidden="true" data-focus="false">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('add_graduate') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-success" id="accountModalLabel">{{ __('ADD GRADUATE') }}</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="graduateId" id="graduateId" value="">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sy"><span class="far fa-calendar-alt"></span>&emsp;{{ __('School Year') }}</label>
                                    <select name="sy" class="form-control border border-success rounded" id="sy" required>
                                        <option value="" selected>{{ __('-- Select School Year --') }}</option>
                                        @foreach ($academicYears as $sy)
                                            <option value="{{ $sy->school_year }}">{{ $sy->school_year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch"><span class="far fa-calendar-alt"></span>&emsp;{{ __('Batch') }}</label>
                                    <select name="batch" class="form-control border border-success rounded" id="batch" required>
                                        <option value="" selected>{{ __('-- Select Batch --') }}</option>
                                        @foreach ($batches as $batch)
                                            <option value="{{ $batch->name }}">{{ $batch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lastname"><span class="fas fa-user"></span>&emsp;{{ __('Last Name') }}</label>
                                    <input id="lastname" type="text" class="form-control input-text" name="lastname" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="firstname"><span class="fas fa-user"></span>&emsp;{{ __('First Name') }}</label>
                                    <input id="firstname" type="text" class="form-control input-text" name="firstname" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="midname"><span class="fas fa-user"></span>&emsp;{{ __('M.I.') }}</label>
                                    <input id="midname" type="text" class="form-control input-text" name="midname" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group pt-2">
                                    <label for="gender"><span class="fas fa-venus-mars"></span>&emsp;{{ __('Gender') }}</label>
                                    <select name="gender" class="form-control border border-success rounded" id="gender" required>
                                        <option value="" selected>{{ __('-- Select Gender --') }}</option>
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob"><span class="fas fa-calendar-day"></span>&emsp;{{ __('Date of Birth') }}</label>
                                    <input id="dob" type="text" class="form-control border border-success rounded" name="dob" value="01/01/1990" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group pt-2">
                                    <label for="course"><span class="fas fa-book-open"></span>&emsp;{{ __('Degree/Course') }}</label>
                                    <select name="course" class="form-control border border-success rounded" id="course" required>
                                        <option value="" selected>{{ __('-- Select Course --') }}</option>
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pt-2">
                                    <label for="major"><span class="fas fa-medal"></span>&emsp;{{ __('Major') }}</label>
                                    <select name="major" class="form-control border border-success rounded" id="major" required>
                                        <option value="" selected>{{ __('-- Select Major --') }}</option>
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender->name }}">{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-link">{{ __('Submit') }}</button>
                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
