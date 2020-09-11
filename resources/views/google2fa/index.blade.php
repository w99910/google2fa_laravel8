@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">verify 2fa
                        <form method="POST" action="{{ route('verify2fa') }}">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <p><b>One Time Password:</b></p>
                                </div>
                                <div class="form-group col-sm-8">
                                    <input type="password" class="form-control" name="one_time_password" id="one_time_password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-left" name="button">Proceed</button>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
@endsection
