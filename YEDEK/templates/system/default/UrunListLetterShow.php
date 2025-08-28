<div class="item product product-item">


  <figure>
    <a href="{%URUN_DETAY_LINK%}"><img  src="{%IMG_SRC_300%}" width="350" height="350" alt="{%URUN_ADI%}"></a>
  </figure>
  <aside>
    <div>
      <h3> {%URUN_ADI%}</h3>
    </div>
    <div>
      {%URUN_SECIM_LISTE%}
    </div>
    <div>
      <i onclick="azalt($('#sepetadet_{%DB_ID%}')[0]);" class="fa fa-minus"></i>
      <input type="text" value="1" id="sepetadet_{%DB_ID%}">
      <i onclick="arttir($('#sepetadet_{%DB_ID%}')[0]);" class="fa fa-plus"></i>
    </div>
    <div>
      <button onclick="return sepeteEkle('{%DB_ID%}')">Sepete Ekle</button>
        {%Func-data_getSiparisCikar%}
    </div>
  </aside>
</div>