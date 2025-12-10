@extends('layout.app')

@section('title', 'Manage Transactions')

@section('content')
<div class="container mt-4">

    <h1 class="mb-4">Manage User Transactions</h1>

    <button class="btn btn-dark mb-3">
        <a href="{{ route('admin.index') }}" class="text-white text-decoration-none"> <- Back to Admin</a>
    </button>

    @foreach ($transactions as $trx)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span>Transaction #{{ $trx->id }} — User: {{ $trx->user->name }}</span>

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

                @if ($trx->status === 'pending')
                    <form action="{{ route('admin.transactions.update', ['id' => $trx->id, 'status' => 'confirmed']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm">Confirm</button>
                    </form>

                    <form action="{{ route('admin.transactions.update', ['id' => $trx->id, 'status' => 'cancelled']) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger btn-sm">Cancel</button>
                    </form>
                @endif

            </div>

            <div class="card-footer text-muted">
                {{ $trx->created_at }}
            </div>
        </div>
    @endforeach

</div>
@endsection