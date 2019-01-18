let control, controlCato, controlProp;
let selectedID;
let allProductsList;
let inputPropertySelect;
let inputProductPhotoNameElement;
let previousSelectedCato;

document.addEventListener('DOMContentLoaded', OnDOMReady, false);
function OnDOMReady(){
    let requestUrl = '/getAllProducts';
    let requestUrlCato = '/getAllCategories';
	let inputClass = 'inputProduct';
	let inputClassProp = 'inputProperty'
	
	inputProductPhotoNameElement = document.getElementById('inputProductPhoto');
	allProductsList = document.getElementById('allProductsList');
	inputPropertySelect = document.getElementById('inputPropertySelect');
	
	control = new PostControl(requestUrl, inputClass, allCallBack);
	controlCato = new PostControl(requestUrlCato, undefined, allCallBackCato);
	controlProp = new PostControl(undefined, inputClassProp, undefined);
	
	let productIDELM = document.getElementById('inputProductID');
	selectedID = productIDELM.value;
	
	let categoryIDELM = document.getElementById('inputCategoryID');
	categoryID = categoryIDELM.value;
	
	control.getAll();
	controlCato.getAll();
	
	let inputProductCategorySearch = document.getElementById("inputProductCategorySearch");
	inputProductCategorySearch.onchange = function(e) {
		showFromCategoryID(e.target.value);
	};
	
	inputPropertySelect.onchange = function(e) {
		let selectedOpt = e.target.selectedOptions[0];
		let val = e.target.selectedOptions[0].getAttribute("propVal");
		if(selectedOpt !== undefined && selectedOpt !== null) {
			setPropertyDisplayValue(val);
		} else {
			setPropertyDisplayValue(val, true);
		}
	};
	
	let inputProductCategoryElm = document.getElementById("inputProductCategory");
	previousSelectedCato = inputProductCategoryElm.value;
	
	inputProductCategoryElm.onchange = inputProductCategoryChange;
	
	inputProductCategoryElm.onfocus = function(e) {
		previousSelectedCato = e.target.value;
	}
}

function allCallBack(allProducts) {
	findAndSetHiddenProductProperties(allProducts);
	printAllProducts(allProducts);
}

function allCallBackCato(allCategories) {
	addAllCategoriesToSelect("inputProductCategory", allCategories);
	selectCorrectCategorie();
	addAllCategoriesToSelect("inputProductCategorySearch", allCategories);
}

function findAndSetHiddenProductProperties(allProducts) {
	for(let i = 0; i < allProducts.length; i++) {
		if(allProducts[i].id == selectedID) {
			createHiddenElement(allProducts[i], ['inputProduct', 'inputProperty'], 'product-properties');
			i = allProducts.length;
		}
	}
}

function inputProductCategoryChange(e) {
	if(selectedID != "") {
		let continueChange = true;
		if(previousSelectedCato != '') {
			continueChange = confirm("Als je doorgaat worden alle eigenschap waardes veranderd! Weet je zeker dat je wilt doorgaan? ");
		}
		
		if(continueChange) {
			changeProductCategory();
		} else {
			e.target.value = previousSelectedCato;
		}
	}
}

function showFromCategoryID(id) {
	let links = allProductsList.getElementsByTagName("a");
	for(let i = 0; i < links.length; i++) {
		let linkID = links[i].getAttribute("catid");
		if(id == -1) {
			links[i].style.display = "";
		} else if(linkID == id) {
			links[i].style.display = "";
		} else {
			links[i].style.display = "none";
		}
	}
}

function showProperties(properties) {
	let editPropertyButElm = document.getElementById('editPropertyBut');
	editPropertyButElm.classList.add("disabled");
	inputPropertySelect.disabled = true;
	
	removeOptions(inputPropertySelect);
	
	for(let i = 0; i < properties.length; i++) {
		let opt = document.createElement('option');
		opt.value = properties[i].propertyID;
		opt.innerText = properties[i].name;
		if(properties[i].value !== null && properties[i].value !== undefined) {
			opt.setAttribute("propVal", properties[i].value);
		}
		inputPropertySelect.appendChild(opt);
	}
	
	if(inputPropertySelect.selectedOptions[0] !== undefined) {
		setPropertyDisplayValue(inputPropertySelect.selectedOptions[0].getAttribute("propVal"));
		editPropertyButElm.classList.remove("disabled");
		inputPropertySelect.disabled = false;
	} else {
		setPropertyDisplayValue(undefined, true);
	}
}

