<?php

include_once("mod_lib.php");


function mc_BlockArray($array, $user)
{


}

function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1, $style = null)
{
  $output = "";

  foreach ($array as $categoryId => $category) {

    if ($currentParent == $category['parent_id']) {

      if ($currLevel > $prevLevel) $out .= "<ul id='" . ($style["id"]) . "' class='" . $style["class"] . ($category["ul-class"]) . "' " . $style["doom"] . ">";
      if ($currLevel == $prevLevel) $out .= " </li>";

      $out .= '<li class="menu-item-' . $categoryId . ' menu-level-' . $currLevel . ($categoryId == (int)currentCat() ? ' active ' : ' ') . $category["li-class"] . '" ' . $category["li-doom"] . '>
                    <a href="' . $category["seo"] . '" class="' . $category["a-class"] . ' " ' . $category["a-doom"] . ' > ' . $category["name"] . '</a>';


      if ($currLevel > $prevLevel) $prevLevel = $currLevel;

      $currLevel++;
      $out .= createTreeView($array, $categoryId, $currLevel, $prevLevel);
      $currLevel--;
      $out .= ($style["sub"] == 1 ? mc_CategoryStyle("menuSubLevel0", $categoryId) : "");
      $out .= ($style["sub"] == 2 ? mc_CategoryStyle("menuSubLevel1", $categoryId) : "");
      $out .= ($category["style"] == 1 ? mc_CategoryStyle("menuSubLevel2", $categoryId) : "");
      $out .= ($category["style"] == 2 ? mc_CategoryStyle("mmenuSubLevel3", $categoryId) : "");

    }

  }

  if ($currLevel == $prevLevel) $out .= " </li>  </ul> ";

  $out .= '';


  return $out;

}

