@extends('layout.app')

@section('title', 'My Transactions')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">My Transactions</h1>

    <button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">Back to Store</a>
    </button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach ($transactions as $trx)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span>Transaction #{{ $trx->id }}</span>
                <span class="badge 
                    @if($trx->status == 'pending') bg-warning 
                    @elseif($trx->status == 'confirmed') bg-success 
                    @else bg-danger 
                    @endif">
                    {{ ucfirst($trx->status) }}
                </span>
            </div>

            <div class="card-body">
                <ul>
                    @foreach ($trx->items as $item)
                        <li>{{ $item->game->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="card-footer text-muted">
                {{ $trx->created_at }}
            </div>
        </div>
    @endforeach

</div>
@endsection