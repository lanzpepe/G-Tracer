@extends('home')

@section('title')
    {{ __('Add Graduate') }}
@endsection

@section('main')
<div class="card border border-success mb-4">
    <div class="card-body p-3">
        <div class="form-row">
            <div class="form-inline col-md-4 px-3 justify-content-center">
                <span class="h5 mb-0">Add Graduate Entry for:</span>
            </div>
            <div class="form-group col-md-4 px-3">
                <label for="_school">School Year</label>
                <select class="form-control border border-success" name="_school" id="school" required>

                </select>
            </div>
            <div class="form-group col-md-4 px-3">
                <label for="_school">Batch</label>
                <select class="form-control border border-success" name="_school" id="school" required>

                </select>
            </div>
        </div>
    </div>
</div>
<div class="card border border-success mt-4">
    <div class="card-body">
        <form action="{{ route('addEntry') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-3 px-3">
                    <label for="last name">{{ __('Last Name') }}</label>
                    <input type="text" class="form-control border border-success" id="lastname" name="lastname" required>
                </div>
                <div class="form-group col-md-3 px-3">
                    <label for="last name">{{ __('First Name') }}</label>
                    <input type="text" class="form-control border border-success" id="firstname" name="firstname" required>
                </div>
                <div class="form-group col-md-2 px-3">
                    <label for="last name">{{ __('Middle Initial') }}</label>
                    <input type="text" class="form-control border border-success" id="midname" name="midname" required>
                </div>
                <div class="form-group col-md-2 px-3">
                    <label for="last name">{{ __('Suffix') }}</label>
                    <input type="text" class="form-control border border-success" id="suffix" name="suffix">
                </div>
                <div class="form-group col-md-2 px-3">
                    <label for="gender">{{ __('Gender') }}</label>
                    <select class="form-control border border-success" id="gender" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 px-3">
                    <label for="Degree">Degree</label>
                    <select class="form-control border border-success" id="degree" name="degree">
                        <option value="BSIT">Information Technology</option>
                        <option value="BSCS">Computer Science</option>
                        <option value="BSIS">Information Science</option>
                    </select>
                </div>
                <div class="form-group col-md-6 px-3">
                    <label for="Major">Major</label>
                    <select class="form-control border border-success" id="major" name="major">
                        <option value="Web">Web</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Multimedia">Multimedia</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary m-2">
                Add Entry
            </button>
        </form>
    </div>
</div>
@endsection
