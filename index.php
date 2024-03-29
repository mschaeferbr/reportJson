<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">

    <title>.:: JSON Editor Online ::. View, edit and format JSON online</title>

    <!--

    @file index_no_ads.html

    @brief
    JSON Editor Online is a web-based tool to view, edit, and format JSON.
    It shows your data side by side in a clear, editable treeview and in
    formatted plain text.

    Supported browsers: Chrome, Firefox, Safari, Opera, Internet Explorer 8+

    @license
    This json editor is open sourced with the intention to use the editor as
    a component in your own application. Not to just copy and monetize the editor
    as it is.

    Licensed under the Apache License, Version 2.0 (the "License"); you may not
    use this file except in compliance with the License. You may obtain a copy
    of the License at

    http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
    WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
    License for the specific language governing permissions and limitations under
    the License.

    Copyright (C) 2011-2012 Jos de Jong, http://jsoneditoronline.org

    @author   Jos de Jong, <wjosdejong@gmail.com>
    @date     2012-08-25
    -->

    <meta name="description" content="JSON Editor Online is a web-based tool to view, edit, and format JSON. It shows your data side by side in a clear, editable treeview and in formatted plain text.">
    <meta name="keywords" content="json, editor, formatter, online, format, parser, json editor, json editor online, online json editor, javascript, javascript object notation, tools, tool, json tools, treeview, open source, free, json parser, json parser online, json formatter, json formatter online, online json formatter, online json parser, format json online">
    <meta name="author" content="Jos de Jong">
    <link rel="shortcut icon" href="external/jsoneditoronline/favicon.ico">
    <link href="external/jsoneditoronline/interface/interface.css" rel="stylesheet" type="text/css">
    <link href="interface/interface.css" rel="stylesheet" type="text/css">
    <link href="external/jsoneditoronline/jsoneditor/jsoneditor.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="external/jsoneditoronline/jsoneditor/jsoneditor.js"></script>
    <script type="text/javascript" src="external/jsoneditoronline/interface/interface.js"></script>
    <script type="text/javascript" src="interface/interface.js"></script>

</head>

<body spellcheck="false" >

<div id="header" >
    <a class="header">
        <img alt="JSON Editor Online" src="external/jsoneditoronline/interface/img/logo.png" id="logo">
    </a>


    <!-- TODO: info, links, faq -->
    <!--
  <div class="info" style="display:none;">
    JSON, or JavaScript Object Notation, is a lightweight text-based open standard
    designed for human-readable data interchange. It is derived from the JavaScript
    scripting language for representing simple data structures and associative arrays,
    called objects. Despite its relationship to JavaScript, it is language-independent,
    with parsers available for most languages.
    The JSON format was originally specified by Douglas Crockford, and is described
    in RFC 4627. The official Internet media type for JSON is application/json.
    The JSON filename extension is .json.
    The JSON format is often used for serializing and transmitting structured data
    over a network connection. It is used primarily to transmit data between a server
    and web application, serving as an alternative to XML.
    <br><br>
    From <a target="_blank" href="http://en.wikipedia.org/wiki/Json">Wikipedia</a>
  </div>

  <div class="links" style="display:none;">
    <a target="_blank" href="http://json.org/">http://json.org/</a><br>
    <a target="_blank" href="http://en.wikipedia.org/wiki/Json">http://en.wikipedia.org/wiki/Json</a><br>
  </div>

  <div class="faq" style="display:none;"></div>
    -->
