<?php

require_once ('DbConnection.php');

class Functions extends DbConnection {


// insert data
public function insertData($column, $datas,$table) {

           //-----------------------------------------------//
          //                                               //
         //    This is how data is passing to function    //
        //                                               //
       //===============================================//
      //       $columns = ['column 1','column 2'];     //  
     //        $data    = ["'data 1'","'data 2'"];    //
    //         $table = 'news' ;                     //
   //===============================================//

    $number_of_columns = sizeof($column);
    $columnsAndDatas = '';
    // enter data into $columnsAndDatas variable
    for($i=0; $i < $number_of_columns;$i++) {
       $columnsAndDatas = $col.", ".$column[$i]."=".$datas[$i];
    }
    $columnsAndDatas = substr( $columnsAndDatas, 1 ); // removing first comma
    $query = "Insert into $table set $columnsAndDatas ";
    return $this->setData($query);
}


// delete by id
public function deleteByID($id,$table) {
    $query = "Delete from $table WHERE id='$id' ";
    return $this->setData($query);
}

// edit data by id
public function editByID($column, $datas,$table,$id) {
    $number_of_columns = sizeof($column);
    $col = '';
    // enter data into $col variable
    for($i=0; $i < $number_of_columns;$i++) {
       $col = $col.", ".$column[$i]."=".$datas[$i];
    }
    $col = substr( $col, 1 ); // removing first comma
    $query = "Update $table set $col WHERE id='$id' ";
    return $this->setData($query);
}




// result alert
public function result($result,$page='') {
     if($result) {
       echo '<script type="text/javascript">';
       echo 'alert("Operation Sucessfully Completed");';
       echo 'window.location="../admin/'.$page.'.php";';
       echo '</script>';
        }else {
          echo '<script type="text/javascript">';
          echo 'alert("Error..! Something went wrong");';
          echo 'window.location="../admin/'.$page.'.php";';
          echo '</script>';
        }
}

// password hashing
public function encrypt($data) {
    return hash('sha512',$data);
}

// cutting string
public function stringcut($string,$start, $length) {
    $newstring =  substr($string,$start,$length);
    $newstring = $newstring.'....';
    return $newstring;
}

// number of days
public function numberofdayspassed($date_to_check) {
    // toays date
    $today = date("Y-m-d");
    $today = explode('-', $today);
    $today_year = $today[0];
    $today_month = $today[1];
    $today_date = $today[2];
    // date tp check
    $date = explode('-', $date_to_check);
    $year_to_Check = $date[0];
    $month_to_check = $date[1];
    $day_to_check = $date[2];
    // days in a year and month
    $days_in_year = 365;
    $days_in_month = 30;
    // number of years passed and days in passed year
    $number_of_years_passed = $today_year - $year_to_Check;
    $passed_year_days = $number_of_years_passed * $days_in_year;
    //number of months passed and days in that days
    $number_of_months_passed = $today_month - $month_to_check;
    $passed_month_days = $number_of_months_passed * $days_in_month;
    // number of days
    $passed_days = $today_date - $day_to_check;
    //total days
    $total_days_passed = $passed_year_days + $number_of_months_passed + $passed_days;
    return $total_days_passed;
}




// sending mails
public function SendMail($msg_type,$msg_nature, $service_needed, $sender_name, $sender_mailid,$sender_subject,$sender_msg) {
    require './PHPMailer/PHPMailerAutoload.php';
    require './PHPMailer/class.phpmailer.php';
    require './PHPMailer/class.smtp.php';
    $from = $sender_mailid;
    $from_name = $sender_name;
    $subject = $sender_subject;
    $body = 'here goes your message as text or can use html codes';
    $to = "reciever mail id";
    $mail = new PHPMailer;  // create a new object
    $mail->IsSMTP(); // enable SMTP   //
    $mail->SMTPAuth = true;  // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = "yourmailid";
    $mail->Password = "yourpassword";
    $mail->SetFrom($from, $from_name);
    $mail->addReplyTo($from);
    $mail->Subject = $subject;
    $mail->IsHTML(true);
    $mail->Body = $body;
    $mail->AddAddress($to);
    if (!empty($cc)) {
        $mail->addCC($cc);
    }
    if (!empty($bcc)) {
        $mail->addBCC($bcc);
    }
    if (!$mail->Send()) {
        echo $error = 'Mail error: ' . $mail->ErrorInfo;
        return false;
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Sucess Message");';
        echo 'window.location="page to show after sucess message shows";';
        echo '</script>';
        return true;
    }
}

// File Uploading (single uploads)
public function uploads($file, $dest) {
    $Imagefile = $_FILES[$file];
//file properties
    $fileName = $Imagefile['name'];
    $fileType = $Imagefile['type'];
    $fileSize = $Imagefile['size'];
    $fileTempName = $Imagefile['tmp_name'];
    $fileError = $Imagefile['error'];
//file upload
    $fileExt = explode('.', $fileName);
    $fileExt = strtolower(end($fileExt));
    $allowedExt = array('png', 'jpeg', 'jpg', 'pdf');
    if (in_array($fileExt, $allowedExt)) {
        if ($fileError === 0) {
            if ($fileSize <= '2000000') {
                $fileNew = uniqid('', TRUE) . '.' . $fileExt;
                $fileDest = $dest . $fileNew;

                if (!empty($_SESSION['crop_items'])) {
                    $crop_items = $_SESSION['crop_items'];
                } else {
                    $crop_items = array();
                }
//array_push($crop_items,$fileDest);

                if (move_uploaded_file($fileTempName, $fileDest)) {

                    array_push($crop_items, $fileDest);
                    $_SESSION['crop_items'] = $crop_items;
//                               header("Location:./crop");
//                            echo sizeof($_SESSION['crop_items']);
                    return $fileDest;
                }
            } else {
                echo "Image Upload Error";
            }
        }
    }
}

    // multiple file upload
    public function multiplefileupload(){

    }

}

?>
