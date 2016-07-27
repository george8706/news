$(document).ready(function() {
    $('#newsForm').bootstrapValidator({
        //live: 'disabled',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            caption: {
                validators:{
                    notEmpty: {
                        message: 'The Caption is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        max: 100,
                        message: 'The Caption must be more than 3 and less than 100 characters long'
                    }
                }
            },
            text: {
                validators: {
                    notEmpty: {
                        message: 'The Text News is required and cannot be empty'
                    },
                    stringLength: {
                        min: 3,
                        message: 'The Text must be more than 3 characters'
                    }
                }
            },
            date: {
                feedbackIcons: 'false',
                validators: {
                    notEmpty: {
                        message: 'The date is required and cannot be empty'
                    },
                    date: {
                        format: 'DD-MM-YYYY'
                    }
                }
            },
            keystring: {
                feedbackIcons: 'false',
                validators: {
                    notEmpty: {
                        message: 'The Captcha is required and cannot be empty'
                    }
                }
            }
        }
    }).on('success.field.fv', function(e, data) {
        if (data.fv.getInvalidFields().length > 0) {    // There is invalid field
            data.fv.disableSubmitButtons(true);
        }
    });
});