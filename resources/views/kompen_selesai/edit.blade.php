@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title">Update Kompen Selesai Tugas</h3>
        </div>
        <div class="card-body">
            <form id="formUpdate" method="POST">
                @csrf
                @method('PUT') <!-- Ensure to use PUT method for update -->
                <input type="hidden" name="id" value="{{ $selesai->pengumpulan_id }}">

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="terima" {{ $selesai->status == 'terima' ? 'selected' : '' }}>Terima</option>
                        <option value="tolak" {{ $selesai->status == 'tolak' ? 'selected' : '' }}>Tolak</option>
                    </select>
                </div>

                <div class="form-group" id="alasanContainer" style="display: {{ $selesai->status == 'tolak' ? 'block' : 'none' }}">
                    <label for="alasan">Alasan Tolak</label>
                    <textarea id="alasan" name="alasan" class="form-control">{{ $selesai->alasan }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Handle the change event for status select
            $('#status').change(function () {
                if ($(this).val() === 'tolak') {
                    $('#alasanContainer').show(); // Show alasan container
                } else {
                    $('#alasanContainer').hide(); // Hide alasan container
                    $('#alasan').val(''); // Clear the alasan field
                }
            });

            // Handle form submit via AJAX
            $('#formUpdate').submit(function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ url("/kompen_selesai") }}/' + $("input[name=id]").val(), // Dynamic URL
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            window.location.href = '{{ url('/kompen_selesai') }}';  // Redirect to the index page
                        } else if (response.status === 'error') {
                            alert('Error: ' + response.errors.join(', '));
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan, coba lagi.');
                    }
                });
            });
        });
    </script>
@endpush
