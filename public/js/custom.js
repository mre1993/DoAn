//collapse menu
$('.active').css('background-color','#8080802e');
$('.active').parent().collapse("show");
$('body').click(function(){
    var remove = $('.suggest-search');
    remove.css('display','none').find("a").remove();
    remove.parent().find('input[name="TimVT"]').val('');
});
//Tính tiền cho phiếu nhập
function myFunction(e) {
    var max = parseInt($(e).attr('max'));
    if(max != 'undefined'){
        if ($(e).val() > max)
        {
            $(e).val(max);
        }
    }
    var DonGia = $(e).parent().parent().find("input[name='DonGia[]']").val().split('.').join("");
    var SoLuong =  $(e).val().split('.').join("");
    var ThanhTien = DonGia*SoLuong;
    $(e).parent().parent().find("input[name='ThanhTien[]']").val(parseFloat(ThanhTien).toLocaleString('us'));
}

function myFunction2(e) {
    var DonGia = $(e).parent().parent().find("input[name='DonGia[]']").val().split('.').join("");
    var SoLuong = $(e).parent().parent().find("input[name='SoLuong[]']").val().split('.').join("");
    var ThanhTien =DonGia*SoLuong;
    $(e).parent().parent().find("input[name='ThanhTien[]']").val(parseFloat(ThanhTien).toLocaleString('us'));
}

function remove(e){
    $(e).parent().parent().remove();
}

