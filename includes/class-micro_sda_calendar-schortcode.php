<?php
/**
 * The file that defines the core plugin shortcode
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://micro-sda.kl.com.ua/
 * @since      1.0.0
 *
 * @package    Micro_sda_calendar
 * @subpackage Micro_sda_calendar/includes
 */
class Micro_sda_calendar_shortcode {

    public function __construct(){

        add_shortcode('calendar_shortcode',array($this,'micro_sda_calendar_shortcode_func'));
    }

    public function my_calendar($fill=array()){

        $month_names=array("Январь","Февраль","Март","Апрель","Май","Июнь",
            "Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
        $d=$_GET['D'];
        $d =explode('/',$d);
        $y=intval($d[1]);
        $m=intval($d[0]);
        if (isset($_GET['date']) && strstr($_GET['date'],"-")){
            list($y,$m)=explode("-",$_GET['date']);
        }

        if (!isset($y) || $y < 1970){
            $y=date("Y");
        }

        if (!isset($m) || $m < 1 || $m > 12){
            $m=date("m");
        }

        $month_stamp=mktime(0,0,0,$m,1,$y);
        $day_count=date("t",$month_stamp);
        $weekday=date("w",$month_stamp);
        if ($weekday==0){
            $weekday=7;
        }

        $start=-($weekday-2);
        $last=($day_count+$weekday-1) % 7;
        if ($last==0){
            $end=$day_count;
        }else{
            $end=$day_count+7-$last;
        }

        $prev=date('?\D=m/Y',mktime (0,0,0,$m-1,1,$y));
        $next=date('?\D=m/Y',mktime (0,0,0,$m+1,1,$y));
        $i=0;

        echo '<table border=1 cellspacing=0 cellpadding=0 width=100% style="height:500px">
        <tr>
            <td colspan=7>
                <table width="100%" border=0 cellspacing=0 cellpadding=0>
                    <tr min-height="30px"  max-height="30px">
                        <td align="left"><a href="'.get_permalink().$prev.'"><img src="'.plugin_dir_url( dirname( __FILE__ )).'public/img/arrow-left-transparent.png"></a></td>
                        <td align="center" ><h3><font color="'.get_option("mc_calendar_color_month_week").'">'.$month_names[$m-1].' - '.$y.'</font></h3></td>
                        <td align="right"><a href="'.get_permalink().$next.'"><img src="'.plugin_dir_url( dirname( __FILE__ )).'public/img/arrow-right-transparent.png"></a></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="text-align:center"><td style="color:'.get_option("mc_calendar_color_month_week").'">Пн</td><td style="color:'.get_option("mc_calendar_color_month_week").'">Вт</td><td style="color:'.get_option("mc_calendar_color_month_week").'">Ср</td><td style="color:'.get_option("mc_calendar_color_month_week").'">Чт</td><td style="color:'.get_option("mc_calendar_color_month_week").'">Пт</td><td style="color:'.get_option("mc_calendar_color_weekend").'">Сб</td><td style="color:'.get_option("mc_calendar_color_weekend").'">Вс</td><tr>';

        function red_day($d,$res){
            $count_res=count($res);

            for ($i=0;$i<$count_res;$i++){
                if($d==$res[$i]->Day){
                    return true;
                }

            }
        }

        /*
         * Приводим к целочислительному типу.
         */
        $m=intval($m);
        $y=intval($y);

        global $wpdb;
        $res=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."micro_sda_calendar WHERE Month='".$m."' AND Year='".$y."'");

        for($d=$start;$d<=$end;$d++) {
            if (!($i++ % 7)){
                echo "<tr>\n";
            }

            echo '  <td align="center" style=" width:60px;height: 100px">';
            if ($d < 1 OR $d > $day_count) {
                echo "&nbsp;";
            } else {
                    if($i==6 || $i==13 || $i==20 || $i==27 || $i==34 ||!($i % 7)){
                        echo '<div style="background-color:'.get_option("mc_calendar_color_weekend").' ; margin-top: -35px;px;width:auto;height: 17px"></div><br>';
                        echo '<h3><font color="'.get_option("mc_calendar_color_weekend").'">'.$d.'</font></h3><br>';
                    }else{

                        if(red_day($d,$res)){
                            echo '<div style="background-color:'.get_option("mc_calendar_color_non-available_day").' ; margin-top:-35px;height: 17px"><h3><font color="black">Занято</font></h3></div><br>';
                            echo '<h3><font color="'.get_option("mc_calendar_color_non-available_day").'">'.$d.'</font></h3><br>';
                           }else{
                            echo '<div style="background-color:'.get_option("mc_calendar_color_available_day").';width:auto;height: 17px"></div><br>';
                            echo '<h3><font color="'.get_option("mc_calendar_color_available_day").'">'.$d.'</font></h3><br>';

                            $id_button_day="'".$d."'";
                            $id_button_month="'".$m."'";
                            $id_button_year="'".$y."'";
                            echo '<div class="holder"><button class="block" style="width:80px;height:40px" type="button" id="mc_c_b_'.$d.'"  onclick="mc_c_form_show('.$id_button_day.','.$id_button_month.','. $id_button_year.')">Выбрать</button></div>';
                          }
                         }
            }

            echo "</td>\n";
            if (!($i % 7)){
                echo "</td>\n";
            }
        }

        echo ' </table>';
        echo '<br>';
        echo '<div id="mc_c_form_id" ></div>';
        return array('Month'=> $m,'Year'=> $y);
    }



