$(document).ready(function () {
    $("#brand-logo").owlCarousel({
        autoPlay: 3000, //Set AutoPlay to 3 seconds
        items: 6,
        itemsDesktop: [1199, 6],
        itemsDesktopSmall: [979, 6]
    });

    $('.select2').select2();

    if ($('#thumbnails li img').length > 0) {
        $('#thumbnails li img').on('click', function () {
            $('#main-image')
                .attr('src', $(this).attr('src') + '?w=400')
                .attr('data-zoom', $(this).attr('src') + '?w=1200');
        });
    }

    $(".img-orderDetail").mouseover(function () {
        $(this).css({ width: '150px', height: '150px' });
    }).mouseout(function () {
        $(".img-orderDetail").css({ width: '50px', height: '50px' });
    });

    //add to wishlist
    $(".product-wishlist-btn").each(function () {
        $(this).attr('product-id');
        var wishlist_product = JSON.parse(localStorage.getItem("wishlist_product_id"));
        if (wishlist_product) {
            var index = wishlist_product.indexOf($(this).attr('product-id'));
            if (index >= 0) {
                $(this).removeClass('add-to-wishlist-btn');
                $(this).addClass('remove-to-wishlist-btn');
                $(this).html('<i class="fa fa-heart"> Added in wishlist');
            }
        }
    });

    $(document).on('click', '.product-wishlist-btn', function () {
        if ($(this).hasClass('add-to-wishlist-btn')) {

            var wishlist_product = JSON.parse(localStorage.getItem("wishlist_product_id"));
            var wishlist_productLenght;
            var wishlist_product_id;
            if (wishlist_product) {
                wishlist_product_id = wishlist_product;
                wishlist_productLenght = wishlist_product.length;
            } else {
                wishlist_product_id = [];
                wishlist_productLenght = 0;
            }
            wishlist_product_id[wishlist_productLenght] = $(this).attr('product-id');
            localStorage.setItem("wishlist_product_id", JSON.stringify(wishlist_product_id));
            $(this).removeClass('add-to-wishlist-btn');
            $(this).addClass('remove-to-wishlist-btn');
            $(this).html('<i class="fa fa-heart"> Added in wishlist');

        } else if ($(this).hasClass('remove-to-wishlist-btn')) {

            var wishlist_product = JSON.parse(localStorage.getItem("wishlist_product_id"));
            var deleteIndex = wishlist_product.indexOf($(this).attr('product-id'));
            if (deleteIndex) {
                wishlist_product.splice(deleteIndex, 1);
            }
            localStorage.setItem("wishlist_product_id", JSON.stringify(wishlist_product));
            $(this).addClass('add-to-wishlist-btn');
            $(this).removeClass('remove-to-wishlist-btn');
            $(this).html('<i class="fa fa-heart-o"> Add to wishlist');

        }
    });

    $("body").delegate(".delete-model", "click", function (e) {
        e.preventDefault();
        var url = this.href;
        var title = $(this).attr("data-swal-title")
        Swal.fire({
            icon: 'question',
            title: title,
            confirmButtonText: 'Yes',
            showCancelButton: true,
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-common-form').attr('action', url).submit()
            }
        })
    })

});

