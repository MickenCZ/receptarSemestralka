const formTag = document.getElementById("form")
const usernameTag = document.getElementById("username")
const emailTag = document.getElementById("email")
const password1Tag = document.getElementById("password1")
const password2Tag = document.getElementById("password2")
const emailError = document.getElementById("emailError")

function validateEmail() {
    const email = emailTag.value
    if (email == "") {return {valid: true, error:null}}
    if (email.includes("@")) {return {valid:true, error:null}}
    if (!email.includes("@")) {return {valid:false, error:"Email není platný"}}
}

emailTag.addEventListener("blur", () => {
    const {isValid, error} = validateEmail()
    if (!isValid) {
        emailError.innerHTML = error
    }
    else {
        emailError.innerHTML = ""
    }
})


//MAKE SURE TO PREVENT DEFAULT at end if everything isnt validated