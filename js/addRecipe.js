const formTag = document.querySelector("form")
const recipeNameTag = document.getElementById("recipeName")
const ingredientsTag = document.getElementById("ingredients")
const descriptionTag = document.getElementById("description")
const imageTag = document.getElementById("image")
const recipeNameError = document.getElementById("recipeNameError")
const ingredientsError = document.getElementById("ingredientsError")
const descriptionError = document.getElementById("descriptionError")
const imageError = document.getElementById("imageError")
const ingredientsInfo = document.getElementById("ingredientsInfo")
// Set constants of needed tags so I dont have to use getElementById later

function validateRecipeName() {
    if (recipeNameTag.value.length >= 3) {
        return {valid:true, error:""}
    }
    else {
        return {valid:false, error:"Jméno receptu je moc krátké."}
    }
}

recipeNameTag.addEventListener("blur", () => {
    const { error } = validateRecipeName()
    recipeNameError.innerHTML = error
})

function validateIngredients() {
    if (ingredientsTag.value.length == 0) {
        ingredientsInfo.innerHTML = ""
        return {valid:false, error:"Ingredience nesmí být prázdné."}
    }
    else {
        let ingredientsArray = ingredientsTag.value.split(",") //ingredients are separated by commas
        ingredientsArray = ingredientsArray.map(item => item.trim()) //trim the space at end or start of each ingredient, to prevent asd, qwe => ["asd", " qwe"]
        ingredientsArray = ingredientsArray.filter(item => item != "") //remove empty items caused by comma at end
        //now we have a valid array of ingredients
        ingredientsInfo.innerHTML = "Ingredience:" + ingredientsArray.join(", ")
        return {valid:true, error:""}
    }
}

ingredientsTag.addEventListener("blur", () => {
    const { error } = validateIngredients()
    ingredientsError.innerHTML = error
})

function validateDescription() {
    if (descriptionTag.value.length <= 20) {
        return {valid:false, error:"Popis postupu je moc krátký"}
    }
    else {
        return {valid:true, error:""}
    }
}

descriptionTag.addEventListener("blur", () => {
    const { error } = validateDescription()
    descriptionError.innerHTML = error
})


function validateImage() {
    if (imageTag.files.length == 1) {
        return {valid:true, error:""}
    }
    else {
        return {valid:false, error:"Recept musí mít právě jeden obrázek"}
    }
}

imageTag.addEventListener("change", () => {
    const { error } = validateImage()
    imageError.innerHTML = error
})

formTag.addEventListener("submit", e => {
    if (!(validateRecipeName().valid && validateIngredients().valid && validateDescription().valid && validateDescription().valid)) {
        recipeNameError.innerHTML = validateRecipeName().error
        ingredientsError.innerHTML = validateIngredients().error
        descriptionError.innerHTML = validateDescription().error
        imageError.innerHTML = validateImage().error
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