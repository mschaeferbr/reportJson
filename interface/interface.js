/**
 * @file interface.js
 *
 * @brief
 * JsonEditor is an editor to display and edit JSON data in a treeview.
 *
 * Supported browsers: Chrome, Firefox, Safari, Opera, Internet Explorer 8+
 *
 * @license
 * This json editor is open sourced with the intention to use the editor as
 * a component in your own application. Not to just copy and monetize the editor
 * as it is.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 *
 * Copyright (C) 2011-2012 Jos de Jong, http://jsoneditoronline.org
 *
 * @author  Jos de Jong, <wjosdejong@gmail.com>
 * @date    2012-08-31
 */

main._loadConf = function() {
    try {
        var domConfig = document.getElementById('config');
        domConfig.style.right= ((parseFloat(window.innerWidth || document.body.offsetWidth || document.documentElement.offsetWidth)/2) - 300) + 'px';
        domConfig.style.top= ((parseFloat(window.innerHeight || document.body.offsetHeight || document.documentElement.offsetHeight)/2) - 200) + 'px';

        var closeConf = document.createElement('img');
        closeConf.id = 'confClose';
        closeConf.onmouseover = function () {
            closeConf.src="interface/img/window_close_over.gif";
        };
        closeConf.onmouseout = function () {
            closeConf.src="interface/img/window_close_out.gif";
        };
        closeConf.style.cursor="pointer";
        closeConf.title = 'Fechar';
        closeConf.src="interface/img/window_close_out.gif";
        closeConf.onclick = function () {
            document.getElementById('block').style.visibility="hidden";
            document.getElementById('config').style.visibility="hidden";
        };
        closeConf.style.position="absolute";
        closeConf.style.right="5px";
        closeConf.style.top="10px";

        domConfig.appendChild(closeConf);

        var openConf = document.createElement('button');
        openConf.id = 'openConf';
        openConf.title = 'Configurações / Ações do Componente ReportJson';
        openConf.className = 'convert';
        openConf.innerHTML = '<div class="openConf"></div>';
        openConf.onclick = function () {
            document.getElementById('block').style.visibility="visible";
            document.getElementById('config').style.visibility="visible";
        };
        var domSplitter = '';
        var linha = '';
        try{
            domSplitter = document.getElementById('splitter');
            domSplitter.insertAdjacentElement("afterBegin",openConf);
            linha = document.createElement('br');
            domSplitter.insertAdjacentElement("afterBegin",linha);
        }catch(e){
            domSplitter = document.getElementById('toForm');
            domSplitter.parentNode.insertBefore(openConf, domSplitter.previousSibling.previousSibling);
            linha = document.createElement('br');
            domSplitter.parentNode.insertBefore(linha, domSplitter.previousSibling);
        }


        if( /.*Chrome.*/.test(navigator.userAgent) ){
            //divGrupoPrincipal.style.WebkitTransform = 'scale(1)';
        }else if( /.*Firefox.*/.test(navigator.userAgent) ){
            document.getElementById('fileName').size='35';
        }else if( /.*MSI.*/.test(navigator.userAgent) ){
            //divGrupoPrincipal.style.MsTransform = 'scale(1)';
        }



    /* TODO: use checkChange
         checkChange();
         */
    } catch (err) {
        var msg = err.message || err;
        main.showError('Error: ' + msg);
    }
}

main._reportJson = function (type) {
    main._clear();
    var json = main._getJson();
//        var d = new Date();
//        var data=d.getFullYear().toString() + (d.getMonth()+1).toString() + d.getDay().toString();
//        var hora=d.getHours().toString() + (d.getMinutes()+1).toString() + d.getMilliseconds().toString();
////        +data+'_'+hora
//        document.getElementById('fileDown').value='reportJson'+data+'_'+hora;

    var url = 'report/control.php';
    var params = 'type='+type+'&json='+ encodeURIComponent(json);
    var http_request = main._ajax(url, params);
    http_request.onreadystatechange = function () {
        var done = 4, ok = 200;
        if (http_request.readyState == done && http_request.status == ok) {
            eval(http_request.responseText);
        }
    }
}

main._reportJsonDisplay = function () {
    if (!document.getElementById('fileDown').value){
        alert('Arquivo não encontrado.');
        return;
    }
    if (!document.getElementById('fileType').innerHTML){
        alert('Typo do arquivo não encontrado.');
        return;
    }else if(document.getElementById('fileType').innerHTML=='.xls'){
        main._reportJsonDownload();
        return;
    }

    var Y= 950;
    var H= 650;
    window.open(
        'http://localhost/reportJson/tmp/'+document.getElementById('fileDown').value+document.getElementById('fileType').innerHTML,
        'openpdf',
        'toolbar=no,location=no,directories=no,status=no,menubar=no,'+
        'scrollbars=yes,resizable=no,copyhistory=no,width='+Y+',height='+
        H+',left='+((screen.availWidth/2)-Y/2)+',top='+((screen.availHeight/2)-H/2)
        );
}

main._reportJsonDownload = function () {
    if (!document.getElementById('fileDown').value){
        alert('Arquivo não encontrado.');
        return;
    }
    if (!document.getElementById('fileType').innerHTML){
        alert('Tipo de arquivo não encontrado.');
        return;
    }
    if (!document.getElementById('fileName').value){
        alert('Informe um nome para o arquivo.');
        document.getElementById('fileName').focus();
        return;
    }
    var url = 'upDownFile/download.php?';
    var params = 'fileDown=http://localhost/reportJson/tmp/'+document.getElementById('fileDown').value+document.getElementById('fileType').innerHTML;
    params +='&fileName='+document.getElementById('fileName').value+document.getElementById('fileType').innerHTML;
    document.getElementById('frame').src=url+params;
}

main._getJson = function () {
    var obj = formatter.get();
    var json = JSON.stringify(obj, null, 2);
    return json;
}

main._clear = function () {
    document.getElementById('fileDown').value='';
    document.getElementById('fileType').innerHTML='';
    document.getElementById('fileName').value='';
}
main._upload = function () {
    main._clear();
    document.form_upload.submit();
    setTimeout('main._setJson();',100);
}

main._setJson = function () {
    var url = 'examples/getJson.php';
    var params = 'fileUp='+document.getElementById('fileUp').value.replace('C:\\fakepath\\','');
    var json = {};

    var http_request = main._ajax(url, params);
    http_request.onreadystatechange = function () {
        var done = 4, ok = 200;
        if (http_request.readyState == done && http_request.status == ok) {
            if (!http_request.responseText){
                alert('JSON não encontrado.');
            }else{
                try{
                    json =  JSON.parse(http_request.responseText);
                }catch(e){
                    alert("JSON inválido. "+ e);
                }
            }
            editor.set(json);
            formatter.set(json);
        }
    }
}

main._ajax = function (url, params) {
    var http_request = new XMLHttpRequest();
    http_request.open("POST", url, true);
    http_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
    http_request.send(params);
    return http_request;
}