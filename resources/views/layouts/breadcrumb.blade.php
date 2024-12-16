<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1> {{ $breadcrumb->title }} </h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach ($breadcrumb->list as $key => $value)
                        @if ($key == count($breadcrumb->list) - 1)
                            <li class="breadcrumb-item menu-open"> {{ $value }} </li>
                            <li class="breadcrumb-item active"> {{ $value }} </li>
                        @else
                            <li class="breadcrumb-item"> {{ $value }} </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
<<<<<<< HEAD
</section>
=======
</section>
>>>>>>> 0916f1e641e08abb12c4e55b5e84393c72c4d7e5
