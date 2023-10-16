function verifier() {
    var pass1 = document.getElementById("password");
    var pass2 = document.getElementById("passwordC");
    var message = document.getElementById("message");
    if (pass1.value == pass2.value) {
        message.innerHTML = "Valide";
        message.style.color = "green";
    } else {
        message.innerHTML = "Invalide";
        message.style.color = "red";
    }
}
