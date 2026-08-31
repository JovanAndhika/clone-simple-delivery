@extends('layouts.wirausaha')

@section('content')
    <h1 class="mx-auto text-center my-3 text-uppercase fw-bold">Offer Barang</h1>
    @include('components.alert')

    <div class="p-3 my-2 container rounded shadow-lg bg-secondary bg-opacity-50">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tanggal Jual</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notaJual as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>
                                @if ($item->status == 0)
                                    <div class="px-2 py-1 bg-info text-center text-light rounded">
                                        Pending
                                    </div>
                                @elseif($item->status == 1)
                                    <div class="px-2 py-1 bg-success text-center text-light rounded">
                                        Approved
                                    </div>
                                @else
                                    <div class="px-2 py-1 bg-danger text-center text-light rounded">
                                        Rejected
                                    </div>
                                @endif
                            </td>
                            <td>
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#modalFotoBarang"
                                    data-foto="{{ $item->foto }}">
                                    <i class="bi bi-card-image"></i></i>
                                </button>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div class="d-inline-block m-1">
                                        <form id="approveForm" action="{{ route('wirausaha.offer.konfirmasiHarga') }}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="status" value="1">
                                            <input type="submit" class="btn btn-success" value="Approve"
                                                onclick="return confirmAction('Approve this item?')">
                                        </form>
                                    </div>
                                    <div class="d-inline-block m-1">
                                        <form id="rejectForm" action="{{ route('wirausaha.offer.konfirmasiHarga') }}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="hidden" name="status" value="2">
                                            <input type="submit" class="btn btn-danger" value="Reject"
                                                onclick="return confirmAction('Reject this item?')">
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('modal')
    {{-- modal foto --}}
    <div class="modal fade" id="modalFotoBarang" tabindex="-1" data-id="0">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalFotoBarang">Foto Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" style="max-width:100%">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the modal element
            var modalFotoBarang = document.getElementById('modalFotoBarang');

            // Add event listener for showing the modal
            modalFotoBarang.addEventListener('show.bs.modal', function(event) {
                // Get the button that triggered the modal
                var button = event.relatedTarget;

                // Extract value from data-foto attribute
                var fotoSrc = button.getAttribute('data-foto');

                // Get the modal body element
                var modalBody = modalFotoBarang.querySelector('.modal-body');

                // Set the src attribute of the img tag
                modalBody.querySelector('img').src = `{{ asset('uploads/` + fotoSrc + `') }}`;
            });
        });

        function confirmAction(message) {
            return confirm(message);
        }
    </script>
@endsection
