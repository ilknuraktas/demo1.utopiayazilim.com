<?php defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                $cargo = [];
                $toplu_al = [];
                $cargo_indirim = [];
                if ($cart_items != null): ?>
                    <div class="shopping-cart">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8">
                                <div class="left">
                                    <h1 class="cart-section-title"><?php echo trans("my_cart"); ?>
                                        (<?php echo get_cart_product_count(); ?>)</h1>
                                    <?php if (!empty($cart_items)):
                                        foreach ($cart_items as $cart_item):
                                            $product = get_available_product($cart_item->product_id);
                                            if (!isset($cargo[$product->user_id])) {
                                                $cargo[$product->user_id] = 0;
                                                $cargo_indirim[$product->user_id] = 0;
                                            }
                                            if (!empty($product)):
                                                $total = price_formatted($cart_item->total_price, $cart_item->currency);
                                                $total_cargo = price_formatted($cart_item->shipping_cost, $cart_item->currency);
                                                $cargo[$product->user_id] += $cart_item->total_price;
                                                $cargo_indirim[$product->user_id] += $cart_item->shipping_cost;
                                                ?>

                                                <div class="item">

                                                    <div class="cart-item-image">
                                                        <div class="img-cart-product">
                                                            <a href="<?php echo generate_product_url($product); ?>">
                                                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>"
                                                                     data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>"
                                                                     alt="<?php echo html_escape($cart_item->product_title); ?>"
                                                                     class="lazyload img-fluid img-product"
                                                                     onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="cart-item-details">
                                                        <?php if ($product->product_type == 'digital'): ?>
                                                            <div class="list-item">
                                                                <label class="label-instant-download label-instant-download-sm"><i
                                                                            class="icon-download-solid"></i><?php echo trans("instant_download"); ?>
                                                                </label>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="list-item">
                                                            <a href="<?php echo generate_product_url($product); ?>">
                                                                <?php echo html_escape($cart_item->product_title); ?>
                                                            </a>
                                                            <?php if (empty($cart_item->is_stock_available)): ?>
                                                                <div class="lbl-enough-quantity"><?php echo trans("out_of_stock"); ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="list-item seller">
                                                            <?php echo trans("by"); ?>&nbsp;<a
                                                                    href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo get_shop_name_product($product); ?></a>
                                                        </div>
                                                        <?php

                                                        if ($product->alinacak_miktar > 0 && $product->odenecek_miktar > 0) {
                                                            if ($cart_item->quantity>=$product->alinacak_miktar) {
                                                                $count = $product->alinacak_miktar-$product->odenecek_miktar;

                                                                var_dump($count);
                                                                $toplu_al[$product->id]= $count*$cart_item->unit_price;
//                                                                for ($i=$cart_item->quantity;$i>0;$i--){
//echo
//                                                                if (!$i>0)
//                                                                    echo '1';
//                                                                $toplu_al[$cart_item->id] =$product->unit_price;
//                                                                }
                                                            }

                                                            ?>

                                                            <div class="list-item m-t-15">
                                                                <strong class="lbl-price" style="color: #4ca500">
                                                                    Bu Ürün de <?= $product->alinacak_miktar ?>
                                                                    al <?= $product->odenecek_miktar ?> öde kampanyası
                                                                    vardır.

                                                                </strong>
                                                            </div>
                                                        <?php }
                                                        ?>
                                                        <?php
                                                        $satici1 = $this->db->query("SELECT * FROM users WHERE id=" . $product->user_id);
                                                        $satici = $satici1->row();
                                                        if ($satici->ucretsiz_kargo_siniri > 0) {
//                                                            if ($cargo[$product->user_id] >number_format($satici->ucretsiz_kargo_siniri, '2', '', '')) {
                                                            ?>
                                                            <!--                                                                <div class="list-item m-t-15">-->
                                                            <!--                                                                    <strong class="lbl-price" style="color: #4ca500">-->
                                                            <!--                                                                        Ücretsiz Kargo-->
                                                            <!--                                                                    </strong>-->
                                                            <!--                                                                </div>-->
                                                            <!--                                                            --><?php //} else { ?>
                                                            <div class="list-item m-t-15">
                                                                <strong class="lbl-price" style="color: #4ca500">
                                                                    Bu Mağazada
                                                                    <?= number_format($satici->ucretsiz_kargo_siniri, '2', ',', '.') ?>
                                                                    TL Üzeri Ücretsiz Kargo

                                                                </strong>
                                                            </div>
                                                        <?php }
                                                        //                                                        }
                                                        ?>
                                                        <div class="list-item m-t-15">
                                                            <label><?php echo trans("unit_price"); ?>:</label>
                                                            <strong class="lbl-price">
                                                                <?php echo price_formatted($cart_item->unit_price, $cart_item->currency);
                                                                if (!empty($cart_item->discount_rate)): ?>
                                                                    <span class="discount-rate-cart">
                                                                        (<?php echo discount_rate_format($cart_item->discount_rate); ?>)
                                                                    </span>
                                                                <?php endif; ?>
                                                            </strong>
                                                        </div>
                                                        <div class="list-item">
                                                            <label><?php echo trans("total"); ?>:</label>
                                                            <strong class="lbl-price"><?php echo price_formatted($cart_item->total_price, $cart_item->currency); ?></strong>
                                                        </div>
                                                        <?php if (!empty($product->vat_rate)): ?>
                                                            <div class="list-item">
                                                                <label><?php echo trans("vat"); ?>
                                                                    &nbsp;(<?php echo $product->vat_rate; ?>%):</label>
                                                                <strong class="lbl-price"><?php echo price_formatted($cart_item->product_vat, $cart_item->currency); ?></strong>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($product->product_type != 'digital' && $this->form_settings->shipping == 1): ?>
                                                            <div class="list-item">
                                                                <label><?php echo trans("shipping"); ?>:</label>
                                                                <strong><?php echo price_formatted($cart_item->shipping_cost, $cart_item->currency); ?></strong>
                                                            </div>
                                                        <?php endif; ?>
                                                        <a href="javascript:void(0)"
                                                           class="btn btn-md btn-outline-gray btn-cart-remove"
                                                           onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"><i
                                                                    class="icon-close"></i> <?php echo trans("remove"); ?>
                                                        </a>
                                                    </div>
                                                    <div class="cart-item-quantity">
                                                        <?php if ($cart_item->purchase_type == 'bidding'): ?>
                                                            <span><?php echo trans("quantity") . ": " . $cart_item->quantity; ?></span>
                                                        <?php else: ?>
                                                            <?php if ($product->stock > 1): ?>
                                                                <div class="number-spinner">
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <button type="button"
                                                                                    class="btn btn-default btn-spinner-minus"
                                                                                    data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>"
                                                                                    data-dir="dwn">-</button>
                                                                        </span>
                                                                        <input type="text"
                                                                               id="q-<?php echo $cart_item->cart_item_id; ?>"
                                                                               class="form-control text-center"
                                                                               value="<?php echo $cart_item->quantity; ?>"
                                                                               data-product-id="<?php echo $cart_item->product_id; ?>"
                                                                               data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>">
                                                                        <span class="input-group-btn">
                                                                            <button type="button"
                                                                                    class="btn btn-default btn-spinner-plus"
                                                                                    data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>"
                                                                                    data-dir="up">+</button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </div>
                                <a href="<?php echo lang_base_url(); ?>" class="btn btn-lg btn-custom m-t-15"><i
                                            class="icon-arrow-left m-r-2"></i><?php echo trans("keep_shopping") ?></a>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="right">
                                    <p>
                                        <strong><?php echo trans("subtotal"); ?><span
                                                    class="float-right"><?php echo price_formatted($cart_total->subtotal, $cart_total->currency); ?></span></strong>
                                    </p>
                                    <?php if (!empty($cart_total->vat)): ?>
                                        <p>
                                            <?php echo trans("vat"); ?><span
                                                    class="float-right"><?php echo price_formatted($cart_total->vat, $cart_total->currency); ?></span>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ($cart_has_physical_product == true && $this->form_settings->shipping == 1): ?>
                                        <p>
                                            <?php echo trans("shipping"); ?><span class="float-right"><?php

                                                echo price_formatted($cart_total->shipping_cost, $cart_total->currency); ?>
                                              </span>
                                        </p>
                                    <?php endif; ?>
                                    <?php
                                    $total_indirim = 0;
                                    foreach ($toplu_al as $key => $value):

                                        $uruns = $this->db->query("SELECT * FROM products WHERE id=" . $key);
                                        $urun = $uruns->row();
                                        $total_indirim+=$value;
