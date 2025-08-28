<?php
@ini_set('display_errors', '0');
$CSS_FILES = array(
  "jquery.fancybox.css",
  "jquery.autocomplete.css",
  "jslider.css",
  "tab.menu.css",
  "sepet.css",
  "form.css",
  "jqzoom.css",
  "siparis.css",
  "pagination.css",
  "passrev.css",
  "screen.css",
  "font-awesome.min.css",
  "others.css"
);
$css_cache = new CSSCache($CSS_FILES);
$css_cache->dump_style();
class CSSCache
{
  private $filenames = array();
  private $cwd;
  public function __construct($i_filename_arr)
  {
    if (!is_array($i_filename_arr))
      $i_filename_arr = array($i_filename_arr);
    $this->filenames = $i_filename_arr;
    $this->cwd = getcwd() . DIRECTORY_SEPARATOR;
    if ($this->style_changed())
      $expire = -72000;
    else
      $expire = 3200;
    header('Content-Type: text/css;');
    header('Cache-Control: must-revalidate');
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expire) . ' GMT');
  }
  public function dump_style()
  {
    ob_start('ob_gzhandler');
    foreach ($this->filenames as $filename)
      $this->dump_cache_contents($filename);
    ob_end_flush();
  }
  private function get_cache_name($filename, $wildcard = FALSE)
  {
    $stat = stat($filename);
    return $this->cwd . '.' . $filename . '.' .
      ($wildcard ? '*' : ($stat['size'] . '-' . $stat['mtime'])) . '.cache';
  }
  private function style_changed()
  {
    foreach ($this->filenames as $filename)
      if (!is_file($this->get_cache_name($filename)))
        return TRUE;
    return FALSE;
  }
  private function compress($buffer)
  {
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $buffer);
    $buffer = str_replace('{ ', '{', $buffer);
    $buffer = str_replace(' }', '}', $buffer);
    $buffer = str_replace('; ', ';', $buffer);
    $buffer = str_replace(', ', ',', $buffer);
    $buffer = str_replace(' {', '{', $buffer);
    $buffer = str_replace('} ', '}', $buffer);
    $buffer = str_replace(': ', ':', $buffer);
    $buffer = str_replace(' ,', ',', $buffer);
    $buffer = str_replace(' ;', ';', $buffer);
    return $buffer;
  }
  private function dump_cache_contents($filename)
  {
    $compressed = $this->compress(file_get_contents($filename));
    echo $compressed;
  }
}
