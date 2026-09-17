$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var site_url = $('meta[name="base-url"]').attr('content');

// $(document).ready(function () {
//     comman_function();

//     if ($(".dataTable").length > 0) {
//         const dataTable = new simpleDatatables.DataTable(".dataTable");
//     }
// });


$(document).on('input', '.autogrow', function () {
    console.log($(this).scrollHeight);
    $(this).height("auto").height($(this)[0].scrollHeight - 18);
});

$(document).on('click', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
    var title = $(this).data('title');
    var size = ($(this).attr('data-size') == '') ? 'md' : $(this).attr('data-size');
    var url = $(this).data('url');
    $("#commanModel .modal-title").html(title);
    $("#commanModel .modal-dialog").removeClass('modal-lg').removeClass('modal-md').removeClass('modal-sm');
    $("#commanModel .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        success: function (data) {
            $('#commanModel .modal-body').html(data);
            $("#commanModel").modal('show');

            $('#theme_id').trigger('change');

            // Product Page
            $('#enable_product_variant').trigger('change');
            $('#variant_tag').trigger('change');
            $('#maincategory').trigger('change');

            // Review Page
            $('#category_id').trigger('change');

            // coupone Code Page
            $('.code').trigger('click');

            comman_function();
        },
        error: function (data) {
            data = data.responseJSON;
        }
    });

});

$(document).on('click', 'a[data-ajax-popup-over="true"], button[data-ajax-popup-over="true"], div[data-ajax-popup-over="true"]', function () {
    var title = $(this).data('title');
    var size = ($(this).attr('data-size') == '') ? 'md' : $(this).attr('data-size');
    var url = $(this).data('url');
    $("#commanModelOver .modal-title").html(title);
    $("#commanModelOver .modal-dialog").removeClass('modal-lg').removeClass('modal-md').removeClass('modal-sm');
    $("#commanModelOver .modal-dialog").addClass('modal-' + size);
    $.ajax({
        url: url,
        success: function (data) {
            $('#commanModelOver .modal-body').html(data);
            $("#commanModelOver").modal('show');

            $('#theme_id').trigger('change');

            // Product Page
            $('#enable_product_variant').trigger('change');
            $('#variant_tag').trigger('change');
            $('#maincategory').trigger('change');

            // Review Page
            $('#category_id').trigger('change');

            // coupone Code Page
            $('.code').trigger('click');

            comman_function();
        },
        error: function (data) {
            data = data.responseJSON;
        }
    });

});

$(document).on('click', '.show_confirm', function (e) {
    var form = $(this).closest("form");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "This action can not be undone. Do you want to continue?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
});

function comman_function() {
    if ($('[data-role="tagsinput"]').length > 0) {
        $('[data-role="tagsinput"]').each(function (index, element) {
            var obj_id = $(this).attr('id');
            var textRemove = new Choices(
                document.getElementById(obj_id), {
                delimiter: ',',
                editItems: true,
                removeItemButton: true,
            }
            );
        });
    }
}

function show_toastr(title, message, type) {
    var o, i;
    var icon = '';
    var cls = '';
    if (type == 'success') {
        cls = 'primary';
        notifier.show('Success', message, 'success', '/assets/images/notification/ok-48.png', 4000);
    } else {
        cls = 'danger';
        notifier.show('Error', message, 'danger','/assets/images/notification/high_priority-48.png', 4000);
    }
}

PurposeStyle = function () {
    var e = getComputedStyle(document.body);
    return {
        colors: {
            gray: {100: "#f6f9fc", 200: "#e9ecef", 300: "#dee2e6", 400: "#ced4da", 500: "#adb5bd", 600: "#8898aa", 700: "#525f7f", 800: "#32325d", 900: "#212529"},
            theme: {
                primary: e.getPropertyValue("--primary") ? e.getPropertyValue("--primary").replace(" ", "") : "#6e00ff",
                info: e.getPropertyValue("--info") ? e.getPropertyValue("--info").replace(" ", "") : "#00B8D9",
                success: e.getPropertyValue("--success") ? e.getPropertyValue("--success").replace(" ", "") : "#36B37E",
                danger: e.getPropertyValue("--danger") ? e.getPropertyValue("--danger").replace(" ", "") : "#FF5630",
                warning: e.getPropertyValue("--warning") ? e.getPropertyValue("--warning").replace(" ", "") : "#FFAB00",
                dark: e.getPropertyValue("--dark") ? e.getPropertyValue("--dark").replace(" ", "") : "#212529"
            },
            transparent: "transparent"
        }, fonts: {base: "Nunito"}
    }
}

var PurposeStyle = PurposeStyle();

/********* Cart Popup ********/
$('.wish-header').on('click',function(e){
    e.preventDefault();
    setTimeout(function(){
    $('body').addClass('no-scroll wishOpen');
    $('.overlay').addClass('wish-overlay');
    }, 50);
});
$('body').on('click','.overlay.wish-overlay, .closewish', function(e){
    e.preventDefault();
    $('.overlay').removeClass('wish-overlay');
    $('body').removeClass('no-scroll wishOpen');
});

/********* Domain-subdomain tab ********/
$(document).on('change', '.domain_click#enable_storelink', function (e) {
    $('#StoreLink').show();
    $('.sundomain').hide();
    $('.domain').hide();
    $('#domainnote').hide();
    $( "#enable_storelink" ).parent().addClass('active');
    $( "#enable_domain" ).parent().removeClass('active');
    $( "#enable_subdomain" ).parent().removeClass('active');
});
$(document).on('change', '.domain_click#enable_domain', function (e) {
    $('.domain').show();
    $('#StoreLink').hide();
    $('.sundomain').hide();
    $('#domainnote').show();
    $( "#enable_domain" ).parent().addClass('active');
    $( "#enable_storelink" ).parent().removeClass('active');
    $( "#enable_subdomain" ).parent().removeClass('active');
});
$(document).on('change', '.domain_click#enable_subdomain', function (e) {
    $('.sundomain').show();
    $('#StoreLink').hide();
    $('.domain').hide();
    $('#domainnote').hide();
    $( "#enable_subdomain" ).parent().addClass('active');
    $( "#enable_domain" ).parent().removeClass('active');
    $( "#enable_domain" ).parent().removeClass('active');
});
