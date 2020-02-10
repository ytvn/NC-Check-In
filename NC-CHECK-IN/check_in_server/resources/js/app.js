require('./bootstrap');
require('datatables.net-bs4' );
$.Swal = require('sweetalert2')
require("admin-lte");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

