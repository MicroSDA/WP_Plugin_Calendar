<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://micro-sda.kl.com.ua/
 * @since      1.0.0
 *
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/admin/partials
 */



function admin_general_page_view(){
    global $wpdb;

    if(isset($_POST['Set'])){
        if(isset($_POST['Day'])&& !empty($_POST['Day'])){
            if(isset($_POST['Month'])&& !empty($_POST['Month'])){
                if(isset($_POST['Year'])&& !empty($_POST['Year'])){
                    $day=intval($_POST['Day']);
                    $month=intval($_POST['Month']);
                    $year=intval($_POST['Year']);
                    $res_hack=$wpdb->get_row("SELECT * FROM wp_micro_sda_calendar WHERE Day LIKE '".$day."' AND Month LIKE '".$month."' AND Year LIKE '".$year."'");
                    if($res_hack>0){
                        $error_msg='Ошибка! Этот день уже занят.';
                    }else{
                        $name='АДМИНИСТРАТОР';
                        $email='АДМИНИСТРАТОР';
                        $fonne='000000000000';
                        $message='СТАТУС: НЕРАБОЧИЙ ДЕНЬ';
                        $wpdb->query("INSERT INTO ".$wpdb->prefix."micro_sda_calendar (Day, Month, Year, Name, Email, Fone, Message) VALUES ('".$day."','".$month."','".$year."','".$name."','".$email."','".$fonne."','".$message."');");

                        unset($_POST['Day']);
                        unset($_POST['Month']);
                        unset($_POST['Year']);
                    }
                }
            }
        }
    }

    if(isset($_POST['Del'])){
        $id_i=1;
        while(isset($_POST['id_q_'.$id_i.''])){
            $wpdb->query();
            $id_i++;
            echo $id_i;
        }
    }

    $res=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."micro_sda_calendar ORDER BY id DESC");

    echo '<h1 style="text-align: center">Ваши заказы:</h1>';
    echo '<hr>';
    echo '<div style="margin-left: 5px;width: 1455px">';
    echo '<table style="border-style:solid;text-align:center;width:1455px;background-color:#00a0d2" border=1>
           <tr>
           <td style="width: 35px"><h2>№</h2></td>
           <td style="width:200px;"><h2>Имя</h2></td>
           <td style="width:200px;"><h2>Почта</h2></td>
           <td style="width:200px;"><h2>Телефон</h2></td>
           <td style="width: 70px"><h2>День</h2></td>
           <td style="width: 80px"><h2>Месяц</h2></td>
           <td style="width: 50px"><h2>Год</h2></td>
           <td style="width:574px;"><h2>Детали</h2></td>
           </tr>';
    echo '</table>';
    echo '<hr style="width: 1000px">';

    echo '<div style="max-height:650px;overflow-y:auto;">';
    echo '<table style="border-style:solid;text-align:center;background-color:white;" border=1>
          ';
     for($i=0;$i<count($res);$i++){

         if($res[$i]->Name !=='АДМИНИСТРАТОР' && $res[$i]->Email !=='АДМИНИСТРАТОР'){

             //Если не администраторская запись то выводим как обычно
             echo '<tr>';
             echo '<td style="width: 35px"><h3>'.$res[$i]->id.'</h3></td>';
             echo '<td style="max-width:200px;min-width:200px;overflow: auto;"><h3>'.$res[$i]->Name.'</h3></td>';
             echo '<td style="max-width:200px;min-width:200px;overflow: auto;"><h3>'.$res[$i]->Email.'</h3></td>';
             echo '<td style="max-width:200px;min-width:200px;overflow: auto;"><h3>'.$res[$i]->Fone.'</h3></td>';
             echo '<td style="width: 70px"><h3>'.$res[$i]->Day.'</h3></td>';
             echo '<td style="width: 80px"><h3>'.$res[$i]->Month.'</h3></td>';
             echo '<td style="width: 50px"><h3>'.$res[$i]->Year.'</h3></td>';
             echo '<td style="width:550px; text-align:left; overflow: auto;"><h3>&nbsp;&nbsp;'.$res[$i]->Message.'</h3></td>';
             echo '<td style=" text-align:center;"><input type="checkbox" name="id_q_'.$res[$i]->id.'" /></td>';
             echo '</tr>';

         }
     }
     echo '</table>';
     echo '</div>';
     echo '<hr style="width: 1000px">';
     echo '<hr>';
     echo '</div>';


     echo '<h1 style="text-align: center">Нерабочие дни:</h1>';
     echo '<hr>';
     echo '<div style="margin-left: 5px;width: 1455px">';
     echo '<table style="border-style:solid;text-align:center;background-color:white;" border=1>';

    for($i=0;$i<count($res);$i++){
        if($res[$i]->Name =='АДМИНИСТРАТОР' && $res[$i]->Email =='АДМИНИСТРАТОР'){

            echo '<tr>';
            echo '<td style="width: 35px"><h3>'.$res[$i]->id.'</h3></td>';
            echo '<td style="max-width:200px;min-width:200px"><h2 style="color: red">'.$res[$i]->Name.'</h2></td>';
            echo '<td style="max-width:200px;min-width:200px"><h2 style="color: red">'.$res[$i]->Email.'</h2></td>';
            echo '<td style="max-width:200px;min-width:200px"><h2 style="color: red">'.$res[$i]->Fone.'</h2></td>';
            echo '<td style="width: 70px"><h3>'.$res[$i]->Day.'</h3></td>';
            echo '<td style="width: 80px"><h3>'.$res[$i]->Month.'</h3></td>';
            echo '<td style="width: 50px"><h3>'.$res[$i]->Year.'</h3></td>';
            echo '<td style="width:550px; text-align:left;"><h2 style="color: red">&nbsp;&nbsp;'.$res[$i]->Message.'</h2></td>';
            echo '<td style=" text-align:center;"><input type="checkbox" name="id_q_'.$res[$i]->id.'" /></td>';
            echo '</tr>';

        }
    }
       /* echo '<tr>';
        echo '<td style="width: 35px"><h3>'.$res[$i]->id.'</h3></td>';
        echo '<td style="max-width:200px;min-width:200px"><h2 style="color: red">'.$res[$i]->Name.'</h2></td>';
        echo '<td style="max-width:200px;min-width:200px"><h2 style="color: red">'.$res[$i]->Email.'</h2></td>';
        echo '<td style="max-width:200px;min-width:200px"><h2 style="color: red">'.$res[$i]->Fone.'</h2></td>';
        echo '<td style="width: 70px"><h3>'.$res[$i]->Day.'</h3></td>';
        echo '<td style="width: 80px"><h3>'.$res[$i]->Month.'</h3></td>';
        echo '<td style="width: 50px"><h3>'.$res[$i]->Year.'</h3></td>';
        echo '<td style="width:550px; text-align:left;"><h2 style="color: red">&nbsp;&nbsp;'.$res[$i]->Message.'</h2></td>';
        echo '</tr>';*/


     echo '</table>';
     echo '<hr>';
     echo '<h2 style="margin-left: 5px">Добавить не рабочий день.</h2>';
     echo '<hr>';
     echo '</div>';
     echo '<form action="'.get_the_permalink().'" method="post">';

     echo '<h2 style="margin-left: 5px">День:<input name="Day" style="height: 28px;margin-left: 25px;width: 47px" placeholder="'.date('d').'"/></h2>';
     echo '<h2 style="margin-left: 5px">Месяц:<input name="Month" style="height: 28px;margin-left: 12px;width: 47px" placeholder="'.date('m').'"/></h2>';
     echo '<h2 style="margin-left: 5px">Год:<input name="Year" style="height: 28px;margin-left: 40px;width: 47px" placeholder="'.date('Y').'"/></h2>';
     echo '<button name="Set" type="submit" style="height: 28px">Добавить</button>';
     echo '<button name="Del" type="submit" style="height: 28px;float: right;margin-right: 40px ">Удалить отмеченные</button>';
     echo '</form>';
    echo '<hr>';
    if(isset($error_msg) && !empty($error_msg)){
        echo '<h1 style="margin-left: 5px">'.$error_msg.'</h1>';
        unset($error_msg);
    }
}
function admin_sub_menu_gage_settings_views(){

    if(isset($_POST['mc_c_email_option_b'])){
        if(!empty($_POST['mc_c_email_option'])){
            update_option('mc_calendar_email',''.$_POST['mc_c_email_option'].'');
        }

        if(isset($_POST['mc_c_email_option_email_send'])){
            update_option('mc_calendar_email_send',$_POST['mc_c_email_option_email_send']);
        }
        ////////////////
        if(isset($_POST['mc_c__month_week'])){
            update_option('mc_calendar_color_month_week',$_POST['mc_c__month_week']);
        }

        if(isset($_POST['mc_c_available_day'])){
            update_option('mc_calendar_color_available_day',$_POST['mc_c_available_day']);
        }

        if(isset($_POST['mc_c_non-available_day'])){
            update_option('mc_calendar_color_non-available_day',$_POST['mc_c_non-available_day']);
        }

        if(isset($_POST['mc_c_weekend'])){
            update_option('mc_calendar_color_weekend',$_POST['mc_c_weekend']);
        }
    }

    $mc_c_option_email='mc_calendar_email';

    echo '<h1 style="text-align: center">Настройки:</h1>';
    echo '<hr>';
    echo '<h3>Основные настройки:</h3>';
    echo '<hr>';
    echo '<form action="'.get_the_permalink().'" method="post">';
    echo '<input type="text" name="mc_c_email_option" placeholder="'.get_option($mc_c_option_email).'"><br><br>';
    if(get_option('mc_calendar_email_send')=='yes'){

        echo '<input checked type="radio" name="mc_c_email_option_email_send" value="yes">Оповещать<br><br>';
        echo '<input  type="radio" name="mc_c_email_option_email_send" value="no">Не оповещать<br><br>';

    }else{

        echo '<input type="radio" name="mc_c_email_option_email_send" value="yes">Оповещать<br><br>';
        echo '<input checked type="radio" name="mc_c_email_option_email_send" value="no">Не оповещать<br><br>';

    }
    echo '<hr>';
    echo '<h3>Визуальные настройки:</h3>';
    echo '<hr>';
    echo '<br>';
    echo '<br>';
    echo '<table border="0" cellpadding="5" cellspacing="0" style="text-align: left">';
         echo '<tr>';
         echo '<td width="250px"><h3>Дата и дни недели</h3><td width="250px"><h3>Доступные дни</h3><td width="250px"><h3>Недоступные дни</h3></td><td width="250px"><h3>Выходные дни</h3></td></tr>';
         echo '<tr>';
         echo '<td width="250px">';
         echo '<input class="mc_color_picker" name="mc_c__month_week"  type="text" value="'.get_option("mc_calendar_color_month_week").'"  data-default-color="#ffffff" />';

         echo '<br>';
         echo '</td>';
         echo '<td width="250px">';
         echo '<input class="mc_color_picker" name="mc_c_available_day" type="text" value="'.get_option("mc_calendar_color_available_day").'"  data-default-color="#1b9700" />';

         echo '<br>';
         echo '</td>';
         echo '<td width="250px">';
         echo '<input class="mc_color_picker" name="mc_c_non-available_day"  type="text" value="'.get_option("mc_calendar_color_non-available_day").'"  data-default-color="#97000f" />';

         echo '<br>';
         echo '</td>';
         echo '<td width="250px">';
         echo '<input class="mc_color_picker" name="mc_c_weekend" type="text" value="'.get_option("mc_calendar_color_weekend").'"  data-default-color="#1f5300" />';
         echo '<br>';
         echo '</td>';
         echo '</tr>';

    echo '</table><br><hr>';

    echo '<button name="mc_c_email_option_b" type="submit" style="height: 26px">Обновить</button>';
    echo '</form>';


    echo '<script> mc_c_color_picker();</script>';
}


