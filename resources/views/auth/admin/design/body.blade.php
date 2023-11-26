<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- including the title, meta and links here --}}
        @include('auth.admin.design.outline.admin_header')

        @livewireStyles()
    </head>

    <body>
        @yield('contents')

        {{-- including the script files --}}
        @include('auth.admin.design.outline.admin_script')

        @livewireScripts()
    </body>

</html>
