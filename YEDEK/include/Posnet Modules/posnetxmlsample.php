<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
<?php
    /**
     * @package posnettest
     */

    //Include POSNET Class
    require_once('Posnet Modules/Posnet XML/posnet.php');

    $hostname = $HTTP_POST_VARS['hostname'];
    $ownip = $HTTP_POST_VARS['ownip'];
    $mid = $HTTP_POST_VARS['mid'];
    $tid = $HTTP_POST_VARS['tid'];
    $username = $HTTP_POST_VARS['username'];
    $password = $HTTP_POST_VARS['password'];
    $hostname = $HTTP_POST_VARS['hostname'];
    $trantype = $HTTP_POST_VARS['trantype'];
    $ccno = $HTTP_POST_VARS['ccno'];
    $expdate = $HTTP_POST_VARS['expdate'];
    $cvc = $HTTP_POST_VARS['cvc'];
    $orderid = $HTTP_POST_VARS['orderid'];
    $amount = $HTTP_POST_VARS['amount'];
    $currencycode = $HTTP_POST_VARS['currencycode'];
    $instnumber = $HTTP_POST_VARS['instnumber'];
    $multpoint = $HTTP_POST_VARS['multpoint'];
    $extpoint = $HTTP_POST_VARS['extpoint'];
    $hostlogkey = $HTTP_POST_VARS['hostlogkey'];
    $authcode = $HTTP_POST_VARS['authcode'];
    $vftcode = $HTTP_POST_VARS['vftcode'];

    $posnet = new Posnet;
    //$posnet->SetDebugLevel(1);

    $posnet->SetURL($hostname);
    $posnet->SetMid($mid);
    $posnet->SetTid($tid);
    $posnet->SetUsername($username);
    $posnet->SetPassword($password);
     
    if ($trantype == "Auth") {
        $posnet->DoAuthTran(
        $ccno,
            $expdate, // Ex : 0703 - Format : YYMM
        $cvc,
            $orderid,
            $amount, // Ex : 1500->15.00 YTL
        $currencycode, // Ex : YT
        $instnumber // Ex : 05
        );
    }
    else if ($trantype == "Sale") {
        $posnet->DoSaleTran(
        $ccno,
            $expdate, // Ex : 0703 - Format : YYMM
        $cvc,
            $orderid,
            $amount, // Ex : 1500->15.00 YTL
        $currencycode, // Ex : YT
        $instnumber // Ex : 05
        );
    }
    else if ($trantype == "Capture") {
        $posnet->DoCaptTran(
        $hostlogkey,
            $authcode,
            $amount,
            $currencycode, // Ex :YT
        $instnumber // Ex : 05
        );
    }
    else if ($trantype == "AuthRev") {
        $posnet->DoAuthReverseTran(
        $hostlogkey,
            $authcode );
    }
    else if ($trantype == "SaleRev") {
        $posnet->DoSaleReverseTran(
        $hostlogkey,
            $authcode );
    }
    else if ($trantype == "CaptureRev") {
        $posnet->DoCaptReverseTran(
        $hostlogkey,
            $authcode );
    }
    else if ($trantype == "PNTU") {
        $posnet->DoPointUsageTran(
        $ccno,
            $expdate, // Ex : 0703 - Format : YYMM
        $orderid,
            $amount, // Ex : 1500->15.00 YTL
        $currencycode // Ex : YT
        );
    }
    else if ($trantype == "PNTV") {
        $posnet->DoPointReverseTran(
        $hostlogkey);
    }
    else if ($trantype == "PNTI") {
        $posnet->DoPointInquiryTran(
        $ccno,
            $expdate // Ex : 0703 - Format : YYMM
        );
    }
    // VFT Transactions
    else if ($trantype == "VFTI") {
        $posnet->DoVFTInquiry(
        $ccno,
            $amount, // Ex : 1500->15.00 YTL
        $instnumber, // Ex : 05
        $vftcode );
    }
    else if ($trantype == "VFTS") {
        $posnet->DoVFTSale(
        $ccno,
            $expdate, // Ex : 0703 - Format : YYMM
        $cvc,
            $orderid,
            $amount, // Ex : 1500->15.00 YTL
        $currencycode, // Ex : YT
        $instnumber, // Ex : 05
        $vftcode );
    }
    else if ($trantype == "VFTR") {
        $posnet->DoVFTSaleReverse(
        $hostlogkey,
            $authcode );
    }
?>
<html>
<head>
<title> Posnet Integration for PHP by using Java </title>
</head>
<font color = "#0066FF" size = "6" >
Posnet Integration for PHP by using Java </font> </p>
<table width = "797" HEIGHT="150" border = "0" align = "center" >
<tr> 
    <td width = "4%" height = "58">&nbsp;</td>
    <td WIDTH="96%"> <font color = "#0066FF" size = "4">Response From Posnet;</font></td>
  </tr>
  <tr> 
    <td height = "86">&nbsp;</td>
    <td> <P> <FONT COLOR="#0066FF" SIZE="2">XML Request : <FONT COLOR="#000000"><? echo HtmlSpecialChars($posnet->GetRequestXMLData()); ?></FONT></FONT><BR>
        <BR>
        <FONT COLOR="#0066FF" SIZE="2">XML Response : <FONT COLOR="#000000"><? echo HtmlSpecialChars($posnet->GetResponseXMLData()); ?></FONT></FONT> 
      </P></td>
  </tr>
</table>
<div align="center"> 
  <table width = "727" HEIGHT="261" border = "0" align = "center" >
<tr> 
      <td WIDTH="6%" height = "73" ROWSPAN="2">&nbsp;</td>
      <td HEIGHT="133" COLSPAN="3"> <P><FONT COLOR="#0066FF" SIZE="3"><STRONG>Response 
          Parameters :</STRONG></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Approved Code : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetApprovedCode(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Response Code : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetResponseCode(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Response Text : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo HtmlSpecialChars($posnet->GetResponseText()); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Authcode : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetAuthcode(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Hostlogkey : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetHostlogkey(); ?></FONT> 
        </P></td>
    </tr>
    <tr> 
      <td WIDTH="30%" HEIGHT="114" VALIGN="TOP"> 
<P><FONT COLOR="#0066FF" SIZE="3"><STRONG>Point 
          Info :</STRONG></FONT> <BR>
          <FONT COLOR="#0066FF" SIZE="2">Point : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetPoint(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Point Amount: </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetPointAmount(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Total Point : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetTotalPoint(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Total Point Amount : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetTotalPointAmount(); ?></FONT><BR>
        </P></td>
      <td WIDTH="31%" VALIGN="TOP"> 
        <P><FONT COLOR="#0066FF" SIZE="3"><STRONG>Instalment 
          Info : </STRONG></FONT><FONT SIZE="3"></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Instalment Number : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetInstalmentNumber(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">Instalment Amount: </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetInstalmentAmount(); ?></FONT><BR>
        </P></td>
      <td WIDTH="33%" VALIGN="TOP"> 
        <P><FONT COLOR="#0066FF" SIZE="3"><STRONG>VFT 
          Info : </STRONG></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">VFT Amount : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetVFTAmount(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">VFT Rate : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetVFTRate(); ?></FONT><BR>
          <FONT COLOR="#0066FF" SIZE="2">VFT Day Count : </FONT> <FONT COLOR="#000000" SIZE="2"><? echo $posnet->GetVFTDayCount(); ?></FONT> 
        </P></td>
    </tr>
  </table>
  <p> 
    <input name="Submit" type="button" id="Submit" onClick="history.back()" value="Back">
  </p>
</div>
<p>&nbsp; </p>
</html>
