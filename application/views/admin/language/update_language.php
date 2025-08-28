<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header with-border">
                        <h3 class="card-title"><?php echo trans("update_language"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open_multipart('language_controller/update_language_post'); ?>

                    <input type="hidden" name="id" value="<?php echo html_escape($language->id); ?>">

                    <div class="card-body">
                        <!-- include message block -->
                        <?php $this->load->view('admin/includes/_messages'); ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label><?php echo trans("language_name"); ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans("language_name"); ?>"
                                    value="<?php echo $language->name; ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                    <small>(Örnek: Türkçe)</small>
                                </div>

                                <?php if ($language->short_form == "en"): ?>
                                    <div class="col-sm-4">
                                        <label class="control-label"><?php echo trans("short_form"); ?> </label>
                                        <input type="text" class="form-control" name="short_form" placeholder="<?php echo trans("short_form"); ?>"
                                        value="<?php echo $language->short_form; ?>" maxlength="200" readonly <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                        <small>(Örnek: tr)</small>
                                    </div>
                                <?php else: ?>
                                    <div class="col-sm-4">
                                        <label class="control-label"><?php echo trans("short_form"); ?> </label>
                                        <input type="text" class="form-control" name="short_form" placeholder="<?php echo trans("short_form"); ?>"
                                        value="<?php echo $language->short_form; ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                        <small>(Örnek: tr)</small>
                                    </div>
                                <?php endif; ?>
                                <div class="col-sm-4">
                                    <label class="control-label"><?php echo trans("language_code"); ?> </label>
                                    <input type="text" class="form-control" name="language_code" placeholder="<?php echo trans("language_code"); ?>"
                                    value="<?php echo $language->language_code; ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                    <small>(Örnek: tr_tr)</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label><?php echo trans('order'); ?></label>
                                    <input type="number" class="form-control" name="language_order" placeholder="<?php echo trans('order'); ?>"
                                    value="<?php echo $language->language_order; ?>" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="col-sm-4">
                                    <label><?php echo trans('text_editor_language'); ?></label>
                                    <select name="ckeditor_lang" class="form-control" required>
                                        <option value="af" <?php echo ($this->selected_lang->ckeditor_lang == 'af') ? 'selected' : ''; ?>>Afrikanca</option>
                                        <option value="sq" <?php echo ($this->selected_lang->ckeditor_lang == 'sq') ? 'selected' : ''; ?>>Arnavut</option>
                                        <option value="ar" <?php echo ($this->selected_lang->ckeditor_lang == 'ar') ? 'selected' : ''; ?>>Arapça</option>
                                        <option value="az" <?php echo ($this->selected_lang->ckeditor_lang == 'az') ? 'selected' : ''; ?>>Azerice</option>
                                        <option value="eu" <?php echo ($this->selected_lang->ckeditor_lang == 'eu') ? 'selected' : ''; ?>>Bask Dili</option>
                                        <option value="bn" <?php echo ($this->selected_lang->ckeditor_lang == 'bn') ? 'selected' : ''; ?>>Bengalce/Bangla</option>
                                        <option value="bs" <?php echo ($this->selected_lang->ckeditor_lang == 'bs') ? 'selected' : ''; ?>>Boşnakça</option>
                                        <option value="bg" <?php echo ($this->selected_lang->ckeditor_lang == 'bg') ? 'selected' : ''; ?>>Bulgarca</option>
                                        <option value="ca" <?php echo ($this->selected_lang->ckeditor_lang == 'ca') ? 'selected' : ''; ?>>Katalanca</option>
                                        <option value="zh-cn" <?php echo ($this->selected_lang->ckeditor_lang == 'zh-cn') ? 'selected' : ''; ?>>Basitleştirilmiş Çince</option>
                                        <option value="zh" <?php echo ($this->selected_lang->ckeditor_lang == 'zh') ? 'selected' : ''; ?>>Geleneksel Çince</option>
                                        <option value="hr" <?php echo ($this->selected_lang->ckeditor_lang == 'hr') ? 'selected' : ''; ?>>Hırvatca</option>
                                        <option value="cs" <?php echo ($this->selected_lang->ckeditor_lang == 'cs') ? 'selected' : ''; ?>>Çekce</option>
                                        <option value="da" <?php echo ($this->selected_lang->ckeditor_lang == 'da') ? 'selected' : ''; ?>>Danimarkaca</option>
                                        <option value="nl" <?php echo ($this->selected_lang->ckeditor_lang == 'nl') ? 'selected' : ''; ?>>Flemenkçe</option>
                                        <option value="en" <?php echo ($this->selected_lang->ckeditor_lang == 'en') ? 'selected' : ''; ?>>İngilizce</option>
                                        <option value="en-au" <?php echo ($this->selected_lang->ckeditor_lang == 'en-au') ? 'selected' : ''; ?>>İngilizce (Avustralya)</option>
                                        <option value="en-ca" <?php echo ($this->selected_lang->ckeditor_lang == 'en-ca') ? 'selected' : ''; ?>>İngilizce (Kanada)</option>
                                        <option value="en-gb" <?php echo ($this->selected_lang->ckeditor_lang == 'en-gb') ? 'selected' : ''; ?>>İngilizce (Birleşik Krallık)</option>
                                        <option value="eo" <?php echo ($this->selected_lang->ckeditor_lang == 'eo') ? 'selected' : ''; ?>>Esperanto</option>
                                        <option value="et" <?php echo ($this->selected_lang->ckeditor_lang == 'et') ? 'selected' : ''; ?>>Estonyaca</option>
                                        <option value="fo" <?php echo ($this->selected_lang->ckeditor_lang == 'fo') ? 'selected' : ''; ?>>Faroe Dili</option>
                                        <option value="fi" <?php echo ($this->selected_lang->ckeditor_lang == 'fi') ? 'selected' : ''; ?>>Fince</option>
                                        <option value="fr" <?php echo ($this->selected_lang->ckeditor_lang == 'fr') ? 'selected' : ''; ?>>Fransızca</option>
                                        <option value="fr-ca" <?php echo ($this->selected_lang->ckeditor_lang == 'fr-ca') ? 'selected' : ''; ?>>Fransızca (Canada)</option>
                                        <option value="gl" <?php echo ($this->selected_lang->ckeditor_lang == 'gl') ? 'selected' : ''; ?>>Galiçyaca</option>
                                        <option value="ka" <?php echo ($this->selected_lang->ckeditor_lang == 'ka') ? 'selected' : ''; ?>>Gürcüce</option>
                                        <option value="de" <?php echo ($this->selected_lang->ckeditor_lang == 'de') ? 'selected' : ''; ?>>Almanca</option>
                                        <option value="de-ch" <?php echo ($this->selected_lang->ckeditor_lang == 'de-ch') ? 'selected' : ''; ?>>Almanca (İsviçre)</option>
                                        <option value="el" <?php echo ($this->selected_lang->ckeditor_lang == 'el') ? 'selected' : ''; ?>>Yunanca</option>
                                        <option value="gu" <?php echo ($this->selected_lang->ckeditor_lang == 'gu') ? 'selected' : ''; ?>>Gujarati</option>
                                        <option value="he" <?php echo ($this->selected_lang->ckeditor_lang == 'he') ? 'selected' : ''; ?>>İbranice</option>
                                        <option value="hi" <?php echo ($this->selected_lang->ckeditor_lang == 'hi') ? 'selected' : ''; ?>>Hintçe</option>
                                        <option value="hu" <?php echo ($this->selected_lang->ckeditor_lang == 'hu') ? 'selected' : ''; ?>>Macarca</option>
                                        <option value="is" <?php echo ($this->selected_lang->ckeditor_lang == 'is') ? 'selected' : ''; ?>>İzlandaca</option>
                                        <option value="id" <?php echo ($this->selected_lang->ckeditor_lang == 'id') ? 'selected' : ''; ?>>Endonezyaca</option>
                                        <option value="it" <?php echo ($this->selected_lang->ckeditor_lang == 'it') ? 'selected' : ''; ?>>İtalyanca</option>
                                        <option value="ja" <?php echo ($this->selected_lang->ckeditor_lang == 'ja') ? 'selected' : ''; ?>>Japonca</option>
                                        <option value="km" <?php echo ($this->selected_lang->ckeditor_lang == 'km') ? 'selected' : ''; ?>>Kmer</option>
                                        <option value="ko" <?php echo ($this->selected_lang->ckeditor_lang == 'ko') ? 'selected' : ''; ?>>Korece</option>
                                        <option value="ku" <?php echo ($this->selected_lang->ckeditor_lang == 'ku') ? 'selected' : ''; ?>>Kürtçe</option>
                                        <option value="lv" <?php echo ($this->selected_lang->ckeditor_lang == 'lv') ? 'selected' : ''; ?>>Letonca</option>
                                        <option value="lt" <?php echo ($this->selected_lang->ckeditor_lang == 'lt') ? 'selected' : ''; ?>>Litvanyaca</option>
                                        <option value="mk" <?php echo ($this->selected_lang->ckeditor_lang == 'mk') ? 'selected' : ''; ?>>Makedonca</option>
                                        <option value="ms" <?php echo ($this->selected_lang->ckeditor_lang == 'ms') ? 'selected' : ''; ?>>Malayca</option>
                                        <option value="mn" <?php echo ($this->selected_lang->ckeditor_lang == 'mn') ? 'selected' : ''; ?>>Moğolca</option>
                                        <option value="no" <?php echo ($this->selected_lang->ckeditor_lang == 'no') ? 'selected' : ''; ?>>Norveççe</option>
                                        <option value="nb" <?php echo ($this->selected_lang->ckeditor_lang == 'nb') ? 'selected' : ''; ?>>Norveç Bokmal</option>
                                        <option value="oc" <?php echo ($this->selected_lang->ckeditor_lang == 'oc') ? 'selected' : ''; ?>>Oksitanca</option>
                                        <option value="fa" <?php echo ($this->selected_lang->ckeditor_lang == 'fa') ? 'selected' : ''; ?>>Farsça</option>
                                        <option value="pl" <?php echo ($this->selected_lang->ckeditor_lang == 'pl') ? 'selected' : ''; ?>>Lehçe</option>
                                        <option value="pt-br" <?php echo ($this->selected_lang->ckeditor_lang == 'pt-br') ? 'selected' : ''; ?>>Portekiz (Brezilya)</option>
                                        <option value="pt" <?php echo ($this->selected_lang->ckeditor_lang == 'pt') ? 'selected' : ''; ?>>Portekizce (Portekiz)</option>
                                        <option value="ro" <?php echo ($this->selected_lang->ckeditor_lang == 'ro') ? 'selected' : ''; ?>>Romence</option>
                                        <option value="ru" <?php echo ($this->selected_lang->ckeditor_lang == 'ru') ? 'selected' : ''; ?>>Rusça</option>
                                        <option value="sr" <?php echo ($this->selected_lang->ckeditor_lang == 'sr') ? 'selected' : ''; ?>>Sırpça (Kiril)</option>
                                        <option value="sr-latn" <?php echo ($this->selected_lang->ckeditor_lang == 'sr-latn') ? 'selected' : ''; ?>>Sırpça (Latin)</option>
                                        <option value="si" <?php echo ($this->selected_lang->ckeditor_lang == 'si') ? 'selected' : ''; ?>>Sinhala</option>
                                        <option value="sk" <?php echo ($this->selected_lang->ckeditor_lang == 'sk') ? 'selected' : ''; ?>>Slovakca</option>
                                        <option value="sl" <?php echo ($this->selected_lang->ckeditor_lang == 'sl') ? 'selected' : ''; ?>>Slovence</option>
                                        <option value="es" <?php echo ($this->selected_lang->ckeditor_lang == 'es') ? 'selected' : ''; ?>>İspanyolca</option>
                                        <option value="es-mx" <?php echo ($this->selected_lang->ckeditor_lang == 'es-mx') ? 'selected' : ''; ?>>İspanyolca (Meksika)</option>
                                        <option value="sv" <?php echo ($this->selected_lang->ckeditor_lang == 'sv') ? 'selected' : ''; ?>>İsveççe</option>
                                        <option value="tt" <?php echo ($this->selected_lang->ckeditor_lang == 'tt') ? 'selected' : ''; ?>>Tatarca</option>
                                        <option value="th" <?php echo ($this->selected_lang->ckeditor_lang == 'th') ? 'selected' : ''; ?>>Tayca</option>
                                        <option value="tr" <?php echo ($this->selected_lang->ckeditor_lang == 'tr') ? 'selected' : ''; ?>>Türkçe</option>
                                        <option value="ug" <?php echo ($this->selected_lang->ckeditor_lang == 'ug') ? 'selected' : ''; ?>>Uygurca</option>
                                        <option value="uk" <?php echo ($this->selected_lang->ckeditor_lang == 'uk') ? 'selected' : ''; ?>>Ukraynaca</option>
                                        <option value="vi" <?php echo ($this->selected_lang->ckeditor_lang == 'vi') ? 'selected' : ''; ?>>Vietnamca</option>
                                        <option value="cy" <?php echo ($this->selected_lang->ckeditor_lang == 'cy') ? 'selected' : ''; ?>>Galce</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label><?php echo trans('status'); ?></label>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 col-option">
                                            <input type="radio" name="status" value="1" id="status1" class="form-check-input" <?php echo ($language->status == "1") ? 'checked' : ''; ?>>&nbsp;&nbsp;
                                            <label for="status1" class="form-check-label"><?php echo trans('active'); ?></label>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 col-option">
                                            <input type="radio" name="status" value="0" id="status2" class="form-check-input" <?php echo ($language->status != "1") ? 'checked' : ''; ?>>&nbsp;&nbsp;
                                            <label for="status2" class="form-check-label"><?php echo trans('inactive'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('flag'); ?></label>
                            <div class="display-block mb-3">
                                <img src="<?php echo base_url() . $language->flag_path; ?>" alt=""/>
                            </div>
                            <div class="display-block">
                                <a class='btn-file-upload'>
                                    <input class="form-control" type="file" id="Multifileupload" name="file" size="40" accept=".png, .jpg, .jpeg, .gif">
                                </a>
                            </div>

                            <div id="MultidvPreview" class="image-preview"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary waves-effect btn-label waves-light">
                            <i class="bx bx-check label-icon"></i>
                            <?php echo trans('save_changes'); ?>
                        </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
</div>