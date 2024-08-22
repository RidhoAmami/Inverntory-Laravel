@extends('layouts.app')

@section('title', 'Daftar Barang Keluar')

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
    <a href="{{ route('exports.create') }}" class="btn btn-primary mb-3">Tambah Barang Keluar</a>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Barang</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Tanggal</th>
            <th scope="col" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exports as $export)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $export->product->name ?? 'N/A' }}</td>
                    <td>{{ $export->quantity }}</td>
                    <td>{{ $export->tanggal->format('d-m-Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('exports.edit', $export->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('exports.destroy', $export->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
        }, 5000); // Alert will disappear after 3 seconds
    });
    document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    event.preventDefault();
                }
            });
        });
</script>
@endsection