<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('layouts.resource',[
            'title' => 'Hiring portal',
        ])
    </head>
    <body>
        <section >
            <div class="container home_container">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="/images/image.png" class="img-fluid" alt="">
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>

            </div>
        </section>

        @if (session()->has('alert'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        {{-- <img src="..." class="rounded me-2" alt="..."> --}}
                        <strong class="me-auto">Access denied</strong>
                        <small>1 sec ago</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session()->get('alert') }}
                    </div>
                </div>
            </div>

            <script defer>
                var toastLiveExample = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastLiveExample)
                toast.show()
            </script>
        @endif
    </body>
</html>
