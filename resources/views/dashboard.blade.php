@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Jumlah Barang yang Tersedia</div>
            <div class="card-body">
                <h5 class="card-title">{{ $totalProduct }} Barang</h5>
                <p class="card-text">Jumlah total barang yang tersedia.</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body text-end">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <p>Selamat Datang! {{ Auth::user()->name }}</p>
                <p>Email Anda: {{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Barang</h5>
                <p class="card-text">{{ $barangCount }} Barang</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Barang Keluar</h5>
                <p class="card-text">{{ $exportCount }} Barang Keluar</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Barang Masuk</h5>
                <p class="card-text">{{ $importCount }} Barang Masuk</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Supplier</h5>
                <p class="card-text">{{ $supplierCount }} Supplier</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">Barang Keluar Terbaru</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Barang</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exports as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Informasi Tambahan -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">Informasi Tambahan</div>
            <div class="card-body">
                <h5 class="card-title">Stok Barang Menipis</h5>
                <ul class="list-group">
                    @foreach ($lowStockItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->name }}
                            <span class="badge bg-danger rounded-pill">Stok: {{ $item->quantity }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
