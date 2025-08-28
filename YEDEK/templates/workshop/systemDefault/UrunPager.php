<!-- HEADER -->
        <div style="clear:both"></div>
        <center><ul id="twbsPagination"></ul></center>
	<script src="js/jquery.twbsPagination.min.js" type="text/javascript"></script>
        <script>
            $('#twbsPagination').twbsPagination({
                totalPages: {%TOPLAM_SAYFA%},
                visiblePages: 5,
                startPage : {%SAYFA_NO%},
                href: '{%SAYFA_MAKRO_LINK%}',
                first:'&laquo;',
                prev:'&lsaquo;',
                next:'&rsaquo;',
                last:'&raquo;'
            });
        </script>        
<!-- // HEADER -->
