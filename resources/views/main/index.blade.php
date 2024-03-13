@extends('layouts.main-ip', ['title'=> 'Vesper Bootstrap Template'])

@section('container')

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
            <h2>Inner Page</h2>
            <ol>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Inner Page</li>
            </ol>
            </div>

        </div>
    </section>
    <!-- End Breadcrumbs Section -->

    <section class="inner-page">
        <div class="container">
            <p>
            Login berhasil
            </p>
        </div>
    </section>

@endsection