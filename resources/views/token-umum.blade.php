@extends('layouts.master')
@section('title', 'Explorer | Detail Campaign')
@section('logo-navbar',$logoPath)

@section('content')

<div class="text-center mt-4 mb-4">
    <h3>{{ucwords($subdomain)}} Token Penerimaan</h3>
</div>

<div class="row">
    <div class="col-md-4 d-flex justify-content-center align-items-center">
        <img src="{{$logoPath}}" class="img-fluid" alt="Responsive image">
    </div>

    <div class="col-md-8">
        <div class="dashboard">
            <div class="summary-usage">
                <div class="section-header"></div>
                <div class="summary-cards">
                    @forelse ($results as $result)
                    <a href="/token-umum/{{ $result->tokenName }}" style="text-decoration:none"> 
                    <div class="summary-card">
                        <h4>{{$result->tokenName}}</h4>
                        <div class="summary-content">
                            <i class="fas fa-coins icon"></i>
                            <span>
                                {{$result->totalAmount}} {{$result->tokenUmumSymbol}}
                            </span>
                        </div>
                    </div>
                    </a>
                    @empty
                        <p>Belum ada Token Penerimaan</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



@endsection