$(document).ready(function() {

    //before submit
    $('.before-post').on('click',function(e){
        return confirm("Bạn chắc chắn muốn xóa?");
    });

    $('.new-vt').click(function(){
        $("#new-vt").addClass('in').css('display','block');
    });
    //them moi vat tu phieu nhap
    $('#saveVT').click(function(e){
        e.preventDefault();
       MaNCC =  $('#MaNCC').val();
        if(MaNCC==null){
            $('.error-vt').show();
            $('.error-vt h5').show();
        }else {
            var fd = $('#new-vt form').serialize();
            var MaVT = $('#MaVTNew').val();
            var DVT = $('#DVT').val();
            var DonGia = $('#DonGiaMoi').val();
            var TenVT = $('#TenVT').val();
            var MoTa = $('#MoTaMoi').val();
            var record =  '<tr class="input-record" >'+
                '<td class="TenVT">'+ TenVT +'<input type="hidden" name="MaVT[]" value="'+MaVT+'"><input type="hidden" name="MoTa[]" value="'+MoTa+'"><input type="hidden" name="TenVT[]" value="'+TenVT+'"></td>' +
                '<td><input type="text" readonly class="form-control" name="DVT[]" value="'+ DVT +'"></td>' +
                '<td><input name="SoLuong[]" type="number" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" onchange="return  myFunction(this)" min="0" value="0"></td>' +
                '<td><input name="DonGia[]" onchange="return  myFunction2(this)"  onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" type="text" value="'+DonGia+'" class="form-control"></td>' +
                '<td><input type="text" readonly class="form-control" name="ThanhTien[]" value=""></td>' +
                '<td><button type="button" class="btn btn-danger remove-record" onclick="return remove(this)">Delete</button></td>'+
                '</tr>';
            $('.suggest-search').css('display','none').find("a").remove();
            $('.inputVT').append(record);
            $('#new-vt').modal('hide').removeClass('in');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
    });
    $('#new-vt').on('hidden.bs.modal', function () {
        // and empty the modal-content element
        $(this).find('form').trigger('reset');
        //
        $('.error-vt').hide();
        $('.error-vt h5').hide();
    });
    //them moi NCC
    $('#saveNCC').click(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var fd = $('.form-new-NCC').serialize();
        var MaNCC = $('.form-new-NCC input[name="MaNCCNew"]').val();
        var TenNCC = $('.form-new-NCC input[name="TenNCCNew"]').val();
        $.ajax({
            dataType: 'JSON',
            type: 'POST',
            url: "../provider/createNew",
            data: fd,
            success: function (data) {
                $('#MaNCC').append($('<option>', {
                    value: MaNCC,
                    text: TenNCC
                }));
                $('#MaNCC').val(MaNCC).attr('selected', true);
                $('#newNCC').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            },
            error:function () {
            }
        });
    });

    //search vật tư
    $(".search-vat-tu").autocomplete({
        source: function (request, response) {
            $.ajax({
                dataType: 'JSON',
                type: 'GET',
                url: "../search-vt/" + request.term,
                data: {},
                success: function (data) {
                    $('.suggest-search-vat-tu a').remove();
                    $.each(data, function(k, v){
                        VT = v;
                        $('.suggest-search-vat-tu').css('display','block').append('<a href="#">'+v['TenVT']+'<input type="hidden" value="'+v['TenVT']+'" name="TenVT">'+'</a>');
                    });
                }
            });
        }
    });
    $(".suggest-search-vat-tu").click(function(e){
        var target = e.target;
        var TenVT = $(target).find("input[name='TenVT']").val();
        $("input[name='TimVT']").val(TenVT);
        $('.suggest-search-vat-tu').css('display','none').find("a").remove();
    });


    $(".search-query").autocomplete({
        source: function (request, response) {
            var MaKVT =  $('#MaKVT  :selected').val();
            var MaNCC = $('#MaNCC :selected').val();
            var url = "search/" + request.term;
            if(window.location.href.indexOf("edit") > -1) {
                url = "../search/" + request.term;
            }
            $.ajax({
                dataType: 'JSON',
                type: 'GET',
                url: url,
                data: {
                    MaNCC: MaNCC,
                    MaKVT: MaKVT,
                    term : request.term
                },
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
        url = "../getVT/";
        urlXuat = "../getVT-xuat/";
        check = "phieuxuat";
        currentURL = window.location.href;
        if(currentURL.indexOf(check) != -1){
            url = urlXuat;
        }
        if(window.location.href.indexOf("edit") > -1) {
            url = "../"+url;
        }
        $.ajax({
            dataType: 'JSON',
            type: 'GET',
            url: url + MaVT,
            data: {},
            success: function (data) {
                var max = '';
                if(data['SoLuongTon'] != 'undefined'){
                    max = data['SoLuongTon'];
                }
                var DonGia = parseFloat(data['DonGia']).toLocaleString('us');
                var recordDonGia = '<td><input name="DonGia[]" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" onchange="return  myFunction2(this)" type="text" value="'+DonGia+'" class="form-control"></td>';
                var recordThanhTien = '<td><input type="text" readonly class="form-control" name="ThanhTien[]" value=""></td>' ;
                if(currentURL.indexOf(check) != -1){
                    recordDonGia = '<td><input type="hidden" name="DonGia[]" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" onchange="return  myFunction2(this)" type="text" value="'+DonGia+'" class="form-control"></td>';
                    recordThanhTien = '<td><input type="hidden" readonly class="form-control" name="ThanhTien[]" value=""></td>' ;
                }
                var record =  '<tr class="input-record" >'+
                    '<td class="TenVT">'+$(target).text()+'<input type="hidden" name="MaVT[]" value="'+MaVT+'"></td>' +
                    '<td><input type="text" readonly class="form-control" name="DVT[]" value="'+ data['DVT'] +'"></td>' +
                    '<td><input name="SoLuong[]" type="number" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" onchange="return  myFunction(this)" min="0" value="0" max="'+ max +'"></td>' +
                    recordDonGia +
                    recordThanhTien +
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

    //function display export record
    $('#create-report-phieuxuat').on('click',function () {
        var fd = $('#myform').serialize();
        $.ajax({
            dataType: 'JSON',
            type: 'get',
            url: "bc-phieuxuat/get",
            data: fd,
            success: function (data) {
                var content = [];
                $.each(data, function(k, v){
                    var i = k+1;
                    var d = v['created_at'].split(" ")[0];
                    var NoiDung = v['NoiDung'];
                    if(NoiDung==null){
                        NoiDung = '';
                    }
                    content.push(
                        '<tr>'+
                            '<td>'+i+'</td>'+
                            '<td>'+ v['MaPhieuXuat'] +'</td>'+
                            '<td>'+ v['MaVT'] +'</td>'+
                            '<td>'+ v['TenVT'] +'</td>'+
                            '<td>'+ v['TenKVT'] +'</td>'+
                            '<td>'+ v['TenPX'] +'</td>'+
                            '<td>'+ parseFloat(v['SoLuong']).toLocaleString('us') +'</td>'+
                            '<td>'+ parseFloat(v['ThanhTien']).toLocaleString('us') +'</td>'+
                            '<td>'+ NoiDung +'</td>'+
                            '<td>'+ d +'</td>'+
                            '<td>'+ v['TenNV'] +'</td>'+
                        '</tr>');
                    return k <= data.length
                });
                var record =
                    '<table class="table text-center">'+
                        '<thead>'+
                            '<tr>'+
                                '<th>STT</th>'+
                                '<th>Mã phiếu xuất</th>'+
                                '<th>Mã vật tư</th>'+
                                '<th>Tên vật tư</th>'+
                                '<th>Kho vật tư</th>'+
                                '<th>Phân xưởng</th>'+
                                '<th>Số lượng</th>'+
                                '<th>Thành Tiền</th>'+
                                '<th>Ghi chú</th>'+
                                '<th>Ngày tạo</th>'+
                                '<th>Nhân viên</th>'+
                            '</tr>'+
                        '</thead>'+
                        '<tbody class="export-content">'+
                            content +
                        '</tbody>'+
                    '</table>';
                    $('#btn-export').css('display','block');
                    $('#export-report').children().remove();
                    $('#export-report').append(record);
            }
        });
    });

    //function display export record
    $('#create-report-phieunhap').on('click',function () {
        var fd = $('#myform').serialize();
        $.ajax({
            dataType: 'JSON',
            type: 'get',
            url: "bc-phieunhap/get",
            data: fd,
            success: function (data) {
                var content = [];
                $.each(data, function(k, v){
                    var i = k+1;
                    var d = v['created_at'].split(" ")[0];
                    var ThanhTien = v['SoLuong']*v['DonGia'];
                    var NoiDung = v['NoiDung'];
                    if(NoiDung==null){
                        NoiDung = '';
                    }
                    content.push(
                        '<tr>'+
                        '<td>'+i+'</td>'+
                        '<td>'+ v['MaPN'] +'</td>'+
                        '<td>'+ v['MaVT'] +'</td>'+
                        '<td>'+ v['TenVT'] +'</td>'+
                        '<td>'+ v['TenNCC'] +'</td>'+
                        '<td>'+ v['TenKVT'] +'</td>'+
                        '<td>'+ parseFloat(v['SoLuong']).toLocaleString('us') +'</td>'+
                        '<td>'+ parseFloat(v['DonGia']).toLocaleString('us') +'</td>'+
                        '<td>'+ parseFloat(ThanhTien).toLocaleString('us') +'</td>'+
                        '<td>'+ NoiDung +'</td>'+
                        '<td>'+ d +'</td>'+
                        '<td>'+ v['TenNV'] +'</td>'+
                        '</tr>');
                    return k <= data.length
                });
                var record =
                    '<table class="table text-center">'+
                    '<thead>'+
                    '<tr>'+
                    '<th>STT</th>'+
                    '<th>Mã phiếu nhập</th>'+
                    '<th>Mã vật tư</th>'+
                    '<th>Tên vật tư</th>'+
                    '<th>Nhà cung cấp</th>'+
                    '<th>Kho vật tư</th>'+
                    '<th>Số lượng</th>'+
                    '<th>Đơn Giá</th>'+
                    '<th>Thành Tiền</th>'+
                    '<th>Ghi chú</th>'+
                    '<th>Ngày tạo</th>'+
                    '<th>Nhân viên</th>'+
                    '</tr>'+
                    '</thead>'+
                    '<tbody class="export-content">'+
                    content +
                    '</tbody>'+
                    '</table>';
                $('#btn-export').css("display",'block');
                $('#export-report').children().remove();
                $('#export-report').append(record);
            }
        });
    });

    $('#report-ton').on('click',function () {
        var fd = $('#myform-ton').serialize();
        $.ajax({
            dataType: 'JSON',
            type: 'get',
            url: "bc-vattu/get",
            data: fd,
            success: function (data) {
                var content = [];
                $.each(data, function(k, v){
                    var i = k+1;
                    var ThanhTien = v['SoLuongTon']*v['DonGia'] ;
                    content.push(
                        '<tr>'+
                        '<td>'+i+'</td>'+
                        '<td>'+v['TenKVT']+'</td>'+
                        '<td>'+ v['MaVT'] +'</td>'+
                        '<td>'+ v['TenVT'] +'</td>'+
                        '<td>'+ v['DVT'] +'</td>'+
                        '<td>'+ parseFloat(v['DonGia']).toLocaleString('us') +'</td>'+
                        '<td>'+ parseFloat(v['SoLuongTon']).toLocaleString('us') +'</td>'+
                        '<td>'+ parseFloat(v['SoLuongHong']).toLocaleString('us') +'</td>'+
                        '<td>'+ parseFloat(v['TongSoLuong']).toLocaleString('us') +'</td>'+
                        '<td>'+ parseFloat(ThanhTien).toLocaleString('us') +'</td>'+
                        '</tr>');
                    return k <= data.length
                });
                var record =
                    '<table class="table text-center">'+
                    '<thead>'+
                    '<tr>'+
                    '<th>STT</th>'+
                    '<th>Kho vật tư</th>'+
                    '<th>Mã vật tư</th>'+
                    '<th>Tên vật tư</th>'+
                    '<th>Đơn vị tính</th>'+
                    '<th>Đơn Giá</th>'+
                    '<th>Số lượng tồn</th>'+
                    '<th>Số lượng hỏng</th>'+
                    '<th>Tổng số lượng</th>'+
                    '<th>Tổng giá trị trị</th>'+
                    '</tr>'+
                    '</thead>'+
                    '<tbody class="export-content">'+
                    content +
                    '</tbody>'+
                    '</table>';
                $('#btn-export-ton').css("display",'block');
                $('#export-report').children().remove();
                $('#export-report').append(record);
            }
        });
    });

    $('#btn-export-ton').click(function() {
        var fd = $('#myform-ton').serialize();
        url = "bc-vattu/printTon";
        $.ajax({
            url: url, // the url of the php file that will generate the excel file
            data:fd , //or similar - based on the grid's API
            success: function(response){
                var a = document.createElement("a");
                a.href = response.file;
                a.download = response.name;
                document.body.appendChild(a);
                a.click();
                a.remove();
            },
        })
    });

    $('#btn-export').click(function() {
        var fd = $('#myform').serialize();
        url = "bc-phieunhap/printReport/";
        urlXuat = "bc-phieuxuat/printReport/";
        check = "phieuxuat";
        currentURL = window.location.href;
        if(currentURL.indexOf(check) != -1){
            url = urlXuat;
        }
        $.ajax({
            url: url, // the url of the php file that will generate the excel file
            data:fd , //or similar - based on the grid's API
            success: function(response){
                var a = document.createElement("a");
                a.href = response.file;
                a.download = response.name;
                document.body.appendChild(a);
                a.click();
                a.remove();
            },
        })
    });
    ///charts
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: "mostimport",
        success:function (data) {
            AmCharts.makeChart("chartNhap", {
                "type": "pie",
                "theme": "light",
                "dataProvider" : data,
                "valueField": "number",
                "titleField": "name",
                "outlineAlpha": 0.4,
                "depth3D": 15,
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "angle": 30,
                "export": {
                    "enabled": false
                }
            });
        }
    });

    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: "mostexport",
        success:function (data) {
            AmCharts.makeChart("chartXuat", {
                "type": "pie",
                "theme": "light",
                "dataProvider" : data,
                "valueField": "number",
                "titleField": "name",
                "outlineAlpha": 0.4,
                "depth3D": 15,
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "angle": 30,
                "export": {
                    "enabled": false
                }
            });
        }
    });

    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: "mostinventory",
        success:function (data) {
            AmCharts.makeChart("chartTon", {
                "type": "pie",
                "theme": "light",
                "dataProvider" : data,
                "valueField": "number",
                "titleField": "name",
                "outlineAlpha": 0.4,
                "depth3D": 15,
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "angle": 30,
                "export": {
                    "enabled": false
                }
            });        }
    });

});
