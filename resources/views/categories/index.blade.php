@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="container my-4">
    <h3 class="text-center mb-4">Halaman Kategori</h3>
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

    <div class="d-flex justify-content-end mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahkategori">Tambah data kategori</button>
    </div>

    @include('partials.modal.add_category')

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#modalCategoryEdit{{ $category->id }}">Edit</button>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="delete-form" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @include('partials.modal.edit_category', ['category' => $category])
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
                setTimeout(() => alertElement.remove(), 600); // Remove after fade out
            }
        }, 5000); // Alert will disappear after 5 seconds
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
