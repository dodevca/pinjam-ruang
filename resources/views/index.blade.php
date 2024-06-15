@extends('layouts.default')
@section('content')

    <div class="hero-wrap js-fullheight" style="background-image: url('vendor/vonso/hero-img.jpg');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start"
                data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <h2 class="subheading">Selamat datang di Pinjam Ruang</h2>
                    <h1 class="mb-4">Pinjam ruangan mudah dan cepat</h1>
                </div>
            </div>
        </div>
    </div>

    <section id="form-pinjam-ruang" class="ftco-section ftco-book ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-lg-4">
                    <form method="POST" action="{{ route('api.v1.borrow-room-with-college-student', []) }}"
                        class="appointment-form">
                        @csrf
                        <h3 class="h4 text-center mb-3"><strong>Pinjam ruang disini</strong></h3>
                        {{-- Show any errors --}}
                        @if ($errors->isNotEmpty())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $message)
                                    @if ($message == 'login_for_more_info')
                                        <a href="{{ route('admin.login') }}">Masuk</a> untuk meilihat aktivitas peminjaman.
                                    @else
                                        {{ $message }}<br>
                                    @endif
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Pinjam ruang berhasil, silahkan cek status peminjaman <a
                                    href="{{ route('admin.login') }}">disini</a>.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="full_name" value="{{ empty($data['admin_user']) ? '' : $data['admin_user']->name }}" type="text"
                                        class="form-control" placeholder="Atas Nama">
                                    <input name="nim" value="{{ empty($data['admin_user']) ? '' : $data['admin_user']->username }}" type="hidden">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-wrap">
                                        <div class="icon"><span class="ion-md-calendar"></span></div>
                                        <input id="borrow_at" name="borrow_at" value="{{ old('borrow_at') }}" type="text"
                                            class="form-control appointment_date-check-in datetimepicker-input"
                                            placeholder="Tgl Mulai" data-toggle="datetimepicker" data-target="#borrow_at">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-wrap">
                                        <div class="icon"><span class="ion-md-calendar"></span></div>
                                        <input id="until_at" name="until_at" value="{{ old('until_at') }}" type="text"
                                            class="form-control appointment_date-check-out datetimepicker-input"
                                            placeholder="Tgl Selesai" data-toggle="datetimepicker" data-target="#until_at">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-field">
                                        <div class="select-wrap">
                                            <div class="icon"><span class="fa fa-chevron-down"></span></div>
                                            <select name="room" id="" class="form-control">
                                                <option value="" selected disabled>Pilih ruangan</option>
                                                @forelse ($data['rooms'] as $room)
                                                    <option value="{{ $room->id }}"
                                                        @if (old('room') == $room->id) selected @endif>
                                                        {{ $room->room_type->name . ' - ' . $room->name . ' (' . $room->max_people . ' orang)' }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Belum ada ruangan yang tersedia</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::guard('admin')->check())
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="submit" value="Pinjam Ruang Sekarang" class="btn btn-primary py-3 px-4">
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <a href="/admin" class="btn btn-primary py-3 px-4">Log In untuk Pinjam</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section testimony-section">
        <div class="container">
            <div class="row justify-content-center pb-5 mb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h2>Tata Cara Peminjaman</h2>
                </div>
            </div>
            <div class="row ftco-animate">
                <div class="col-md-12 wrap-about">
                    <div class="text-center">
                        <img src="{{ asset('vendor/vonso/flowchart.png') }}" class="img-fluid" alt="...">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @section('scripts')
        <script>
            $(document).ready(function() {
                $('.appointment_date-check-in-alt').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm',
                });
                $('.appointment_date-check-out-alt').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm',
                });
            });
        </script>

        @if ($errors->isNotEmpty())
            <script>
                $(document).ready(function() {
                    if (/Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
                            .userAgent)) {
                        document.getElementById("form-pinjam-ruang").scrollIntoView();
                    }
                });
            </script>
        @endif
    @endsection
@endsection
