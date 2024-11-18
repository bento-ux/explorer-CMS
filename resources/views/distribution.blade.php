@extends('layouts.master')
@section('title', 'Explorer | Token Umum')

@section('logo-navbar',$logoPath)


@section('content')


<div class="text-center mt-5 mb-4">
    <h3 class="mb-4" style="font-size:2.2em; font-weight:700">Distribusi</h3>
    @if ($transactions)
        <h3 style="font-size:1.4em; font-weight:600">Token {{$transactions->tokenName}}</h3>
        <h3 style="font-size:1.2em;">to </h3>
        <h3 style="font-size:1.4em; font-weight:600"> Program {{$transactions->program}}</h3>
    @else
        <p>Gagal Mengambil transaksi</p>
    @endif
</div>

<div class="dashboard">
    <div class="summary-usage">
        <!-- <div class="section-header"></div> -->
        @if ($transactions)
            <div class="summary-cards">
                <div class="summary-card">
                    <h4>Signers</h4>
                    <ul class="list-group list-group-flush">
                        @foreach (json_decode($transactions->signers) as $signer)
                            <li class="list-group-item">
                            {{ substr($signer, 0, 8) . '....' . substr($signer, -6) }}
                                <!-- {{ $signer }} -->
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="summary-card">
                <h4>Tanggal Penyaluran</h4>
                <span>{{$transactions->lastDistributionDate}}</span>
                <br>
                    <h4>Amount</h4>
                    <span>{{$transactions->total_amount}} {{$transactions->tokenUmumSymbol}} </span>
                </div>
                <!-- <div class="summary-card">
                    <h4>Tanggal Penyaluran</h4>
                    <span>{{$transactions->lastDistributionDate}}</span>
                </div> -->
            </div>
        @else
            <p>Gagal Mengambil transaksi</p>
        @endif

    </div>
    <div class="blockchain-section">
        <div class="blockchain-list mt-4">
            @forelse ($allData as $results)
                <div class="blockchain-item" key={index}>
                    <div class="blockchain-column blockchain-column-campaign">
                        <div class="column-label">Campaign</div>
                        <div class="blockchain-title">
                            <i class="fas fa-network-wired"></i>
                            <span>{{$results->campaign}}</span>
                            <span class="tag">{{$results->program}}</span>
                        </div>
                    </div>
                    <div class="blockchain-column">
                        <div class="column-label">Amount</div>
                        <div class="stat-item">
                            <i class="fas fa-coins"></i>
                            <div class="status">
                                {{$results->amount}} {{$results->tokenUmumSymbol}}
                            </div>
                        </div>
                    </div>
                    <div class="blockchain-column">
                        <div class="column-label">Transaksi Hash</div>
                        <div class="blockchain-stats">
                            <div class="stat-item">
                                <i class="fas fa-link"></i>
                                <a href="/token-umum/tx/{{ $results->txhash }}">
                                    <span>
                                        {{ substr($results->txhash, 0, 8) . '....' . substr($results->txhash, -4) }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="blockchain-column">
                        <div class="column-label">Status</div>
                        <div class="blockchain-stats">
                            <div class="stat-item">
                                @if (($results->status == 1))
                                    <i class="fas fa-circle-check"></i>
                                    <span>Sudah Tersalurkan</span>
                                @else
                                    <i class="fas fa-hourglass-start"></i>
                                    <span>Belum Disalurkan</span>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Belum ada campaign</p>
            @endforelse
        </div>
    </div>




</div>

@endsection