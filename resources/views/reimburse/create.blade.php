@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome') @section('content_header_title', 'Reimburse')
@section('content_header_subtitle', 'Tambah Reimburse') @section('content_body')

<div class="row">
    <div class="col-12">
        <form name="add-reimburse" id="add-reimburse">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Reimburse</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input
                            id="title"
                            type="text"
                            name="title"
                            class="form-control @error('title') is-invalid @enderror"
                        />
                        @error('title')
                        <span id="title-error" class="error invalid-feedback">{{
                            $message
                        }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="project_id">Proyek</label>
                        <select
                            class="form-control @error('project_id') is-invalid @enderror"
                            name="project_id"
                        >
                            @foreach($projects as $project)
                            <option value="{{ $project->proyek_id }}">
                                {{ $project->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <span
                            id="project_id-error"
                            class="error invalid-feedback"
                            >{{ $message }}</span
                        >
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Kategori</label>
                        <select
                            class="form-control @error('category_id') is-invalid @enderror"
                            name="category_id"
                        >
                            @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span
                            id="category_id-error"
                            class="error invalid-feedback"
                            >{{ $message }}</span
                        >
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal</label>
                        <input
                            id="date"
                            type="date"
                            name="date"
                            class="form-control @error('date') is-invalid @enderror"
                        />
                        @error('date')
                        <span id="date-error" class="error invalid-feedback">{{
                            $message
                        }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="remark">Keterangan</label>
                        <textarea
                            class="form-control @error('remark') is-invalid @enderror"
                            name="remark"
                            id=""
                            cols="30"
                            rows="4"
                        ></textarea>
                        @error('remark')
                        <span
                            id="remark-error"
                            class="error invalid-feedback"
                            >{{ $message }}</span
                        >
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div
                        class="d-flex justify-content-between align-items-center"
                    >
                        <h3 class="card-title">Detail Berkas</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="dynamic-field">
                        <div id="item-1" class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="archive[1][title]"
                                                >Judul</label
                                            >
                                            <input
                                                id="title"
                                                type="text"
                                                name="archive[1][title]"
                                                class="form-control @error('title') is-invalid @enderror"
                                            />
                                            @error('title')
                                            <span
                                                id="title-error"
                                                class="error invalid-feedback"
                                                >{{ $message }}</span
                                            >
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="archive[1][jumlah]"
                                                >Jumlah</label
                                            >
                                            <input
                                                type="text"
                                                name="archive[1][jumlah]"
                                                data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digitsOptional': true, 'placeholder': '0', 'removeMaskOnSubmit': true"
                                                class="form-control @error('jumlah') is-invalid @enderror"
                                            />
                                            @error('jumlah')
                                            <span
                                                id="jumlah-error"
                                                class="error invalid-feedback"
                                                >{{ $message }}</span
                                            >
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="archive[1][file]"
                                                >Berkas</label
                                            >
                                            <input
                                                type="file"
                                                name="archive[1][file]"
                                                class="form-control @error('file') is-invalid @enderror"
                                            />
                                            @error('file')
                                            <span
                                                id="file-error"
                                                class="error invalid-feedback"
                                                >{{ $message }}</span
                                            >
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-1 d-none">
                                <div class="form-group">
                                    <label class="invisible">Remove</label>
                                    <div class="d-flex justify-content-end">
                                        <buitton
                                            id="1"
                                            class="btn btn-danger remove-reimburse-item"
                                            ><i class="fas fa-times"></i
                                        ></buitton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center">
                        <buitton id="add" class="btn btn-primary"
                            ><i class="fa fa-plus"></i
                        ></buitton>
                    </div>
                </div>
            </div>

            <div class="mt-3 mb-5">
                <button id="submit" type="submit" class="btn btn-primary">
                    Submit
                </button>
                <a href="/reimburse" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@stop @push('js')

<script>
    $(document).ready(function () {
        const postURL = "<?php echo url('reimburse'); ?>";
        let itemId = 1;
        $("#add").click(function () {
            itemId++;
            const detailItems = $("#dynamic-field").children();

            if (detailItems.length <= 1) {
                detailItems
                    .find(".col-12")
                    .removeClass("col-12")
                    .addClass("col-11");
                detailItems.find(".col-1").removeClass("d-none");
            }

            $("#dynamic-field").append(`
                <div id="item-${itemId}" class="row">
                    <div class="col-11">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="archive[${itemId}][title]">Judul</label>
                                    <input
                                        type="text"
                                        name="archive[${itemId}][title]"
                                        class="form-control @error('title') is-invalid @enderror"
                                    />
                                    @error('title')
                                    <span id="title-error" class="error invalid-feedback">{{
                                        $message
                                    }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="archive[${itemId}][jumlah]">Jumlah</label>
                                    <input
                                        type="text"
                                        name="archive[${itemId}][jumlah]"
                                        data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'autoGroup': true, 'digitsOptional': true, 'placeholder': '0', 'removeMaskOnSubmit': true"
                                        class="form-control @error('jumlah') is-invalid @enderror"
                                    />
                                    @error('jumlah')
                                    <span id="jumlah-error" class="error invalid-feedback">{{
                                        $message
                                    }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="archive[${itemId}][file]">Berkas</label>
                                    <input
                                        type="file"
                                        name="archive[${itemId}][file]"
                                        class="form-control @error('file') is-invalid @enderror"
                                    />
                                    @error('file')
                                    <span id="file-error" class="error invalid-feedback">{{
                                        $message
                                    }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label class="invisible">Remove</label>
                            <div class="d-flex justify-content-end">
                                <buitton
                                    id="${itemId}"
                                    class="btn btn-danger remove-reimburse-item"
                                    >
                                    <i class="fas fa-times"></i>
                                </buitton>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        });
        $(".remove-reimburse-item").click(function () {
            var buttonId = $(this).attr("id");
            $(`#item-${buttonId}`).remove();

            const detailItems = $("#dynamic-field").children();
            if (detailItems.length <= 1) {
                detailItems
                    .find(".col-11")
                    .removeClass("col-11")
                    .addClass("col-12");
                detailItems.find(".col-1").addClass("d-none");
            }
        });
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $("#submit").click(function (e) {
            e.preventDefault();

            const form = $("#add-reimburse")[0];
            const formData = new FormData(form);
            console.log("form", form);
            $.ajax({
                url: postURL,
                method: "POST",
                data: formData,
                enctype: "multipart/form-data",
                processData: false, // Important!
                contentType: false,

                success: function (data) {
                    if (data.error) {
                        console.log(data.error);
                    }
                },
            });
        });
        // function printErrorMsg(msg) {
        //     $(".print-error-msg").find("ul").html("");

        //     $(".print-error-msg").css("display", "block");

        //     $(".print-success-msg").css("display", "none");

        //     $.each(msg, function (key, value) {
        //         $(".print-error-msg")
        //             .find("ul")
        //             .append("<li>" + value + "</li>");
        //     });
        // }
    });
</script>
@endpush
