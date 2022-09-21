var FormValidator = function () {

    // function to initiate Validation Sample 1
    var runValidator = function () {
        
        var form1 = $('#add_purchases_form');
        var errorHandler = $('.errorHandler', form1);
        var successHandler = $('.successHandler', form1);

        $('#add_purchases_form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            ignore: "",
            rules: {
                branch_id: {
                    required: true
                },
                date_time: {
                    required: true
                },
                supplier_id: {
                    required: true
                }
            },

            messages: {
                branch_id: {
                    required: "Branch is required."
                },
                date_time: {
                    required: "Date is required."
                },
                supplier_id: {
                    required: "Supplier is required."
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
                add_purchase(form);
            }
        });
    };
    return {
        init: function () {
            runValidator();
        }
    };
}();