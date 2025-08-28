<div class="modal modal-top fade" id="modalTop" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTopTitle">Genel Bilgiler</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="collapse show">
          <table class="table table-hover">
            <tbody class="table-border-bottom-0">
              <tr>
                <th>Yazılım Sürümü</th>
                <td>v<?= file_get_contents('include/v.txt') ?></td>
              </tr>
              <tr>
                <th>Gelecek Sürümü</th>
                <td>v<?= v4Admin::gelecekSurum() ?> (%<?= v4Admin::gelecekOran() ?>)</td>
              </tr>
              <tr>
                <th>Serial No</th>
                <td><?= $serial ?></td>
              </tr>
              <tr>
                <th>Local IP</th>
                <td><?= $_SERVER['SERVER_ADDR'] ?></td>
              </tr>
              <tr>
                <th>Kullanıcı IP</th>
                <td><?= $_SERVER['REMOTE_ADDR'] ?></td>
              </tr>
              <tr>
                <th>PHP Sürümü</th>
                <td>v<?= phpversion() ?></td>
              </tr>
              <tr>
                <th>Memory Limit</th>
                <td><?= ini_get('memory_limit') ?></td>
              </tr>
              <tr>
                <th>Upload Limit</th>
                <td><?= (min((ini_get('post_max_size')), (ini_get('upload_max_filesize')))) ?></td>
              </tr>
              <tr>
                <th>Timeout</th>
                <td><?= ini_get('max_execution_time') ?> Saniye</td>
              </tr>
              <tr>
                <th>SOAP</th>
                <td><?= (class_exists("SOAPClient") ? 'Aktif' : 'Pasif') ?></td>
              </tr>
              <tr>
                <th>Allow URL Fopen</th>
                <td><?= (ini_get('allow_url_fopen') ? 'Aktif' : 'Pasif') ?></td>
              </tr>
              <tr>
                <th>cURL</th>
                <td>v<?= curl_version()['version']; ?></td>
              </tr>
              <tr>
                <th>GD Library</th>
                <td><?= gd_info()['GD Version'] ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Kapat
        </button>
      </div>
    </form>
  </div>
</div>