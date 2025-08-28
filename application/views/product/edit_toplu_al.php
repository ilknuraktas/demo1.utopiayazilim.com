<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- File Manager -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-manager/file-manager.css">
<script src="<?php echo base_url(); ?>assets/vendor/file-manager/file-manager.js"></script>
<!-- Ckeditor js -->
<script src="<?php echo base_url(); ?>assets/vendor/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/ckeditor/lang/<?php echo $this->selected_lang->ckeditor_lang; ?>.js"></script>

<!-- Wrapper -->
<div id="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>

                <div class="form-add-product card" style="padding:2rem;">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-11">
                        <!--div class="row">
                            <div class="col-12">
                                <?php $this->load->view('product/_messages'); ?>
                            </div>
                        </div-->

                        <div class="row">
                            <div class="col-12">
                                <?php echo form_open('toplu-duzenle-post', ['id' => 'form_validate', 'class' => 'validate_price', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                                <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                                <?php if ($this->general_settings->physical_products_system == 1 && $this->general_settings->digital_products_system == 0): ?>
                                    <input type="hidden" name="product_type" value="physical">
                                <?php elseif ($this->general_settings->physical_products_system == 0 && $this->general_settings->digital_products_system == 1): ?>
                                    <input type="hidden" name="product_type" value="digital">

                                    <?php endif; ?>






                                    <div class="form-box">
                                        <div class="form-box-head">
                                            <h4 class="title">Trend Ürün</h4>
                                        </div>
                                       <div class="row">
                                           <div class="col-lg-6">
                                               <div class="form-box-body alert alert-info alert-dismissible fade show mb-0">
                                                   <div class="form-group">
                                                       <label class="control-label">Alınacak Ürün Sayısı</label>
                                                       <div class="selectdiv">
                                                           <input type="text" name="alinacak" value="<?= $product->alinacak_miktar  ?>" class="form-control">
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-lg-6">
                                               <div class="form-box-body alert alert-info alert-dismissible fade show mb-0">
                                                   <div class="form-group">
                                                       <label class="control-label">Ödenecek Ürün Sayısı</label>
                                                       <div class="selectdiv">
                                                           <input type="text" name="odenecek" value="<?= $product->odenecek_miktar  ?>" class="form-control">
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                    </div>





                                <div class="form-group">
                                    <?php if ($product->is_draft == 1): ?>
                                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-check-double label-icon"></i> <?php echo trans("save_and_continue"); ?></button>
                                    <?php else: ?>

                                        <button type="submit" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx-check-double label-icon"></i> <?php echo trans("save_changes"); ?></button>
                                    <?php endif; ?>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->

<script>
    function get_subcategories(category_id, data_select_id) {
        var subcategories = get_subcategories_array(category_id);
        var date = new Date();
        //reset subcategories
        $('.subcategory-select').each(function () {
            if (parseInt($(this).attr('data-select-id')) > parseInt(data_select_id)) {
                $(this).remove();
            }
        });
        if (category_id == 0) {
            return false;
        }
        if (subcategories.length > 0) {
            var new_data_select_id = date.getTime();
            var select_tag = '<div class="selectdiv m-t-5"><select class="form-control subcategory-select" data-select-id="' + new_data_select_id + '" name="category_id_' + new_data_select_id + '" required onchange="get_subcategories(this.value,' + new_data_select_id + ');">' +
            '<option value=""><?php echo trans("select_category"); ?></option>';
            for (i = 0; i < subcategories.length; i++) {
                select_tag += '<option value="' + subcategories[i].id + '">' + subcategories[i].name + '</option>';
            }
            select_tag += '</select></div>';
            $('#subcategories_container').append(select_tag);
        }
        //remove empty selectdivs
        $(".selectdiv").each(function () {
            if ($(this).children('select').length == 0) {
                $(this).remove();
            }
        });
    }

    function get_subcategories_array(category_id) {
        var categories_array = <?php echo get_categories_json($this->selected_lang->id); ?>;
        var subcategories_array = [];
        for (i = 0; i < categories_array.length; i++) {
            if (categories_array[i].parent_id == category_id) {
                subcategories_array.push(categories_array[i]);
            }
        }
        return subcategories_array;
    }
</script>

<?php $this->load->view("product/_file_manager_ckeditor"); ?>

<!-- Ckeditor -->
<script>
    var ckEditor = document.getElementById('ckEditor');
    if (ckEditor != undefined && ckEditor != null) {
        CKEDITOR.replace('ckEditor', {
            language: '<?php echo $this->selected_lang->ckeditor_lang; ?>',
            filebrowserBrowseUrl: 'path',
            removeButtons: 'Save',
            allowedContent: true,
            extraPlugins: 'videoembed,oembed'
        });
    }

    function selectFile(fileUrl) {
        window.opener.CKEDITOR.tools.callFunction(1, fileUrl);
    }

    CKEDITOR.on('dialogDefinition', function (ev) {
        var editor = ev.editor;
        var dialogDefinition = ev.data.definition;

        // This function will be called when the user will pick a file in file manager
        var cleanUpFuncRef = CKEDITOR.tools.addFunction(function (a) {
            $('#ckFileManagerModal').modal('hide');
            CKEDITOR.tools.callFunction(1, a, "");
        });
        var tabCount = dialogDefinition.contents.length;
        for (var i = 0; i < tabCount; i++) {
            var browseButton = dialogDefinition.contents[i].get('browse');
            if (browseButton !== null) {
                browseButton.onClick = function (dialog, i) {
                    editor._.filebrowserSe = this;
                    var iframe = $('#ckFileManagerModal').find('iframe').attr({
                        src: editor.config.filebrowserBrowseUrl + '&CKEditor=body&CKEditorFuncNum=' + cleanUpFuncRef + '&langCode=en'
                    });
                    $('#ckFileManagerModal').appendTo('body').modal('show');
                }
            }
        }
    });

    CKEDITOR.on('instanceReady', function (evt) {
        $(document).on('click', '.btn_ck_add_image', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('image');
            }
        });
        $(document).on('click', '.btn_ck_add_video', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('videoembed');
            }
        });
        $(document).on('click', '.btn_ck_add_iframe', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('iframe');
            }
        });
    });
</script>
