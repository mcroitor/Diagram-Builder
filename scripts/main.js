var selected = "blank";
var move = 0;
var piece = 0;

function switchCase(chr){
    var lowcase = "abcdefghijklmnopqrstuvwxyz";
    var upcase  = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var index = lowcase.indexOf(chr);
    if(index !== -1)
        return upcase.charAt(index);
    index = upcase.indexOf(chr);
    if(index !== -1)
        return lowcase.charAt(index);
    return chr;
}

function genLink()
{
    link_ = "./diagram/?fen=";
    link_ = link_ + document.getElementById("fen").value;
    size_ = document.getElementById("size");
    link_ = link_ + "&size=" + size_.options[size_.selectedIndex].text;
    style_ = document.getElementById("style");
    link_ = link_ + "&style=" + style_.options[style_.selectedIndex].text;
    color_ = document.getElementById("color");
    link_ = link_ + "&color=" + color_.options[color_.selectedIndex].value;
    strip_ = document.getElementById("solid").checked;
    link_ = link_ + "&solid=" + strip_;
    double_ = document.getElementById("double").checked;
    link_ = link_ + "&double=" + double_;
    document.getElementById("dlink").setAttribute("href", link_);
}

function fenToTable(fen)
{
    tmp = fen.split("/");
    pos = [
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0]
    ];
    for(i = 0; i < 8; ++i)
    {
        k = 0;
        for(j = 0; j < tmp[i].length; ++j)
        {
            if(tmp[i][j] > '0' && tmp[i][j] < '9')
            {
                k+= parseInt(tmp[i][j]);
            }
            else
            {
                //alert(tmp[i][j] + ": (" + i+", "+k+")");
                pos[i][k] = tmp[i][j];
                k++;
            }
        }
    }
    return pos;
}

function tableToFen(pos)
{
    fen = "";
    lines = ["", "", "", "", "", "", "", ""];
    for(i = 0; i < 8; ++i)
    {
        count = 0;
        for(j = 0; j < 8; ++j)
        {
            if(pos[i][j] === 0)
            {
                count++;
            }
            else
            {
                if(count > 0)
                {
                    lines[i] += count;
                    count = 0;
                }
                lines[i] += pos[i][j];
            }
        }
        if(count > 0)
            lines[i] += count;
    //alert("line "+i+" : "+lines[i]);
    }
    fen = lines.join("/");
    return fen;
}

function transformP(method)
{
    fen = document.getElementById("fen").value;
    fen = fen.split(" ")[0];
    tmp = fen.split("/");
    switch(method)
    {
        case "left":
            pos = fenToTable(fen);
            for(i = 0; i < 8; i++)
            {
                value = pos[i].shift();
                pos[i][pos[i].length] = value;
            }
            fen = tableToFen(pos);
            break;
        case "right":
            pos = fenToTable(fen);
            for(i = 0; i < 8; i++)
            {
                pos[i].unshift(0);
                pos[i][0] = pos[i][8];
                pos[i].splice(8,1);
            }
            fen = tableToFen(pos);
            break;
        case "top":
            obj = tmp.shift();
            fen = tmp.join("/")+"/"+obj;
            break;
        case "bottom":
            tmp.unshift("8");
            tmp[0] = tmp[8];
            tmp.splice(8, 1);
            fen = tmp.join("/");
            break;
        case "cw":
            pos = fenToTable(fen);
            aux = [[],[],[],[],[],[],[],[]];
            for(i = 0; i < 8; ++i)
            {
                for(j = 0; j < 8; ++j)
                {
                    aux[i][j] = pos[7-j][i];
                }
            }
            fen = tableToFen(aux);
            break;
        case "acw":
            pos = fenToTable(fen);
            aux = [[],[],[],[],[],[],[],[]];
            for(i = 0; i < 8; ++i)
            {
                for(j = 0; j < 8; ++j)
                {
                    aux[i][j] = pos[j][7-i];
                }
            }
            fen = tableToFen(aux);
            break;
        case "switch":
            pos = fenToTable(fen);
            aux = [];
            for(i = 0; i < 8; ++i)
                aux[i] = pos[7-i];
            fen = tableToFen(aux);
            break;
        case "switch_color":
            pos = fenToTable(fen);
            aux = [[],[],[],[],[],[],[],[]];
            for(i = 0; i < 8; ++i){
                for(j = 0; j < 8; ++j)
                    aux[i][j] = switchCase(pos[7-i][j]);
            }
                
            fen = tableToFen(aux);
            break;
    }
    genBoard(fen);
    document.getElementById("fen").value = fen;
    genLink();
}

function previewD()
{
    link_ = document.getElementById("dlink").getAttribute("href");
    document.getElementById("preview").innerHTML = "<img src='"+link_+"' />";
}

