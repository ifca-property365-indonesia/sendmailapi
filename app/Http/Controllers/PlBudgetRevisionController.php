<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\BudgetLymanRMail;
use Illuminate\Support\Facades\DB;

class PlBudgetRevisionController extends Controller
{
    public function Mail(Request $request) {
        $callback = array(
            'data' => null,
            'Error' => false,
            'Pesan' => '',
            'Status' => 200
        );

        $amount = number_format( $request->amount , 2 , '.' , ',' );

        $dataArray = array(
            'user_id'       => $request->user_id,
            'level_no'      => $request->level_no,
            'entity_cd'     => $request->entity_cd,
            'trx_type'      => $request->trx_type,
            'doc_no'        => $request->doc_no,
            'email_addr'    => $request->email_addr,
            'descs'         => $request->descs,
            'project_no'    => $request->project_no,
            'entity_name'   => $request->entity_name,
            'project_name'  => $request->project_name,
            'amount'        => $amount,
            'user_name'     => $request->user_name,
            'link'          => 'plbudgetrevision',
            'body'          => 'Revision RAB Budget'
        );

        $sendToEmail = strtolower($request->email_addr);
        if(isset($sendToEmail) && !empty($sendToEmail) && filter_var($sendToEmail, FILTER_VALIDATE_EMAIL))
        {
            Mail::to($sendToEmail)
                ->send(new BudgetLymanRMail($dataArray));
            $callback['Error'] = true;
            $callback['Pesan'] = 'sendToEmail';
            echo json_encode($callback);
        }
    }

    public function changestatus($entity_cd='', $project_no='', $doc_no='', $trx_type='', $status='', $level_no='', $user_id='')
    {
        $where2 = array(
            'doc_no'        => $doc_no,
            'status'        => array("A",'R', 'C'),
            'entity_cd'     => $entity_cd,
            'level_no'      => $level_no,
            'type'          => 'R',
            'module'        => 'PL',
        );

        $where3 = array(
            'doc_no'        => $doc_no,
            'status'        => 'P',
            'entity_cd'     => $entity_cd,
            'level_no'      => $level_no,
            'type'          => 'R',
            'module'        => 'PL',
        );
        $query = DB::connection('SSI')
        ->table('mgr.cb_cash_request_appr')
        ->where($where2)
        ->get();

        $query3 = DB::connection('SSI')
        ->table('mgr.cb_cash_request_appr')
        ->where($where3)
        ->get();
        if(count($query)>0){
            $msg = 'You Have Already Made a Request to Budget Revision No. '.$doc_no ;
            $notif = 'Restricted !';
            $st  = 'OK';
            $image = "double_approve.png";
            $msg1 = array(
                "Pesan" => $msg,
                "St" => $st,
                "notif" => $notif,
                "image" => $image
            );
        } else {
            if($status == 'A') {
                $pdo = DB::connection('SSI')->getPdo();
                $sth = $pdo->prepare("SET NOCOUNT ON; EXEC mgr.xrl_send_mail_approval_pl_budget_revision ?, ?, ?, ?, ?, ?, ?;");
                $sth->bindParam(1, $entity_cd);
                $sth->bindParam(2, $project_no);
                $sth->bindParam(3, $doc_no);
                $sth->bindParam(4, $trx_type);
                $sth->bindParam(5, $status);
                $sth->bindParam(6, $level_no);
                $sth->bindParam(7, $user_id);
                $sth->execute();
                if ($sth == true) {
                    $msg = "You Have Successfully Approved the Budget Revision No. ".$doc_no;
                    $notif = 'Approved !';
                    $st = 'OK';
                    $image = "approved.png";
                } else {
                    $msg = "You Failed to Approve the Budget Revision No ".$doc_no;
                    $notif = 'Fail to Approve !';
                    $st = 'OK';
                    $image = "reject.png";
                }
            } else if($status == 'R'){
                $pdo = DB::connection('SSI')->getPdo();
                $sth = $pdo->prepare("SET NOCOUNT ON; EXEC mgr.xrl_send_mail_approval_pl_budget_revision ?, ?, ?, ?, ?, ?, ?;");
                $sth->bindParam(1, $entity_cd);
                $sth->bindParam(2, $project_no);
                $sth->bindParam(3, $doc_no);
                $sth->bindParam(4, $trx_type);
                $sth->bindParam(5, $status);
                $sth->bindParam(6, $level_no);
                $sth->bindParam(7, $user_id);
                $sth->execute();
                if ($sth == true) {
                    $msg = "You Have Successfully Made a Revise Request on Budget Revision No. ".$doc_no;
                    $notif = 'Revised !';
                    $st = 'OK';
                    $image = "revise.png";
                } else {
                    $msg = "You Failed to Make a Revise Request on Budget Revision No. ".$doc_no;
                    $notif = 'Fail to Revised !';
                    $st = 'OK';
                    $image = "reject.png";
                }
            } else {
                $pdo = DB::connection('SSI')->getPdo();
                $sth = $pdo->prepare("SET NOCOUNT ON; EXEC mgr.xrl_send_mail_approval_pl_budget_revision ?, ?, ?, ?, ?, ?, ?;");
                $sth->bindParam(1, $entity_cd);
                $sth->bindParam(2, $project_no);
                $sth->bindParam(3, $doc_no);
                $sth->bindParam(4, $trx_type);
                $sth->bindParam(5, $status);
                $sth->bindParam(6, $level_no);
                $sth->bindParam(7, $user_id);
                $sth->execute();
                if ($sth == true) {
                    $msg = "You Have Successfully Cancelled the Budget Revision No. ".$doc_no;
                    $notif = 'Cancelled !';
                    $st = 'OK';
                    $image = "reject.png";
                } else {
                    $msg = "You Failed to Cancel the Budget Revision No. ".$doc_no;
                    $notif = 'Fail to Cancelled !';
                    $st = 'OK';
                    $image = "reject.png";
                }
            }
            $msg1 = array(
                "Pesan" => $msg,
                "St" => $st,
                "image" => $image,
                "notif" => $notif
            );
        }
        return view("emails.after", $msg1);
    }
}