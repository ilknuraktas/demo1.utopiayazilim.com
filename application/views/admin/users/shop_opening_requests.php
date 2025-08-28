<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="layout-wrapper">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header with-border">
                <div class="left">
                    <h3 class="card-title"><?php echo trans('shop_opening_requests'); ?></h3>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th><?php echo trans('username'); ?></th>
                                        <th><?php echo trans('email'); ?></th>
                                        <th><?php echo trans('phone_number'); ?></th>
                                        <th>İmza Beyannamesi</th>
                                        <th>Vergi Levhası</th>
                                        <th>Nufus Cüzdanı</th>
                                        <th>Mağaza Sözlesmesi</th>
                                        <th>Satıcı Sözlesmesi</th>
                                        <th>Gizlilik Sözlesmesi</th>
                                        <th><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $user): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-link"><?php echo html_escape($user->username); ?></a>
                                            </td>
                                            <td>
                                                <?php echo html_escape($user->email);
                                                if ($user->email_status == 1): ?>
                                                    <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                                <?php else: ?>
                                                    <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo html_escape($user->phone_number); ?></td>
                                            <td>
                                                <?php
                                                if (isset($user->vergi) && $user->vergi!= null && $user->vergi!= ''):
                                                    echo form_open('admin_controller/vergi_aktif'); ?>
                                                    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                                    <div class="btn-group">
                                                        <button id="btnGroupDrop1" class="btn btn-warning waves-effect btn-label waves-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                            <?php echo trans('select_option'); ?>
                                                            <i class="bx bx-brightness label-icon"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <li>
                                                                <a class="dropdown-item" href="/evrak/uploads/<?= $user->vergi  ?>" download="">
                                                                    İndir
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button type="submit" name="submit" value="1" class="dropdown-item">
                                                                    <?php echo trans('approve'); ?>
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="submit" name="submit" value="0" class="dropdown-item">
                                                                    <?php echo trans('decline'); ?>
                                                                </button>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <?php  echo form_close(); endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (isset($user->imza) && $user->imza!= null && $user->imza!= ''):
                                                        echo form_open('admin_controller/imza_aktif'); ?>
                                                        <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                                        <div class="btn-group">
                                                            <button id="btnGroupDrop1" class="btn btn-warning waves-effect btn-label waves-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                                <?php echo trans('select_option'); ?>
                                                                <i class="bx bx-brightness label-icon"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li>
                                                                    <a class="dropdown-item" href="/evrak/uploads/<?= $user->imza  ?>" download="">
                                                                        İndir
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" type="submit" name="submit" value="1">
                                                                        <?php echo trans('approve'); ?>
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" type="submit" name="submit" value="0">
                                                                     <?php echo trans('decline'); ?>
                                                                 </button>
                                                             </li>

                                                         </ul>
                                                     </div>
                                                     <?php  echo form_close(); endif; ?>
                                                 </td>
                                                 <td>
                                                     <?php
                                                     if (isset($user->nufus) && $user->nufus!= null && $user->nufus!= ''):
                                                        echo form_open('admin_controller/nufus_aktif'); ?>
                                                        <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                                        <div class="btn-group">
                                                            <button id="btnGroupDrop1" class="btn btn-warning waves-effect btn-label waves-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                                <?php echo trans('select_option'); ?>
                                                                <i class="bx bx-brightness label-icon"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li>
                                                                    <a class="dropdown-item" href="/evrak/uploads/<?= $user->nufus  ?>" download="">
                                                                        İndir
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" type="submit" name="submit" value="1">
                                                                        <?php echo trans('approve'); ?>
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button class="dropdown-item" type="submit" name="submit" value="0">
                                                                        <?php echo trans('decline'); ?>
                                                                    </button>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <?php  echo form_close(); endif; ?>
                                                    </td>

                                                    <td>
                                                     <?php
                                                     if (isset($user->magaza_sozlesmesi) && $user->magaza_sozlesmesi!= null && $user->magaza_sozlesmesi!= ''):
                                                        echo form_open('admin_controller/magaza_aktif'); ?>
                                                        <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                                        <div class="btn-group">
                                                            <button id="btnGroupDrop1" class="btn btn-warning waves-effect btn-label waves-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                                <?php echo trans('select_option'); ?>
                                                                <i class="bx bx-brightness label-icon"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                <li>
                                                                    <a class="dropdown-item" href="/evrak/uploads/<?= $user->magaza_sozlesmesi  ?>" download="">
                                                                       İndir
                                                                   </a>
                                                               </li>
                                                               <li>
                                                                <button class="dropdown-item" type="submit" name="submit" value="1">
                                                                   <?php echo trans('approve'); ?>
                                                               </button>
                                                           </li>
                                                           <li>
                                                            <button class="dropdown-item" type="submit" name="submit" value="0">
                                                               <?php echo trans('decline'); ?>
                                                           </button>
                                                       </li>

                                                   </ul>
                                               </div>
                                               <?php  echo form_close(); endif; ?>
                                           </td>
                                           <td>
                                             <?php
                                             if (isset($user->satici_sozlesmesi) && $user->satici_sozlesmesi!= null && $user->satici_sozlesmesi!= ''):
                                                echo form_open('admin_controller/satici_aktif'); ?>
                                                <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                                <div class="btn-group">
                                                    <button id="btnGroupDrop1" class="btn btn-warning waves-effect btn-label waves-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                        <?php echo trans('select_option'); ?>
                                                        <i class="bx bx-brightness label-icon"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <li>
                                                            <a class="dropdown-item" href="/evrak/uploads/<?= $user->satici_sozlesmesi  ?>" download="">
                                                                İndir
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item" type="submit" name="submit" value="1">
                                                                <?php echo trans('approve'); ?>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item" type="submit" name="submit" value="0">
                                                                <?php echo trans('decline'); ?>
                                                            </button>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <?php  echo form_close(); endif; ?>
                                            </td>
                                            <td>
                                             <?php
                                             if (isset($user->gizlilik_sozlesmesi) && $user->gizlilik_sozlesmesi!= null && $user->gizlilik_sozlesmesi!= ''):
                                                echo form_open('admin_controller/gizlilik_aktif'); ?>
                                                <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                                <div class="btn-group">
                                                    <button id="btnGroupDrop1" class="btn btn-warning waves-effect btn-label waves-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                        <?php echo trans('select_option'); ?>
                                                        <i class="bx bx-brightness label-icon"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <li>
                                                            <a class="dropdown-item" href="/evrak/uploads/<?= $user->gizlilik_sozlesmesi  ?>" download="">
                                                             İndir
                                                         </a>
                                                     </li>
                                                     <li>
                                                        <button class="dropdown-item" type="submit" name="submit" value="1">
                                                            <?php echo trans('approve'); ?>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" type="submit" name="submit" value="0">
                                                            <?php echo trans('decline'); ?>
                                                        </button>
                                                    </li>

                                                </ul>
                                            </div>
                                            <?php  echo form_close(); endif; ?>
                                        </td>
                                        <td>
                                            <?php echo form_open('admin_controller/approve_shop_opening_request'); ?>
                                            <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                            <div class="btn-group">
                                                <button id="btnGroupDrop1" class="btn btn-primary waves-effect btn-label waves-light btn-sm" type="button" data-bs-toggle="dropdown">
                                                    <?php echo trans('select_option'); ?>
                                                    <i class="bx bx-brightness label-icon"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <li>
                                                        <button class="dropdown-item" type="submit" name="submit" value="1">
                                                            <?php echo trans('approve'); ?>
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item" type="submit" name="submit" value="0">
                                                            <?php echo trans('decline'); ?>
                                                        </button>
                                                    </li>

                                                </ul>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div>
</div>
</div>

<?php if (!empty($this->session->userdata('mds_send_email_data'))): ?>
    <script>
        $(document).ready(function () {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data"));?>);
            if (data) {
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "ajax_controller/send_email",
                    data: data,
                    success: function (response) {
                    }
                });
            }
        });
    </script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>