function set(image)
{
    if(move > 0)
    {
        if(move === 1)
        {
            if(piece)piece.setAttribute("style", "border: 0px solid red");
            piece = image;
            move = 2;
            image.setAttribute("style", "border: 1px solid red");
        }
        else if(move === 2)
        {
            if(piece !== image)
            {
                image.setAttribute("src",piece.getAttribute("src"));
                image.setAttribute("alt", piece.getAttribute("alt"));
                piece.setAttribute("src","./images/blank.png");
                piece.setAttribute("alt", "blank");
                image.setAttribute("style", "border: 0px solid red");
                piece.setAttribute("style", "border: 0px solid red");
                document.getElementById("fen").value=genFen();
                genLink();
            }

            move = 1;
        }
    }
    else
    {
        image.setAttribute("src","./images/"+selected+".png");
        image.setAttribute("alt", selected);
        document.getElementById("fen").value=genFen();
        genLink();
    }
}

function selectPiece(piece, p)
{
    move = 0;
    var t = document.getElementById("pieces").getElementsByTagName("img");
    for(i = 0; i < t.length; i++)
        t[i].style.border = "2px solid #fff";
    p.style.border = "2px solid red";
    selected = piece;
}

function clearAll()
{
    var t = document.getElementById("board").getElementsByTagName("img");
    for(i = 0; i< t.length; i++)
    {
        t[i].setAttribute("src","./images/blank.png");
        t[i].setAttribute("alt", "blank");
    }
    document.getElementById("fen").value="8/8/8/8/8/8/8/8";
}

function genBoard(fen)
{
    var s = 0;
    fen = fen.split(" ")[0];
    //alert(fen);
    var reg = /[^1-8a-h\/]+/i;
    if(reg.test(fen) === null)
    {
        fen = "8/8/8/8/8/8/8/8";
    }
    var t = document.getElementById("board").getElementsByTagName("img");
    for(i = 0; i < fen.length && fen[i] !== ' '; i++)
    {
        switch(fen[i])
        {
            case 'K': case 'Q': case 'R': case 'B': case 'N': case 'P':
                t[s].setAttribute("src","./images/w"+fen[i].toLowerCase()+".png");
                t[s].setAttribute("alt", "w"+fen[i].toLowerCase());
                s++;
                break;
            case 'k': case 'q': case 'r': case 'b': case 'n': case 'p':
                t[s].setAttribute("src","./images/b"+fen[i]+".png");
                t[s].setAttribute("alt", "b"+fen[i]);
                s++;
                break;
            case 'X':
                t[s].setAttribute("src","./images/cross.png");
                t[s].setAttribute("alt", "cross");
                s++;
                break;
        }
        if(fen[i]>'0' && fen[i]<'9')
        {
            for(j = 0; j < parseInt(fen[i]); j++, s++)
            {
                t[s].setAttribute("src","./images/blank.png");
                t[s].setAttribute("alt", "blank");
            }

        }
    }
    genLink();
}

function genFen()
{
    result="";
    count = 0;
    var t = document.getElementById("board");
    var fields = t.getElementsByTagName("img");
    for(i = 0; i < 64; i++)
    {
        if(i%8 === 0 && i !== 0)
        {
            if(count)
                result += count;
            result += '/';
            count = 0;
        }
        switch(fields[i].alt)
        {
            case 'wk':
                if(count)
                    result += count;
                result += 'K';
                count = 0;
                break;
            case 'wq':
                if(count)
                    result += count;
                result += 'Q';
                count = 0;
                break;
            case 'wr':
                if(count)
                    result += count;
                result += 'R';
                count = 0;
                break;
            case 'wb':
                if(count)
                    result += count;
                result += 'B';
                count = 0;
                break;
            case 'wn':
                if(count)
                    result += count;
                result += 'N';
                count = 0;
                break;
            case 'wp':
                if(count)
                    result += count;
                result += 'P';
                count = 0;
                break;
            case 'bk':
                if(count)
                    result += count;
                result += 'k';
                count = 0;
                break;
            case 'bq':
                if(count)
                    result += count;
                result += 'q';
                count = 0;
                break;
            case 'br':
                if(count)
                    result += count;
                result += 'r';
                count = 0;
                break;
            case 'bb':
                if(count)
                    result += count;
                result += 'b';
                count = 0;
                break;
            case 'bn':
                if(count)
                    result += count;
                result += 'n';
                count = 0;
                break;
            case 'bp':
                if(count)
                    result += count;
                result += 'p';
                count = 0;
                break;
            case 'cross':
                if(count)
                    result += count;
                result += 'X';
                count = 0;
                break;
            default:
                count++;
        }
    }
    if(count)
        result += count;
    return result;
}

function movePiece(img)
{
    move = 1;
    var t = document.getElementById("pieces").getElementsByTagName("img");
    for(i = 0; i < t.length; i++)
        t[i].style.border = "2px solid #fff";
    img.style.border = "2px solid red";
}

