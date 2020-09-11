@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}
                    @if(session()->has('message'))
                        <div class="alert alert-success">{{session('message')}}</div>
                       {{session()->forget('message')}}
                        @endif
                    </div>
                 @if($data['user']->password_security == null)
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                       <form action="{{route('2fa_generate')}}" method="POST" >
                          @csrf
                           <button type="submit" >Enable 2FA</button>

                       </form>

                    </div>

                    @elseif(!$data['user']->password_security->google2fa_enable)
                        <div class="card-body">
                            @error('verify_code')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                            <img src="{{$data['google2fa_url']}}">
                            <form method="POST" action="{{route('2fa_verify')}}">
                              @csrf
                                <input type="password" name="verify_code">
                                <button class="btn-primary" type="submit">Verify</button>
                            </form>
                        </div>
                    @elseif($data['user']->password_security->google2fa_enable)
                    <div class="card-body">
                        <form action="{{route('2fa_disable')}}" method="POST" >
                                                                            @csrf
                            <button class="primary" type="submit">Disable</button>
                        </form>
                </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
