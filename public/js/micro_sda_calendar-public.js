function mc_c_form_show(id_day,id_month,id_year){
    var id_d=id_day;
    var id_m=id_month;
    var id_y=id_year;
    jQuery(document).ready(function($){
        $('#mc_c_form_id').empty();
        $('#mc_c_form_id').append('<hr>'+
        '<br>'+
        '<h2 style="text-align: center">Оформите заявку</h2>'+
        '<br>'+
        '<h2>Выбранна дата: '+id_d+'/'+id_m+'/'+id_y+'</h2>'+
        '<br>'+
        '<hr>'+
        '<br>'+
        '<form method="post" action="">'+
        '<input id="mc_c_d_hide" value="" hidden name="mc_c_day" type="text">'+
        '<div style="text-align: center">'+
        '<input style="height: 22px;width: 200px" placeholder="Имя" name="mc_c_name">&nbsp;&nbsp;&nbsp;'+
        '<input style="height: 22px;width:200px" placeholder="Почта" name="mc_c_email">&nbsp;&nbsp;&nbsp;'+
        '<input style="height: 22px;width: 200px" placeholder="Телефон" name="mc_c_fone"><br><br>'+
        '</div>'+
        '<h2 style="text-align: center">Опишите заказ</h2><br>'+
        '<textarea style="width: 100%;height: 100px" type="text" name="mc_c_message"></textarea><br><br>'+
        '<button style="width: 100%;height: 50px" name="mc_c_sumbit" type="submit ">Заказать</button>'+
        '</form>' + '<br>');
        $('#mc_c_d_hide').val('');
        $('#mc_c_d_hide').val(id_d);
    });
}


