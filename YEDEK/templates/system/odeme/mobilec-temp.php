<link rel="stylesheet" type="text/css" href="templates/system/odeme/card-master/css/style.css" />
<style>
    .collapse {
        display: block !important;
        visibility: visible !important;
    }

    .ui-btn-hidden {
        display: none !important;
    }

    .cc-odeme-aciklama {
        height: 50px;
    }

    .cc-odeme-aciklama strong {
        color: green;
    }

    .cc-odeme-aciklama strong.red {
        color: red;
    }
</style>
<img src="images/banka/{%DB_ODEMELOGO%}" alt="" style="margin-bottom:20px;" />
<div class="cc-odeme-aciklama">{%DB_ODEMEACIKLAMA%}<br /><br /><strong id="cc-type-info"></strong></div>

<div id="pay-screen">
    <div class="demo-wrapper">
        <div class="demo-container">
            <div class="clear-space">&nbsp;</div>
            <div class="card-wrapper"></div>
            <div class="form-container active">
                <div class="row collapse">
                    <div class="small-6 columns" style="width:100%; float:none;">
                        <input name="cardno" autocomplete="off" class="jp-card-invalid mastercard identified" type="text" placeholder="Card No" vk_1763a="subscribed" id="cardno">
                    </div>
                </div>

                <div class="row collapse">
                    <div class="small-12 columns">
                        <input class="button postfix cc-submit-button" type="submit" onclick="$('#cardno').val($('#cardno').val().replace(/ /g,''))" value="Gönder">
                    </div>
                </div>
                <input type="hidden" name="cardtype" id="cardtype">
                <input type="hidden" name="exp" id="exp-update">
            </div>
            <div class="clear-space"></div>
        </div>
        <div class="clear-space"></div>
    </div>
    <div class="clear-space"></div>
</div>
<!-- //pay screen -->
<script type="text/javascript">
    window.addEventListener("load", (event) => {
        $('.ui-btn-inner').click(function() {
            $('#cardno').val($('#cardno').val().replace(/ /g, ''));
            $('.sp-payment form').submit();
        });
    });
</script>