var FormValidator = function () {

    // function to initiate Validation Sample 1
    var runValidator = function () {
        
        var form1 = $('#add_product_form');
        var errorHandler = $('.errorHandler', form1);
        var successHandler = $('.successHandler', form1);

        $('#add_product_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: "",
            rules: {
                product_name: {
                    required: true,
                    minlength: 2
                },
                category: {
                    required: true
                },
                unit: {
                    required: true
                },
                product_cost: {
                    required: true
                },
                product_price: {
                    required: true
                },
                alert_quty: {
                    required: true
                }
            },

            messages: {
                product_name: {
                    required: "Product Name is required or need attention."
                },
                category: {
                    required: "Category is required or need attention."
                },
                product_cost: {
                    required: "Product Cost is required or need attention."
                },
                product_price: {
                    required: "Product Price is required or need attention."
                },
                alert_quty: {
                    required: "Alert Quantity is required or need attention."
                }

            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler.hide();
                errorHandler.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (form) {
                add_product(form);
            }
        });
    };
    return {
        init: function () {
            runValidator();
        }
    };
}();