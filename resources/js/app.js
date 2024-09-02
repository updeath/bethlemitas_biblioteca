import './bootstrap';
import 'select2/dist/css/select2.min.css';
import 'select2/dist/js/select2.min.js';

$(document).ready(function() {
    $('#mySelect').select2({
        placeholder: "Select an option",
        allowClear: true
    });
});