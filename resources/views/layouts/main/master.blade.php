{{-- https://bean-tools.mysapo.net/ --}}
<!DOCTYPE html>
<html lang="vi">
   <head>
      @php
      $seoCanonical = trim($__env->yieldContent('canonical')) ?: seo_canonical_url();
      $seoRobots = trim($__env->yieldContent('robots')) ?: seo_robots_directive();
      $seoTitle = trim($__env->yieldContent('title'));
      $seoDescription = trim($__env->yieldContent('description'));
      $seoImage = trim($__env->yieldContent('image'));
      $seoSiteName = $setting->webname ?? ($setting->company ?? config('app.name'));
      @endphp
      <meta charset="UTF-8" />
      <meta name="theme-color" content="#d70018">
      <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ $seoTitle }}</title>
      <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
      <meta http-equiv="Content-Language" content="vi" />
      <link rel="alternate" href="{{ $seoCanonical }}" hreflang="vi" />
      <meta name="description" content="{{ $seoDescription }}">
      <meta name="robots" content="{{ $seoRobots }}" />
      <meta name="googlebot" content="{{ $seoRobots }}">
      <meta name="revisit-after" content="3 days" />
      <meta name="rating" content="General">
      <meta name="application-name" content="{{ $seoSiteName }}" />
      <meta name="theme-color" content="#ed3235" />
      <meta name="msapplication-TileColor" content="#ed3235" />
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <meta name="apple-mobile-web-app-title" content="{{ $seoSiteName }}" />
      @if ($seoImage)
      <link rel="apple-touch-icon-precomposed" href="{{ $seoImage }}" sizes="700x700">
      @endif
      <meta property="og:url" content="{{ $seoCanonical }}">
      <meta property="og:title" content="{{ $seoTitle }}">
      <meta property="og:description" content="{{ $seoDescription }}">
      <meta property="og:image" content="{{ $seoImage }}">
      <meta property="og:site_name" content="{{ $seoSiteName }}">
      <meta property="og:image:alt" content="{{ $seoTitle }}">
      <meta property="og:type" content="website" />
      <meta property="og:locale" content="vi_VN" />
      <meta name="twitter:card" content="summary_large_image" />
      <meta name="twitter:title" content="{{ $seoTitle }}" />
      <meta name="twitter:description" content="{{ $seoDescription }}" />
      <meta name="twitter:image" content="{{ $seoImage }}" />
      <meta name="twitter:url" content="{{ $seoCanonical }}" />
      <meta itemprop="name" content="{{ $seoTitle }}">
      <meta itemprop="description" content="{{ $seoDescription }}">
      <meta itemprop="image" content="{{ $seoImage }}">
      <meta itemprop="url" content="{{ $seoCanonical }}">
      <link rel="canonical" href="{{ $seoCanonical }}">
      @if ($seoImage)
      <link rel="image_src" href="{{ $seoImage }}" />
      @endif
      <link rel="shortcut icon" href="{{ url('' . $setting->favicon) }}" type="image/x-icon">
      <link rel="icon" href="{{ url('' . $setting->favicon) }}" type="image/x-icon">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      @hasSection('schema')
      @yield('schema')
      @else
      @include('partials.seo-organization')
      @endif
      <link rel="stylesheet" href="/frontend/css/site-fonts.css">
      <link rel="stylesheet" href="/frontend/css/base.css">

    <link rel='stylesheet' id='mfn-be-css' href='/frontend/css/be.css' media='all' />
    <link rel='stylesheet' id='mfn-animations-css' href='/frontend/css/animations.min.css' media='all' />
    <link rel='stylesheet' id='mfn-font-awesome-css' href='/frontend/css/fontawesome.css' media='all' />

    <link rel='stylesheet' id='mfn-responsive-css' href='/frontend/css/responsive.css' media='all' />

    <link rel='stylesheet' id='evcal_cal_default-css' href='/frontend/css/eventon_styles.css' media='all' />
    <link rel='stylesheet' id='evo_font_icons-css' href='/frontend/css/all.css' media='all' />
    <link rel='stylesheet' id='eventon_dynamic_styles-css' href='/frontend/css/eventon_dynamic_styles.css' media='all' />
    <link rel='stylesheet' id='mfn-hb-css' href='/frontend/css/style.css' media='all' />
    <link rel="stylesheet" href="/frontend/css/header.css">
    <link rel='stylesheet' id='elementor-icons-css' href='/frontend/css/elementor-icons.min.css' media='all' />
    <link rel='stylesheet' id='elementor-frontend-css' href='/frontend/css/frontend-lite.min.css' media='all' />

    <link rel='stylesheet' id='elementor-post-74-css' href='/frontend/css/post-74.css' media='all' />

    <link rel='stylesheet' id='elementor-post-10-css' href='/frontend/css/post-10.css' media='all' />
    <link rel="stylesheet" href="/frontend/css/theme.css">
    <link rel='stylesheet' id='elementor-icons-shared-0-css' href='/frontend/css/fontawesome.min.css' media='all' />
    <link rel='stylesheet' id='elementor-icons-fa-regular-css' href='/frontend/css/regular.min.css' media='all' />
    <script id="jquery-core-js" src='/frontend/js/jquery.min.js'></script>
    <script id="jquery-migrate-js" src='/frontend/js/jquery-migrate.min.js'></script>

    <link rel='stylesheet' id='mfn-element-divider-2-css' href='/frontend/css/divider-2.css' media='all' />
    <link rel='stylesheet' id='mfn-post-local-styles-1541791420973-css' href='/frontend/css/post-154.css' media='all' />
    <link rel='stylesheet' id='mfn-elementor-css' href='/frontend/css/elementor.css' media='all' />
    <link rel="stylesheet" href="/frontend/css/banner.css?v={{ filemtime(public_path('frontend/css/banner.css')) }}">
    <link rel="stylesheet" href="/frontend/css/about.css?v={{ filemtime(public_path('frontend/css/about.css')) }}">
    <link rel="stylesheet" href="/frontend/css/services.css?v={{ filemtime(public_path('frontend/css/services.css')) }}">
    <link rel="stylesheet" href="/frontend/css/events.css?v={{ filemtime(public_path('frontend/css/events.css')) }}">
    <link rel="stylesheet" href="/frontend/css/gallery.css">
    <link rel="stylesheet" href="/frontend/css/news.css">
    <link rel="stylesheet" href="/frontend/css/footer.css?v={{ filemtime(public_path('frontend/css/footer.css')) }}">
    <link rel="stylesheet" href="/frontend/css/call-buttons.css?v={{ filemtime(public_path('frontend/css/call-buttons.css')) }}">
      
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">{{-- <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet"> --}}

      @yield('css')
   </head>
   <body class="home wp-singular page-template-default page page-id-10 wp-theme-betheme mfn-footer-default  color-custom content-brightness-light input-brightness-dark style-simple button-round layout-full-width one-page if-zoom is-elementor mhb header-boxed sticky-header sticky-tb-color ab-hide menu-line-below-80-1 menuo-no-borders logo-no-sticky-padding subheader-both-center footer-sliding footer-copy-center mobile-tb-center mobile-mini-mr-lc tablet-sticky mobile-sticky mobile-header-mini mobile-icon-user-ss mobile-icon-wishlist-ss mobile-icon-search-ss mobile-icon-wpml-ss mobile-icon-action-ss tr-menu be-page-10 be-2666 elementor-default elementor-kit-74 elementor-page elementor-page-10">
   
      <div id="home"></div>

      <div id="Wrapper">
  
         @include('layouts.header.index')
          
          @yield('content')
  
          
          @include('layouts.footer.index')
  
      </div>

      @include('partials.call-buttons')
  
      <div id="body_overlay"></div>
  
      <div class='evo_elms'><em class='evo_tooltip_box'></em></div>
  
      <div id='evo_global_data' data-d='{"calendars":[]}'></div>
      <div id='evo_lightboxes' class='evo_lightboxes' style='display:none'>
          <div class='evo_lightbox eventcard eventon_events_list' id=''>
              <div class="evo_content_in">
                  <div class="evo_content_inin">
                      <div class="evo_lightbox_content">
                          <div class='evo_lb_closer'>
                              <a class='evolbclose '>X</a>
                          </div>
                          <div class='evo_lightbox_body eventon_list_event evo_pop_body evcal_eventcard'> </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <script id="jquery-ui-core-js-before">
          jQuery.uiBackCompat = true;
          //# sourceURL=jquery-ui-core-js-before
      </script>
      <script id="jquery-ui-core-js" src="/frontend/js/core.min.js"></script>
    <script id="jquery-ui-tabs-js" src="/frontend/js/tabs.min.js"></script>
    <script id="mfn-debouncedresize-js" src="/frontend/js/debouncedresize.min.js"></script>
    <script id="mfn-magnificpopup-js" src="/frontend/js/magnificpopup.min.js"></script>
    <script id="mfn-menu-js" src="/frontend/js/menu.js"></script>
    <script id="mfn-visible-js" src="/frontend/js/visible.min.js"></script>
    <script id="mfn-animations-js" src="/frontend/js/animations.min.js"></script>
    <script id="mfn-enllax-js" src="/frontend/js/enllax.min.js"></script>
    <script id="mfn-parallax-js" src="/frontend/js/translate3d.js"></script>
    <script id="mfn-scripts-js-extra">
        var mfn = { "mobileInit": "1240", "parallax": "translate3d", "responsive": "1", "sidebarSticky": "", "lightbox": { "disable": false, "disableMobile": false, "title": false }, "slider": { "blog": 0, "clients": 0, "offer": 0, "portfolio": 0, "shop": 0, "slider": 0, "testimonials": 0 }, "livesearch": { "minChar": 3, "loadPosts": 10, "translation": { "pages": "Pages", "categories": "Categories", "portfolio": "Portfolio", "post": "Posts", "products": "Products" } }, "accessibility": { "translation": { "headerContainer": "Header container", "toggleSubmenu": "Toggle submenu" } }, "home_url": "", "site_url": "https://www.khinhkhicau.vn", "ajax": "https://www.khinhkhicau.vn/wp-admin/admin-ajax.php" };
        //# sourceURL=mfn-scripts-js-extra
    </script>
    <script id="mfn-scripts-js" src="/frontend/js/scripts.js"></script>
    <script id="evcal_functions-js" src="/frontend/js/eventon_functions.js"></script>
    <script id="evcal_easing-js" src="/frontend/js/jquery.easing.1.3.js"></script>
    <script id="evo_handlebars-js" src="/frontend/js/handlebars.js"></script>
    <script id="evo_mobile-js" src="/frontend/js/jquery.mobile.min.js"></script>
    <script id="evo_moment-js" src="/frontend/js/moment.min.js"></script>
    <script id="evo_mouse-js" src="/frontend/js/jquery.mousewheel.min.js"></script>
    <script id="evcal_ajax_handle-js-extra">
        var the_ajax_script = { "ajaxurl": "https://www.khinhkhicau.vn/wp-admin/admin-ajax.php", "rurl": "https://www.khinhkhicau.vn/wp-json/", "postnonce": "3e228cd674", "ajax_method": "ajax", "evo_v": "4.3.4" };
        var evo_general_params = { "ajaxurl": "https://www.khinhkhicau.vn/wp-admin/admin-ajax.php", "rurl": "https://www.khinhkhicau.vn/wp-json/", "n": "3e228cd674", "ajax_method": "ajax", "evo_v": "4.3.4" };
        //# sourceURL=evcal_ajax_handle-js-extra
    </script>  
    <script id="evcal_ajax_handle-js" src="/frontend/js/eventon_script.js"></script>
    <script id="mfn-hb-js" src="/frontend/js/mfn-header.js"></script>
    <script id="mfn-isotope-js" src="/frontend/js/isotope.min.js"></script>
    <script id="elementor-webpack-runtime-js" src="/frontend/js/webpack.runtime.min.js?v={{ filemtime(public_path('frontend/js/webpack.runtime.min.js')) }}"></script>
    <script id="elementor-frontend-modules-js" src="/frontend/js/frontend-modules.min.js"></script>
    <script id="elementor-waypoints-js" src="/frontend/js/waypoints.min.js"></script>
    <script id="elementor-frontend-js-before">
        var elementorFrontendConfig = { "environmentMode": { "edit": false, "wpPreview": false, "isScriptDebug": false }, "i18n": { "shareOnFacebook": "Chia s\u1ebb tr\u00ean Facebook", "shareOnTwitter": "Chia s\u1ebb tr\u00ean Twitter", "pinIt": "Ghim n\u00f3", "download": "T\u1ea3i xu\u1ed1ng", "downloadImage": "T\u1ea3i h\u00ecnh \u1ea3nh", "fullscreen": "To\u00e0n m\u00e0n h\u00ecnh", "zoom": "Thu ph\u00f3ng", "share": "Chia s\u1ebb", "playVideo": "Ch\u01a1i Video", "previous": "Previous", "next": "Next", "close": "\u0110\u00f3ng" }, "is_rtl": false, "breakpoints": { "xs": 0, "sm": 480, "md": 768, "lg": 960, "xl": 1440, "xxl": 1600 }, "responsive": { "breakpoints": { "mobile": { "label": "Thi\u1ebft b\u1ecb di \u0111\u1ed9ng", "value": 767, "default_value": 767, "direction": "max", "is_enabled": true }, "mobile_extra": { "label": "Mobile Extra", "value": 880, "default_value": 880, "direction": "max", "is_enabled": false }, "tablet": { "label": "M\u00e1y t\u00ednh b\u1ea3ng", "value": 1024, "default_value": 1024, "direction": "max", "is_enabled": true }, "tablet_extra": { "label": "Tablet Extra", "value": 1200, "default_value": 1200, "direction": "max", "is_enabled": false }, "laptop": { "label": "Laptop", "value": 1366, "default_value": 1366, "direction": "max", "is_enabled": false }, "widescreen": { "label": "Widescreen", "value": 2400, "default_value": 2400, "direction": "min", "is_enabled": false } } }, "version": "3.11.5", "is_static": false, "experimentalFeatures": { "e_dom_optimization": true, "e_optimized_assets_loading": true, "e_optimized_css_loading": true, "a11y_improvements": true, "additional_custom_breakpoints": true, "landing-pages": true, "kit-elements-defaults": true }, "urls": { "assets": "\/frontend\/" }, "swiperClass": "swiper-container", "settings": { "page": [], "editorPreferences": [] }, "kit": { "stretched_section_container": "#Wrapper", "active_breakpoints": ["viewport_mobile", "viewport_tablet"], "global_image_lightbox": "yes", "lightbox_enable_counter": "yes", "lightbox_enable_fullscreen": "yes", "lightbox_enable_zoom": "yes", "lightbox_enable_share": "yes", "lightbox_title_src": "title", "lightbox_description_src": "description" }, "post": { "id": 10, "title": "Khinh%20Kh%C3%AD%20C%E1%BA%A7u%20%E2%80%93%20Bay%20cao%20Vi%E1%BB%87t%20Nam", "excerpt": "", "featuredImage": false } };
        //# sourceURL=elementor-frontend-js-before
    </script>
    <script id="elementor-frontend-js" src="/frontend/js/frontend.min.js?v={{ filemtime(public_path('frontend/js/frontend.min.js')) }}"></script>
    <script src="/frontend/js/banner.js?v={{ filemtime(public_path('frontend/js/banner.js')) }}"></script>
    <script src="/frontend/js/video-popup.js?v={{ filemtime(public_path('frontend/js/video-popup.js')) }}"></script>
    <script src="/frontend/js/slider.js"></script>
    <script src="/frontend/js/gallery.js"></script>
      @yield('js')
   </body>
</html>