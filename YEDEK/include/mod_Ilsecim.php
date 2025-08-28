<?
function modIlSelectHeader()
{
	return '    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<style>
a:hover{text-decoration: none}

            .korfez-sehirSelect .innerHeader {
                top: -22px
            }
            .korfez-sehirSelect .container {
                margin-top: -5px;
                top: 0px;
                padding-top: 0;
                max-width: 1010px;
            }
            .col-md-16 {
                position: static
            }
            .sehirLink {
                z-index: 2;
                font-family: \'Open Sans\', sans-serif;
                display: inline-block;
                padding: 0;

                text-decoration: none;
                min-height: 82px
            }
            
            .sehirContainer {
                width: 40px;
                height: 40px;
                border-radius: 3px;
                background-color: #b70000;
                border: 2px solid #a80000;
                display: block;
                box-shadow: 0px 2px 0 0 rgba(0,0,0,0.08);
                color: #fff;
                margin: auto auto 9px auto
            }
        .sehirPasif{width: 40px;
                height: 40px;
                border-radius: 3px;
                background-color: #ccc;
                border: 2px solid #bbb;
                display: block;
                box-shadow: 0px 2px 0 0 rgba(0,0,0,0.08);
                color: #fff;
                margin: auto auto 9px auto;
            }
            .plaka {
                font-weight: bold;
                font-size: 16px;
                line-height: 38px;
                text-align: center;
                display: block
            }
            .sehirContainer:hover {
                background-color: #fff;
                color: #000
            }
            .sehirLink .name {
                color: #333333;
                font-size: 12px;
                font-weight: 600;
                text-align: center;
                display: block;
                line-height: 14px
            }
            .sehirLink:nth-child(12n) {
                margin-right: 0
            }
</style>

<div class="container korfez-main">
        <div class="row">
            <div class="col-md-16">
    <div class="sehirPlatesContainer">
';	
}

function modIlSelectFooter()
{
	return '</div></div></div></div>';
}

function modIlSelect()
{
	$langq = my_mysql_query("select plakaID,name,active from iller where cID=0 OR cID=1 order by name");
	while($d = my_mysql_fetch_array($langq))
	{
		$out.='<a class="sehirLink col-md-1 " href="page.php?act=cselect&cityID='.$d['plakaID'].'">
            <div class="sehirContainer '.($d['active']?'':'sehirPasif').'">
                    <span class="plaka">'.$d['plakaID'].'</span>
            </div>
            <span class="name">'.$d['name'].'</span>
        </a>';
	}
	return modIlSelectHeader().$out.modIlSelectFooter();	
}
?>