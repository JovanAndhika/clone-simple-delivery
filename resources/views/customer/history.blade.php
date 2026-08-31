@extends('layouts.customer')

@section('content')
    <h1 class="mx-auto text-center my-3 text-uppercase fw-bold">History</h1>

    @if ($notaBeli->count() > 0)
        <div class=" shadow-lg rounded bg-light bg-opacity-50 p-3">
            <h2 class="text-center">Beli Barang</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tanggal Pesan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Detail Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notaBeli as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    @if ($item->tugas->status == 'belum_diambil')
                                        <span class="badge bg-danger text-light">Sedang Diproses</span>
                                    @elseif($item->tugas->status == 'berlangsung')
                                        <span class="badge bg-warning text-dark">Pengiriman</span>
                                    @elseif($item->tugas->status == 'selesai')
                                        <span class="badge bg-success text-light">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalDetailNota"
                                        data-nota="{{ $item }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($notaJual->count() > 0)
        <div class=" shadow-lg rounded bg-light bg-opacity-50 p-3 mt-4">
            <h2 class="text-center">Barang Jual</h2>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
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
                    <div style="
                        position: relative;
                        width: 100%;
                        padding-top: 80%;
                        /* This sets the aspect ratio to 4:3. Adjust this value to get the aspect ratio you want. */
                        overflow: hidden;
                        transform-style: preserve-3d;
                        transition: transform 1s;"
                    >
                        <img src="" id="foto" class=" mx-auto" style="object-fit: cover;position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        backface-visibility: hidden;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal detail nota --}}
    <div class="modal fade" id="modalDetailNota" tabindex="-1" data-id="0">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalDetailNota">Detail Nota</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- id, tanggal, dan status nota --}}
                    <div class="d-flex justify-content-between">
                        <div>
                            <div>
                                <p>ID : <span id="idNota"></span></p>
                                <p>Tanggal : <span id="tanggalNota"></span></p>
                                <p>Status : <span id="statusNota"></span></p>
                                <p>Alamat Pengiriman : <span id="alamatPengiriman"></span></p>
                            </div>
                        </div>
                    </div>

                    {{-- list barang --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data will be inserted here --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // untuk gambar nota jual
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

        // untuk detail nota beli
        const modalBeli = document.getElementById("modalDetailNota");
        const idNota = modalBeli.querySelector("#idNota");
        const tanggalNota = modalBeli.querySelector("#tanggalNota");
        const statusNota = modalBeli.querySelector("#statusNota");
        const alamatPengiriman = modalBeli.querySelector("#alamatPengiriman");
        const tbody = modalBeli.querySelector("tbody");
        let formattedTanggal;

        if (modalBeli) {
            modalBeli.addEventListener("show.bs.modal", (event) => {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-* attributes
                const nota = JSON.parse(button.getAttribute("data-nota"));

                // setiap barang, masukkan ke dalam tabel
                tbody.innerHTML = "";
                nota.barang.forEach((item) => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${item.nama}</td>
                        <td>${item.harga}</td>
                        <td>${item.pivot.jumlah}</td>
                    `;
                    tbody.appendChild(tr);
                });

                // masukan id, tanggal, status nota, alamat pengirman, dan nama wirausaha
                idNota.textContent = nota.id;
                formattedTanggal = new Date(nota.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' });
                tanggalNota.textContent = formattedTanggal;
                alamatPengiriman.textContent = nota.alamat_customer;
                if (nota.tugas.status == 'belum_diambil')
                    statusNota.innerHTML = `<span class="badge bg-danger">Sedang Diproses</span>`;
                else if (nota.tugas.status == 'berlangsung')
                    statusNota.innerHTML = `<span class="badge bg-warning text-dark">Pengiriman</span>`;
                else if (nota.tugas.status == 'selesai')
                    statusNota.innerHTML = `<span class="badge bg-success">Selesai</span>`;
            });
        }
    </script>
@endsection
