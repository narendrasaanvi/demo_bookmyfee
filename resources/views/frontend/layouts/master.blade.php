<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Book My Fee</title>
      <!-- google font -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
      <!-- animation -->
      <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
      <!-- magnific popup -->
      <link rel="stylesheet" href="{{url('assets/css/magnific-popup.css')}}">
      <!-- font awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
         integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
         crossorigin="anonymous" referrerpolicy="no-referrer">
      <!-- slik carousel -->
      <link rel="stylesheet" href="{{url('assets/css/slick-theme.css')}}">
      <link rel="stylesheet" href="{{url('assets/css/slick.css')}}">
      <!-- bootstrap -->
      <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
      <!-- css -->
      <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
      <!-- favicon -->
      <link rel="icon" href="{{url('assets/images/fevicon.png')}}" type="image/x-icon">

      <script src="{{url('assets/js/jquery.min.js')}}"></script>
   </head>
   <style>
    .search-icon{
    padding-right: 12px;
    cursor: pointer;
    color: #8562fa;
    }
   </style>
   <body>
      <div class="body-wrap">
         <!-- header area start -->
         <header class="header-area">
            <nav class="header-nav navbar fixed-top navbar-expand-lg position-absolute w-100">
               <div class="container header-nav-menu">
                  <a class="navbar-brand" href="{{url('/')}}">
                  <img src="{{url('assets/images/logo.png')}}" alt="Header Logo">
                  </a>
                  <div class="collapse navbar-collapse d-none d-lg-block">
                     <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                           <a href="{{url('/')}}" class="nav-link py-3">Home</a>
                        </li>
                        <li class="nav-item">
                           <a href="{{url('/contact')}}" class="nav-link py-3">Contact Us</a>
                        </li>
                        @if(auth()->check())
                            <li class="nav-item">
                                <a href="{{url('/player-registration/view')}}" class="nav-link py-3">Manage Player</a>
                            </li>

                            @if(auth()->user()->organizer === 'yes')
                                <li class="nav-item">
                                    <a href="{{url('/tournament-create')}}" class="nav-link py-3">Manage Tournament</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{url('/invoice')}}" class="nav-link py-3">Receipt</a>
                            </li>
                        @endif
                     </ul>
                     <div class="mode-and-button d-flex align-items-center">
                     <span class="search-icon" data-bs-toggle="modal" data-bs-target="#staticBackdrop" tabindex="0"><i class="fa-solid fa-magnifying-glass"></i></span>
                     @if(Auth::check())
                     <a href="{{url('/user/profile')}}" class="header-btn custom-btn2">
                            <button class="header-btn custom-btn2">Profile</button>
                    </a>
                    @else
                        <!-- Show Login button if user is not logged in -->
                        <a href="{{ url('login') }}" class="header-btn custom-btn2">
                            <button class="header-btn custom-btn2">Login here</button>
                        </a>
                    @endif

                     </div>
                  </div>
                  <!-- mobile menu -->
                  <div class="mobile-view-header d-block d-lg-none d-flex gap-3 align-items-center">
                     <div class="  me-md-3">
                     <span class="search-icon" data-bs-toggle="modal" data-bs-target="#staticBackdrop" tabindex="0"><i class="fa-solid fa-magnifying-glass"></i></span>
                     </div>
                     <!-- <button class="header-btn custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">List Your Tournament</button> -->
                     <a class="border rounded-1 py-1 px-2 bg-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                     <span class="navbar-toggler-icon nav-toggler-icon"></span>
                     </a>
                     <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" >
                        <div class="offcanvas-header">
                           <a class="navbar-brand" href="{{url('/')}}">
                           <img src="{{url('assets/images/logo.png')}}" alt="Header Logo">
                           </a>
                           <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                           <div class="dropdown mt-3">
                              <ul class="navbar-nav m-auto">
                                 <li class="nav-item">
                                    <a href="{{url('/')}}" class="nav-link py-3">Home</a>
                                 </li>
                                 <li class="nav-item">
                                    <a href="{{url('/contact')}}" class="nav-link py-3">Contact Us</a>
                                 </li>
                                 @if(auth()->check() && auth()->user()->organizer === 'yes')
                                 <li class="nav-item">
                                    <a href="{{url('/player-registration/view')}}" class="nav-link py-3">Manage Players</a>
                                 </li>
                                 <li class="nav-item">
                                    <a href="{{url('/tournament-create')}}" class="nav-link py-3">Manage Tournament</a>
                                 </li>
                                 <li class="nav-item">
                                    <a href="{{url('/invoice')}}" class="nav-link py-3">Receipt</a>
                                 </li>
                                 @endif
                                 </li>
                                 @if(auth()->check() && auth()->user()->organizer === 'no')
                                 <li class="nav-item">
                                    <a href="{{url('/player-registration/view')}}" class="nav-link py-3">Manage Players</a>
                                 </li>
                                 <li class="nav-item">
                                    <a href="{{url('/invoice')}}" class="nav-link py-3">Receipt</a>
                                 </li>
                                 @endif
                                 @if (Auth::check())
                                 <!-- Show Account and Logout when the user is logged in -->
                                 <li class="nav-item">
                                    <a href="{{url('/user/profile')}}" class="nav-link py-3">Account</a>
                                 </li>
                                 <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="POST" class="nav-link py-3 m-0">
                                       @csrf
                                       <button type="submit" class="btn btn-link">Logout</button>
                                    </form>
                                 </li>
                                 @else
                                 <!-- Show Sign Up and Login when the user is not logged in -->
                                 <li class="nav-item">
                                    <a href="{{ url('/register') }}" class="nav-link py-3">Sign Up</a>
                                 </li>
                                 <li class="nav-item">
                                    <a href="{{ url('/login') }}" class="nav-link py-3">Login</a>
                                 </li>
                                 @endif
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- end mobile menu -->
               </div>
            </nav>
            <!-- hero sec start -->
            <!-- hero sec start -->
         </header>
         <!-- header area end -->
         @yield('main-content')
         <!-- footer area start -->
         <footer class="footer-area" style="background-image: url({{url('assets/images/Footer.png')}});">
            <div class="container">
               <div class="footer-top">
                  <div class="row">
                     <div class=" col-lg-6">
                        <div class="row">
                           <div class="col-sm-6 col-lg-8 ">
                              <div class="footer-info">
                                 <a href="{{url('/')}}" class="footer-logo">
                                 <img src="{{url('assets/images/footer_logo.png')}}" alt="Footer Logo" style="width:200px">
                                 </a>
                                 <p class="footer-desc">
                                 Book My Fee is the easiest way to organize<br class="d-none d-lg-block"> and register the entry for chess tournaments especially in India.
                                 </p>
                                 <ul class="footer-social social">
                                    <li>
                                       <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                       <a href=""><i class="fa-brands fa-linkedin-in"></i></a>
                                    </li>
                                    <li>
                                       <a href=""><i class="fa-brands fa-twitter"></i></a>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                           <div class="col-sm-6 col-lg-4">
                              <div class="footer-about custom-item">
                                 <h5 class="title">Quick Links</h5>
                                 <ul class="about-item">
                                    <li><a href="{{url('/')}}">Home</a></li>
                                    <!-- <li><a href="{{url('/about-us')}}">About us</a></li> -->
                                    <li><a href="{{url('/contact')}}">Contact us</a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class=" col-lg-6">
                        <div class="row">
                           <div class="col-sm-6">
                              <div class="footer-enterprise custom-item">
                                 <h5 class="title">Help</h5>
                                 <ul class="enterprise-item">
                                    <li><a href="{{url('privacy-policy')}}">Privacy Policy</a></li>
                                    <li><a href="{{url('return-policy')}}">Cancellation and Refund Policy</a></li>
                                    <li><a href="{{url('term-condition')}}">Terms and Conditions</a></li>
                                 </ul>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="footer-contact custom-item">
                                 <h5 class="title">Contact</h5>
                                 <ul class="contact-item">
                                    <li><a href="">info@bookmyfee.com</a></li>
                                    <li><a href="https://wa.me/09159166464" target="_blank">(+91) 915 916 6464</a></li>
                                    <li><a href="https://www.google.com/maps?q=13.0772706,80.1178481" target="_blank">No : 207, Vinayagar Kovil Road,
                                       Kasthuribhai Avenue, (Near by Abirami Nagar)
                                       Thiruverkadu, Chennai - 600077 </a>
                                       </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <hr>
               <div class="footer-copyright-area text-center pb-3">
                  <span>© 2024 Book My Fee. All rights reserved</span>
               </div>
            </div>
         </footer>
         <!-- footer area end -->
         <!-- Modal -->
         <div class="modal fade popup-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg popup-dialogue modal-dialog-centered">
               <div class="modal-content popup-content p-4 bg-white">
                  <button type="button" class="btn btn-secondary  ms-auto" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                  <div class="modal-body popup-body">
                  <div class="position-relative">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search for tournaments..." autocomplete="off">
                        <div id="suggestions" class="list-group shadow-sm"></div>
                    </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Button trigger modal -->
         <!-- Modal 2 -->
         <x-submit-tournaments />
      </div>
      <!-- jquery -->

      <script src="{{url('assets/js/jquery.countdown.min.js')}}"></script>
      <!-- animation -->
      <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
      <!-- magnific popup -->
      <script src="{{url('assets/js/jquery.magnific-popup.min.js')}}"></script>
      <!-- bootstrap -->
      <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
      <!-- slick -->
      <script src="{{url('assets/js/slick.min.js')}}"></script>
      <!-- parallax js -->
      <script src="{{url('assets/js/parallax.min.js')}}"></script>
      <!-- javaScript -->
      <script src="{{url('assets/js/main.js')}}"></script>
      <script>
        function fetchAndDisplaySuggestions(query) {
            const suggestionsBox = document.getElementById('suggestions');
            fetch(`/api/tournament-list?query=${encodeURIComponent(query)}`)
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success" && data.data.length > 0) {
                        suggestionsBox.innerHTML = ""; // Clear old suggestions
                        suggestionsBox.style.display = "block";

                        data.data.forEach((item) => {
                            const suggestionItem = document.createElement("a");
                            suggestionItem.classList.add("list-group-item", "list-group-item-action");
                            suggestionItem.textContent = item.title;
                            suggestionItem.href = `/booking-tournament/${item.slug}`;
                            suggestionsBox.appendChild(suggestionItem);
                        });
                    } else {
                        suggestionsBox.innerHTML = ""; // Clear and hide if no results
                        suggestionsBox.style.display = "none";
                    }
                })
                .catch((error) => {
                    console.error("Error fetching data:", error);
                    suggestionsBox.innerHTML = '<div class="text-danger">Failed to fetch results</div>';
                    suggestionsBox.style.display = "block";
                });
        }

        // Event Listener for Input Field
        document.getElementById("searchInput").addEventListener("input", function () {
            const query = this.value.trim();
            if (query.length > 1) {
                fetchAndDisplaySuggestions(query);
            } else {
                document.getElementById("suggestions").style.display = "none";
            }
        });
        </script>
   </body>
</html>
