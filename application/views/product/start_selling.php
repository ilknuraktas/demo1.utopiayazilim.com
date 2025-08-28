<?php defined('BASEPATH') OR exit('No direct script access allowed');
$vergi1 = $this->db->query("SELECT * FROM evrak WHERE id=1");
$vergi = $vergi1->row();
$imza1 = $this->db->query("SELECT * FROM evrak WHERE id=2");
$imza = $imza1->row();
$nufus1 = $this->db->query("SELECT * FROM evrak WHERE id=3");
$nufus = $nufus1->row();
$magaza1 = $this->db->query("SELECT * FROM evrak WHERE id=4");
$magaza = $magaza1->row();
$satici1 = $this->db->query("SELECT * FROM evrak WHERE id=5");
$satici = $satici1->row();
$gizlilik1 = $this->db->query("SELECT * FROM evrak WHERE id=6");
$gizlilik = $gizlilik1->row();
$users = $this->db->query("SELECT * FROM users WHERE id=" . $_SESSION['modesy_sess_user_id']);
$user = $users->row();
?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
                <h1 class="page-title page-title-product m-b-15"><?php echo trans("start_selling"); ?></h1>
                <div class="form-add-product card" style="padding:2rem;" >
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-10">
                            <div class="row">
                                <div class="col-12">
                                    <p class="start-selling-description"><?php echo trans("start_selling_exp"); ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php $this->load->view('product/_messages'); ?>
                                </div>
                            </div>
