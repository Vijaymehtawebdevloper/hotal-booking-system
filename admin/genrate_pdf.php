<?php
    include("inc/header.php");
    // include "inc/config.php";
    // include "inc/essencials.php";
    include_once('inc/tcpdf/tcpdf.php');
    // adminLogin();

    //----- Code for generate pdf
	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);  
	//$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
	$pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	$pdf->SetDefaultMonospacedFont('helvetica');  
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
	$pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
	$pdf->setPrintHeader(false);  
	$pdf->setPrintFooter(false);  
	$pdf->SetAutoPageBreak(TRUE, 10);  
	$pdf->SetFont('helvetica', '', 12);  
	$pdf->AddPage(); //default A4
	//$pdf->AddPage('P','A5'); //when you require custome page size 
    
    if(isset($_GET['gen_pdf']) && isset($_GET['id'])){
        $frm_data = filteration($_GET);

        $query = "SELECT bo.*, bd.*, ur.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.`booking_id` = bd.booking_id INNER JOIN `user_register` ur ON bo.user_id = ur.id WHERE ((bo.booking_status = 'booked' AND bo.arivel = 1) OR (bo.booking_status = 'cancel' AND bo.refund = 1) OR (bo.booking_status = 'payment failed')) AND bo.booking_id = $frm_data[id]"; 

        $res = mysqli_query($con, $query);

        $total_rows = mysqli_num_rows($res);

        if($total_rows == 0){
            header('Location : dashbord.php');
            exit;
        }

        $data = mysqli_fetch_assoc($res);
        
        $date = date("h:ia | d-n-Y", strtotime($data['datetime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $table_data = "
            <h2>BOOKING RECIEPT</h2>
            <table class = 'table table-bordered'>
                <tr>
                    <td>Order ID : $data[order_id]</td>
                    <td>Booking Date : $date</td>
                </tr>
                <tr>
                    <td colspan = '2'>Status : $data[booking_status]</td>
                </tr>
                <tr>
                    <td>Name : $data[order_id]</td>
                    <td>Email : $data[order_id]</td>
                </tr>
                <tr>
                    <td>Phone Number : $data[phonenumber]</td>
                    <td>Address : $data[address]</td>
                </tr>
                <tr>
                    <td>Room Name : $data[room_name]</td>
                    <td>Cost : $data[price] per night</td>
                </tr>
                <tr>
                    <td>Check in : $data[check_in]</td>
                    <td>Check out : $data[check_out]</td>
                </tr>";

        if($data['booking_status'] == 'cancel'){
            $refund = $data['refund'] ? "Amount Refunded!" : "Not yet refund";
            $table_data .= "
                <tr>
                    <td>Amount Paid : $data[trans_amt]</td>
                    <td>Refund : $refund</td>
                </tr>
            ";
        }else if($data['booking_status'] == 'payment failed'){
            $table_data .= "
                <tr>
                    <td>Transaction Amount  : $data[trans_amt]</td>
                    <td>Failure Responnse : $data[trans_res_msg]</td>
                </tr>
            ";
        }else{
            $table_data .= "
                <tr>
                    <td>Room Number  : $data[room_no]</td>
                    <td> Amount Paid : $data[trans_amt]</td>
                </tr>
            ";
        }
        $table_data .="</table>";
        echo $table_data;

        $file_name = $data['order_id']."pdf";

        $pdf->Output($file_name, 'D');

    }else{
        header('Location : dashbord.php');
    }

?>