?>
                                            <php><?=  $urun->title." Ürünün'de ". price_formatted($value, $value)  .'Toplu Al İndirimi' ?></php><br>

 <?php                                   endforeach;

                                    foreach ($cargo_indirim as $key => $value):

                                        $satici1 = $this->db->query("SELECT * FROM users WHERE id=" . $key);
                                        $satici = $satici1->row();
                                        $ucretsiz_kargo_siniri = number_format($satici->ucretsiz_kargo_siniri, '2', '', '');
                                        if ($ucretsiz_kargo_siniri > 0 && $ucretsiz_kargo_siniri < $cargo[$satici->id]) {
                                            if ($value > 0):
                                                $total_indirim += $value;
                                                ?>
                                                <php><?= $satici->username . ' Mağazasından ' . price_formatted($value, $cart_total->currency) . ' Tutarında Kargo İndirimi' ?></php>
                                            <?php

                                            endif;
                                        }
                                    endforeach;

                                    ?>
                                    <p class="line-seperator"></p>
                                    <p>
                                        <strong><?php echo trans("total"); ?><span
                                                    class="float-right"><?php echo price_formatted(($cart_total->total - $total_indirim), $cart_total->currency); ?></span></strong>
                                    </p>
                                    <div class="payment-icons">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg"
                                             alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/maestro.svg"
                                             alt="maestro">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/discover.svg"
                                             alt="discover">
                                    </div>
                                </div>
                                <p class="m-t-30">
                                    <?php if (empty($cart_item->is_stock_available)): ?>
                                        <a href="javascript:void(0)"
                                           class="btn btn-block"><strong><?php echo trans("continue_to_checkout"); ?></strong></a>
                                    <?php else:
                                        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1): ?>
                                            <a href="#" class="btn btn-block" data-toggle="modal"
                                               data-target="#loginModal"><strong><?php echo trans("continue_to_checkout"); ?></strong></a>
                                        <?php else:
                                            if ($cart_has_physical_product == true && $this->form_settings->shipping == 1): ?>
                                                <a href="<?php echo generate_url("cart", "shipping"); ?>"
                                                   class="btn btn-block"><strong><?php echo trans("continue_to_checkout"); ?></strong></a>
                                            <?php else: ?>
                                                <a href="<?php echo generate_url("cart", "payment_method"); ?>"
                                                   class="btn btn-block"><strong><?php echo trans("continue_to_checkout"); ?></strong></a>
                                            <?php endif;
                                        endif;
                                    endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="shopping-cart-empty">
                        <p><strong class="font-600"><?php echo trans("your_cart_is_empty"); ?></strong></p>
                        <a href="<?php echo lang_base_url(); ?>" class="btn btn-lg btn-custom"><i
                                    class="icon-arrow-left"></i>&nbsp;<?php echo trans("shop_now"); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->