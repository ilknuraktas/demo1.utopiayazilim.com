<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div id="wrapper">
    <div class="container-fluid">
        <div class="col-sm-12 col-md-12">

            <div class="row">
                <div class="col-lg-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Toplu Ürün Yükleme</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/magazam">Panel</a></li>
                                <li class="breadcrumb-item active">Toplu Ürün Yükleme</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card-group">

                    <!-- Toplu ürün Verileri -->
                    <div class="col-lg-4 card border border-primary" style="margin: 10px;">
                        <div class="p-3">
                            <h5 class="my-0 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 32 38">
                                    <g fill="none" fill-rule="evenodd">
                                        <path fill="#5794FF" d="M30 0c1.105 0 2 .895 2 2v30c0 1.105-.895 2-2 2H2c-1.105 0-2-.895-2-2V2C0 .895.895 0 2 0h28zm0 2H2v30h28V2zM4 32h24v2H4v-2z"/>
                                        <circle cx="5" cy="5" r="1" fill="#5794FF"/>
                                        <circle cx="9" cy="5" r="1" fill="#5794FF"/>
                                        <circle cx="13" cy="5" r="1" fill="#5794FF"/>
                                        <path fill="#5794FF" d="M2 8H30V10H2z"/>
                                        <circle cx="16" cy="25" r="8" stroke="#5794FF" stroke-width="2"/>
                                        <rect width="2" height="9" x="23" y="29" fill="#5794FF" rx="1" transform="rotate(-45 24 33.5)"/>
                                    </g>
                                </svg>
                            Toplu Ürün Verileri</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Bu alandan, Excel dosyasına girmeniz gereken zorunlu alanlara ait ID bilgilerini öğrenebilirsiniz.</p>
                            <h5 class="card-title">
                                <a href="/toplu_veri" class="text-primary hstack" target="_blank">
                                    <button type="button" class="btn btn-primary waves-effect btn-label waves-light"><i class="bx bx-link-alt label-icon"></i> Toplu Ürün Verilerine Git</button>
                                </a>
                            </h5>
                            <p class="card-text">ID bilgilerini doğru kopyaladığınıza emin olun.</p>
                        </div>
                    </div>
                    
                    <!-- Excel Şablonu -->
                    <div class="col-lg-4 card border border-success" style="margin: 10px;">
                        <div class="p-3">
                            <h5 class="my-0 text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 32 38">
                                    <g fill="none" fill-rule="evenodd">
                                        <path fill="#0EAD68" d="M2 0h28a2 2 0 0 1 2 2v30a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 2v30h28V2H2zm8 30h12v2H10v-2z"/>
                                        <path stroke="#0EAD68" stroke-width="2" d="M5 5h22v15H5z"/>
                                        <path fill="#D8D8D8" stroke="#0EAD68" d="M11.5 5.5h1v14h-1zM19.5 5.5h1v14h-1z"/>
                                        <path fill="#D8D8D8" stroke="#0EAD68" d="M5.5 14.5h21v1h-21zM5.5 9.5h21v1h-21z"/>
                                        <rect width="28" height="2" x="2" y="36" fill="#0EAD68" rx="1"/>
                                        <path fill="#0EAD68" d="M16.018 34a1.02 1.02 0 0 1-.036 0 1.032 1.032 0 0 1-.75-.303l-2.929-2.93a1.036 1.036 0 1 1 1.465-1.464L15 30.536V24a1 1 0 0 1 2 0v6.536l1.232-1.233a1.036 1.036 0 1 1 1.465 1.465l-2.93 2.929c-.206.206-.478.307-.75.303z"/>
                                    </g>
                                </svg>
                            Yüklemek İçin Şablon İndir</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Ürünlerinizi toplu bir şekilde ekleyebilmek için örnek excel dosyamızı indirin.</p>
                            <h5 class="card-title">
                                <a href="/uploads/document/toplu-urun.xlsx" class="text-success hstack" download="">
                                    <button type="button" class="btn btn-success waves-effect btn-label waves-light"><i class="bx bx bx-download label-icon"></i> Örnek Excel Dosyasını İndir</button>
                                </a>
                            </h5>
                            <p class="card-text">Zorunlu alanları eksiksiz doldurduğunuza emin olun.</p>
                        </div>
                    </div>
                    
                    <!-- Excel Yükleme -->
                    <div class="col-lg-4 card border border-warning" style="margin: 10px;">
                        <div class="p-3">
                            <h5 class="my-0 text-warning">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 32 34">
                                    <g fill="none" fill-rule="evenodd">
                                        <path fill="#F27A1A" d="M2 0h28a2 2 0 0 1 2 2v30a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 2v30h28V2H2zm8 30h12v2H10v-2z"/>
                                        <circle cx="5" cy="5" r="1" fill="#F27A1A"/>
                                        <circle cx="9" cy="5" r="1" fill="#F27A1A"/>
                                        <circle cx="13" cy="5" r="1" fill="#F27A1A"/>
                                        <path fill="#F27A1A" d="M2 8h28v2H2z"/>
                                        <rect width="20" height="2" x="6" y="18" fill="#F27A1A" rx="1"/>
                                        <path fill="#F27A1A" d="M15.982 22a1.02 1.02 0 0 1 .036 0c.27-.004.543.097.75.303l2.929 2.93a1.036 1.036 0 1 1-1.465 1.464L17 25.464V33a1 1 0 0 1-2 0v-7.536l-1.232 1.233a1.036 1.036 0 1 1-1.465-1.465l2.93-2.929c.206-.206.478-.307.75-.303z"/>
                                    </g>
                                </svg>
                            Hazırladığın Excel'i Yükle</h5>
                        </div>
                        <div class="card-body">

                            <h5 class="card-title">
                                <?php echo form_open_multipart('/excel/test.php'); ?>
                                <div class="form-group">
                                    <input type="file" name="upload_file" class="form-control auth-form-input" required="">
                                </div>
                                <input type="hidden" value="<?php echo $_SESSION['modesy_sess_user_id'] ?>" name="id">
                                <div class="form-group d-grid">
                                    <button type="submit" class="btn btn-warning mt-3">İçeri Aktar</button>
                                </div>
                                <?php echo form_close(); ?>
                            </h5>
                            <p class="card-text">Yüklemek için seçtiğiniz dosya şablonu, yükleme tipine uygun olmalıdır.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>