
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
