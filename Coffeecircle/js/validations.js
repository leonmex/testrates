jQuery.validator.setDefaults({
    debug: false,
    success: "valid"
});

$(document).ready(function() {
    //* validation
    $('#uploadorders').validate({
        rules: {
            orderfile: {
                required: true,
                regx: /.*\.csv$/
            },
            ratesfile: {
                required: true,
                regx: /.*\.csv$/
            },
            currency : {
                required: true
            }
        }
    });

    $.validator.addMethod("regx", function(value, element, regexpr){
        return regexpr.test(value);
    }, "Please use files the type csv");

});



