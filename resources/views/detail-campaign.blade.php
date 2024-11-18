@extends('layouts.master')
@section('title', 'Explorer | Detail Campaign')
@section('logo-navbar',$logoPath)

@section('content')
<div class="text-center mt-4">
    <h3>Detail Transactions</h3>
</div>
@forelse($allData as $result)
    <div class="dashboard">
        <div class="blockchain-section">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Campaign:</div>
                    <div class="col-md-8">{{$result->campaign}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Transaksi Hash:</div>
                    <div class="col-md-8">
                        <span class="text-break">{{$result->txhash}}</span>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4 col-sm-4 fw-bold d-flex align-items-center">Token Program:</div>
                    <div class="col-md-8 col-sm-8 d-flex align-items-center">
                        <span class="badge bg-primary">{{$result->program}}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    @if (($result->status == 1))
                        <div class="col-md-8">
                            <span class="badge bg-success">Tersalurkan</span>
                        </div>
                    @else
                        <div class="col-md-8">
                            <span class="badge bg-secondary">Belum Disalurkan</span>
                        </div>
                    @endif
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Jumlah:</div>
                    <div class="col-md-8">Rp. {{$result->amount}}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Token:</div>
                    <!-- <i class="fas fa-coins"></i> -->
                    <div class="col-md-8 ">{{$result->amount}} {{$result->tokenUmumSymbol}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Donasi:</div>
                    <div class="col-md-8">
                        {{ \Carbon\Carbon::parse($result->donate_at)->translatedFormat('H:i:s  D,d-M-Y') }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Tanggal Penyaluran:</div>
                    @if (($result->status == 1))
                    <div class="col-md-8">
                        {{ \Carbon\Carbon::parse($result->tglDisalurkan)->translatedFormat('H:i:s  D,d-M-Y') }}
                    </div>
                    @else
                    <div class="col-md-8">-</div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-4 fw-bold">Transaksi Penyaluran:</div>
                    <div class="col-md-8">
                        @if (($result->status == 1))
                            <a href="/token-program/distribusi/tx/{{$result->txhashtokenprogram}}" class="text-decoration-none ">
                                <!-- Data lengkap untuk desktop -->
                                <span class="tx-desktop">
                                    {{ $result->txhashtokenprogram }}
                                </span>
                                <!-- Data dipotong untuk mobile -->
                                <span class="tx-mobile">
                                    {{ substr($result->txhashtokenprogram, 0, 8) . '....' . substr($result->txhashtokenprogram, -4) }}
                                </span>
                            </a>
                        @else
                            <a href="#" class="text-decoration-none">
                                -
                            </a>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
@empty
    <p>Error campaign</p>
@endforelse
@endsection