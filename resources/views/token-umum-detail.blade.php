@extends('layouts.master')
@section('title', 'Explorer | Token Umum')


@section('logo-navbar',$logoPath)

@section('content')


<div class="text-center mt-5 mb-4">
    @if ($tokenSummary)
        <h3>Token {{$tokenSummary->tokenName}}</h3>
    @else
        <p>Gagal Mengambil nama Token</p>
    @endif
</div>

<div class="dashboard">
    <div class="summary-usage">
        <h3 class="mb-1 mt-2">Circulating Supply</h3>
        <div class="section-header"></div>
        <div class="summary-cards">
            @if ($tokenSummary)
                <div class="summary-card">
                    <h4>Total Token</h4>
                    <div class="summary-content">
                        <i class="fas fa-coins icon"></i>
                        <span>
                            {{$tokenSummary->totalAmount}} {{$tokenSummary->tokenUmumSymbol}}
                        </span>
                    </div>
                </div>
                <div class="summary-card">
                    <h4>Current Token</h4>
                    <div class="summary-content">
                        <i class="fas fa-chart-line icon"></i>
                        <span>
                            {{$tokenSummary->currentToken}} {{$tokenSummary->tokenUmumSymbol}}
                        </span>
                    </div>
                </div>
                <div class="summary-card">
                    <h4>Total Distribusi</h4>
                    <div class="summary-content">
                        <i class="fas fa-donate icon"></i>
                        <span>
                            {{$tokenSummary->totalDistributed}} {{$tokenSummary->tokenUmumSymbol}}
                        </span>
                    </div>
                </div>
            @else
                <p>Gagal Mengambil detail Token</p>
            @endif
        </div>
        <h3 class="mt-5 mb-1">Distribusi Token</h3>
        <div class="section-header"></div>
        <div class="summary-cards mt-2">
            @forelse ($programs as $results)
                <div class="summary-card">
                    <h4>{{$results->program}}</h4>
                    <div class="summary-content">
                        <i class="fas fa-coins icon"></i>
                        <span>
                            {{$results->programTotalAmount}} {{$results->tokenUmumSymbol}}
                        </span>
                    </div>
                </div>
            @empty
                <p>Token belum pernah di distribusikan</p>
            @endforelse
        </div>
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