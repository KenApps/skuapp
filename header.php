<?php
require_once './config.php';
?>
<!-- Testing cloud munch build  -->
<html>
    <head>
        <script type="text/javascript" src="<?= App::$baseUrl; ?>js/app.js"></script>
        <link type="text/css" src="<?= App::$baseUrl; ?>css/app.css" />
    </head>
    <script type="text/javascript">
        var i = 0;
        function getXhr() {
            var xhr;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xhr = new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            return xhr;
        }
        function addAttributeOptions() {
            attributeType = document.getElementById('attribute_type').value;
            if (attributeType == '1' || attributeType == '2' || attributeType == '3') {
                document.getElementById('attributeOptions').style.display = 'inline';
            }
        }
        function addOption() {
            divOption = document.getElementById('option_' + i);
            i++;
            var newOption = document.createElement('div')
            newOption.setAttribute("id", "option_" + i)
            newOption.innerHTML = '<label><span>Option' + i + ' :</span><input id="option' + i + '" type="text" name="option[]" placeholder=""></label>';
            divOption.appendChild(newOption);
        }

        function deleteOption() {
            document.getElementById('option_' + i).remove();
            i--;
        }

        function addAttribute() {
            console.log("comming addAttribute");
            var attrTypes = new Array();
            var xmlhttp = getXhr();
            var attributeName = document.getElementById('attribute_name').value;
            var attributeType = document.getElementById('attribute_type').value;
            var attributeLabel = document.getElementById('attribute_label').value;

            if (attributeLabel.length == 0) {
                document.getElementById('attribute_label').style.border = '1px solid red';
                return false;
            }
            if (attributeName.length == 0) {
                document.getElementById('attribute_name').style.border = '1px solid red';
                return false;
            }
            if (attributeType.length == 0) {
                document.getElementById('attribute_type').style.border = '1px solid red';
                return false;
            }

            if (attributeType == '1' || attributeType == '2' || attributeType == '3')
            {
                //attributeOptions = document.getElementById('option0').value;
                var attributeOptions = document.getElementsByName('option[]');
                var options = [];
                for (var i = 0; i < attributeOptions.length; i++) {
                    options.push(attributeOptions[i].value)
                }
                //console.log(options.length);
                //alert("attributeOptions length :" + attributeOptions.length);
            }

            //console.log("attributeName : " + attributeName + "attributeType" + attributeType + "attributeOptions : " + attributeOptions);
            xmlhttp.onreadystatechange = function()
            {
                //console.log("xmlhttp.readyState : " + xmlhttp.readyState + "xmlhttp.status : " + xmlhttp.status);
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                    var response = xmlhttp.responseText;
                    console.log("Response : " + response);
                    if (response == "true")
                    {
                        var innerHTML;
                        if (attributeType == "1") {
                            //alert("Inside if");
                            innerHTML = '<label><span>' + attributeName + ' :</span><select id="newAttribute" name="' + attributeName + '"><option value="0" selected="selected">Please select..</option>';
                            for (var i = 0; i < attributeOptions.length; i++) {
                                innerHTML += '<option value="' + attributeOptions[i].value + '">' + attributeOptions[i].value + '</option>';
                            }
                            innerHTML += '</select></label>';
                        }
                        else {
                            innerHTML = '<label><span>' + attributeName + ' :</span><input type="text" placeholder="" name="' + attributeName + '" id="newAttribute" /></label>';
                        }

                        document.getElementById('attribute_name').value = '';
                        document.getElementById('attribute_type').value = '';
                        document.getElementById('attribute_label').value = '';

                        document.getElementById('attribute_name').style.border = '1px solid #e7e7e7';
                        document.getElementById('attribute_type').style.border = '1px solid #e7e7e7';
                        document.getElementById('attribute_label').style.border = '1px solid #e7e7e7';

                        //document.getElementById('Message').innerHTML = "<div class='success'>Field has beed added sucessfully.</div>"

                        setTimeout(function()
                        {
                            window.location.reload();
                        }, 200);
                        
                        var innermyspan = document.getElementById("bootstrap-frm").innerHTML;
                        //document.getElementById('light').style.display = 'none';
                        //document.getElementById('fade').style.display = 'none';
                        //document.getElementById("bootstrap-frm").innerHTML = innermyspan + innerHTML;
                        
                    }
                }
            }
            //xmlhttp.open("POST","./lib/route.php?attributeName=" + attributeName + "&attributeType=" + attributeType + "&attributeOptions=" + attributeOptions + "&action='addAttribute'",true);
            xmlhttp.open("POST", "./lib/route.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("attributeName=" + attributeName + "&attributeType=" + attributeType + "&attributeLabel=" + attributeLabel + "&action=addAttribute&attributeOptions=" + options);
            return false;
        }
        function createSku() {
            var xmlhttp = getXhr();
            var sku = document.getElementById('sku').value;
            var manfacturer_part_number = document.getElementById('manufacturer_part_number').value;
            var manfacturer_name = document.getElementById('manufacturer_name').value;
            var title = document.getElementById('title').value;
            var price = document.getElementById('price').value;
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                    var response = xmlhttp.responseText;
                    if (response == "true") {
                        alert("Sku Successfully created.");
                        window.location.href = './sku.php';
                    }
                    else {
                        alert(response);
                    }
                }
            }
            xmlhttp.open("POST", "./lib/route.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("sku=" + sku + "&manufacturer_part_number=" + manfacturer_part_number + "&action=createSku&manufacturer_name=" + manfacturer_name + "&title=" + title + "&price=" + price);
            return false;
        }

        function UpdateSku() {
            var xmlhttp = getXhr();
            var sku_id = document.getElementById('edit_sku_id').value;
            var sku = document.getElementById('edit_sku').value;
            var manfacturer_part_number = document.getElementById('edit_manufacturer_part_number').value;
            var manfacturer_name = document.getElementById('edit_manufacturer_name').value;
            var title = document.getElementById('edit_title').value;
            var price = document.getElementById('edit_price').value;
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                    var response = xmlhttp.responseText;
                    if (response == "true") {
                        alert("Sku Successfully updated.");
                        window.location.href = './sku.php';
                    }
                    else {
                        alert(response);
                    }
                }
            }
            xmlhttp.open("POST", "./lib/route.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("edit_sku=" + sku + "&edit_manufacturer_part_number=" + manfacturer_part_number + "&action=editSku&edit_manufacturer_name=" + manfacturer_name + "&edit_title=" + title + "&edit_price=" + price + "&id=" + sku_id);
            return false;
        }
        function displayTopSearchReport() {
            var xmlhttp = getXhr();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                    //alert(xmlhttp.responseText);
                    var response = xmlhttp.responseText;

                    var myChart = new FusionCharts("./charts/Pie3D.swf", "myChartId", "600", "280", "0");

                    myChart.setJSONData({
                        "chart":
                                {
                                    "caption": "Top Searches",
                                    "xAxisName": "Search Term",
                                    "yAxisName": "Hits",
                                    "numberPrefix": "",
                                    "showexportdatamenuitem": "1"
                                },
                        "data": JSON.parse(xmlhttp.responseText)
                    });
                    myChart.render("chartContainer");
                }
            }
            xmlhttp.open("POST", "./lib/route.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("action=getTopSkuSearch");
            return false;
        }
        function searchSku() {
            //  alert("Comming inside");
            var skuId = document.getElementById('search_sku').value;
            var xmlhttp = getXhr();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                    console.log(xmlhttp.responseText);
                    var table;
                    var response = JSON.parse(xmlhttp.responseText);
                    var headers = Object.keys(response[0]);
                    document.getElementById('searchResults').innerHTML = '';
                    table = "<thead><tr>";
                    for (header in headers) {
                        table += "<th>" + headers[header] + "</th>";
                    }
                    table += "</tr></thead>";
                    console.log(table);
                    var res = document.getElementById('searchResults').innerHTML;

                    for (i = 0; i < response.length; i++) {
                        //table=table+'<tr class=tixrow><td>'+response[i]['ID']+'</td><td>'+response[i]['SKU']+'</td><td>'+response[i]['manufacturer_part_number']+'</td><td>'+response[i]['manufacturer_name']+'</td><td>'+response[i]['Title']+'</td></tr>';
                        table += "<tbody><tr>";
                        for (header in headers) {
                            table += "<td>" + response[i][headers[header]] + "</td>";
                        }
                        table += "</tr></tbody>";
                    }
                    document.getElementById('searchResults').innerHTML = res + table;
                }
            }
            xmlhttp.open("POST", "./lib/route.php");
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("action=getSkuSearch&skuId=" + skuId);
            return false;
        }
    </script>
    <style type="text/css">
        .container {
            width:960px;
            margin: auto;
            /*padding:10px;
            border-left:1px solid #EEEEEE;
            border-right:1px solid #EEEEEE;*/
        }
        .sku-grid {
            border-collapse:collapse;
            width:100%;
            font-family: arial;
            overflow-x: scroll;
        }
        .sku-grid thead tr th {
            background-color: #eeeeee;
            text-align: left;
            font-size: 13px;
            background-image: linear-gradient(to bottom, #F0F0F0, #DEDEDE);
        }
        .sku-grid thead tr th a {
            color: #777777;
            text-decoration: none;            
        }
        .sku-grid tbody tr td:first-child a{color: #3399FF;}
        .sku-grid tbody tr td{font-size: 12px; text-align: left;}
        .sku-grid thead tr th,
        .sku-grid tbody tr td {
            border:1px solid #E1E4E4;
            padding:10px 5px;

        }
        .sku-grid .filter {
            background-color: #eeeeff;
        }
        .sku-grid tbody tr td a{
            text-decoration: none;
            color: #000000;
        }
        .pagination {
            padding: 12px;
        }
        .page {
            display: inline-block;
            padding: 3px 7px;
            margin-right: 4px;
            border-radius: 3px;
            border: solid 1px #c0c0c0;
            background: #e9e9e9;
            /*box-shadow: inset 0px 1px 0px rgba(255,255,255, .8), 0px 1px 3px rgba(0,0,0, .1);*/
            font-size: 1em;
            font-weight: normal;
            text-decoration: none;
            color: #717171;
            font-family: arial;
            font-size:12px;
        }
        .page:hover, .page.gradient:hover {
            background: #fefefe;
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FEFEFE), to(#f0f0f0));
            background: -moz-linear-gradient(0% 0% 270deg,#FEFEFE, #f0f0f0);
        }        
        .filter-in {
            width: 40px;;
        }       
        tr:nth-child(even) {background: #fff}
        tr:nth-child(odd) {background: #F7FAFA;}
        tr:hover {
            background-color: #C6D5D5;
        }
        .page.selected  {
            background: #A7BC7A !important;
        }
        .numbers {
            padding:10px 0px;
        }
        .form-wrapper {
            width:70%;
        }
        .field-wrapper {
            padding: 10px;
            height:30px;
        }
        .form-field {
            padding:5px;
            margin:3px;
            border:1px solid #e3e3e3;
            width:300px;
        }
        .button-wrapper {
            float:right;

        }
        .form-button {
            background-color: #e6e6e6;
            padding:4px 4px;
            border:1px;
            width:100px;
            margin:3px;
        }
        .field-label {
            text-transform: capitalize;
            width:300px;
            display: table-row;
        }

        /* Starter CSS for Flyout Menu */
        #menu,
        #menu ul,
        #menu li #menu a {
            list-style: none;
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 14px;
            font-family: Helvetica;
            line-height: 1;
        }
        #menu {
            width:960px;
            margin: auto;
        }
        #menu ul {
            zoom: 1;
            background: #a7bc7a url(pattern.png) top left repeat;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            border: 1px solid #839b4e;
            -moz-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
            -webkit-box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3);
        }
        #menu ul:before {
            content: '';
            display: block;
        }
        #menu ul:after {
            content: '';
            display: table;
            clear: both;
        }
        #menu a,
        #menu a:link,
        #menu a:visited {
            padding: 15px 20px;
            display: block;
            text-decoration: none;
            color: #ffffff;
            text-shadow: 0 -1px 1px #586835;
            border-right: 1px solid #839b4e;
        }
        #menu a:hover {
            color: #586835;
            text-shadow: 0 1px 1px #bdcd9c;
        }
        #menu li {
            float: left;
            border-right: 1px solid #b2c58b;
        }
        #menu li:hover {
            background: #9cb369 url(pattern.png) top left repeat;
        }
        #menu li:first-child {
            border-left: none;
            -webkit-border-radius: 4px 0 0 4px;
            -moz-border-radius: 4px 0 0 4px;
            border-radius: 4px 0 0 4px;
        }

        .sub-menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            line-height: 1;
            display: block;
            zoom: 1;
        }

        .sub-menu ul li {
            float: left;
            display: block;
            padding: 2;
        }

        .sub-menu li a{

            color: #717171;
        }

        #clear {
            clear: both;
            padding: 5px;
        }
        .bootstrap-frm {
            width: 700px;
            margin-left: 10px;
            background: #FFF;
            padding: 20px 30px 20px 30px;
            font: 12px "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #888;
            text-shadow: 1px 1px 1px #FFF;
            border:1px solid #DDD;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
        }
        .bootstrap-frm h1 {
            font: 25px "Helvetica Neue", Helvetica, Arial, sans-serif;
            padding: 0px 0px 10px 40px;
            display: block;
            border-bottom: 1px solid #DADADA;
            margin: -10px -30px 30px -30px;
            color: #888;
        }
        .bootstrap-frm h1>span {
            display: block;
            font-size: 11px;
        }
        .bootstrap-frm label {
            display: block;
            margin: 0px 0px 5px;
        }
        .bootstrap-frm label>span {
            float: left;
            width: 160px;
            text-align: right;
            padding-right: 10px;
            margin-top: 10px;
            color: #333;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: bold;
        }
        .bootstrap-frm input[type="text"], .bootstrap-frm input[type="email"], .bootstrap-frm textarea, .bootstrap-frm select{
            border: 1px solid #CCC;
            color: #888;
            height: 40px;
            margin-bottom: 16px;
            margin-right: 6px;
            margin-top: 2px;
            outline: 0 none;
            padding: 6px 12px;
            width: 40%;
            border-radius: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            font: normal 14px/14px "Helvetica Neue", Helvetica, Arial, sans-serif;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }

        .bootstrap-frm select {
            background: #FFF url('down-arrow.png') no-repeat right;
            background: #FFF url('down-arrow.png') no-repeat right; 
            appearance:none;
            /*-webkit-appearance:none;
            -moz-appearance: none;
            text-indent: 0.01px;*/
            text-overflow: '';
            width: 40%;
            height: 30px;
        }
        .bootstrap-frm textarea{
            height:100px;
        }
        .bootstrap-frm .button {
            background: #FFF;
            border: 1px solid #CCC;
            padding: 10px 25px 10px 25px;
            color: #333;
            border-radius: 4px;
        }
        .bootstrap-frm .button:hover {
            color: #333;
            background-color: #EBEBEB;
            border-color: #ADADAD;
        }
        .bootstrap-frm a {    
            color: #333;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: bold;
            text-transform: uppercase;
        }
        .black_overlay{
            display: none;
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 100%;
            background-color: black;
            z-index:1001;
            -moz-opacity: 0.8;
            opacity:.80;
            filter: alpha(opacity=80);
        }
        .white_content {
            display: none;
            position: absolute;
            top: 25%;
            left: 25%;
            width: 600px;
            height: 400px;
            padding: 16px;
            border:1px solid #DDD;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            background-color: white;
            z-index:1002;
            overflow: auto;
        }

        #Message{text-align: center;}
        .success{color: #437C00; text-align: center;}
        .newSku{padding: 10px; background-color: #EFFFEF; border:1px solid #DEEEDE; margin-bottom: 10px; color: #8BA05E; font-family: arial; font-size: 13px;}
        #tableWraper{width: 100%; overflow-x: scroll;}
        #displayButton{margin-top: 10px;}
        .error{}
    </style>
</head>
<body>
    <div id="Header">
        <div id="menu">
            <ul>
                <li class='active'><a href='<?= App::$baseUrl; ?>'><span>Home</span></a></li>
                <li><a href='<?= App::$baseUrl; ?>sku.php'><span>SKU</span></a></li>
                <li><a href='<?= App::$baseUrl; ?>createSku.php'><span>Add SKU</span></a></li>
                <li><a href='<?= App::$baseUrl; ?>reports.php'><span>Reports</span></a></li>
                <li><a href='<?= App::$baseUrl; ?>fields.php'><span>Add Field</span></a></li>
            </ul>
        </div>
    </div>