</div>
    <div id="config">
        <div id="headerConfig">
            <img alt="JSON Editor Online" src="interface/img/logo.png" id="logo">
        </div>
        <center>
            <fieldset style="width: 550px; text-align: left; height: 50px; margin-top: 30px; border-radius: 8px 8px 8px 8px; box-shadow: inset 0px 0px 5px #ffffff;">
                <legend><label><b>Entrada (</b>Arquivo JSON<b>)</b></label></legend>
                <table>
                    <tr>
                        <td>
                            <form enctype='multipart/form-data' target="frame" style="height:10px;"
                              id="form_upload"  name="form_upload"
                              method="post" action="upDownFile/upload.php"
                             >
                                <input style=" cursor: pointer;" type="file" id="fileUp" name="fileUp">
                                <button style="cursor: pointer;" onclick="main._upload();">Carregar JSON</button>
                                <iframe name="frame" id="frame" style="margin:0px;padding:0px;height:0px;width:0px;visibility:hidden;"></iframe>
                            </form>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset style="width: 550px; text-align: left; margin-top: 50px; border-radius: 8px 8px 8px 8px; box-shadow: inset 0px 0px 5px #ffffff;">
                <legend><label><b>Processamento (</b>Gerar Relatórios<b>)</b></label></legend>
                <table>
                    <tr>
                        <td style="width: 183px; text-align: center;">
                            <button style="cursor: pointer;" onclick="main._reportJson('.html');">HTML</button>
                        </td>
                        <td style="width: 183px; text-align: center;">
                            <button style="cursor: pointer;" onclick="main._reportJson('.pdf');">PDF</button>
                        </td>
                        <td style="width: 183px; text-align: center;">
                            <button style="cursor: pointer;" onclick="main._reportJson('.xls');">XLS</button>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset style="width: 550px; text-align: left; margin-top: 50px; border-radius: 8px 8px 8px 8px; box-shadow: inset 0px 0px 5px #ffffff;">
                <legend><label><b>Saída (</b>Arquivo:&nbsp;<span id="fileType"></span><b>)</b></label></legend>
                <table>
                    <tr>
                        <td style="text-align: right;">
                            <label>Nome:</label>
                        </td>
                        <td>
                            <input id="fileDown" type="hidden" value="" />
                            <!--<input id="fileType" type="hidden" value="" />-->
                            <input id="fileName" size="50" maxlength="30" />
                        </td>
                        <td>
                            <button style="cursor: pointer;" onclick="main._reportJsonDisplay();">Exibir</button>
                        </td>
                        <td>
                            <button style="cursor: pointer;" onclick="main._reportJsonDownload();">Salvar</button>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </center>
    </div>
    <div id="block" style="cursor: pointer;" onclick="document.getElementById('confClose').click();"></div>
    <div id="auto">
    <div id="contents">
        <div id="jsonformatter"></div>

        <div id="splitter"></div>

        <div id="jsoneditor"></div>

        <script type="text/javascript">
            main.load();
            main.resize();
            main._loadConf();
            main._setJson();
        </script>

        <div id="ad" title="advertisement" >
            <div id="adInfo">
                ADVERTISEMENT<br>
                <a class="adInfo" href="javascript: main.hideAds();">hide for now</a><br>
                <div id="removeAds">
                    <a class="adInfo" href="javascript: main.removeAds()">get rid of the ads</a>
                </div>
                <div id="chromeAppInfo" style='display: none;'>
                    <br>If you want to get rid of the ads,
                    you can buy the Chrome App.
                    This will give you the JSON Editor without ads,
                    offline available, always up to date, and just one click away.<br>
                    <a class="adInfo"
                       href="https://chrome.google.com/webstore/detail/gckckcmcgknlbcmnpgijfmpppiplijgn"
                       target="_blank">Click here for more info</a>
                </div>
            </div>

            <div class="adSpace"></div>

            <script type="text/javascript"><!--
            google_ad_client = "ca-pub-7938810169574141";
            /* jsoneditoronline_160x600 */
            google_ad_slot = "4671869937";
            google_ad_width = 160;
            google_ad_height = 600;
            //-->
            </script>

            <!--
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
            -->

        </div>
    </div>
</div>

<div id="footer">
    <div id="footer-inner">
        <a href="http://jsoneditoronline.org" class="footer">JSON Editor Online 1.4.4</a>
        &bull;
        <a href="changelog.txt" target="_blank" class="footer">Changelog</a>
        &bull;
        <a href="https://github.com/wjosdejong/jsoneditoronline" target="_blank" class="footer">Sourcecode</a>
        &bull;
        <a href="NOTICE" target="_blank" class="footer">Copyright 2011-2012 Jos de Jong</a>
    </div>
</div>

<script type="text/javascript">
    main.resize();
</script>

</body>
</html>