<!--                            --><?php //if ($this->auth_check):
//                                if ($this->auth_user->is_active_shop_request == 1):?>
<!--                                    <div class="row">-->
<!--                                        <div class="col-12">-->
<!--                                            <div class="alert alert-info" role="alert">-->
<!--                                                --><?php //echo trans("msg_shop_opening_requests"); ?>
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                --><?php //elseif ($this->auth_user->is_active_shop_request == 2): ?>
<!--                                    <div class="row">-->
<!--                                        <div class="col-12">-->
<!--                                            <div class="alert alert-secondary" role="alert">-->
<!--                                                --><?php //echo trans("msg_shop_request_declined"); ?>
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                --><?php //else: ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <?php echo form_open_multipart('start-selling-post', ['id' => 'form_validate', 'class' => 'validate_terms', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                                            <input type="hidden" name="id" value="<?php echo $this->auth_user->id; ?>">
                                            <div class="form-box m-b-15">
                                                <div class="form-box-head text-center">
                                                    <h4 class="title title-start-selling-box"><?php echo trans('tell_us_about_shop'); ?></h4>
                                                </div>
                                                <div class="form-box-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-6 m-b-15">
                                                                <label class="control-label"><?php echo trans("shop_name"); ?></label>
                                                                <input type="text" name="shop_name"
                                                                       class="form-control form-input"
                                                                       value="<?php echo $this->auth_user->username; ?>"
                                                                       placeholder="<?php echo trans("shop_name"); ?>"
                                                                       maxlength="<?php echo $this->username_maxlength; ?>"
                                                                       required>
                                                            </div>
                                                            <div class="col-12 col-sm-6 m-b-15">
                                                                <label class="control-label"><?php echo trans("phone_number"); ?></label>
                                                                <input type="text" name="phone_number"
                                                                       class="form-control form-input"
                                                                       value="<?php echo html_escape($this->auth_user->phone_number); ?>"
                                                                       placeholder="<?php echo trans("phone_number"); ?>">
                                                            </div>
                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                <label class="control-label"><?php echo trans('country'); ?></label>
                                                                <div class="selectdiv">
                                                                    <select id="select_countries" name="country_id"
                                                                            class="form-control"
                                                                            onchange="get_states(this.value, false);" required>
                                                                        <option value=""><?php echo trans('select'); ?></option>
                                                                        <?php foreach ($this->countries as $item): ?>
                                                                            <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $this->auth_user->country_id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                <label class="control-label"><?php echo trans('state'); ?></label>
                                                                <div class="selectdiv">
                                                                    <select id="select_states" name="state_id"
                                                                            class="form-control"
                                                                            onchange="get_cities(this.value, false);">
                                                                        <option value=""><?php echo trans('select'); ?></option>
                                                                        <?php
                                                                        if (!empty($this->auth_user->country_id)) {
                                                                            $states = get_states_by_country($this->auth_user->country_id);
                                                                        }
                                                                        if (!empty($states)):
                                                                            foreach ($states as $item): ?>
                                                                                <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $this->auth_user->state_id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                                            <?php endforeach;
                                                                        endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                <label class="control-label"><?php echo trans("city"); ?></label>
                                                                <input type="text" name="ilce" class="form-control form-input"
                                                                       value="" placeholder="<?php echo trans("city"); ?>">
                                                            </div>
                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                <label class="control-label">Vergi Dairesi</label>
                                                                <input type="text" name="vergi_dairesi"
                                                                       class="form-control form-input" value=""
                                                                       placeholder="Vergi Dairesi">
                                                            </div>
                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                <label class="control-label">Vergi Numarası</label>
                                                                <input type="text" name="vergi_no"
                                                                       class="form-control form-input" value=""
                                                                       placeholder="Vergi Numarası">
                                                            </div>
                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                <label class="control-label">Kep Adresi</label>
                                                                <input type="text" name="kep_adresi"
                                                                       class="form-control form-input" value=""
                                                                       placeholder="orn@orn.kep.tr">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label"><?php echo trans("shop_description"); ?></label>
                                                        <textarea name="about_me" class="form-control form-textarea"
                                                                  placeholder="<?php echo trans("shop_description"); ?>"><?php echo old('about_me'); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row m-b-15">
                                                <div class="col-12">
                                                    <div class="form-box-head text-center">
                                                        <h4 class="title title-start-selling-box">Gerekli Evrak ve Sözleşmeleri
                                                            Yükleyin</h4>
                                                    </div>
                                                    <div class="table-responsive card">
                                                        <table class="table table-orders table-striped bordered">
                                                            <thead style="text-align: center;">
                                                            <tr>
                                                                <th width="30%">Gereken Evraklar</th>
                                                                <th width="30%">Yükleme Tarihi</th>
                                                                <th width="20%">Durum</th>
                                                                <th width="20%">Yükleme</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>Vergi Levhası</td>

                                                                <td style="text-align: center;"><?= $user->vergi_date ?></td>
                                                                <?php if ($user->vergi == null || $user->vergi == ''): ?>
                                                                    <td style="color: #74788d;text-align: center;font-weight: 900!important;">Yüklenmedi</td>
                                                                <?php elseif ($user->vergi_access == 5): ?>
                                                                    <td style="color: #33a186;text-align: center;font-weight: 900!important;">Onaylandı</td>
                                                                <?php elseif ($user->vergi_access == 3): ?>
                                                                    <td style="color: #fa6374;text-align: center;font-weight: 900!important">Reddedildi</td>
                                                                <?php else: ?>
                                                                    <td style="color: #fc931d;text-align: center;;font-weight: 900!important">Onay Bekliyor
                                                                    </td>

                                                                <?php endif; ?>

                                                                <td style="text-align: center;">
                                                                    <?php if ($user->vergi_access != 5  && $user->vergi_access !=1): ?>
                                                                    <input type="file" id="myFile" name="vergi">
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>İmza Beyannamesi veya Sirküleri</td>

                                                                <td style="text-align: center;"><?= $user->imza_date ?></td>
                                                                <?php if ($user->imza == null || $user->imza == ''): ?>
                                                                    <td style="color: #74788d;text-align: center;font-weight: 900!important;">Yüklenmedi</td>
                                                                <?php elseif ($user->imza_access == 5): ?>
                                                                    <td style="color: #33a186;text-align: center;font-weight: 900!important;">Onaylandı</td>
                                                                <?php elseif ($user->imza_access == 3): ?>
                                                                    <td style="color: #fa6374;text-align: center;font-weight: 900!important">Reddedildi</td>
                                                                <?php else: ?>
                                                                    <td style="color: #fc931d;text-align: center;;font-weight: 900!important">Onay Bekliyor
                                                                    </td>

                                                                <?php endif; ?>
                                                                <td style="text-align: center;">
                                                                    <?php if ($user->imza_access != 5 && $user->imza_access !=1): ?>
                                                                    <input type="file" id="myFile" name="imza">
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Nüfus Cüzdanı</td>

                                                                <td style="text-align: center;"><?= $user->nufus_date ?></td>
                                                                <?php if ($user->nufus == null || $user->nufus == ''): ?>
                                                                    <td style="color: #74788d;text-align: center;font-weight: 900!important;">Yüklenmedi</td>
                                                                <?php elseif ($user->nufus_access == 5): ?>
                                                                    <td style="color: #33a186;text-align: center;font-weight: 900!important;">Onaylandı</td>
                                                                <?php elseif ($user->nufus_access == 3): ?>
                                                                    <td style="color: #fa6374;text-align: center;font-weight: 900!important">Reddedildi</td>
                                                                <?php else: ?>
                                                                    <td style="color: #fc931d;text-align: center;;font-weight: 900!important">Onay Bekliyor
                                                                    </td>

                                                                <?php endif; ?>
                                                                <td style="text-align: center;">
                                                                    <?php if ($user->nufus_access != 5 && $user->nufus_access !=1): ?>
                                                                    <input type="file" id="myFile" name="nufus">
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="table-responsive card">
                                                        <table class="table table-orders table-striped bordered">
                                                            <thead style="text-align: center;">
                                                            <tr>
                                                                <th width="30%">Sözleşme Adı</th>
                                                                <th width="15%">Sözleşmeyi İndir</th>
                                                                <th width="15%">Yükleme Tarihi</th>
                                                                <th width="20%">Durum</th>
                                                                <th width="20%">Yükleme</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>Mağaza Sözleşmesi</td>
                                                                <td style="text-align: center;"><a
                                                                            href="/evrak/<?= $magaza->file ?>" download>Sözleşmeyi
                                                                        İndir</a></td>
                                                                <td style="text-align: center;"><?= $user->magaza_date ?></td>
                                                                <?php if ($user->magaza_sozlesmesi == null || $user->magaza_sozlesmesi == ''): ?>
                                                                    <td style="color: #74788d;text-align: center;font-weight: 900!important;">Yüklenmedi</td>
                                                                <?php elseif ($user->magaza_sozlesmesi_access == 5): ?>
                                                                    <td style="color: #33a186;text-align: center;font-weight: 900!important;">Onaylandı</td>
                                                                <?php elseif ($user->magaza_sozlesmesi_access == 3): ?>
                                                                    <td style="color: #fa6374;text-align: center;font-weight: 900!important">Reddedildi</td>
                                                                <?php else: ?>
                                                                    <td style="color: #fc931d;text-align: center;;font-weight: 900!important">Onay Bekliyor
                                                                    </td>

                                                                <?php endif; ?>
                                                                <td style="text-align: center;">
                                                                    <?php if ($user->magaza_sozlesmesi_access != 5 && $user->magaza_sozlesmesi_access !=1): ?>
                                                                    <input type="file" id="myFile" name="magaza_sozlesmesi">
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Satıcı Sözleşmesi</td>
                                                                <td style="text-align: center;"><a
                                                                            href="/evrak/<?= $satici->file ?>" download>Sözleşmeyi
                                                                        İndir</a></td>
                                                                <td style="text-align: center;"><?= $user->satici_date ?></td>
                                                                <?php if ($user->satici_sozlesmesi == null || $user->satici_sozlesmesi == ''): ?>
                                                                    <td style="color: #74788d;text-align: center;font-weight: 900!important;">Yüklenmedi</td>
                                                                <?php elseif ($user->satici_sozlesmesi_access == 5): ?>
                                                                    <td style="color: #33a186;text-align: center;font-weight: 900!important;">Onaylandı</td>
                                                                <?php elseif ($user->satici_sozlesmesi_access == 3): ?>
                                                                    <td style="color: #fa6374;text-align: center;font-weight: 900!important">Reddedildi</td>
                                                                <?php else: ?>
                                                                    <td style="color: #fc931d;text-align: center;;font-weight: 900!important">Onay Bekliyor
                                                                    </td>

                                                                <?php endif; ?>
                                                                <td style="text-align: center;">
                                                                    <?php if ($user->satici_sozlesmesi_access != 5 && $user->satici_sozlesmesi_access !=1): ?>
                                                                    <input type="file" id="myFile" name="satici_sozlesmesi">
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gizlilik Sözleşmesi</td>
                                                                <td style="text-align: center;"><a
                                                                            href="/evrak/<?= $gizlilik->file ?>" download>Sözleşmeyi
                                                                        İndir</a></td>
                                                                <td style="text-align: center;"><?= $user->gizlilik_date ?></td>
                                                                <?php if ($user->gizlilik_sozlesmesi == null || $user->gizlilik_sozlesmesi == ''): ?>
                                                                    <td style="color: #74788d;text-align: center;font-weight: 900!important;">Yüklenmedi</td>
                                                                <?php elseif ($user->gizlilik_sozlesmesi_access == 5): ?>
                                                                    <td style="color: #33a186;text-align: center;font-weight: 900!important;">Onaylandı</td>
                                                                <?php elseif ($user->gizlilik_sozlesmesi_access == 3): ?>
                                                                    <td style="color: #fa6374;text-align: center;font-weight: 900!important">Reddedildi</td>
                                                                <?php else: ?>
                                                                    <td style="color: #fc931d;text-align: center;;font-weight: 900!important">Onay Bekliyor
                                                                    </td>

                                                                <?php endif; ?>
                                                                <td style="text-align: center;">
                                                                    <?php if ($user->gizlilik_sozlesmesi_access != 5 && $user->gizlilik_sozlesmesi_access !=1): ?>
                                                                    <input type="file" id="myFile" name="gizlilik_sozlesmesi">
                                                                    <?php endif; ?>
                                                                    <form action="#">
                                                                        <input  type="hidden" id="myFile" name="22">
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <span>**Lütfen listede yer alan sözleşmeleri indirdikten sonra, şirket yetkilisi tarafından kaşe ve imza yapıp tekrar yükleyiniz.</span>
                                                </div>
                                            </div>
                                            <div class="form-group m-t-15">
                                                <div class="custom-control custom-checkbox custom-control-validate-input">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="terms_conditions" id="terms_conditions" value="1" required>
                                                    <?php $page_terms_condition = get_page_by_default_name("terms_conditions", $this->selected_lang->id); ?>
                                                    <label for="terms_conditions"
                                                           class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>
                                                        &nbsp;<a
                                                                href="<?php echo lang_base_url() . $page_terms_condition->slug; ?>"
                                                                class="link-terms"
                                                                target="_blank"><strong><?php echo html_escape($page_terms_condition->title); ?></strong></a></label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit"
                                                        class="btn btn-lg btn-custom float-right"><?php echo trans("submit"); ?></button>
                                            </div>

                                            <?php echo form_close(); ?>
            </div>
<!--        --><?php //endif;
//    endif; ?>

</div>
</div>
</div>
</div>
</div>
</div>
</div>