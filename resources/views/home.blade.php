@extends('layouts.master')
@section('title', 'Explorer | Detail Campaign')
@section('logo-navbar',$logoPath)

@section('content')

<div class="text-center mt-4 mb-4">
    <h3>{{ucwords($subdomain)}} Blockhain Explorer</h3>
</div>
<div class="container mt-5 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <div class="text-center">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari Campaign / Token / Txn Hash">
                    <div class="input-group-append">
                        <button class="btn btn-primary rounded-1" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 d-flex justify-content-center align-items-center">
        <img src="{{$logoPath}}" class="img-fluid" alt="Responsive image">
    </div>

    <div class="col-md-8">
        <div class="dashboard">
            <div class="summary-usage">
                <h3 class="mb-1 mt-2">Penerimaan</h3>
                <div class="section-header"></div>
                <div class="summary-cards">
                    @forelse ($tokenUmum as $result)
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
                <h3 class="mt-5 mb-1">Penyaluran</h3>
                <div class="section-header"></div>
                <div class="summary-cards mt-2">
                    @forelse ($tokenProgram as $result)
                    <a href="/token-program/{{ $result->program }}" style="text-decoration:none"> 
                        <div class="summary-card">
                            <h4>{{$result->program}}</h4>
                            <div class="summary-content">
                                <i class="fas fa-coins icon"></i>
                                <span>
                                    {{$result->totalAmount}} {{$result->program}}
                                </span>
                            </div>
                        </div>
                    </a>
                    @empty
                        <p>Belum ada Token Penyaluran</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>



@endsection