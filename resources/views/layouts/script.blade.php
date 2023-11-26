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

{{-- Notify Script --}}


{{-- End Notify Script --}}

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


    {{-- <script src="{{asset('user_assets/js/support-ticket-custom.js')}}" ></script> --}}

    <script src="{{asset('user_assets/js/tooltip-init.js')}}" ></script>
    {{-- <script src="{{asset('user_assets/js/popover-custom.js')}}" ></script> --}}
    <script src="{{asset('user_assets/js/dashboard/dashboard_2.js') }}"></script>
<!-- Theme js-->
<script src="{{ asset('user_assets/js/script.js') }}"></script>
<script src="{{ asset('user_assets/js/theme-customizer/customizer.js') }}"></script>

{{-- Adding Attachment in message. --}}

<!-- include FilePond library -->

<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>


<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

{{--<script>--}}
{{--    $(function(){--}}

{{--        // First register any plugins--}}
{{--        $.fn.filepond.registerPlugin(FilePondPluginImagePreview);--}}

{{--        // Turn input element into a pond--}}
{{--        $('.my-pond').filepond();--}}

{{--        // Set allowMultiple property to true--}}
{{--        $('.my-pond').filepond('allowMultiple', true);--}}

{{--        // Listen for addfile event--}}
{{--        $('.my-pond').on('FilePond:addfile', function(e) {--}}
{{--            console.log('file added event', e);--}}
{{--        });--}}

{{--        // Manually add a file using the addfile method--}}
{{--        $('.my-pond').first().filepond('addFile', 'index.html').then(function(file){--}}
{{--            console.log('file added', file);--}}
{{--        });--}}

{{--    });--}}
{{--</script>--}}
