const formTag = document.getElementById("form")
const usernameTag = document.getElementById("username")
const emailTag = document.getElementById("email")
const password1Tag = document.getElementById("password1")
const password2Tag = document.getElementById("password2")
const emailError = document.getElementById("emailError")
const usernameError = document.getElementById("usernameError")
const password1Error = document.getElementById("password1Error")
const password2Error = document.getElementById("password2Error")

function validateUsername() {
    return {valid:true}
    //isnt empty, check if its already taken
}

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


function validatePassword1() {
    const password1 = password1Tag.value
    if (password1.length < 8) {
        {return {valid:false, error:"Heslo musí obsahovat alespoň 8 znaků"}}
    }
    if (password1.toLowerCase() === password1 || password1.toUpperCase() === password1) {
        {return {valid:false, error:"Heslo musí obsahovat velká i malá písmena"}}
    }
    if (!/\d/.test(password1)) {//regex to check if it contains a number
        {return {valid:false, error:"Heslo musí alespoň 1 číslo"}}
    }
    //if everything is correct
    return {valid: true, error:null}
} 

function validatePassword2() {
    const password2 = password2Tag.value
    if (password2 === password1Tag.value) {
        {return {valid:true, error:null}}
    }
    else {
        {return {valid:false, error:"Hesla se neshodují"}}
    }
}

function runPasswordChecks() {
    const password1 = validatePassword1()
    const password2 = validatePassword2()
    if (!password1.valid) {password1Error.innerHTML = password1.error}
    else {password1Error.innerHTML = ""}
    if (!password2.valid) {password2Error.innerHTML = password2.error}
    else {password2Error.innerHTML = ""}
}

password1Tag.addEventListener("blur", () => {
    runPasswordChecks()
})


password2Tag.addEventListener("blur", () => {
    runPasswordChecks()
})



formTag.addEventListener("submit", e => {
    if (!(validateEmail().valid && validatePassword1().valid && validatePassword2().valid && validateUsername().valid)) {
        e.preventDefault()
    }
})