function mc_Vitrin()
{
  global $siteConfig;

  $output = "";
  $i = 0;
  $q = my_mysql_query("SELECT  * FROM kampanyaJSBanner ORDER BY seq ASC ");
  while ($d = my_mysql_fetch_array($q)) {
    $d = translateArr($d);
    $i++;


    $output .= ('<div class="intro-slide">
                    
                                <figure class="slide-image">
                                    <picture>
                                        <source media="(max-width: 480px)" srcset="images/kampanya/' . $d["resimJS"] . '">
                                        <img src="images/kampanya/' . $d["resimJS"] . '" alt="Image Desc">
                                    </picture>
                                </figure>
                                <div class="intro-content">
                                        <h3 class="intro-subtitle">'.$d["title"].'</h3><!-- End .h3 intro-subtitle -->
                                        <h1 class="intro-title text-white">'.$d["title2"].'</h1>
                                        <!-- End .intro-title -->

                                        <div class="intro-text text-white">'.$d["info"].'</div><!-- End .intro-text -->

                                       <a href="' . $d["url"] . '" class="btn btn-primary">
                                            <span>'.$d["info2"].'</span>
                                        </a>
                                    </div>
                   
                  </div>');


  }


  return $output;


}

function mc_CategoryStyle($style, $id = 0, $type = 0)
{


  global $siteConfig, $siteDizini, $seo;
  switch ($style) {


    case "showStory":


      $i = my_mysql_query("SELECT * from kategori Where parentID=0");
      while ($d = my_mysql_fetch_array($i)) {
        $output .= ' <div class="slick-item">
                                  <a href="' . $d["seo"] . '">
                                      <img src="' . ($d["resim"] ? 'images/kategori/' . $d["resim"] : "https://dummyimage.com/100x100/fafafa/333333") . '" alt="">
                                      <span>' . $d["name"] . '</span>
                                    </a>
                              </div>';

      }


      break;

    case "menu":
      $count = 1;
      $output = "";

      $arrayCategories = array();
      $arrayCategoriesDom = array("class" => 'menu sf-arrows', 'id' => '', 'doom' => '', 'sub' => 0);
      if (!isReallyMobile()) {



        $i = my_mysql_query("SELECT m.*, COUNT(DISTINCT mp.ID) as count FROM kategori m LEFT JOIN kategori mp ON mp.parentID = m.ID WHERE   m.active=1  GROUP BY m.ID ORDER BY m.seq ASC");

        while ($d = my_mysql_fetch_array($i)) {


          $d = translateArr($d);
          $arrayCategories[$d['ID']] = array(
            "type" => "",
            "style" => 0,
            "parent_id" => $d['parentID'],
            "name" => ($d['name']),
            "seo" => $d['seo'],
            "li-class" => ($d["count"] > 0 ? " " : ""),
            "a-class" => "",
            "ul-class"=> ($d["parentID"] != 0 ? " " : "")
          );
        }

     


      } else {
        $arrayCategories["2022"] = array(
          "type" => "",
          "style" => 0,
          "parent_id" => 0,
          "name" => ('<i class="fa fa-bars"></i> '),
          "seo" => "#menu",
          "li-class" => ($d["count"] > 0 ? "" : ""),
          "a-class" => "");
      }


      $output .= createTreeView($arrayCategories, 0, 0, -1, $arrayCategoriesDom);
      break;

    case "menuSubLevel0":
      $count = 1;
      $output = "";
      $i = my_mysql_query("select ID,name,seo,parentID,resim from kategori Where active=1 AND parentID !=0 AND idPath REGEXP'[[:<:]]" . $id . "[[:>:]]' order by seq,name");
      $arrayCategoriesDom = array("class" => 'mega-content', 'id' => '', 'doom' => '', 'sub' => 0);
      $arrayCategories = array();
      while ($d = my_mysql_fetch_array($i)) {

        $d = translateArr($d);
        $arrayCategories[$d['ID']] = array(
          "type" => "",
          "style" => 0,
          "parent_id" => $d["parentID"],
          "name" => $d["name"],
          "seo" => $d['seo'],
          "li-class" => "menu-order-" . $d[seq],
          "a-class" => "menu-title"
        );

      }

      if (createTreeView($arrayCategories, $id, 0, -1, $arrayCategoriesDom)) {
        $output .= '<div class="megamenu megamenu-md">
                     <div class="row no-gutters">
                     ';
        $output .= createTreeView($arrayCategories, $id, 0, -1, $arrayCategoriesDom);

        $output .= '</div></div>';
      }


      break;

    case "menuSubLevel1":

      $i = my_mysql_query("select ID,name,seo,parentID,resim from kategori Where active=1 AND parentID =" . $id . "  order by seq ASC");


      $arrayCategoriesDom = array("class" => 'menu', 'id' => '', 'doom' => '', 'sub' => 0);
      $arrayCategories = array();
      while ($d = my_mysql_fetch_array($i)) {


        $d = translateArr($d);
        $output .= '<a href="' . $d["seo"] . '">' . $d["name"] . '</a>';

      }


      break;

    case "menuSubLevel2":

      $count = 1;
      $output = "";
      $i = my_mysql_query("select * from kategori   order by seq ASC ");
      $arrayCategoriesDom = array("class" => 'mega-content', 'id' => '', 'doom' => '', 'sub' => 0);
      $arrayCategories = array();
      while ($d = my_mysql_fetch_array($i)) {

        $d = translateArr($d);
        $arrayCategories[$d['ID']] = array(
          "type" => "",
          "style" => 0,
          "parent_id" => ($d["parentID"] == 0 ? $id : $d["parentID"]),
          "name" => $d["name"],
          "seo" => $d['seo'],
          "li-class" => "menu-order-" . $d[seq],
          "a-class" => "menu-title"
        );

      }

      if (createTreeView($arrayCategories, $id, 0, -1, $arrayCategoriesDom)) {
        $output .= ' <div class="header-category-panel-menu-drop">';
        $output .= ' <div class="row"><div class="col-sm-12">';
        $output .= createTreeView($arrayCategories, $id, 0, -1, $arrayCategoriesDom);


        $output .= '</div></div></div>';
      }


      break;

    case "menuSubMarka":

      $count = 1;
      $output = "";
      $i = my_mysql_query("select * from marka Where resim !=''  order by  RAND() limit 0,16");
      $arrayCategoriesDom = array("class" => 'mega-content', 'id' => '', 'doom' => '', 'sub' => 0);
      $arrayCategories = array();
      while ($d = my_mysql_fetch_array($i)) {

        $d = translateArr($d);

        $output .= '<a href="' . $d["link"] . '" class="menu-item-brand-child">
         <img src="images/markalar/' . $d["resim"] . '" alt="">
        </a>';


      }


      break;

    case "menuSubBanner":

      $i = 0;
      $q = my_mysql_query("SELECT ID,bannerID FROM  bannerYonetim Where bannerYer LIKE '%Menu-$id%'");

      while ($d = my_mysql_fetch_array($q)) {

        $j = mysql_query("SELECT * FROM  bannerlar Where aktif=1 and ID='" . $d[bannerID] . "' order by ID DESC");

        while ($c = my_mysql_fetch_array($j)) {
          $i++;

          $output .= '<a href="' . $c["url"] . '" class="header-category-panel-menu-banner">
                                    <img src="images/banner/' . $c["bannerPic"] . '"> 
                                </a>';


        }


      }


      break;

    case "menuSub":
      $output = "";

      $arrayCategories = array();
      $arrayCategoriesDom = array("class" => 'ps-list--categories', 'id' => '', 'doom' => '', 'sub' => 0);

      $i = my_mysql_query("select * from kategori Where active=1   AND parentID='" . $id . "' order by seq ASC limit 0,3");
      while ($d = my_mysql_fetch_array($i)) {
        $d = translateArr($d);
        $output .= ' 
                            
                                <a href="' . $d["seo"] . '">' . $d["name"] . '</a>';
      }


      break;

    case "showCategory":
      $output = "";

      $i = my_mysql_query("select * from kategori  Where active=1 and parentID=0  order by seq ASC limit 0,12") or die(mysql_error());

      while ($d = my_mysql_fetch_array($i)) {
        $j++;

        $d = translateArr($d);
        $a .= '<a href="#' . ($d["seo"]) . '"   class="' . $d["seo"] . ' ' . ($j == 1 ? "active" : "") . '">
                
                     ' . $d[name] . '
                    </a>';

        $p .= ' <div id="' . $d["seo"] . '" class="' . $d["seo"] . ' ' . ($j == 1 ? "active" : "hide") . '">
                      <div class="slick-slider" data-slick="product-slick">
                        ' . (urunList('select * from urun Where  active=1 and showCatIDs like "%|' . $d["ID"] . '|%" order by finish desc,ID desc limit 0,8', 'empty', 'UrunListLiteShow')) . '
                    </div>
                   </div>';
      }

      $output .= ' <div class="col-sm-3">
                            
                            <nav>
                            ' . $a . '
                                </nav>
                        

                      </div>

                      <div class="col-sm-9">

' . $p . '

                      </div>';

      break;

    case "showFooter":
      $output = "";

      $i = mysql_query("select * from kategori  Where parentID=0  order by seq ASC") or die(mysql_error());

      while ($d = my_mysql_fetch_array($i)) {
        $d = translateArr($d);
        $output .= '<li><a href="' . $d[seo] . '">' . $d[name] . '</a></option>';
      }


      break;

    case "showCat":
      $output = "";

      $i = mysql_query("select * from kategori  Where menu=1  order by seq ASC limit 0,3") or die(mysql_error());

      while ($d = my_mysql_fetch_array($i)) {
        $d = translateArr($d);
        $output .= '<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                              <a href="' . $d["seo"] . '" class="section-category-item">
                                  <figure>
                                      <img src="images/kategoriler/' . $d["resim"] . '" class="img-fluid" alt="" />
                                  </figure>
                                  <aside>
                                    <span>' . hq('select COUNT(*)  from urun  Where  catID ="' . $d["ID"] . '" OR showCatIDs like "|%' . $d["ID"] . '|%" ') . '</span>
                                     <h3>' . $d["name"] . '</h3>
                                  </aside>
                              </a>
                            </div>';
      }


      break;

    case "showBrand":
      $output = "";

      $i = my_mysql_query("select * from marka   order by seq ASC limit 0,16") or die(mysql_error());

      while ($d = my_mysql_fetch_array($i)) {
        $d = translateArr($d);
        $output .= ' <div class="owl-item"> 
                           
                                <a href="' . $d["seo"] . '">
                                   <img src="' . ($d["resim"] ? 'images/markalar/' . $d["resim"] : "https://dummyimage.com/120x120/fafafa/333") . '" alt="">
                                </a>
                    </div>';
      }


      break;

    case "showComment":
      $output = "";

      $q = my_mysql_query("select urunYorum.* from urunYorum,urun where urun.ID=urunYorum.urunID AND    onay = 1  order by urunYorum.ID desc limit 0,6");
      while ($d = my_mysql_fetch_array($q)) {
        $d = translateArr($d);
        $output .= '<div>
                      <div class="product-comment-item">
                       <i class="fa fa-quote-left" aria-hidden="true"></i>
                       <p>' . $d['aciklama'] . '</p>
                       <strong>' . $d["name"] . " " . mb_substr($d["lastname"], 0, 1) . str_repeat("*", strlen($d["lastname"]) - 1) . '</strong> 
                      </div>
                    </div>';

      }


      break;

    case "showBlog":


      $q = my_mysql_query("select * from makaleler order by Tarih desc limit 0,9");
      while ($d = my_mysql_fetch_array($q)) {
        $d = translateArr($d);
        list($yil, $ay, $gun) = explode('-', $d['Tarih']);


        $output .= '<article class="entry entry-display">
                        <figure class="entry-media">
                            <a href="' . makaleLink($d) . '">
                                <img src="' . (!$d['resim'] ? 'https://dummyimage.com/410x215/fafafa/333' : 'images/makaleler/' . $d['resim'] . '') . '" alt="image desc">
                            </a>
                        </figure><!-- End .entry-media -->

                        <div class="entry-body text-center">
                            <div class="entry-meta">
                                <a href="' . makaleLink($d) . '">'.mysqlTarih($d['Tarih']).'</a>, '.(int)hq("select count(*) from urunYorum where tip=1 AND urunID = '" . $d['ID'] . "' AND onay=1").' Yorumlar
                            </div><!-- End .entry-meta -->

                            <h3 class="entry-title">
                                <a href="' . makaleLink($d) . '">' . $d['Baslik'] . '</a>
                            </h3><!-- End .entry-title -->

                            <div class="entry-content">
                                <a href="' . makaleLink($d) . '" class="read-more">Devamını Oku</a>
                            </div><!-- End .entry-content -->
                        </div><!-- End .entry-body -->
                    </article><!-- End .entry -->';

        $i++;
      }


      break;

    case  "showProduct":

      $c = 0;
      $output = "";
      $i = my_mysql_query("select * from urun Where active=1 and $id order by seq  ASC");
      while ($d = my_mysql_fetch_array($i)) {
        $c++;

        $output .= '<li><a href="#' . $d["seo"] . '"  >' . $d["name"] . '</a></li>';


      }


      break;

    case "catmenu":

      $count = 1;
      $output = "";

      $arrayCategories = array();
      $arrayCategoriesDom = array("class" => 'item-category', 'id' => '', 'doom' => '', 'sub' => 0);
      $key = (!hq("select count(*) from kategori Where parentID=" . (int)currentCat()) ? (int)currentParentCatID() : (int)currentCat());


      $i = my_mysql_query("SELECT m.*, COUNT(DISTINCT mp.ID) as count FROM kategori m LEFT JOIN kategori mp ON mp.parentID = m.ID WHERE m.active=1  and m.parentID=" . $key . " GROUP BY m.ID Order by m.seq ASC");
      while ($d = my_mysql_fetch_array($i)) {

        $d = translateArr($d);
        $arrayCategories[$d['ID']] = array(
          "type" => "",
          "style" => 0,
          "parent_id" => 0,
          "name" => $d['name'] ,
          "seo" => ( $d['seo']),
          "li-class" => (in_array($d["ID"], $parent) == true ? "active" : ""),
          "a-class" => ""
        );

      }


      $output .= createTreeView($arrayCategories, 0, 0, -1, $arrayCategoriesDom);

      break;

    case "showMobil":
      $count = 1;
      $output = "";

      $arrayCategories = array();
      $arrayCategoriesDom = array("class" => 'mobile-menu ', 'id' => 'menu', 'doom' => '', 'sub' => 0);
      if (!$_SESSION['loginStatus']):
        $arrayCategories['110220201'] = array("type" => "", "style" => 0, "parent_id" => 0, "name" => "Giriş Yap", "seo" => "ac/login", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");
        $arrayCategories['110220202'] = array("type" => "", "style" => 0, "parent_id" => 0, "name" => "Üye Ol", "seo" => "ac/register", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");
      else :
        $arrayCategories['110220203'] = array("type" => "", "style" => 0, "parent_id" => 0, "name" => "Hesabım <span class=\"ti-angle-left\"></span>", "seo" => "#", "li-class" => "dropdown", "a-class" => "has-arrow", "ul-class" => "sub-menu");
        $arrayCategories['110220204'] = array("type" => "", "style" => 0, "parent_id" => 110220203, "name" => "Bilgilerim", "seo" => "ac/profile", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");
        $arrayCategories['110220205'] = array("type" => "", "style" => 0, "parent_id" => 110220203, "name" => "Adreslerim", "seo" => "ac/adres", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");
        $arrayCategories['110220206'] = array("type" => "", "style" => 0, "parent_id" => 110220203, "name" => "Siparişlerim", "seo" => "ac/showOrders", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");
        $arrayCategories['110220207'] = array("type" => "", "style" => 0, "parent_id" => 110220203, "name" => "Sipariş Sorun Bildirim/Takip", "seo" => "ac/hataBildirim", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");
        $arrayCategories['110220208'] = array("type" => "", "style" => 0, "parent_id" => 110220203, "name" => "Havale Bildirim Formu", "seo" => "ac/havaleBildirim", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");
        $arrayCategories['110220209'] = array("type" => "", "style" => 0, "parent_id" => 110220203, "name" => "Çıkış", "seo" => "ac/logout", "li-class" => "", "a-class" => "", "ul-class" => "sub-menu");

      endif;


      $i = my_mysql_query("SELECT m.*, COUNT(DISTINCT mp.ID) as count FROM kategori m LEFT JOIN kategori mp ON mp.parentID = m.ID WHERE  m.active=1 GROUP BY m.ID ORDER BY m.seq ASC");
      while ($d = my_mysql_fetch_array($i)) {

        $d = translateArr($d);
        $arrayCategories[$d['ID']] = array(
          "type" => "",
          "style" => 0,
          "parent_id" => $d['parentID'],
          "name" => $d['name'] ,
          "seo" => ($d["count"] > 0 ? '#' : $d['seo']),
          "li-class" => ($d["count"] > 0 ? 'dropdown' : ""),
          "a-class" => ($d["count"] > 0 ? 'has-arrow' : ""),
          "a-doom" => "",
          "ul-class" => "sub-menu"
        );

      }


      $output .= createTreeView($arrayCategories, 0, 0, -1, $arrayCategoriesDom);
      break;

    case "showCatSub":
      $count = 1;
      $output = "";

      $arrayCategories = array();
      $arrayCategoriesDom = array("class" => 'cat-list', 'id' => '', 'doom' => '', 'sub' => 0);

      $catPID = (int)currentParentCatID();
      $catPID = (int)($catPID < 1 ? (int)currentCat() : (int)currentParentCatID());

      $i = my_mysql_query("select * from kategori Where active=1  and    parentID='" . $catPID . "'  order by seq ASC");
      while ($d = my_mysql_fetch_array($i)) {


        $output .= '<option value="' . $d['seo'] . '">' . $d['name'] . '</option>';


      };
      break;


    default:

      break;

  }

  return $output;

}

function mc_CatSideBar()
{
  $output .= ' <div class="accordion__panel accordion__panel--active">

        <div class="accordion__trigger accordion__trigger--active">
            <strong>Kategoriler</strong>
        </div>
        <div class="accordion__content accordion__content--active">
            <div class="scrollbar"> 
                    ' . mc_CategoryStyle("catmenu") . '
            </div>
        </div>
    </div>';
  $output .= generateFilter('FilterLists');
  return $output;
}

function mc_CatMetaOrder()
{


  $output .= ' <h1 class="global-filter-title"> ' . ($_GET['catID'] ? hq("select  name from kategori where ID=" . $_GET["catID"]) : dbInfo('marka', 'name', $_GET['markaID'])) . '</h1>';
  return $output;


}

function mc_CatSlider()
{
  $q = my_mysql_query("select * from sliderkategori where catIDs = '" . $_GET['catID'] . "' OR catIDs like '%," . $_GET['catID'] . ",%' OR catIDs like '%," . $_GET['catID'] . "' OR catIDs like '" . $_GET['catID'] . ",%' order by seq limit 0,1");
  if (!my_mysql_num_rows($q)) return;
  $i = 0;
  while ($d = my_mysql_fetch_array($q)) {
    $output .= '<div>
				<a href="' . $d['link'] . '"><img ' . $imgAttr . '  src="images/kampanya/' . $d['resim'] . '"  alt=""></a>
			</div>';

  }

  return $output;

}

function mc_Page($type)
{
  global $siteConfig;

  $i = 1;

  $query = "Where $type=1";
  $q = my_mysql_query("SELECT  ID,redirect,title,seo  FROM  pages  $query ORDER BY seq DESC ");
  while ($d = my_mysql_fetch_array($q)) {
    $d = translateArr($d);
    $redirect = explode("|", $d['redirect']);
    $out .= '<li><a href="' . (($redirect[0] != '') ? $redirect[0] : "ic/" . $d['seo'] . "") . '">' . $d['title'] . '</a></li>';
  }


  return ($out);

}

function mc_BrandName($d)
{
  return ('<a href="' . dbInfo('marka', 'seo', $d['markaID']) . '">
             <img src="images/markalar/' . dbInfo('marka', 'resim', $d['markaID']) . '">
          </a>');
}

function mc_CatName()
{
  return ($_GET["catID"] ? dbInfo("kategori", "name", $_GET["catID"]) : dbInfo("marka", "name", $_GET["markaID"]));
}

function mc_ImageV3($d)
{


  $j = 0;
  for ($i = 1; $i <= 10; $i++) {

    $j++;

    $str = ('resim' . $i);
    if (!$d[$str]) continue;

    if ($d[$str]) {

      $out .= ' <a class="product-gallery-item " href="#" data-image="images/urunler/' . $d[$str] . '" data-zoom-image="images/urunler/' . $d[$str] . '">
                                    <img src="images/urunler/' . $d[$str] . '" alt="product side">
                </a>';

    }
  }





  return ($out);

}

function edKargoTarih($d)
{
  $date = date("Y-m-d");
  $time = date("H:i:s");
  $mod = strtotime($date . " +" . (int)$d['kargoGun'] . " weekdays $time");
  if ($d['anindaGonderim'] && $d["kargoGun"] == 0) {
    $out .= '<div  class="cargo-truck-box">
               
                  <p>
                  Saat  <color> 12:00</color>\'a kadar vereceğiniz sipariş aynı gün kargoda.
                 </p>
           </div>';
  } else {

    $out .= '<div  class="cargo-truck-box">
                 
                  <p>
                   En geç <color>' . mysqlTarih(date('Y-m-d', $mod)) . '</color> tarihinde kargoda.
                 </p>
           </div>';

  }

  return $out;
}

function mc_UrunYorum($d)
{
  $output = "";
  $toplamPuan = hq("select sum(puan) as toplampuan from urunYorum where tip=0 AND urunID='" . $d['ID'] . "' ");
  $qSub = my_mysql_query("select * from urunYorum where tip=0 AND urunID='" . $d['ID'] . "'  order by ID desc");
  @$ortalamaPuan = (int)($toplamPuan / my_mysql_num_rows($qSub));

  if($ortalamaPuan == 5){$output="width:100%";}
  if($ortalamaPuan == 4){$output="width:80%";}
  if($ortalamaPuan == 3){$output="width:60%";}
  if($ortalamaPuan == 2){$output="width:40%";}
  if($ortalamaPuan == 1){$output="width:20%";}
  if($ortalamaPuan == 0){$output="width:0%";}


  return $output;


}

function mc_Stock($d)
{

  return ($d[stok] > 0 ? '<span class="green">STOKTA VAR</span>' : '<span class="red">STOKTA YOK</span>');
}

function mc_BannerList($location, $class = null)
{

  $i = 0;


  $j = my_mysql_query("SELECT * FROM bannerYonetim  Where bannerYer='" . $location . "'  ORDER BY seq ASC");

  while ($c = my_mysql_fetch_array($j)) {
    $i++;

    list($a,$b,$d,$e,$f) = explode(PHP_EOL,$c["bannerFlashSource"]);

    switch ($location) {

      case "banner1":


      $out .= '<a href="' . $c["url"] . '">
                   <img src="images/banner/' . $c["bannerPic"] . '" alt="Banner">
                </a> 
                <div class="banner-content banner-content-bottom">
                     <h4 class="banner-subtitle text-white"><a href="' . $c["url"] . '">'.$a.'</a></h4>
                     <h3 class="banner-title text-white"><a href="' . $c["url"] . '">'.$b.'</a></h3>
                    <div class="banner-text text-white"><a href="' . $c["url"] . '">'.$d.'</a></div>
                    <a href="' . $c["url"] . '" class="btn btn-outline-white banner-link">'.$e.'</a>
                </div>';
      break;

      case "banner2":


        $out .= '<a href="' . $c["url"] . '">
                   <img src="images/banner/' . $c["bannerPic"] . '" alt="Banner">
                </a> 
                <div class="banner-content banner-content-top">
                                        <h4 class="banner-subtitle text-white"><a href="#">'.$a.'</a></h4>
                                        <!-- End .banner-subtitle -->
                                        <h3 class="banner-title text-white"><a href="#">'.$b.'</a></h3>
                                        <!-- End .banner-title -->
                                        <div class="banner-text text-white"><a href="#">'.$d.'</a></div>
                                        <!-- End .banner-text -->
                                        <a href="#" class="btn btn-outline-white banner-link">'.$e.'</a>
                                    </div>';
        break;

      case "banner3":


        $out .= '<a href="' . $c["url"] . '">
                   <img src="images/banner/' . $c["bannerPic"] . '" alt="Banner">
                </a> 
                <div class="banner-content">
                     <h4 class="banner-subtitle text-white"><a href="' . $c["url"] . '">'.$a.'</a></h4>
                     <h3 class="banner-title text-white"><a href="' . $c["url"] . '">'.$b.'</a></h3>
                    <a href="' . $c["url"] . '" class="btn btn-outline-white banner-link">'.$d.'</a>
                </div>';
        break;

      case "banner4":


        $out .= '<a href="' . $c["url"] . '">
                   <img src="images/banner/' . $c["bannerPic"] . '" alt="Banner">
                </a> 
                <div class="banner-content banner-content-bottom">
                     <h4 class="banner-subtitle text-white"><a href="' . $c["url"] . '">'.$a.'</a></h4>
                     <h3 class="banner-title text-white"><a href="' . $c["url"] . '">'.$b.'</a></h3>
                    <div class="banner-text text-white"><a href="' . $c["url"] . '">'.$d.'</a></div>
                    <a href="' . $c["url"] . '" class="btn btn-outline-white banner-link">'.$e.'</a>
                </div>';
        break;

      case "banner5":


        $out .= '<a href="' . $c["url"] . '">
                   <img src="images/banner/' . $c["bannerPic"] . '" alt="Banner">
                </a> 
                <div class="banner-content">
                                <div class="banner-top">
                                    <div class="banner-title text-white text-center">
                                        <i class="la la-star-o"></i><h3 class="text-white">'.$a.'</h3>
                                    </div>
                                </div>
                                <div class="banner-bottom">
                                    <div class="product-cat">
                                        <h4 class="text-white">'.$b.'</h4>
                                    </div>
                                    <div class="product-price">
                                        <h4 class="text-white">'.$d.'</h4>
                                    </div>
                                    <div class="product-txt">
                                        <p class="text-white">'.$e.'</p>
                                    </div>
                                    <a href=""' . $c["url"] . '" class="btn btn-outline-white banner-link">'.$f.'</a>
                                </div>
                            </div>';
        break;

      case "banner6":


        $out .= '<a href="' . $c["url"] . '">
                   <img src="images/banner/' . $c["bannerPic"] . '" alt="Banner">
                </a> 
                <div class="banner-content">
                                <div class="banner-top">
                                    <div class="banner-title text-white text-center">
                                        <i class="la la-star-o"></i><h3 class="text-white">'.$a.'</h3>
                                    </div>
                                </div>
                                <div class="banner-bottom">
                                    <div class="product-cat">
                                        <h4 class="text-white">'.$b.'</h4>
                                    </div>
                                    <div class="product-price">
                                        <h4 class="text-white">'.$d.'</h4>
                                    </div>
                                    <div class="product-txt">
                                        <p class="text-white">'.$e.'</p>
                                    </div>
                                    <a href=""' . $c["url"] . '" class="btn btn-outline-white banner-link">'.$f.'</a>
                                </div>
                            </div>';
        break;

      case "banner7":


        $out .= '<a href="' . $c["url"] . '">
                   <img src="images/banner/' . $c["bannerPic"] . '" alt="Banner">
                </a> 
                <div class="banner-content banner-content-top banner-content-center">
                                  <h4 class="banner-subtitle">'.$a.'</h4><!-- End .banner-subtitle -->
                                  <h3 class="banner-title">'.$b.'</h3><!-- End .banner-title -->
                                  <div class="banner-text text-primary">'.$d.'</div><!-- End .banner-text -->
                                  <a href="#" class="btn btn-outline-gray banner-link">'.$e.'<i class="icon-long-arrow-right"></i></a>
                              </div>';
        break;

      default :

        $out .= '<div class="banner-item-box ' . (($i % 2) == 0 ? 'odd' : 'even') . ' ' . $class . ' ">
                      <a href="' . $c["url"] . '">
                      <figure>
                             <img src="images/banner/' . $c["bannerPic"] . '" alt="' . $c["name"] . '">
                        </figure>
                       </a>
                     </div> ';


        break;


    }


  }


  return $out;

}

function mc_user()
{
  return ($_SESSION['userID'] ? 'true' : 'false');
}

function mc_template($type = null)
{
  return ($type != "" ? "templates/" . $_SESSION["templateName"] . "/" . $type : "templates/" . $_SESSION["templateName"]);
}

function mc_GetAct()
{

  return seoFix(@$_GET["act"] . ' ' . @$_GET["replaceGet"]);
}

function mcInputVal($d)
{


  return '<input type="number" class="urunSepeteEkleAdet" ' . ($d["urunBirim"] == "Kg." ? 'value="0.90"  data-decimals="2" step="0.1" min="0.10" max="' . $d["STOK"] . '"' : 'value="1"  min="1" max="' . $d["STOK"] . '"') . '  style="display: none;" id="sepetadet_' . $d["ID"] . '">';
}


function mc_alarmControl($d)
{


  return  ($_SESSION["userID"] < 1 ? "alerter.show('" . _lang_uyelikUyari . "');" : "alarmEkle('AlarmListem'," . $d["ID"] . "); return false;");
}

function pageBreadCrumb()
{

  global $siteConfig, $siteDizini, $seo;

  if ($seo->act == "showBlog") {
    $out .= '<li><a href="ac/makale/' . dbInfo("makalekategori", "seo", dbInfo("makaleler", "catID", $_GET['ID'])) . '">' . dbInfo("makalekategori", "name", dbInfo("makaleler", "catID", $_GET['ID'])) . '</a> »</li>';
    $out .= '<li>' . $seo->currentTitle . '</li>';
  } else if ($seo->act == "makale" || $seo->act == "makaleListe") {
    $out .= '<li>' . (!$_GET['mcatID'] ? '<a href="ac/makale">Makale</a>' : '<a href="ac/makale/' . dbInfo("makalekategori", "seo", $_GET['mcatID']) . '">' . dbInfo("makalekategori", "name", $_GET['mcatID']) . '</a>') . '</li>';
  } else if ($seo->act == "kategoriGoster") {

    $out .= dbInfo("kategori", "name", $_GET['catID']);
  } else if ($seo->act == "urunDetay") {

    $out .= dbInfo("urun", "name", $_GET['urunID']);
  } else if ($seo->act == "arama") {

    $out .= _lang_titleDetayliArama . ' : ' . stripslashes($_GET['str']);
  } else {

    $out .= '<li>' . $seo->currentTitle . '</li>';
  }

  return $out;
}


function myitemOrder()
{


  $out .= '<div class="toolbox">
                          <div class="toolbox-left">
                              <a href="#" class="sidebar-toggler"><i class="icon-bars"></i>Filtrele</a>
                          </div><!-- End .toolbox-left -->

                          <div class="toolbox-center">
                              <div class="toolbox-info">
                                 
                              </div><!-- End .toolbox-info -->
                          </div><!-- End .toolbox-center -->

                          <div class="toolbox-right">
                              <div class="toolbox-sort">
                                  <label for="sortby">Sırala:</label>
                                  <div class="select-custom">
                                   <form id="urunsirala" class="form-inline" action="" method="POST">
                                    '.getOrderBySelect('') .'
                                    </form>
                                  </div>
                              </div><!-- End .toolbox-sort -->
                          </div><!-- End .toolbox-right -->
                      </div><!-- End .toolbox -->';
 
  return $out;
}


function mc_urunSayacDeal($d)
{


  if (strtotime(date("Y-m-d H:i:s")) > strtotime(date($d["finish"]))) return false;
  return ' <div class="col-product-item-timer">
            
            <div class="timer-title"><span>FIRSAT İÇİN KALAN SÜRE :</span></div>
            <div class="timer" data-countdown="single" data-date="' . str_replace(array(":", " "), "-", $d["finish"]) . '">
                <span>
                    <span> 0</span>
                    <span>GÜN</span>
                </span>
                <span>
                    <span>0 </span>
                    <span>SAAT</span>
                </span>
                <span>
                    <span>0 </span>
                    <span>SANİYE</span>
                </span>
            </div>
        </div>';


}

function mc_urunBadge($d)
{
  $out .= ($d['anindaGonderim'] ? '<span style="background: #4BB543; color: #fff;">Yeni</span>' : '');
  $out .= ($d['anindaGonderim'] ? '<span style="background: #F26D3F; color: #fff;">Anında Kargo</span>' : '');
  $out .= ($d['ucretsizKargo'] ? '<span style="background: #ffc107; color: #fff;">Ücretsiz Kargo</span>' : '');
  $stok .= ($d['stok'] < 1 ? '<div class="discount-cart "> <span class="price">Tükendi</span> </div>' : '');
  return ' <div class="badges badges-text">'.$out.'</div>' . $stok;

}

function clisteDetay($d)
{
  return ($d["listeDetay"] != "" ? "1" : "0");
}

function cOnDetay($d)
{
  return ($d["onDetay"] != "" ? "1" : "0");
}

function cUrunBirim($d)
{


  return ($d["fiyatBirim"] != "TL" ? 1 : 0);


}

function cUrunPiyasa($d)
{

  if ($d["piyasafiyat"])
    return "İndirimli Fiyat";
  else if ($d["piyasafiyat"] != $d["fiyat"])
    return "Liste Fiyatı";
  else
    return "Liste Fiyatı";
}


function mc_whatsapp($d)
{

  global $siteDizini;
  $wno = str_replace(array(' ', '(', ')', '-'), array(''), siteConfig('whatsappNumber'));
  $text = ($_GET['act'] == 'urunDetay' ? 'Stok Kodu:' . $d['ID'] . ' - Adı: ' . $d['name'] . ' adlı üründen sipariş vermek istiyorum. http://' . $_SERVER['HTTP_HOST'] . $siteDizini . urunLink($d) : 'Telefon üzerinden sipariş vermek istiyorum.');

  //if($_GET['act'] != 'urunDetay' || $shopphp_demo)
  $out = '<a href="https://api.whatsapp.com/send?phone=9' . $wno . '&text=' . $text . '" id="spWhatsAppFooter" target="_blank">
        <img src="images/whatsApp.png" alt="">
    </a>';

  $out = '
	<div class="whatsapp-box">
    <a href="https://api.whatsapp.com/send?phone=9' . $wno . '&text=' . $text . '" target="_blank" class="whatsapp-box-link">
      <div class="icon">
          <i class="fa fa-whatsapp"></i>
      </div>
      <div class="right">
        <p class="title">WHATSAPP İLE SİPARİŞ</p>
        <p class="number">' . siteConfig('whatsappNumber') . '</p>
      </div>
    </a>
    <p class="whatsapp-box-info">
    Siparişinizi whatsapp sipariş hattımızdan iletebilirsiniz.
    Tüm siparişler 3 İş günü içerisinde gönderilmektedir.
    </p>
	</div>
	';
  return $out;
}

function currentTitle($i)
{

  global $seo;

  $d = explode("-", $seo->currentTitle);

  return $d[$i];


}
?>


