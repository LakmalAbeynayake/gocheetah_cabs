<!-- VENDOR CSS -->
<link rel="stylesheet" href="<?php echo assets_url(); ?>/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo assets_url(); ?>/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo assets_url(); ?>/vendor/linearicons/style.css">
<link rel="stylesheet" href="<?php echo assets_url(); ?>/css/bootstrap-datetimepicker.css" type="text/css">
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="<?php echo assets_url(); ?>/plugins/select2/select2.css" type="text/css">

<link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" type="text/css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" type="text/css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- MAIN CSS -->
<link rel="stylesheet" href="<?php echo assets_url(); ?>/css/main.1.0.css">

<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
<link rel="stylesheet" href="<?php echo assets_url(); ?>/css/demo.css">

<!-- GOOGLE FONTS -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

<!-- ICONS -->
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo assets_url(); ?>/img/apple-icon.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo assets_url(); ?>/img/favicon.png">

<!-- FONT AWESOME -->
<style>
    .dropdown-item {
        display: block;
        width: 100%;
        padding: .25rem 1.5rem;
        clear: both;
        font-weight: 400;
        color: #212529;
        text-align: inherit;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
    }

    .dropdown-item:focus,
    .dropdown-item:hover {
        color: #16181b;
        text-decoration: none;
        background-color: #f8f9fa;
    }

    .dropdown-divider {
        height: 0;
        margin: .5rem 0;
        overflow: hidden;
        border-top: 1px solid #e9ecef;
    }

    table>thead>tr:first-child {
        background-color: #2B333E;
        color: white;
    }

    .btn-notification {
        width: 100%;
        font-size: 18px;
        cursor: inherit;
        margin-top: -20px;
        display: none;
    }

    .btn-notification>i::before {
        content: "\f057";
        font-family: "FontAwesome";
        font-style: normal;
    }

    .btn-notification>span {
        margin-left: 10px;
    }

    .slimScrollDiv {
        height: 100% !important;
    }

    /* make .modal-dialog-scrollable scrollable */
    .modal-dialog-scrollable>.modal-content>.modal-body {
        max-height: 72vh;
        overflow-x: hidden;
        overflow-y: scroll;
    }

    /* panel tool buttons */
    .panel .panel-heading button {
        padding: 5px;
        margin-left: 5px;
        background-color: #6e746e59;
        border: none;
        outline: none;
        border-radius: 26px;
        width: 30px;
    }

    /* Display button clock animation */
    button:active {
        color: #ccc;
    }

    /* make select2 container better */
    .select2-container {
        padding: 0;
        background: inherit;
        box-shadow: none;
    }

    .select2-container .select2-choice {
        height: 33px;
        line-height: 32px;
        background-image: none;
    }

    /* Make bootbox appear on center of screen */
    .bootbox.modal.fade.in {
        display: flex !important;
        align-items: center;
    }

    /* Make data tables littlebit detailfull */
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 5px;
    }

    /* td verticle align middle */
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 4px;
        line-height: 1.42857143;
        vertical-align: middle;
        border-top: 1px solid #ddd;
    }

    /* Make datatables not look weird on mobiles */
    .dataTables_wrapper {
        overflow-x: scroll;
    }

    table.dataTable>thead>tr>th {
        text-align: center;
    }

    @media screen and (max-width: 767px) {
        /* #products_table>tbody>tr:nth-child(1)>td:nth-child(2) {
            text-align: center;
            position: relative !important;
        } */

        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_filter,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: left !important;
        }

        div.dataTables_wrapper div.dataTables_filter {
            padding-top: 40px;
        }
    }
</style>