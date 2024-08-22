@extends('layouts.app')

@section('title', 'Daftar Pemasok')

@section('content')
<div class="container my-4">
    <h3 class="text-center mb-4">Halaman Pemasok | Supplier</h3>

    <!-- Pesan Alert -->
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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tombol Tambah Data -->
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModalSupplier">Tambah Data</button>
    </div>

    @include('partials.modal.add_supplier')

    <!-- Tabel -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">No Telepon</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->no_telepon }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td class="text-center">
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#modalSupplierEdit{{ $supplier->id }}">
                                Edit
                            </button>
                            @include('partials.modal.edit_supplier', ['supplier' => $supplier])

                            <!-- Form Hapus -->
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let alertElement = document.querySelector('.alert');
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
                setTimeout(() => alertElement.remove(), 600);
            }
        }, 5000); 
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
