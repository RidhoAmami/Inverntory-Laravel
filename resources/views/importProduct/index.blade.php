@extends('layouts.app')

@section('title', 'Daftar Barang Masuk')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="table-responsive">
    <a href="{{ route('imports.create') }}" class="btn btn-primary mb-3">Tambah Barang Masuk</a>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Barang</th>
            <th scope="col">Supplier</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Tanggal</th>
            <th scope="col" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($imports as $import)
                @php
                    // Temukan produk terkait
                    $product = $products->firstWhere('id', $import->product_id);
                    $isQuantitySufficient = $product ? $product->quantity >= $import->quantity : false;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name ?? 'N/A' }}</td>
                    <td>{{ $import->supplier->name }}</td>
                    <td>{{ $import->quantity }}</td>
                    <td>{{ $import->tanggal->format('d-m-Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('imports.edit', $import->id) }}" class="btn btn-sm btn-warning {{ !$isQuantitySufficient ? 'disabled' : '' }}">Edit</a>
                        <form action="{{ route('imports.destroy', $import->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger {{ !$isQuantitySufficient ? 'disabled' : '' }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let alertElement = document.querySelector('.alert');
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
                setTimeout(() => alertElement.remove(), 600); // Remove after fade out
            }
        }, 5000); // Alert will disappear after 5 seconds
    });
</script>
<style>
    .disabled {
        pointer-events: none; /* Disable click events */
        opacity: 0.5; /* Visual indication of being disabled */
    }
</style>
@endsection