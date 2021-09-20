'use strict';

// Class definition
var KTImageInputDemo = function () {
	// Private functions
	var initDemos = function () {


		// Example 4
		var avatar1 = new KTImageInput('kt_image');

		// avatar1.on('cancel', function(imageInput) {
		// 	swal.fire({
        //         title: 'تم الغاء الصوره بنجاح !',
        //         type: 'success',
        //         buttonsStyling: false,
        //         confirmButtonText: 'موافــق',
        //         confirmButtonClass: 'btn btn-primary font-weight-bold'
        //     });
		// });

		// avatar1.on('change', function(imageInput) {
		// 	swal.fire({
        //         title: 'تم تغيير الصوره بنجاح !',
        //         type: 'success',
        //         buttonsStyling: false,
        //         confirmButtonText: 'موافــق',
        //         confirmButtonClass: 'btn btn-primary font-weight-bold'
        //     });
		// });

		avatar1.on('remove', function(imageInput) {
			swal.fire({
                title: 'Image successfully removed !',
                type: 'error',
                buttonsStyling: false,
                confirmButtonText: 'Got it!',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
		});


        var avatar2 = new KTImageInput('kt_image_2');

        // avatar2.on('cancel', function(imageInput) {
        //     swal.fire({
        //         title: 'تم الغاء الصوره بنجاح !',
        //         type: 'success',
        //         buttonsStyling: false,
        //         confirmButtonText: 'موافــق',
        //         confirmButtonClass: 'btn btn-primary font-weight-bold'
        //     });
        // });

        // avatar2.on('change', function(imageInput) {
        //     swal.fire({
        //         title: 'تم تغيير الصوره بنجاح !',
        //         type: 'success',
        //         buttonsStyling: false,
        //         confirmButtonText: 'موافــق',
        //         confirmButtonClass: 'btn btn-primary font-weight-bold'
        //     });
        // });

        avatar2.on('remove', function(imageInput) {
            swal.fire({
                title: 'Image successfully removed !',
                type: 'error',
                buttonsStyling: false,
                confirmButtonText: 'Got it!',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        var avatar3 = new KTImageInput('kt_image_3');

        avatar3.on('cancel', function(imageInput) {
            swal.fire({
                title: 'تم الغاء الصوره بنجاح !',
                type: 'success',
                buttonsStyling: false,
                confirmButtonText: 'موافــق',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        avatar3.on('change', function(imageInput) {
            swal.fire({
                title: 'تم تغيير الصوره بنجاح !',
                type: 'success',
                buttonsStyling: false,
                confirmButtonText: 'موافــق',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        avatar3.on('remove', function(imageInput) {
            swal.fire({
                title: 'Image successfully removed !',
                type: 'error',
                buttonsStyling: false,
                confirmButtonText: 'Got it!',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        var avatar4 = new KTImageInput('kt_image_4');

        avatar4.on('cancel', function(imageInput) {
            swal.fire({
                title: 'تم الغاء الصوره بنجاح !',
                type: 'success',
                buttonsStyling: false,
                confirmButtonText: 'موافــق',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        avatar4.on('change', function(imageInput) {
            swal.fire({
                title: 'تم تغيير الصوره بنجاح !',
                type: 'success',
                buttonsStyling: false,
                confirmButtonText: 'موافــق',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });

        avatar4.on('remove', function(imageInput) {
            swal.fire({
                title: 'Image successfully removed !',
                type: 'error',
                buttonsStyling: false,
                confirmButtonText: 'Got it!',
                confirmButtonClass: 'btn btn-primary font-weight-bold'
            });
        });
	}

	return {
		// public functions
		init: function() {
			initDemos();
		}
	};
}();

KTUtil.ready(function() {
	KTImageInputDemo.init();
});
