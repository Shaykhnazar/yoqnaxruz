<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', __('site.title'))</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/vendor/select2-4.0.13/dist/css/select2.min.css') }}" rel="stylesheet">
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Template Main CSS File -->
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

<div>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex rem">
            <div class="logo mr-auto">
                <h1 class="text-light"><a href="{{ route('home') }}">{{ __('site.title') }}</a></h1>
            </div>

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="{{ Route::currentRouteNamed('home') ? 'active' : '' }}"><a href="{{ route('home') }}">{{__('site.home')}}</a></li>
                    <li><a href="#about">{{__('site.about')}}</a></li>
                    <li><a href="#contact">{{__('site.contact')}}</a></li>
                    @auth
                        <!-- Links for authenticated users -->
                        <li><a href="{{ route('dashboard') }}">{{__('site.dashboard')}}</a></li>
                        <li>
                            <a href="#" class="logout">{{__('site.logout')}}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <!-- Links for guests -->
                        <li class="{{ Route::currentRouteNamed('login') ? 'active' : '' }}"><a href="{{ route('login') }}">{{ __('site.login') }}</a></li>
                        <li class="{{ Route::currentRouteNamed('register') ? 'active' : '' }}"><a href="{{ route('register') }}">{{__('site.register')}}</a></li>
                    @endauth
                    <!-- Language Chooser with Flags -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img src="/assets/img/svg-country-flags/{{ app()->getLocale() }}.svg " alt="Language Flag" style="height: 20px; width: auto;">
                        </a>
                        <ul class="dropdown-menu" id="language-dropdown">
                            <li class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                <a href="#" data-locale="en">
                                    <img src="/assets/img/svg-country-flags/en.svg " alt="English" style="height: 20px; width: auto;"> English
                                </a>
                            </li>
                            <li class="{{ app()->getLocale() == 'ru' ? 'active' : '' }}">
                                <a href="#" data-locale="ru">
                                    <img src="/assets/img/svg-country-flags/ru.svg " alt="Русский" style="height: 20px; width: auto;"> Русский
                                </a>
                            </li>
                            <li class="{{ app()->getLocale() == 'uz_Latn' ? 'active' : '' }}">
                                <a href="#" data-locale="uz_Latn">
                                    <img src="/assets/img/svg-country-flags/uz_Latn.svg " alt="O'zbek (Latin)" style="height: 20px; width: auto;"> O'zbek (Latin)
                                </a>
                            </li>
                            <li class="{{ app()->getLocale() == 'uz_Cryl' ? 'active' : '' }}">
                                <a href="#" data-locale="uz_Cryl">
                                    <img src="/assets/img/svg-country-flags/uz_Cryl.svg " alt="Ўзбек (Кирилл)" style="height: 20px; width: auto;"> Ўзбек (Кирилл)
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>


        </div>
    </header><!-- End Header -->

    <div class="main-container">
        @yield('content')
    </div>

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <!-- <div class="footer-top">
          <div class="container">
            <div class="row">

              <div class="col-lg-3 col-md-6">
                <div class="footer-info">
                  <h3>Maxim</h3>
                  <p>
                    A108 Adam Street <br>
                    NY 535022, USA<br><br>
                    <strong>Phone:</strong> +1 5589 55488 55<br>
                    <strong>Email:</strong> info@example.com<br>
                  </p>
                  <div class="social-links mt-3">
                    <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                    <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                  </div>
                </div>
              </div>

              <div class="col-lg-2 col-md-6 footer-links">
                <h4>Useful Links</h4>
                <ul>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                </ul>
              </div>

              <div class="col-lg-3 col-md-6 footer-links">
                <h4>Our Services</h4>
                <ul>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                  <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                </ul>
              </div>

              <div class="col-lg-4 col-md-6 footer-newsletter">
                <h4>Our Newsletter</h4>
                <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                <form action="" method="post">
                  <input type="email" name="email"><input type="submit" value="Subscribe">
                </form>

              </div>

            </div>
          </div>
        </div> -->

        <div class="container">
            <div class="copyright">
                &copy; {{ __('site.copyright') }} <strong><span>{{ __('site.title') }}</span></strong>. {{ __('site.all_rights_reserved') }}<!-- THE LICENCE FOR THIS TEMPLATE IS PURCASED BY MY DEVELOPER, EMAIL - saurabhmanna2010@gmail.com -->

            </div>

        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
</div>
<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/venobox/venobox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/select2-4.0.13/dist/js/select2.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>


@stack('scripts')

<script>
    $(document).ready(function () {
        $(".logout").click(function () {
            $.ajax({
                url: '{{ route('logout') }}',
                type: 'POST',
                data: { "form_type": "logout", _token: '{{ csrf_token() }}' },
                success: function (response) {
                    window.location.href = '{{ route('home') }}';
                }
            });
        });

        // Handle language dropdown selection
        $('#language-dropdown a').on('click', function(e) {
            e.preventDefault(); // Prevent default link behavior

            var selectedLocale = $(this).data('locale'); // Get the locale from data-locale attribute

            // Send the selected language using AJAX
            $.ajax({
                url: '{{ route("language.switch") }}', // Your route for language switch
                type: 'POST',
                data: {
                    locale: selectedLocale,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                success: function(response) {
                    // On success, reload the page to apply the language change
                    window.location.reload();
                },
                error: function(xhr) {
                    // Handle error if any
                    alert('An error occurred while switching the language.');
                }
            });
        });
    });

</script>
</body>

</html>
