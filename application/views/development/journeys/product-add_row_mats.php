<!doctype html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- CSS -->
    <?php $this->load->view('common/css') ?>
    <!-- THIS PAGE SPECIFIC -->
    <link rel="stylesheet" href="<?php echo assets_url(); ?>/vendor/chartist/css/chartist-custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo assets_url(); ?>/css/jquery-ui.css">
    <style>
        .form-group {
            margin-bottom: 15px;
            padding-bottom: 35px;
        }

        #purchase_items_table>thead>tr:first-child {
            background-color: #2B333E;
            color: white;
        }

        #purchase_items_table>thead>tr>td {
            vertical-align: middle;
        }

        #purchase_items_table>tfoot>tr {
            font-size: 25px;
            font-weight: bold;
        }

        .panel .table>thead>tr>td:last-child,
        .panel .table>thead>tr>th:last-child,
        .panel .table>tbody>tr>td:last-child,
        .panel .table>tbody>tr>th:last-child,
        .panel .table>tfoot>tr>td:last-child,
        .panel .table>tfoot>tr>th:last-child {
            padding: 3px;
        }
    </style>
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">

        <!-- NAVBAR TOP-->
        <?php $this->load->view('common/nav-bar-top') ?>
        <!-- END NAVBAR TOP -->

        <!-- LEFT SIDEBAR -->
        <?php $this->load->view('common/nav-bar-left') ?>
        <!-- END LEFT SIDEBAR -->

        <!-- MAIN -->
        <div class="main">

            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">

                    <!-- ADVANCED FILTERS -->

                    <div class="row">
                        <div class="col-md-12">
                            <!-- RECENT PURCHASES -->
                            <div class="panel">
                                <div class="panel-heading">
                                    <h1 class="panel-title"><strong>ADD PURCHASED ITEMS</strong></h1>
                                    <div class="right">
                                        <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                                        <!-- <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button> -->
                                    </div>
                                </div>
                                <form action="" id="add_purchases_form">
                                    <div class="panel-body">
                                        <div class="panel-body no-padding">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-3">
                                                        <div class="metric">
                                                            BRANCH *
                                                            <select id="branch_id" name="branch_id" class="form-control search-select">
                                                                <?php foreach ($warehouse as $key => $wh) {
                                                                    $sel = "";
                                                                    echo '<option value="' . $wh->id . '" ' . $sel . '"> ' . $wh->name . '</option>';
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="metric">
                                                            Date
                                                            <input type="text" id="purchase_date_time" class="form-control date" name="purchase_date_time">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="metric">
                                                            Supplier
                                                            <select id="supplier_id" name="supplier_id" class="form-control search-select">
                                                                <option value="">&nbsp;</option>
                                                                <?php foreach ($supplier as $key => $sup) {
                                                                    echo "<option value=" . $sup->supp_id . ">" . $sup->supp_company_name . "</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="metric">
                                                            Supplier Reference No
                                                            <input type="text" id="supp_invocie_no" class="form-control" name="supp_invocie_no">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="metric">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-barcode fa-2x"></i></span>
                                                                <input type="text" id="add_item" class="form-control fa-2x" name="add_item" style="height: 100%;" placeholder="Search products here">
                                                                <span class="input-group-addon">.00</span>
                                                            </div>
                                                            <table class="table items table-striped table-bordered table-condensed table-hover" id="purchase_items_table" style="margin-top: 20px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="col-md-4">Product Name (Product Code)</th>
                                                                        <th class="col-md-1">Unit Cost</th>
                                                                        <th class="col-md-1">Quantity</th>
                                                                        <th class="col-md-1">Discount</th>
                                                                        <th>Subtotal (<span class="currency">LKR</span>)</th>
                                                                        <th style="width: 30px !important; text-align: center;"><i class="fa fa-trash-o"></i></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="5" id="total" class="text-right">
                                                                            0.00
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="uuid" id="uuid">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-primary btn-squared pull-right" type="submit"> SUBMIT PURCHASE </button>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <!-- END RECENT PURCHASES -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
    <!-- END MAIN -->

    <?php $this->load->view('common/footer'); ?>
    </div>
    <!-- END WRAPPER -->

    <!-- Javascript -->
    <?php $this->load->view('common/js') ?>
    <script src="<?php echo assets_url(); ?>/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="<?php echo assets_url(); ?>/vendor/chartist/js/chartist.min.js"></script>
    <script src="<?php echo assets_url(); ?>/scripts/klorofil-common.js"></script>
    <script type="text/javascript" src="<?php echo assets_url(); ?>/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/form_validations-add_purchases.js"></script>
    <script type="text/javascript" src="<?php echo assets_url(); ?>/js/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            FormValidator.init();
            $(".search-select").select2({
                allowClear: true
            });
            check_data();
        });

        $("#add_item").autocomplete({
            source: '<?php echo base_url(); ?>products/suggestions',
            minLength: 3,
            autoFocus: true,
            delay: 5,
            response: function(event, ui) {
                if (ui.content.length == 1 && ui.content[0].product_id != 0) {
                    /* ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading'); */
                } else if (ui.content.length == 0) {
                    var noResult = {
                        value: "",
                        label: "No matching result found! Product might be out of stock in the selected warehouse."
                    };
                    ui.content.push(noResult);
                } else {

                }
            },
            select: function(event, data) {
                if (data.item.value) {
                    var rowCount = $('#purchase_items_table > tbody > tr').length;
                    var is_added = false;
                    var prompt_msg = 'Enter quantity for :'+ data.item.value.product_name;
                    if ($('#quantity_' + data.item.value.product_id).length) {
                        prompt_msg = 'Add quantity for <strong>' + data.item.value.product_name + '</strong>'
                        is_added = true;
                    }
                    bootbox.prompt({
                        title: prompt_msg,
                        /* centerVertical: true, */
                        callback: function(result) {
                            if (result != null && !isNaN(result)) {
                                data.item.value.product_quantity = result;
                                console.log(data.item.value);
                                /* set package for db */
                                var op_item = {
                                    product_id: data.item.value.product_id,
                                    quantity: data.item.value.product_quantity,
                                    price: data.item.value.product_cost,
                                    change_method: 'add'
                                };
                                set_purchase_items(op_item, data.item.value, is_added);
                            } else {
                                toastr.warning("Invalid quantity");
                                setTimeout(() => {
                                    $("#add_item").val("").focus();
                                }, 100);
                            }
                        }
                    });
                    return false;
                }
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
        });

        function is_added_product(product_id) {
            if ($('#quantity_' + product_id).length) {
                $('#quantity_' + product_id).focus();
                return true;
            } else return false;
        }

        function add_to_list(value) {
            var qty = value.product_quantity;
            var sub_total = qty * value.product_cost;
            $('#purchase_items_table tr:first').after(
                '<tr class="child" id="row_' + value.product_id + '" data-product_id="' + value.product_id + '">' +
                '<td>' + value.product_name + ' (' + value.product_code + ')' +
                '<input type="hidden"     name="row[' + value.product_id + '][product_id]" value="' + value.product_id + '" id="product_id_' + value.product_id + '"></td>' +
                '<td class="text-right">' +
                '<input type="text" name="row[' + value.product_id + '][product_cost]" id="product_cost_' + value.product_id + '" value="' + value.product_cost + '" class="form-control text-center variable">' +
                //'<input type="text"   name="row[' + value.product_id + '][item_price_p]" id="item_price_p_' + value.product_id + '" value="' + 0 + '" style="" > + ' + 0 +
                '</td>' +
                '<td>' +
                '<input type="text"   name="row[' + value.product_id + '][quantity]" class="form-control text-center variable" value="' + qty + '" id="quantity_' + value.product_id + '" ></td>' +
                '<td class="text-right"><span class="text-right sdiscount text-danger">' +
                '<input readonly type="text"   name="row[' + value.product_id + '][discount]" value="0" class="form-control text-center variable" id="discount_' + value.product_id + '"> </span>' +
                '<input type="hidden" name="row[' + value.product_id + '][discount_val]" value="' + 0 + '" id="discount_val_' + value.product_id + '">' +
                '<input type="hidden" name="row[' + value.product_id + '][discount_val_tot]" value="' + 0 + '" id="discount_val_tot_' + value.product_id + '"></td>' +
                '<td class="text-right">' +
                '<span class="text-right ssubtotal" id="subtotal_' + value.product_id + '">' + sub_total + '</span>' +
                //'<input type="hidden" name="row[' + value.product_id + '][gross_total]" value="0" id="gross_total_' + value.product_id + '">&nbsp;'+
                '</td>' +
                '<td>' +
                '<a class="btn btn-danger" onclick="delete_row(' + value.product_id + ')"><i class="fa fa-times podel" style="cursor:pointer;"></i></a>' +
                '</td>' +
                '</tr>');
            var tmpFld = "#quantity_" + value.product_id;
            $('#add_item').focus();
            calculateTotal();
        }

        function delete_row(row_id) {
            $.ajax({
                url: "<?php echo base_url('operations/delete_row') ?>",
                data: {
                    product_id: row_id
                },
                method: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
                        var tmp = '#row_' + row_id;
                        $(tmp).remove();
                        calculateTotal();
                        toastr.warning("Row deleted");
                    } else toastr.info("Error");
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
        }

        function calculateTotal() {
            var total = 0;
            $('#purchase_items_table > thead > tr').each(function(index, element) {
                if (index) {
                    var product_id = $(element).data('product_id');
                    var product_cost = $('#product_cost_' + product_id).val();
                    var product_quantity = $('#quantity_' + product_id).val();
                    var sub_total = product_cost * product_quantity;
                    $('#subtotal_' + product_id).text(convertToAmount(sub_total));
                    total += parseFloat(sub_total);
                }
            });
            $('#total').text(convertToAmount(total));
        }
        $(document).on('change', '.variable', function() {
            calculateTotal()
        }).on('click', '.variable', function() {
            this.select();
        });

        function uuidv4() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function add_purchase(form) {
            $('#uuid').val(uuidv4());
            $.ajax({
                url: "<?php echo base_url('purchases/save_purchase'); ?>",
                type: "POST",
                data: new FormData(form),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        bootbox.alert("Purchase added Successfully");
                        setTimeout(() => {
                            window.location.href = "<?php echo base_url('purchases'); ?>";
                        }, 3000);
                    } else bootbox.alert("ERROE!");
                },
                error: function(data) {
                    bootbox.alert("ERROR!");
                    console.log(data.responseText);
                }
            });
        }
        /* load from db */
        function check_data() {
            $.ajax({
                url: "<?php echo base_url('operations/check_purchase') ?>",
                method: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data.success) {
                        console.info(data);
                        toastr.warning("Continue with old data");
                        set_data(data.main, data.items);
                    } else toastr.info("No old data found");
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
        }

        function set_data(main, items) {
            console.info(main);
            //$('#branch_id').val(main.op_supplier_id).trigger('change');
            $('#supplier_id').val(main.op_supplier_id).trigger('change');
            $('#supp_invocie_no').val(main.op_supp_invocie_no);

            $(items).each(function(index, item) {
                console.count("items");
                console.log(index);
                console.log(item);
                add_to_list(item);
            });
        }
        (function($) {
            $('.search-select').on('select2:select', function(e) {
                //console.log('Selecting: ', e.params.args.data);
                var op_item = {
                    branch_id: $('#branch_id').val(),
                    supplier_id: $('#supplier_id').val(),
                    supp_invocie_no: $('#supp_invocie_no').val(),
                    product_id: "",
                    quantity: "",
                    price: "",
                    change_method: "",
                };
                set_purchase(op_item, "", 0);
            });
        })(jQuery);        
        function set_purchase(op_item, value, add_row) {
            if(!$('#supplier_id').val()){
                bootbox.alert("Select supplier");
                return false;
            }
            var success = false;
            $.ajax({
                url: "<?php echo base_url('operations/set_purchase') ?>",
                method: "POST",
                data: {
                    branch_id: op_item.branch_id,
                    supplier_id: op_item.supplier_id,
                    op_supp_invocie_no: op_item.supp_invocie_no
                },
                dataType: "JSON",
                success: function(data) {
                    success = data.success;
                    if (data.success) {
                        if (add_row)
                            add_to_list(value);
                        else {
                            if (data.product_id > 0) {
                                $('#quantity_' + data.product_id).val(data.current_quantity);
                                $("#add_item").val("").focus();
                            }
                        }
                        calculateTotal();
                        $("#add_item").val("");
                    } else {
                        toastr.error("Unable to cennect with server!");
                        console.trace();
                    }
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
            return success;
        }
        function set_purchase_items(op_item, value, is_added) {
            if(!validations()){
                return false;
            }
            var success = false;
            $.ajax({
                url: "<?php echo base_url('operations/set_purchase_items') ?>",
                method: "POST",
                data: {
                    product_id: op_item.product_id,
                    quantity: op_item.quantity,
                    price: op_item.price,
                    change_method: op_item.change_method,
                },
                dataType: "JSON",
                success: function(data) {
                    success = data.success;
                    if (data.success) {
                        if (!is_added){
                            add_to_list(value);
                        }
                        else {
                            if (data.product_id > 0) {
                                $('#quantity_' + data.product_id).val(data.current_quantity);
                                $("#add_item").val("").focus();
                            }
                        }
                        calculateTotal();
                        $("#add_item").val("");
                    } else {
                        toastr.error("Unable to cennect with server!");
                        console.trace();
                    }
                },
                error: function(data) {
                    bootbox.alert(data.responseText);
                }
            });
            return success;
        }
        function validations(){
            if(!$('#branch_id').val()){
                bootbox.alert("Select warehouse");
                return false;
            }
            if(!$('#supplier_id').val()){
                bootbox.alert("Select supplier");
                return false;
            }
            return true;
        }
        $('.variable').on('change',function(event){
            console.log(event.target);
            console.info($(event.target).closest('tr'));
        });
    </script>
</body>

</html>