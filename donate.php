<html>
<head>
</head>
<body style="font-family:helvetica;">
You are being redirected to plugnpay.com to process the payment.
<?php
    global $sam_options;

    $var = $_POST;
    $recur = $var['recur'];
    $amount = $var['amount'];
    $mname = strip_tags(trim($var['mname']));
    $acctnum = strip_tags(trim($var['acctnum']));

?>
    <script type="text/javascript">console.log('Mname: ' + '<?php echo $sam_options; ?>');</script>
    <div style="display:none;"><p style="margin:0px; padding:0px;">
        Make a contribution to <strong><?php echo $sam_options['mname'] ?></strong> and the ministry they are doing:

        <form name="donate_amount" id="donate_amount" method="post" action="https://pay1.plugnpay.com/payment/pay.cgi">
            <!-- NOTE: 'publisher-email' is set within the Email Management admin area. -->
            <input type="hidden" name="publisher-name" value="southameri">
            <input type="hidden" name="publisher-email" value="contrib@southamericamission.org">
            <input type="hidden" name="order-id" value="<?php echo $acctnum ?>">
            <input type="hidden" name="card-allowed" value="Visa,Mastercard">
            <input type="hidden" name="easycart" value="1">
            <input type="hidden" name="subject" value="SAM Donation Receipt">
            <input type="hidden" name="currency_symbol" value="$">
            <input type="hidden" name="comments" value=" ">
            <input type="hidden" name="comm-title" value="Special Instructions">
            <?php if ($recur != '4') { ?>
                <input type="hidden" name="plan1" value="1">
                <input type="hidden" name="item1" value="1">
                <input type="hidden" name="description1" value="<?php echo $mname ?> - Monthly">
                <input type="hidden" name="cost1" value="<?php echo $amount; ?>">
                <input type="hidden" name="plan2" value="2">
                <input type="hidden" name="item2" value="2">
                <input type="hidden" name="description2" value="<?php echo $mname ?> - Quarterly">
                <input type="hidden" name="cost2" value="<?php echo $amount; ?>">
                <input type="hidden" name="plan3" value="3">
                <input type="hidden" name="item3" value="3">
                <input type="hidden" name="description3" value="<?php echo $mname ?> - Annually">
                <input type="hidden" name="cost3" value="<?php echo $amount; ?>">
                <input type="hidden" name="recfee" value="<?php echo $amount; ?>">
                <select name="roption">
                    <option value="1" <?php if($recur == '1') {echo "selected";} ?>>Monthly</option>
                    <option value="2" <?php if($recur == '2') {echo "selected";} ?>>Quarterly</option>
                    <option value="3" <?php if($recur == '3') {echo "selected";} ?>>Annually</option>
                </select>
            <? } else { ?>
                <input type="hidden" name="success-link" value="http://www.southamericamission.org/give-online-thank-you.php">
                <input type="hidden" name="redirect" value="http://www.southamericamission.org/give-online-thank-you.php">
                <input type="hidden" name="item1" value="<?php echo $sam_options['acctnum'] ?>">
                <input type="hidden" name="description1" value="<?php echo $mname ?> - One-time">
                <input type="hidden" name="quantity1" value="1">
                <input type="hidden" name="cost1"  size="12" value='<?php echo $amount; ?>'>
            <? }; ?>
        </form>
    </div>
    <script>
        // Submit Form
        document.forms['donate_amount'].submit();
    </script>
</body>
</html>