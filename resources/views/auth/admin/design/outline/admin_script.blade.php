{{-- footer section --}}
<style>
    body {
        user-select: none;
    }
</style>

{{-- Admin Dashboard Footer --}}
<script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

{{-- custom bootstrap admin scripts --}}
<script src="{{ asset('admin_assets/js/sb-admin-2.min.js') }}"></script>


{{--DataTables js CDN--}}
<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>


<script>
    let table = new DataTable('#myDataTable');

    // Customizing the DataTable display when table data is empty.
    if (table.rows().count() === 0) {
        // If the table is empty, destroy and reinitialize without paging
        table.destroy();
        table = new DataTable('#myDataTable', {
            info: false,
            ordering: false,
            paging: false,
            language: {
                // emptyTable: "No records Found!"
                emptyTable: "<span class='text-danger'> No records found!</span>"
            }
        });
    }

</script>

