const formTag = document.querySelector("form")
const usernameTag = document.getElementById("username")
const emailTag = document.getElementById("email")
const password1Tag = document.getElementById("password1")
const password2Tag = document.getElementById("password2")
const emailError = document.getElementById("emailError")
const usernameError = document.getElementById("usernameError")
const password1Error = document.getElementById("password1Error")
const password2Error = document.getElementById("password2Error")
// Set constants of needed tags so I dont have to use getElementById later

async function validateUsername() {
    const username = usernameTag.value
    if (username == "") {return {valid: false, error:"Uživatelské jméno nesmí být prázdné"}}
    const response = await fetch("./userExists.php?username=" + username)
    const result = await response.text()
    usernameTag.dataset.exists = result
    if (result == "true") {
        return {valid:false, error:"Uživatel s takovým jménem už existuje."}
    }
    else if (result == "false") {
        return {valid:true, error:""}
    }
    else { //Else happens in case of a database error
        return {valid:false, error:"Stala se chyba na serveru."}
    }
}

usernameTag.addEventListener("blur", async () => {
    const { error } = await validateUsername() //returns a promise so we have to await it
    usernameError.innerHTML = error
    //error je prázdný string, pokud chyba není
})

function validateEmail() {
    const email = emailTag.value
    if (email == "") {return {valid: true, error:""}}
    if (email.includes("@")) {return {valid:true, error:""}}
    if (!email.includes("@")) {return {valid:false, error:"Email není platný"}}
}

emailTag.addEventListener("blur", () => {
    const { error } = validateEmail()
    emailError.innerHTML = error
    //error je prázdný string, pokud chyba není
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
    return {valid: true, error:""}
} 

function validatePassword2() {
    const password2 = password2Tag.value
    if (password2 === password1Tag.value) {
        {return {valid:true, error:""}}
    }
    else {
        {return {valid:false, error:"Hesla se neshodují"}}
    }
}

function runPasswordChecks() {
    const password1 = validatePassword1()
    const password2 = validatePassword2()
    password1Error.innerHTML = password1.error
    password2Error.innerHTML = password2.error
    //error is empty string, if there is no error
}

password1Tag.addEventListener("blur", () => {
    runPasswordChecks()
})


password2Tag.addEventListener("blur", () => {
    runPasswordChecks()
})



formTag.addEventListener("submit", e => {
    if (!(validateEmail().valid && validatePassword1().valid && validatePassword2().valid && usernameTag.dataset.exists == "false")) {
        e.preventDefault()
    }
})


/*
The idea is to create functions that start with the word validate, 
which return an object which tells you if the input is valid, and if not, an error. 
These functions are run on blur, errors are displayed if present.
The reason for this architecture is so that I can check all functions on submit,
and prevent default if even just one input fails.
*/