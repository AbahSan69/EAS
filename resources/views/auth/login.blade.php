<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>EAS Login</title>
        <meta name="description" content="EAS Login">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="index, follow">
        <meta property="og:title" content="EAS Login">
        <meta property="og:site_name" content="OneUI">
        <meta property="og:description" content="EAS Login">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
        <link rel="shortcut icon" href="{{ asset('oneui/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('oneui/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('oneui/media/favicons/apple-touch-icon-180x180.png') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('oneui/css/oneui.min.css') }}"><link id="css-theme" rel="stylesheet" href="{{ asset('oneui/css/themes/amethyst.min.css') }}">
      <script async="" src="https://www.googletagmanager.com/gtag/js?id=G-9HQDQJJYW7"></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'G-9HQDQJJYW7');</script>
      </head>
<body>
    <body>
      @include('sweetalert::alert')
        <div id="page-container">
                  <main id="main-container">
        <div class="hero-static d-flex align-items-center">
          <div class="w-100">
            <div class="bg-body-extra-light">
              <div class="content content-full">
                <div class="row g-0 justify-content-center">
                  <div class="col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5">
                    <div class="text-center">
                      <p class="mb-2">
                        <i class="fa fa-2x fa-circle-notch text-primary"></i>
                      </p>
                      <h1 class="h4 mb-1">
                        Sign In
                      </h1>
                      <p class="fw-medium text-muted mb-3">
                        Enterprise Architecture
                      </p>
                    </div>
                    <form class="js-validation-signin" action="{{ route('login') }}" method="POST" novalidate="novalidate">
                      @csrf
                      <div class="py-3">
                        <div class="mb-4">
                          <input type="text" class="form-control form-control-lg form-control-alt" id="name" name="name" placeholder="Username" required>
                        </div>
                        <div class="mb-4">
                          <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password" placeholder="Password" required>
                        </div>
                      </div>
                      <div class="row justify-content-center">
                        <div class="col-lg-6 col-xxl-5">
                          <button type="submit" class="btn w-100 btn-alt-primary">
                            <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Sign In
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="fs-sm text-center text-muted py-3">
              <strong>Created By</strong> © <span data-toggle="year-copy" class="js-year-copy-enabled">2025</span>
            </div>
          </div>
        </div>
          </main>
          </div>
        <script src="assets/js/oneui.app.min-5.11.js"></script>
        <script src="assets/js/lib/jquery.min.js"></script>
        <script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="assets/js/pages/op_auth_signin.min.js"></script>
        
        
        </body>
</body>
</html>