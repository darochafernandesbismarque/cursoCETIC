function removeCharacter(c) {
    var b, a;
    b = "";
    for (a = 0; a < c.length; a++) {
        if (c.charAt(a) !== " " && c.charAt(a) !== "'") {
            b += c.charAt(a)
        }
    }
    return b;
}

function checkCPF(a) {
    var s = 0;
    var c, r;
    c = removeCharacter(a);
    login.cpf.value = c;
    if (c.length !== 11 || c == "00000000000") {
        return false;
    } else {
        for (i = 1; i <= 9; i++) s = s + parseInt(c.substring(i - 1, i)) * (11 - i);
        r = (s * 10) % 11;
        if ((r == 10) || (r == 11)) r = 0;
        if (r != parseInt(c.substring(9, 10))) return false;
        s = 0;
        for (i = 1; i <= 10; i++) s = s + parseInt(c.substring(i - 1, i)) * (12 - i);
        r = (s * 10) % 11;
        if ((r == 10) || (r == 11)) r = 0;
        if (r != parseInt(c.substring(10, 11))) return false;
        return true;
    }
}

function checkPass(s) {
    var p;
    p = removeCharacter(s);
    login.senha.value = p;
    if (p.length < 8) {
        return false;
    } else {
        return true;
    }
}

function eValid() {
    var c, p;
    c = checkCPF(login.cpf.value);
    p = checkPass(login.senha.value);
    if (c == true && p == true) {
        return true;
    } else {
        if (c == false) {
            openAlert("CPF inválido");
        }
        else if (p == false) {
            openAlert("Senha inválida");
        }
        return false;
    }
}

function openAlert(m) {
    var a = document.getElementById('alert');
    var b = document.getElementById('err');
    b.innerHTML = m;
    a.style.display = 'block';
}

function closeAlert() {
    var x = document.getElementById('alert');
    x.style.display = 'none';
}