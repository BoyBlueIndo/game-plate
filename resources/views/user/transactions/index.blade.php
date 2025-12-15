@extends('layout.app')

@section('title', 'My Transactions')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Transactions</h1>
        <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">Back to Store</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse ($transactions as $trx)
        <div class="card mb-4 shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Transaction #{{ $trx->id }}</strong>

                <div>
                    <span class="badge bg-secondary me-2">
                        {{ strtoupper(str_replace('_', ' ', $trx->payment_method)) }}
                    </span>

                    <span class="badge 
                        @if($trx->status === 'pending') bg-warning
                        @elseif($trx->status === 'confirmed') bg-success
                        @else bg-danger
                        @endif">
                        {{ ucfirst($trx->status) }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Game</th>
                            <th style="width:120px;">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trx->items as $item)
                            <tr>
                                <td>{{ $item->game->name }}</td>
                                <td>x{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer text-muted text-end">
                {{ $trx->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    @empty
        <div class="alert alert-info">You have no transactions.</div>
    @endforelse

</div>
@endsection