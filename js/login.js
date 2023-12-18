const formTag = document.querySelector("form")
const usernameTag = document.getElementById("username")
const password1Tag = document.getElementById("password1")
const usernameError = document.getElementById("usernameError")
const password1Error = document.getElementById("password1Error")
// Set constants of needed tags so I dont have to use getElementById later

function validateUsername() {
    if (usernameTag.value == "") {
        return {valid:false, error: "Vaše uživatelské jméno nesmí být prázdné"}
    }
    else {
        return {valid:true, error:""}
    }
}

function validatePassword1() {
    if (password1Tag.value.length < 8) {
        return {valid:false, error:"Heslo má 8 znaků a více"}
    }
    else {
        return {valid:true, error:""}
    }
}

password1Tag.addEventListener("blur", () => {
    const { error } = validatePassword1()
    password1Error.innerHTML = error
})

usernameTag.addEventListener("blur", () => {
    const { error } = validateUsername()
    usernameError.innerHTML = error
})

formTag.addEventListener("submit", e => {
    if (!(validateUsername().valid && validatePassword1().valid)) {
        e.preventDefault()
    }
})


/*
The idea is to create functions that start the word validate, 
which return an object which tells you if the input is valid, and if not, an error. 
These functions are run on blur, errors are displayed if present.
The reason for this architecture is so that I can check all functions on submit,
and prevent default if even just one input fails.
*/