function removeOptions(selectElm) {
	let options = selectElm.getElementsByTagName('option');
	if(options !== undefined && options !== null) {
		for(let i = 0; i < options.length; i++) {
			let keep = options[i].getAttribute("keep");
			if(keep === undefined || keep === null) {
				options[i].remove();
				
				// Lower index by one because one was removed
				i--;
			}
		}
	}
}

function printAllProducts(allProducts) {
    for (let i = 0; i < allProducts.length; i++)
    {
        var a = document.createElement('a');
        a.innerHTML = allProducts[i]['name'];
		a.setAttribute('idval', allProducts[i]['id']);
		
		if(allProducts[i]['category'] !== null && allProducts[i]['category']['id'] !== null) {
			a.setAttribute('catid', allProducts[i]['category']['id']);
		}
		
        a.classList.add('collection-item');
		if(allProducts[i].id === selectedID) {
			showProperties(allProducts[i].properties);
			a.classList.add('active');
		}
		
        a.addEventListener('click', function(){
            selectProduct(allProducts[i]);
        });

        allProductsList.appendChild(a);
    }
}

function addAllCategoriesToSelect(elementID, allCategories) {
	let selectElm = document.getElementById(elementID);
	for(let i = 0; i < allCategories.length; i++) {
		let opt = document.createElement('option');
		opt.value = allCategories[i].id;
		opt.innerText = allCategories[i].name;
		selectElm.appendChild(opt);
	}
}


function selectCorrectCategorie() {
	let inputProductCategoryElm = document.getElementById('inputProductCategory');
	inputProductCategoryElm.value = categoryID;
	previousSelectedCato = inputProductCategoryElm.value;
}


function selectProduct(product) {
	selectedID = product.id;
	if(product.category != null) {
		categoryID  = product.category.id;
	} else {
		previousSelectedCatos = '';
		categoryID = '';
	}
		selectCorrectCategorie();
	
	
	/* Makes selection visible */
	let productsLinks = allProductsList.getElementsByTagName('a');
	for(let i = 0; i < productsLinks.length; i++) {
		if(productsLinks[i].classList.contains('active')) {
			productsLinks[i].classList.remove('active');
		}
		if(productsLinks[i].getAttribute('idval') == product.id) {
			productsLinks[i].classList.add('active');
		}
	}
	
	if(product['image'] === null || product['image']['filename'] === null) {
		inputProductPhotoNameElement.innerHTML = '';
	} else {
		inputProductPhotoNameElement.innerHTML = product['image']['filename'];
	}
	createHiddenElement(product, 'inputProduct', 'product-properties');
	
	setProductDisplayValues(product.name, product.description, product.price, product.btw);
	showProperties(product['properties']);
}

function setProductDisplayValues(name, desc, price, btw) {
	let nameElm = document.getElementById('inputProductName');
	let descElm = document.getElementById('inputProductDescription');
	let priceElm = document.getElementById('inputProductPrice');
	let btwElm = document.getElementById('inputProductBtw');
	
	(name !== null && name !== undefined) ? nameElm.value = name : nameElm.value = '';
	(desc !== null && desc !== undefined) ? descElm.value = desc : descElm.value = '';
	(price !== null && price !== undefined) ? priceElm.value = price : priceElm.value = '';
	(btw !== null && btw !== undefined) ? btwElm.value = btw : btwElm.value = '';
}
var x;

function setPropertyDisplayValue(val, disable) {
	let propValElm = document.getElementById('inputPropertyValue');
	x = val;
	(val !== null && val !== undefined) ? propValElm.value = val : propValElm.value = '';
	if(disable === true) {
		propValElm.disabled = true;
	} else {
		propValElm.disabled = false;
	}
}

function newProduct() {
	control.post('/admin/addProduct')
}

function editProduct() {
	control.post('/admin/editProduct')
}

function deleteProduct() {
	control.post('/admin/deleteProduct')
}

function changeProductCategory() {
	control.post('/admin/changeProductCategory');
}

function editProperty() {
	controlProp.post('/admin/editPropertyValue');
}

function imageChangeCallback(args = { folder: '', filename: ''}) {
    inputProductPhotoNameElement.innerHTML = args.filename;
	let imageFolderElm = document.getElementById('imageFolder');
	let imageNameElm = document.getElementById('imageName');
	
	imageFolderElm.value = args.folder;
	imageNameElm.value = args.filename;
}

imageSelectorHandler.addCallback('onAcceptImage', imageChangeCallback);
imageSelectorHandler.addCallback('onClearImage', imageChangeCallback);
