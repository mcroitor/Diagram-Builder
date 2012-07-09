function colorPickerDialog(){
    var dlg = "<input id='color-picker' onclick='showCPDlg();' />";
    dlg += "<div style='display:none;' id='c-p-dlg'><table style='border-collapse:collapse;' cellspacing='0' cellpadding='0'>";
    for(i = 0; i != 16; ++i){
        dlg += "<tr>";
        for(j = 0; j != 16; ++j){
            dlg += "<td>"+"<div style='background-color:rgb("+16*i+", "+16*j+", "+i*j+"); width:8px; height:8px;' onclick='SetColor(i, j);'></div></td>";
        }
        dlg += "</tr>";
    }
    dlg += "</table></div>";
    return dlg;
}

function ShowCPDlg(){
    var style="position:absolute; z-index:15;";
    document.getElementById("c-p-dlg").style = style;
}

function SetColor(x, y){
    document.getElementById("color-picker").value = "rgb("+16*x+", "+16*y+", "+x*y+");";
    document.getElementById("color-picker").backgroundColor = "rgb("+16*x+", "+16*y+", "+x*y+");";
}


