

//Tính tiền cho phiếu nhập
function myFunction(e) {
    var DonGia = $(e).parent().parent().find("input[name='DonGia[]']").val();
    var SoLuong =  $(e).val();
    var ThanhTien =DonGia*SoLuong;
    $(e).parent().parent().find("input[name='ThanhTien[]']").val(ThanhTien);
}

function remove(e){
    $(e).parent().parent().remove();
}

$(document).ready(function() {

    //search vật tư
    $(".search-query").autocomplete({
        source: function (request, response) {
            $.ajax({
                dataType: 'JSON',
                type: 'GET',
                url: "../search/" + request.term,
                data: {},
                success: function (data) {
                    $('.suggest-search a').remove();
                    $.each(data, function(k, v){
                        VT = v;
                        $('.suggest-search').css('display','block').append('<a href="#">'+v['TenVT']+'<input type="hidden" style="display: none" value="'+v['MaVT']+'" name="MaVT[]">'+'<input style="display: none" value="'+v['DonGia']+'" name="DonGia[]" type="hidden">'+'</a>');
                    });
                }
            });
        }
    });

    //thêm vật tư
    $(".suggest-search").click(function(e){
        var target = e.target;
        var MaVT = $(target).find("input[name='MaVT[]']").val();
        $.ajax({
            dataType: 'JSON',
            type: 'GET',
            url: "../getVT/" + MaVT,
            data: {},
            success: function (data) {
                var DonGia = data['DonGia'];
                var valuationId = MaVT;
                var record =  '<tr class="input-record" >'+
                    '<td class="TenVT">'+$(target).text()+'<input type="hidden" name="MaVT[]" value="'+MaVT+'"></td>' +
                    '<td><input name="SoLuong[]" type="number" class="form-control" onclick="return  myFunction(this)" min="0" value="0"></td>' +
                    '<td><input name="DonGia[]" name="DonGia[]"  readonly type="text" value="'+DonGia+'" class="form-control"></td>' +
                    '<td><input type="text" readonly class="form-control" name="ThanhTien[]" value=""></td>' +
                    '<td><button type="button" class="btn btn-danger remove-record" onclick="return remove(this)">Delete</button></td>'+
                    '</tr>';
                $('.suggest-search').css('display','none').find("a").remove();
                $('.inputVT').append(record);
            }
        });
    });
    //xóa record phiếu nhập
    $('.remove-record').click(function(e){
        var target = e.target;
        $(target).parent().parent().parent().remove();
    });
});
