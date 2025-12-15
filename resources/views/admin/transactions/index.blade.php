@extends('layout.app')

@section('title', 'Manage Transactions')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Transactions</h1>
        <a href="{{ route('admin.index') }}" class="btn btn-dark btn-sm text-white">
            ← Back to Admin
        </a>
    </div>

    @forelse ($transactions as $trx)
        <div class="card mb-4 shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
            <strong>
                Transaction #{{ $trx->id }} — {{ $trx->user->name }}
            </strong>

            <div>
                <span class="badge bg-info me-2">
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
                <table class="table table-bordered mb-0">
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

            @if ($trx->status === 'pending')
                <div class="card-body">
                    <form action="{{ route('admin.transactions.update', ['id' => $trx->id, 'status' => 'confirmed']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Confirm</button>
                    </form>

                    <form action="{{ route('admin.transactions.update', ['id' => $trx->id, 'status' => 'cancelled']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                </div>
            @endif

            <div class="card-footer text-muted text-end">
                {{ $trx->created_at->format('d M Y, H:i') }}
            </div>

        </div>
    @empty
        <div class="alert alert-info">No transactions found.</div>
    @endforelse

</div>
@endsection