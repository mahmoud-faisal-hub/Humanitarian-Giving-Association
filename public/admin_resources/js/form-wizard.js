$(function() {
	'use strict'
    window.ParsleyValidator.setLocale('ar');

    var iffRecursion = false;
    window.Parsley.addValidator( 'iff', {
        validateString: function( value, requirement, instance ) {
            var $partner = $( requirement );
            var isValid = $partner.val() == value;
            if ( iffRecursion ) {
                iffRecursion = false;
            } else {
                iffRecursion = true;
                $partner.parsley().validate();
            }
            return isValid;
        }
    });



    var form = $("#admin-create");

	form.children('#wizard').steps({
        /* Appearance */
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',

        /* Events */
		onStepChanging: function(event, currentIndex, newIndex) {
			if (currentIndex < newIndex) {
                return form.parsley({
                    excluded: ":disabled,:hidden",
                    iffMessage: "كلمتا المرور غير متطابقتين",
                }).validate();

				// Always allow step back to the previous step even if the current step is not valid.
			} else {
				return true;
			}
		},
        onFinished: function (event, currentIndex) {
            form.trigger('submit');
        },

        /* Labels */
        labels: {
            cancel: "إلغاء",
            current: "الخطوة الحالية:",
            pagination: "ترقيم الصفحات",
            finish: "إنهاء",
            next: "التالى",
            previous: "السابق",
            loading: "تحميل ..."
        }
	});

});
