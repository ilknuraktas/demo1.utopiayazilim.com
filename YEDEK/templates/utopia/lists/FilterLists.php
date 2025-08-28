<!-- HEADER -->

<!-- // HEADER -->
<!-- BODY -->
<div class="widget widget-collapsible">
    <h3 class="widget-title">
        <a data-toggle="collapse" href="#" role="button" aria-expanded="true" aria-controls="widget-2">
            {%LISTE_ICERIK%}
        </a>
    </h3>
        <!-- // BODY -->
        <!-- SUBBODY -->
    <div class="collapse show" id="widget">
        <div class="widget-body">
            <div class="filter-items">
            {%LISTE_ICERIK%}
            </div>
        </div>
    </div>
</div>
<!-- // SUBBODY -->
<!-- FOOTER -->
<script>
    var i = 0;
    $(".widget-collapsible").each(function () {
        i++;

        $(this).find(".widget-title a").attr("href","#widget-"+i);
        $(this).find(".collapse").attr("id","widget-"+i);
    });
</script>
<!-- // FOOTER -->