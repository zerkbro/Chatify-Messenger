<script type="text/javascript">
    // localStorage.clear();
    var div = document.querySelector("div.page-wrapper")
    if(div.classList.contains('compact-sidebar')){
        div.classList.remove("compact-sidebar");
    }
    if(div.classList.contains('modern-sidebar')){
        div.classList.remove("modern-sidebar");
    }
    localStorage.setItem('page-wrapper', 'page-wrapper compact-wrapper compact-sidebar');
    localStorage.setItem('page-body-wrapper', 'sidebar-icon');
</script>

<script src="https://kit.fontawesome.com/fafa16a672.js" crossorigin="anonymous"></script>

<script src="{{ asset('user_assets/js/jquery-3.5.1.min.js') }}"></script>

<!-- feather icon js-->
<script src="{{ asset('user_assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('user_assets/js/icons/feather-icon/feather-icon.js') }}"></script>


<!-- Sidebar jquery-->
<script src="{{ asset('user_assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('user_assets/js/config.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('user_assets/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('user_assets/js/bootstrap/bootstrap.min.js') }}"></script>
<!-- Plugins JS start-->

    {{-- <script src="https://laravel.pixelstrap.com/viho/assets/js/chart/chartjs/chart.min.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/chart/chartist/chartist.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/chart/knob/knob.min.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/chart/apex-chart/stock-prices.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/prism/prism.min.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/clipboard/clipboard.min.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/counter/jquery.counterup.min.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/counter/counter-custom.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/custom-card/custom-card.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/owlcarousel/owl.carousel.js"></script>
    <script src="https://laravel.pixelstrap.com/viho/assets/js/owlcarousel/owl-custom.js"></script>
    <!-- Plugins JS Ends-->--}}
    {{-- <script src="{{asset('user_assets/js/support-ticket-custom.js')}}" ></script> --}}
    {{-- <script src="{{asset('user_assets/js/dropzone/dropzone.js')}}" ></script> --}}
    {{-- <script src="{{asset('user_assets/js/dropzone/dropzone-script.js')}}" ></script> --}}
    {{-- <script src="{{asset('user_assets/js/tooltip-init.js')}}" ></script> --}}
    <script src="{{ asset('user_assets/js/dashboard/dashboard_2.js') }}"></script>
<!-- Theme js-->
<script src="{{ asset('user_assets/js/script.js') }}"></script>
<script src="{{ asset('user_assets/js/theme-customizer/customizer.js') }}"></script>
