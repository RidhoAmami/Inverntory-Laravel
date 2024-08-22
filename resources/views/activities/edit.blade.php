@extends('layouts.app')

@section('title', 'Ubah Aktivitas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center align-items-center flex-column">
        <div class="col-lg-8">

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-message">
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

            <form class="border p-4 rounded bg-light" style="width: 100%; max-width: 500px;" action="{{ route('activities.update', $activity->id) }}" method="POST">
                <h2 class="mb-4">Edit Aktivitas</h2>
                @csrf
                @method('PUT')
                
                <div class="form-group mb-2">
                    <label for="product_id">Produk</label>
                    <select name="product_id" id="product_id" class="form-control">
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $activity->product_id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="aksi">Aksi</label>
                    <select name="aksi" id="aksi" class="form-control">
                        <option value="">Pilih Aksi</option>
                        <option value="masuk" {{ $activity->aksi == 'masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="keluar" {{ $activity->aksi == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $activity->quantity) }}">
                </div>

                <div class="form-group mb-2">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $activity->tanggal) }}">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let errorAlert = document.getElementById('error-message');
            if (errorAlert) {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('fade');
                setTimeout(() => errorAlert.remove(), 600); // Remove after fade out
            }
        }, 5000); // Alert will disappear after 5 seconds
    });
</script>
@endsection
