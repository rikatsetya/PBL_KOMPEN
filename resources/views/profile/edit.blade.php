@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-start">
        <div class="col-6">
            <!-- Menampilkan foto profil dan detail pengguna -->
            <form action="{{ route('profile.update') }}" method="POST" id="form-edit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Username</label>
                    <input placeholder="username" type="text" name="username" id="username" class="form-control" value="{{ $user->username }}" required>
                </div>
                @if($user->level_id === 5)
                <div class="form-group">
                    <label>No Telepon</label>
                    <input placeholder="no_telp" type="number" name="no_telp" id="no_telp" class="form-control" value="{{ $user->no_telp }}" required>
                </div>
                @endif
                <div class="form-group">
                    <label>Avatar</label>
                    <input placeholder="avatar" type="file" name="avatar" id="avatar" accept="image/*" class="form-control">
                </div>
                <div class="form-group row">
                    <label>Avatar Preview</label>
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default.png') }}" id="avatar-preview" class="w-100" style="max-width: 100px;" alt="Avatar Preview" />
                </div>
                <div class="form-group mt-5 text-right">
                    <a href="javascript:history.back()" data-dismiss="modal" class="btn btn-warning ml-auto">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(() => {
        const avatarInput = document.getElementById("avatar");
        const avatarPreview = document.getElementById("avatar-preview");

        avatarInput.addEventListener("change", function() {
            const file = avatarInput.files[0]; // Get the selected file

            if (file && file.type.startsWith("image/")) {
                // Display the preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result; // Set image source
                    avatarPreview.style.display = "block"; // Show the preview image
                };
                reader.readAsDataURL(file); // Read the file as a Data URL
            } else {
                // Clear preview if the file is not valid
                avatarPreview.src = "";
                avatarPreview.style.display = "none";
                alert("Please select a valid image file.");
            }
        });
    })
</script>
@endpush