    public function micro_sda_calendar_shortcode_func()
    {

        $m_y=$this->my_calendar(array(date("Y-m-d")));

        if(isset($_POST['mc_c_sumbit'])){
         if(isset($_POST['mc_c_name'],$_POST['mc_c_email'],$_POST['mc_c_fone'])){
             if(empty($_POST['mc_c_name'])){echo '<h1>Вы не ввели имя !</h1><br>'; die();}
             if($_POST['mc_c_name']==''){ echo '<h1>Вы не ввели имя !</h1><br>'; die();}
             if($_POST['mc_c_name']==' '){echo '<h1>Вы не ввели имя !</h1><br>'; die();}

             if(empty($_POST['mc_c_email'])){echo '<h1>Вы не ввели почту !</h1><br>'; die();}
             if($_POST['mc_c_email']==''){ echo '<h1>Вы не ввели почту !</h1><br>'; die();}
             if($_POST['mc_c_email']==' '){echo '<h1>Вы не ввели почту !</h1><br>'; die();}

             if(empty($_POST['mc_c_message'])){echo '<h1>Вы не описали заказ !</h1><br>'; die();}
             if($_POST['mc_c_message']==''){ echo '<h1>Вы не описали заказ !</h1><br>'; die();}
             if($_POST['mc_c_message']==' '){echo '<h1>Вы не описали заказ !</h1><br>'; die();}



             global $wpdb;
               /*
                * Приводим к целочислительному типу.
                */
             $day=intval($_POST['mc_c_day']);
             $month=intval($m_y['Month']);
             $year=intval($m_y['Year']);
             $fonne=intval($_POST['mc_c_fone']);


             /*
              * Обрабатываем входные данные.
              */

             //Меняем знаки < и > на -.
             $name=preg_replace("!<(.*?)>!si","-\\1-",$_POST['mc_c_name']);
             $email=preg_replace("!<(.*?)>!si","-\\1-",$_POST['mc_c_email']);
             $message=preg_replace("!<(.*?)>!si","-\\1-",$_POST['mc_c_message']);


             /*
              * Заполняем массив с возможными не желательными словами.
              */
             $array_wrong_symbols=array(
                 0=>'SELECT',
                 1=>'INSERT',
                 2=>'UNION',
                 3=>'LIKE',
                 4=>'DROP',
                 5=>'CREATE',
                 6=>'TABLE',
                 7=>'USE',
                 8=>'DELETE',
                 9=>'UPDATE',
                 10=>'DROP',
                 11=>'WHERE',
                 12=>'VALUES',
                 13=>'ALTER',
                 14=>'DESC'
             );


             //Если найдем совпадение, то отклоняем!
             for($i_w=0;$i_w<=count($array_wrong_symbols);$i_w++){

                 $wrong_symbols="/^".$array_wrong_symbols[$i_w]."$/";
                 if(preg_match($wrong_symbols, $name)){

                    //Была попытка инъекции
                    echo '<script>location.href="'.get_the_permalink().'"</script>';
                    die();
                 }

                 if(preg_match($wrong_symbols, $email)){

                     //Была попытка инъекции

                     echo '<script>location.href="'.get_the_permalink().'"</script>';
                     die();
                 }

                 if(preg_match($wrong_symbols, $message)){

                     //Была попытка инъекции
                     echo '<script>location.href="'.get_the_permalink().'"</script>';
                     die();
                 }
             }


             $res_hack=$wpdb->get_row("SELECT * FROM wp_micro_sda_calendar WHERE Day LIKE '".$day."' AND Month LIKE '".$month."' AND Year LIKE '".$year."'");
             //Если день уже есть, то была попытка взлома. Отклоняем !
            if($res_hack>0){
                echo '<h1>Encorect, my friend, encorect!</h1>';
                echo '<script>location.href="'.get_the_permalink().'"</script>';
                die();
            }else{
                echo '<h1>Заказ добавлен</h1>';



                $wpdb->query("INSERT INTO ".$wpdb->prefix."micro_sda_calendar (Day, Month, Year, Name, Email, Fone, Message) VALUES ('".$day."','".$month."','".$year."','".$name."','".$email."','".$fonne."','".$message."');");
                if(get_option('mc_calendar_email')!=='Ваша почта'){
                    if(get_option('mc_calendar_email_send')=='yes'){

                        $mc_c_mail_subject='От кого: '.$_POST['mc_c_name'].'';
                        $mc_c_mail_subject=$mc_c_mail_subject."\n";
                        $mc_c_mail_subject=$mc_c_mail_subject.'Детали: '.$_POST['mc_c_message'].'. ';
                        $mc_c_mail_subject=$mc_c_mail_subject."\n";
                        $mc_c_mail_subject=$mc_c_mail_subject.'Почта: '.$_POST['mc_c_message'].'. ';
                        $mc_c_mail_subject=$mc_c_mail_subject."\n";
                        $mc_c_mail_subject=$mc_c_mail_subject.'Телефон: '.$_POST['mc_c_fone'].'. ';
                        $mc_c_mail_subject=$mc_c_mail_subject."\n";
                        $mc_c_mail_subject=$mc_c_mail_subject.'Дата заказа: '.$_POST['mc_c_day'].'/'.$m_y['Month'].'/'.$m_y['Year'].'. ';

                        wp_mail(get_option('mc_calendar_email'),'Новый заказ',$mc_c_mail_subject);

                    }
                }
                if(date('Y')==$year && date('m')==$month){
                    //Если мы на странице текущей даты, то выполняем редирект на эту же страницу
                    echo '<script>location.href="'.get_the_permalink().'"</script>';

                }else{
                    //Иначе редирект на страницу с нужной датой
                    echo '<script>location.href="'.get_the_permalink().'?D='.$_GET['D'].'"</script>';
                }

            }

         }
        }

    }
}

