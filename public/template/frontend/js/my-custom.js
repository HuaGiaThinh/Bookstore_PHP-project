$(document).ready(function () {
    activeMenu();

    $('.slide-5').on('setPosition', function () {
        $(this).find('.slick-slide').height('auto');
        var slickTrack = $(this).find('.slick-track');
        var slickTrackHeight = $(slickTrack).height();
        $(this)
            .find('.slick-slide')
            .css('height', slickTrackHeight + 'px');
        $(this)
            .find('.slick-slide > div')
            .css('height', slickTrackHeight + 'px');
        $(this)
            .find('.slick-slide .category-wrapper')
            .css('height', slickTrackHeight + 'px');
    });

    $('.breadcrumb-section').css('margin-top', $('.my-header').height() + 'px');
    $('.my-home-slider').css('margin-top', $('.my-header').height() + 'px');

    $(window).resize(function () {
        let height = $('.my-header').height();
        $('.breadcrumb-section').css('margin-top', height + 'px');
        $('.my-home-slider').css('margin-top', height + 'px');
    });

    // show more show less
    if ($('.category-item').length > 10) {
        $('.category-item:gt(9)').hide();
        $('#btn-view-more').show();
    }

    $('#btn-view-more').on('click', function () {
        $('.category-item:gt(9)').toggle();
        $(this).text() === 'Xem thêm' ? $(this).text('Thu gọn') : $(this).text('Xem thêm');
    });

    $('li.my-layout-view > img').click(function () {
        $('li.my-layout-view').removeClass('active');
        $(this).parent().addClass('active');
    });

    $('#sort-form select[name="sort"]').change(function () {
        // console.log(getUrlParam('filter_price'));
        if (getUrlParam('filter_price')) {
            $('#sort-form').append(
                '<input type="hidden" name="filter_price" value="' +
                getUrlParam('filter_price') +
                '">'
            );
        }

        if (getUrlParam('search')) {
            $('#sort-form').append(
                '<input type="hidden" name="search" value="' +
                getUrlParam('search') +
                '">'
            );
        }

        $('#sort-form').submit();
    });

    $(document).on('click', 'a.quick-view', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');

        const PICTURE_URL = '/zvn-php15-project_HuaGiaThinh/public/files/book/';
        $.ajax({
            type: "GET",
            url: url,
            data: "data",
            success: function (response) {
                let data = JSON.parse(response);
                
                console.log(data);
                let price = formatPriceVND(data.price);
                $('#quick-view .book-name').html(data.name);
                $('#quick-view .book-price').html(price);
                $('#quick-view .book-description').html(data.description);
                $('#quick-view .book-picture').attr('src', data.pictureURL);
            }
        });
    });



    setTimeout(function () {
        $('#frontend-message').toggle('slow');
    }, 4000);
});

function activeMenu() {
    let controller = (getUrlParam('controller') == null) ? 'index' : getUrlParam('controller');
    let action = (getUrlParam('action') == null) ? 'index' : getUrlParam('action');
    let dataActive = controller + '-' + action;

    $(`a[data-active=${dataActive}]`).addClass('my-menu-link active');
}

function getUrlParam(key) {
    let searchParams = new URLSearchParams(window.location.search);
    return searchParams.get(key);
}

function quickViewBook(link) {
    // let link = rootURL + `index.php?module=${module}&controller=book&action=ajaxQuickView&book_id=` + id;
    $.get(
        link,
        function (data) {
            console.log(data);
            console.log(123);
            $('#quick-view .book-name').html(data.name);
            let originalPrice = formatPriceVND(data.price);
            let salePrice = formatPriceVND(data.sale_price);
            let xhtmlPrice =
                data.sale_off == 0 ? originalPrice : `${salePrice} <del>${originalPrice}</del>`;
            $('#quick-view .book-price').html(xhtmlPrice);
            $('#quick-view .book-description').html(data.short_description);
            $('#quick-view .book-picture').attr('src', data.src_picture);
            // let viewDetailLink = `index.php?module=default&controller=book&action=detail&id=${data.id}`;
            let viewDetailLink = data.link;
            $('#quick-view input[name="quantity"]').val(1);
            $('#quick-view .btn-view-book-detail').attr('href', viewDetailLink);
            let addToCartLink = `javascript:addToCart(${data.id}, ${data.sale_price})`;
            $('#quick-view .btn-add-to-cart').attr('href', addToCartLink);
            $('#quick-view').modal('show');
        },
        'json'
    );
}

function changeQuantityInCart(link) {
    $.get(link, function (data) {
        $('#cart span').html(data);
    });
}

function formatPriceVND(value) {
    return new Intl.NumberFormat('vi-VI', {
        style: 'currency',
        currency: 'VND',
    }).format(value);
}