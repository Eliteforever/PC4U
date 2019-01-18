let allCategoryListElement;
let categoryHeaderTextElement;
let inputCategoryNameElement;
let inputCategoryDescriptionElement;
let inputCategoryPhotoNameElement;

let inputPropertySelectElement;
let inputPropertyNameElement;
let inputPropertyDatatypeElement;
let inputPropertyPrefixElement;
let inputPropertyPostfixElement;
let inputPropertyDescriptonElement;

let inputPropertyCategorieId

let propertySelectValues = [];
let allCategories = "";

let control;
let controlProp;


document.addEventListener('DOMContentLoaded', OnDOMReady, false);
function OnDOMReady(){
    allCategoryListElement = document.getElementById('allCategoriesList');  
    categoryHeaderTextElement = document.getElementById('categoryHeaderText');
    inputCategoryNameElement = document.getElementById('inputCategoryName'); 
    inputCategoryDescriptionElement = document.getElementById('inputCategoryDescription'); 
    inputCategoryPhotoNameElement = document.getElementById("inputCategoryPhoto");

    inputPropertySelectElement = document.getElementById('inputPropertySelect'); 
    inputPropertyNameElement = document.getElementById('inputPropertyName'); 
    inputPropertyDatatypeElement = document.getElementById('inputPropertyDatatype'); 
    inputPropertyPrefixElement = document.getElementById('inputPropertyPrefix'); 
    inputPropertyPostfixElement = document.getElementById('inputPropertyPostfix'); 
    inputPropertyDescriptionElement = document.getElementById('inputPropertyDescription');

	inputPropertyCategorieId = document.getElementById('categoryIDInput');
	
    let requestUrl = "/getAllCategories";
	let inputClass = "inputCategory";
	let requestUrlProp = "/getAllProperties";
	let inputClassProp = "inputProperty";
	
	control = new PostControl(requestUrl, inputClass, allCallback);
	controlProp = new PostControl(undefined, inputClassProp);
	
	control.getAll();
	

    inputPropertySelectElement.addEventListener('change', function(){
        selectProperty(propertySelectValues[this.selectedIndex]);
    }); 
	
}

function allCallback(allCategories) {
	
	printCategoryData(allCategories);
	createHiddenElement(allCategories[0], "inputCategory", "category-properties");
	selectedCategory = allCategories[0];

	if (selectedCategory != null){
		//selectCategory(selectedCategory);
	} else {
		selectedCategory = [];
	}
}

function printCategoryData(allCategories){
    printAllCategoryList(allCategories);
}

function printAllCategoryList(allCategories){
	console.log(allCategories);
    for (let i = 0; i < allCategories.length; i++)
    {
        var a = document.createElement('a');
        a.innerHTML = allCategories[i]['name'];
        a.classList.add("collection-item");
		a.setAttribute('idVal', allCategories[i]['id']);
        a.addEventListener('click', function(e){
            selectCategory(allCategories[i]);
        });

        allCategoryListElement.appendChild(a);
    }
}

function selectCategory(category){
    selectedCategory = category;
	
	createHiddenElement(category, "inputCategory", "category-properties");
	
	inputPropertyCategorieId.value = category['id'];
    inputCategoryNameElement.value = category['name'];
    inputCategoryDescription.innerHTML = category['description'];
    inputCategoryPhotoNameElement.innerHTML = category['image']['filename'];

    while (inputPropertySelectElement.firstChild) {
        inputPropertySelectElement.removeChild(inputPropertySelectElement.firstChild);
    }

    propertySelectValues.length = 0;
    let i = 0;

    for (i; i < category['properties'].length; i++){
        option = document.createElement('option');
        propertySelectValues[i] = category['properties'][i];
        option.innerHTML = category['properties'][i]['name'];
        inputPropertySelectElement.appendChild(option);
    }
	console.log(propertySelectValues);
    if (i > 0){
        selectProperty(propertySelectValues[0]);
    } else {
        unselectProperty();
    }
}

function selectProperty(property){
	createHiddenElement(property, "inputProperty","property-properties");
	
    inputPropertyNameElement.value = property['name'];
    inputPropertyDatatypeElement.value = property['datatype'];
    inputPropertyPrefixElement.value = property['prefix'];
    inputPropertyPostfixElement.value = property['postfix'];
    inputPropertyDescriptionElement.innerHTML = property['description'];
}

function unselectProperty(){
    inputPropertyNameElement.value = "";
    inputPropertyDatatypeElement.value = "";
    inputPropertyPrefixElement.value = "";
    inputPropertyPostfixElement.value = "";
    inputPropertyDescriptionElement.innerHTML = ""; 
}

function newCategory(){
    control.post('/admin/addCategory');
}

function editCategory(){
    control.post('/admin/editCategory');
}

function deleteCategory(){
    control.post('/admin/deleteCategory');
}

function newProperty(){
	controlProp.post("/admin/addProperty")
}

function editProperty(){
    controlProp.post('/admin/editProperty');
}

function deleteProperty(){
    controlProp.post('/admin/deleteProperty');
}

function imageChangeCallback(args = { folder: '', filename: ''}) {
    inputCategoryPhotoNameElement.innerHTML = args.filename;
	let imageFolderElm = document.getElementById("imageFolder");
	let imageNameElm = document.getElementById("imageName");
	
	imageFolderElm.value = args.folder;
	imageNameElm.value = args.filename;
}

imageSelectorHandler.addCallback('onAcceptImage', imageChangeCallback);
imageSelectorHandler.addCallback('onClearImage', imageChangeCallback);