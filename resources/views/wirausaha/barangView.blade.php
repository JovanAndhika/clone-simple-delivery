@extends('layouts.wirausaha')

@section('content')
    <h1 class="mx-auto text-center my-3 text-uppercase fw-bold">Product View</h1>
    @include('components.alert')

    <div class="shadow-lg rounded col-7 mx-auto bg-secondary bg-opacity-50">
        <form action={{ @route('wirausaha.add') }} method="POST"
            class="mx-auto p-3 d-flex flex-column justify-content-center" enctype="multipart/form-data">
            @csrf
            <input type="text" name=nama id="nama"
                class="form-control p-2 mt-0 w-100 mx-auto @error('nama') is-invalid @enderror" placeholder="Nama Barang">
            @error('nama')
                <div class="invalid-feedback mx-auto w-100">
                    {{ $message }}
                </div>
            @enderror
            <input type="number" name=harga id="harga"
                class="form-control p-2 mt-2 w-100 mx-auto @error('harga') is-invalid @enderror" placeholder="Harga Barang">
            @error('harga')
                <div class="invalid-feedback mx-auto w-100">
                    {{ $message }}
                </div>
            @enderror
            <input type="number" name=stock id="stok"
                class="form-control p-2 mt-2 w-100 mx-auto @error('stock') is-invalid @enderror" placeholder="Stok Barang"
                max="999">
            @error('stock')
                <div class="invalid-feedback mx-auto w-100">
                    {{ $message }}
                </div>
            @enderror
            <textarea name="detail" id="detail"
                class="form-control p-2 mt-2 w-100 mx-auto @error('detail') is-invalid @enderror" placeholder="Detail Barang"></textarea>
            @error('detail')
                <div class="invalid-feedback mx-auto w-100">
                    {{ $message }}
                </div>
            @enderror
            <input type="file" class="form-control p-2 mt-2 w-100 mx-auto @error('fotoBarang') is-invalid @enderror"
                id="fotoBarang" name="fotoBarang" accept="image/*" required>
            @error('fotoBarang')
                <div class="invalid-feedback mx-auto w-100">
                    {{ $message }}
                </div>
            @enderror
            <select class="form-select p-2 my-2 w-75 mx-auto" aria-label="Default select example" name="jenis_barang_id">
                @foreach ($jenis as $jen)
                    <option value="{{ $jen->id }}">{{ $jen->nama }}</option>
                @endforeach
            </select>
            <input type="submit" id="submit" class="btn btn-primary p-2 mt-2 mx-auto w-50">
        </form>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal">Update Data Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form action={{ @route('wirausaha.update') }} method="Post"
                    class="mx-auto d-flex flex-column justify-content-center w-100" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="barang_id" id="barang_id">

                        <input type="text" name=nama id="nama"
                            class="form-control p-2 mt-2 w-100 mx-auto @error('nama') is-invalid @enderror"
                            placeholder="Nama Barang">
                        @error('nama')
                            <div class="invalid-feedback mx-auto w-100">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="number" name=harga id="harga"
                            class="form-control p-2 mt-2 w-100 mx-auto @error('harga') is-invalid @enderror"
                            placeholder="Harga Barang">
                        @error('harga')
                            <div class="invalid-feedback mx-auto w-100">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="number" name=stock id="stock"
                            class="form-control p-2 mt-2 w-100 mx-auto @error('stock') is-invalid @enderror"
                            placeholder="Stok Barang" max="999">
                        @error('stock')
                            <div class="invalid-feedback mx-auto w-100">
                                {{ $message }}
                            </div>
                        @enderror
                        <textarea name="detail" id="detail"
                            class="form-control p-2 mt-2 w-100 mx-auto @error('detail') is-invalid @enderror" placeholder="Detail Barang"></textarea>
                        @error('detail')
                            <div class="invalid-feedback mx-auto w-100">
                                {{ $message }}
                            </div>
                        @enderror
                        <input type="file"
                            class="form-control p-2 mt-2 w-100 mx-auto @error('fotoBarang') is-invalid @enderror"
                            id="fotoBarang" name="fotoBarang" accept="image/*" required>
                        @error('fotoBarang')
                            <div class="invalid-feedback mx-auto w-100">
                                {{ $message }}
                            </div>
                        @enderror

                        <select class="form-select p-2 my-2 w-100 mx-auto  @error('jenis_barang_id') is-invalid @enderror"
                            aria-label="Default select example" name="jenis_barang_id" id="jenis_barang_id">
                            @foreach ($jenis as $jen)
                                <option value="{{ $jen->id }}">{{ $jen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary w-25">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal">Detail Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
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
                    <p class="p-3" id="detail" style="text-align: justify"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Close</button>
                </div>


            </div>
        </div>
    </div>
@endsection


@section('extras')
    <div class=" container mx-auto text-center">
        <div class=" d-inline-block shadow-lg p-3 bg-light bg-opacity-75 rounded">
            <table class="d-block table table-hover table-bordered table-striped mx-auto w-100" id="barangtable">
                <thead class="w-100">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="w-100">
                    @foreach ($barang as $index => $w)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $w->nama }}</td>
                            <td>{{ $w->harga }}</td>
                            <td>{{ $w->stock }}</td>
                            <td>{{ $w->jenisbarang->nama }}</td>
                            <td>
                                <button class="btn btn-success p-1 mx-1 detailButton" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" id="detailButton" data-nama="{{ $w->nama }}"
                                    data-harga="{{ $w->harga }}" data-stock="{{ $w->stock }}"
                                    data-jenis-barang="{{ $w->jenis_barang_id }}" data-foto="{{ $w->foto }}"
                                    data-detail="{{ $w->detail }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-warning p-1 mx-1 editButton" data-bs-toggle="modal"
                                    data-bs-target="#editModal" id="editButton" data-id="{{ $w->id }}"
                                    data-nama="{{ $w->nama }}" data-harga="{{ $w->harga }}"
                                    data-stock="{{ $w->stock }}" data-jenis-barang="{{ $w->jenis_barang_id }}"
                                    data-foto="{{ $w->foto }}" data-detail="{{ $w->detail }}"><i
                                        class="bi bi-pencil-square"></i></button>
                                <form action={{ @route('wirausaha.delete') }} method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="barang_id" value="{{ $w->id }}">
                                    <button type='submit' class="btn btn-danger mx-1 p-1 d-inline border-0"
                                        onclick="return confirm('Are You Sure')"><i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>

    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            new DataTable('#barangtable');
            $(document).on('click','.editButton',function() {

                let modal = $('#editModal');

                if (modal.length === 0) {
                    console.error('Modal not found');
                    return;
                }

                // console.log($(this).attr("data-nama"));

                modal.find('#barang_id').val($(this).attr("data-id"));
                modal.find('#nama').val($(this).attr("data-nama"));
                modal.find('#harga').val($(this).attr("data-harga"));
                modal.find('#stock').val($(this).attr("data-stock"));
                modal.find('#jenis_barang_id').val($(this).attr("data-jenis-barang"));
                // modal.find('#fotoBarang').val($(this).attr("data-foto"));
                modal.find('#detail').text($(this).attr("data-detail"));

            });

            $(document).on('click', '.detailButton',function() {
                let modal = $('#detailModal');

                if (modal.length === 0) {
                    console.error('Modal not found');
                    return;
                }

                let source = $(this).attr("data-foto");
                console.log(source);

                if(source.length === 0){
                    source = 'https://source.unsplash.com/random/'+getRandomInt(1, 100);
                    console.log("tidak ada");
                }
                else {
                    source ='/uploads/'+source;
                    console.log("ada");
                }

                modal.find('#foto').attr('src', source);
                modal.find('#detail').text($(this).attr("data-detail"));
            });

            function getRandomInt(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }






        });
    </script>
@endsection

{{-- @section('css') --}}
{{-- <style>
        h1 {
            color: red;
        }
    </style> --}}
{{-- @endsection --}}
