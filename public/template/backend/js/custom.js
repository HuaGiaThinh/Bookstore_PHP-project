function submitForm(url) {
    $('#main-form').attr('action', url);
    $('#main-form').submit();
}

function sortList(column, order) {
    $('input[name=filter_column]').val(column);
    $('input[name=filter_column_dir]').val(order);
    $('#adminForm').submit();
}

function changePage(page) {
    $('input[name=filter_page]').val(page);
    $('#main-form').submit();
}



function deleteItem(url) {
    let result = confirm("Bạn có chắc chắn muốn xóa không?");
    if (result) {
        window.location.replace(url)
    }
}

function generateString(length = 12) {
    let characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}

$(document).ready(function () {
    $('input[name=checkall-toggle]').change(function () {
        var checkStatus = this.checked;
        $('div.table-responsive').find(':checkbox').each(function () {
            this.checked = checkStatus;
        });
    })

    $('#filter-bar button[name=submit-keyword]').click(function () {
        $('#adminForm').submit();
    })

    $('#filter-bar button[name=clear-keyword]').click(function () {
        $('#filter-bar input[name=filter_search]').val('');
        $('#adminForm').submit();
    })

    $('#filter-bar select[name=filter_state]').change(function () {
        $('#adminForm').submit();
    })

    $('#filter-bar select[name=filter_group_acp]').change(function () {
        $('#adminForm').submit();
    })

    $('#currentPage').parent().addClass('active');

    $('.filter-element').on('change', function () {
        $('#filter-form').submit();
    });

    $('.slb-group').on('change', function () {
        let value   = $(this).val();
        let parent  = $(this).parent();
        let url     = $(this).data('url');

        url = url.replace('value_new', value);

        $.ajax({
            type: "GET",
            url: url,
            data: "data",
            success: function (response) {
                parent.find("select.slb-group").notify("Success", {
                    className: 'success',
                    position: 'top-center'
                });
            }
        });
    });

    $(document).on('click', '.btn-ajax-status', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');
        let parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url,
            data: "data",
            success: function (response) {
                parent.html(response);
                parent.find("a.btn-ajax-status").notify("Success", {
                    className: 'success',
                    position: 'top-center'
                });
            }
        });
    });

    $(document).on('click', '.btn-ajax-groupAcp', function (e) {
        e.preventDefault();

        let url = $(this).attr('href');
        let parent = $(this).parent();
        $.ajax({
            type: "GET",
            url: url,
            data: "data",
            success: function (response) {
                parent.html(response);
                parent.find("a.btn-ajax-groupAcp").notify("Success", {
                    className: 'success',
                    position: 'top-center'
                });
            }
        });
    });

    $('.btn-delete').click(function (e) {
        e.preventDefault();

        let url = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            // text: "You won't be able to revert this!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Không',
            confirmButtonText: 'Có!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    });

    // User changePassword
    $('.input-password').val(generateString());

    $('.btn-generate').click(function (e) { 
        e.preventDefault();
    
        $('.input-password').val(generateString());
    });
})

