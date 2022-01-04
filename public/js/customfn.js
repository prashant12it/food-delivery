
function SubCategories() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: siteUrl + '/get_subcategories',
            data: {
                _token: CSRF_TOKEN,
                category_id: $('#category_id').val()
            },
            success: function (response) {
                if(response.code == 200){
                    $('#sub_category_id').empty();
                    $('#sub_category_id').append('<option value="">Select Sub Category</option>');
                    if(response.data && response.data.length>0){
                        $.each(response.data,function (index,val) {
                            $('#sub_category_id').append('<option value="'+val.id+'">'+val.category_name+'</option>');
                        });
                    }
                }
            }
        });
}

function add_to_cart(product_id,quantity) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: siteUrl + '/add_to_cart',
            data: {
                _token: CSRF_TOKEN,
                product_id: product_id,
                user_id: 2,
                quantity: quantity
            },
            success: function (response) {
                if(response.code == 200){
                    alert('Product successfully added to the cart');
                }else{
                    alert('Something goes wrong. Please try later.');
                }
            }
        });
}
