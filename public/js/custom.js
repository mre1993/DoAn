

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
                            '<td>'+ v['SoLuong'] +'</td>'+
                            '<td>'+ v['DonGia'] +'</td>'+
                            '<td>'+ v['ThanhTien'] +'</td>'+
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
                        '<td>'+ v['SoLuong'] +'</td>'+
                        '<td>'+ v['DonGia'] +'</td>'+
                        '<td>'+ v['ThanhTien'] +'</td>'+
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
                    var NoiDung = v['MoTa'];
                    if(NoiDung==null){
                        NoiDung = '';
                    }
                    content.push(
                        '<tr>'+
                        '<td>'+i+'</td>'+
                        '<td>'+v['TenKVT']+'</td>'+
                        '<td>'+ v['MaVT'] +'</td>'+
                        '<td>'+ v['TenVT'] +'</td>'+
                        '<td>'+ v['SoLuongTon'] +'</td>'+
                        '<td>'+ v['SoLuongHong'] +'</td>'+
                        '<td>'+ v['TongSoLuong'] +'</td>'+
                        '<td>'+ v['DonGia'] +'</td>'+
                        '<td>'+ NoiDung +'</td>'+
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
                    '<th>Số lượng tồn</th>'+
                    '<th>Số lượng hỏng</th>'+
                    '<th>Tổng số lượng</th>'+
                    '<th>Đơn Giá</th>'+
                    '<th>Mô Tả</th>'+
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
        console.log(url);
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
    var jsonData1  ;
    $.ajax({
        dataType: 'JSON',
        type: 'GET',
        url: "mostsupplies",
        success:function (data) {
            jsonData1 = data
        }
    });
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    // Draw the chart and set the chart values
    function drawChart() {
        var data1 = google.visualization.arrayToDataTable(jsonData1);
        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Vật tư nhập nhiều nhất', 'width':550, 'height':400};

        // Display the chart inside the <div> element with id="piechart"
        var chart = new google.visualization.PieChart(document.getElementById('piechart-1'));
        chart.draw(data1, options);
    }
});
