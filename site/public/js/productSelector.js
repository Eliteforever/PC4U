class PropertyValue{
	constructor(value){
		this.datatype = 0;
		this.data = value;	
	}

	setValue(value){
		this.data = value;
	}

	toString(prefix = "", postfix = ""){
		return "" + prefix + this.data + postfix;
	}
}

class PropertyStringValue extends PropertyValue{
	constructor(value){
		super(value);
		this.datatype = 1;
	}
}

class PropertyNumeralRangeValue extends PropertyValue{
	constructor(min = 0, max = 0){
		super({});
		this.data.min = min;
		this.data.max = max;
		this.datatype = 2;
	}

	setValue(min, max){
		this.data.min = min;
		this.data.max = max;
	}

	toString(prefix = "", postfix = ""){
		console.log("yepperdepep: " + prefix);
		return "" + prefix + this.data.min + postfix + " - " + prefix + this.data.max + postfix;
	}
}

class BaseCategory{
	constructor(name){
		this.name = name;
	}
}

class FilterProperty{
	constructor(category, property, value, datatype){
		this.category = category;
		this.property = property;
		this.value = value;
		this.datatype = datatype;
	}
}

class FilterPropertyParameter{
	constructor(categoryName, propertyName, value, datatype){
		this.categoryName = categoryName;
		this.propertyName = propertyName;
		this.value = value;
		this.datatype = datatype;
	}
}

class SortProperty{
	constructor(category, property, orderType){
		this.category = category;
		this.property = property;
		this.orderType = orderType;
	}
}

class SortPropertyParameter{
	constructor(categoryName, propertyName, orderType){
		this.categoryName = categoryName;
		this.propertyName = propertyName;
		this.orderType = orderType;
	}
}

class ProductSelectMenu{
	constructor($baseList, $categoryList, productUpdater){
		let _this = this;

		this.$baseList = $baseList;
		this.$categoryList = $categoryList;

		this.showingInputContainer = false;

		this.propertyButtons = [];

		this.createCallbacks();

		this.productUpdater = productUpdater;
	}

	createCallbacks(){
		this.callbacks = {};
		this.callbacks.categoryCreateEvents = [];
		this.callbacks.propertyCreateEvents = [];
		this.callbacks.filtersChangedEvents = [];
	}

	bindOnCategoryCreate(callback){
		this.callbacks.categoryCreateEvents.push(callback);
	}

	bindOnPropertyCreate(callback){
		this.callbacks.propertyCreateEvents.push(callback);
	}

	bindOnFiltersChanged(callback){
		this.callbacks.filtersChangedEvents.push(callback);
	}

	runCategoryCreateCallbacks(menu, $elem, category){
		for (let i = 0; i < this.callbacks.categoryCreateEvents.length; i++){
			this.callbacks.categoryCreateEvents[i](menu, $elem, category);
		}
	}

	runPropertyCreateCallbacks(menu, $elem, category, property){
		for (let i = 0; i < this.callbacks.propertyCreateEvents.length; i++){
			this.callbacks.propertyCreateEvents[i](menu, $elem, category, property);
		}
	}

	runFiltersChangedCallbacks(filters){
		for (let i = 0; i < this.callbacks.filtersChangedEvents.length; i++){
			this.callbacks.filtersChangedEvents[i](filters);
		}
	}

	createBaseProperties(){	
		var _this = this;

		let baseCategory = new BaseCategory("");

		let prijsProperty = [];
			prijsProperty['datatype'] = 2;
			prijsProperty['min'] = 0;
			prijsProperty['max'] = 5000;
			prijsProperty['name'] = "Prijs";
			prijsProperty['prefix'] = '&euro;';

		let naamDescProperty = [];
			naamDescProperty['datatype'] = 1;
			naamDescProperty['name'] = "Naam";

		this.$baseList.prepend(this.createMenuOption(baseCategory, prijsProperty));
		this.$baseList.prepend(this.createMenuOption(baseCategory, naamDescProperty));
	}

	updateCategories(categories){
		this.$categoryList.empty();

		for (let i = 0; i < categories.length; i++){			
			let category = this.createMenuCategory(categories[i]);			
		}
	}

	createMenuOption(category = null, property = null){
		let _this = this;

		let $nameDiv = $('<div></div>', {
			class: 'menuPropertyDiv',
			text: property['name']
		});

		let $li = $('<li></li>', {
			class: 'collection-item'
		}).append($nameDiv);

		this.runPropertyCreateCallbacks(this, $li, category, property);

		this.propertyButtons[property['name']] = property;

		return $li;
	}

	createMenuCategory(category){
		var _this = this;

		var $nodge = $('<i></i>', {class: 'material-icons bla'}).text('arrow_drop_down');
		let $nameDiv = $('<div></div>', {
			class: 'menuPropertyDiv',
			text: category['name']
		});
		var $header = $('<div></div>', {class: 'collapsible-header'})
			.append($nodge)
			.append($nameDiv)		
		var $li = $('<li></li>').append($header);

		var $propertiesList = $('<ul></ul>', {class: 'collection'});
		var $propertiesBody = $('<div></div>', {class: 'collapsible-body removePadding'}).append($propertiesList);

		$header.click(function(){

			if (this.isOpen == "undefined" || this.isOpen == null){
				this.isOpen = true;
			} else {
				if (this.isOpen == false){
					this.isOpen = true;
				} else {
					this.isOpen = false;
				}
			}	
		});

		this.$categoryList.append($li);

		for (let i = 0; i < category.properties.length; i++){
			$propertiesList.append(this.createMenuOption(category, category.properties[i]));
		}

		console.log($propertiesList);

		$li.append($propertiesBody);

		this.runCategoryCreateCallbacks(this, $header, category);
	}
}

class FilterMenu extends ProductSelectMenu{
	constructor($baseList, $categoryList, productUpdater){
		super($baseList, $categoryList, productUpdater);

		this.usedFilterProperties = [];
		this.usedFilterCategories = [];

		this.registerCallbacks();
		this.createBaseProperties();
	}

	registerCallbacks(){
		let _this = this;

		this.bindOnCategoryCreate(this.onCategoryCreate);
		this.bindOnPropertyCreate(this.onPropertyCreate);
	}

	onCategoryCreate(menu, $elem, category){
		let $add = $('<i></i>', {
			class: 'material-icons menuPropertyButton',
			text:'add_circle'
		});

		$add.click(function(){
			menu.addCategory(category);
			menu.updateUsedFilters();
		});

		$elem.append($add);
	}

	onPropertyCreate(menu, $elem, category, property){
		let $button = $('<i></i>', {
			class: 'material-icons menuPropertyButton',
			text: 'edit'
		});

		$button.click(function(){
			menu.showPropertyValue($(this), category, property);
		});

		$elem.append($button);
	}

	getCategoryByName(categoryName){
		for (let i = 0; i < this.usedFilterCategories.length; i++){
			if (this.usedFilterCategories[i].name == categoryName){
				return this.usedFilterCategories[i];
			}
		}	

		return null;
	}

	addCategory(category){
		for (let i = 0; i < this.usedFilterCategories.length; i++){

			if (this.usedFilterCategories[i].name == category.name){
				return;
			}
		}

		console.log("yep");

		this.usedFilterCategories.push(category);
	}

	removeCategory(category){
		for (let i = 0; i < this.usedFilterCategories.length; i++){

			if (this.usedFilterCategories[i] == category){
				this.usedFilterCategories.splice(i, 1);
				return;
			}
		}
	}

	addPropertyValue(category, property, value, datatype = 1){

		var found = false;

		console.log(category);

		for (let i = 0; i < this.usedFilterProperties.length; i++){

			if (this.usedFilterProperties[i].category['name'] === category['name'] &&
				this.usedFilterProperties[i].property['name'] === property['name']){
				this.usedFilterProperties[i].value = value;
				found = true;
				break;
			}
		}

		if (!found){
			var filterProperty = new FilterProperty(category, property, value, datatype);
			this.usedFilterProperties.push(filterProperty);
		}

		console.log(filterProperty);
	}

	removePropertyValue(category, property){

		for (let i = 0; i < this.usedFilterProperties.length; i++){

			console.log(this.usedFilterProperties[i].category['name'] + ', ' + category['name']);

			if (this.usedFilterProperties[i].category['name'] == category['name'] &&
				this.usedFilterProperties[i].property['name'] == property['name']){
				console.log("FOUND");
				this.usedFilterProperties.splice(i, 1);
			}
		}
	}

	updateUsedFilters(){
		var _this = this;
		var $usedFiltersList = $('#usedFilters').empty();

		for (let i = 0; i < this.usedFilterProperties.length; i++){
			console.log(this.usedFilterProperties[i]);
			let $button = $('<i></i>', {
				class: 'material-icons productFilterButton productsMenuIcon'
			}).text('remove_circle');

			$button.click(function(){
				_this.removePropertyValue(_this.usedFilterProperties[i].category, _this.usedFilterProperties[i].property);
				_this.updateUsedFilters();
			});

			let $usedFilterItem = $('<li></li>', {
				class: 'collection-item',
				text: this.usedFilterProperties[i].property.name + ": " + this.usedFilterProperties[i].value.toString()
			}).append($button);

			$usedFiltersList.append($usedFilterItem);
		}

		for (let i = 0; i < this.usedFilterCategories.length; i++){

			let $button = $('<i></i>', {
				class: 'material-icons productFilterButton productsMenuIcon'
			}).text('remove_circle');

			$button.click(function(){
				_this.removeCategory(_this.usedFilterCategories[i]);
				_this.updateUsedFilters();
			});

			let $usedFilterItem = $('<li></li>', {
				class: 'collection-item',
				text: this.usedFilterCategories[i].name
			}).append($button);

			$usedFiltersList.append($usedFilterItem);
		}

		this.productUpdater.updateProductList();
	}

 	updatePriceRange(priceRange){
 		this.propertyButtons['Prijs']['min'] = priceRange['min'];
		this.propertyButtons['Prijs']['max'] = priceRange['max'];
 	}

	showPropertyValue($menuItem, category, property){
		var _this = this;

		if (this.showingInputContainer){
			$('.menuInputContainer').remove();
		} else {
			this.showingInputContainer = true;
		}

		var $input;

		if (property['datatype'] == 1){ // string
			$input = $('<input></input>', {
				class: 'menuInputField',
				type: 'text',
				placeholder: 'Voer waarde in'
			});
		} else if (property['datatype'] == 2){ // numeral
			$input = $('<div></div>', {
				class: 'menuRangeInputField',
			});

			if (property['prefix'] == null){
				property['prefix'] = "";
			}

			if (property['postfix'] == null){
				property['postfix'] = "";
			}

			console.log(property);

			let pipFormats = [];
				pipFormats[Number(property.min)] = "" + property['prefix'] + property['min'] + property['postfix'];
				pipFormats[Number(property.max)] = "" + property['prefix'] + property['max'] + property['postfix'];

			let $slider = noUiSlider.create($input[0], {
			 	start: [property['min'], property['max']],
			 	connect: true,
			 	step: 1,
			 	orientation: 'horizontal',
			 	tooltips: true,
			 	range: {
			 		'min': Number(property['min']), 
			 		'max': Number(property['max'])
			 	},
			 	format: wNumb({
			 		decimals: 0
			 	}),
			 	pips: { // Show a scale with the slider
					mode: 'range',
					density: 10,
					format: {
						to: function(a){
							console.log(a);
							return pipFormats[a];
						}
					}
				}
			});
		} else if (property['datatype' == 3]){ // checkbox

		}

		var $inputAcceptButton = $('<i></i>', {
			class: 'material-icons',
			text: 'check'});

		$inputAcceptButton.click(function(){
			let value;

			if (property['datatype'] == 1){
				value = new PropertyStringValue($input.val());
			} else if (property['datatype'] == 2){
				let inputValue = $input[0].noUiSlider.get();
				value = new PropertyNumeralRangeValue(inputValue[0], inputValue[1]);
			}

			console.log("category['name'] begins[");
			console.log(category);
			console.log("]category['name'] ends");

			_this.addPropertyValue(category, property, value);
			_this.updateUsedFilters();
			$('.menuInputContainer').remove();
		});

		var $inputDeclineButton = $('<i></i>', {
			class: 'material-icons',
			text: 'close'});

		$inputDeclineButton.click(function(){
			$('.menuInputContainer').remove();
		});

		var $inputControlsDiv = $('<div></div>', {
			class: 'inputControlDiv'})
			.prepend($inputAcceptButton)
			.prepend($inputDeclineButton);

		var $inputDiv = $('<div></div>', {class:'menuInputContainer'})
			.append($input)
			.append($inputControlsDiv);

		$menuItem.parent().append($inputDiv);
	}
}

class SortMenu extends ProductSelectMenu{
	constructor($baseList, $categoryList, productUpdater){
		super($baseList, $categoryList, productUpdater);

		this.registerCallbacks();
		this.createBaseProperties();

		this.usedSort = null; 
	}

	registerCallbacks(){
		this.bindOnCategoryCreate(this.onCategoryCreate);
		this.bindOnPropertyCreate(this.onPropertyCreate);
	}

	onCategoryCreate(menu, $elem, category){
		
	}

	onPropertyCreate(menu, $elem, category, property){
		let $buttonAsc = $('<i></i>', {
			class: 'material-icons menuPropertyButton'
		}).text('keyboard_arrow_up');

		$buttonAsc.click(function(){
			menu.setSortByProperty(category, property);
		});

		let $buttonDesc = $('<i></i>', {
			class: 'material-icons menuPropertyButton'
		}).text('keyboard_arrow_down');

		$buttonDesc.click(function(){
			menu.setSortByProperty(category, property, "DESC");
		});

		$elem.append($buttonDesc);
		$elem.append($buttonAsc);
	}	

	setSortByCategory(category, orderType = "ASC"){
		this.usedSort = new SortProperty(category, property, orderType);
		this.updateCurrentSort();
	}

	setSortByProperty(category, property, orderType = "ASC"){
		this.usedSort = new SortProperty(category, property, orderType);
		this.updateCurrentSort();
	}

	updateCurrentSort(){
		let _this = this;
		console.log(this.usedSort);

		if (this.usedSort != null){
			let orderName = "oplopend";
			if (this.usedSort.orderType == "DESC"){
				orderName = "aflopend";
			}

			$('#usedSorters').empty();
			$('#usedSorters')
				.append($('<div></div>', {
					class: 'menuPropertyDiv',
					text: "Gesorteerd op: " + this.usedSort.property.name + " " + orderName,
				}))
				.append($('<i></i>', {
					class: 'material-icons menuPropertyButton',
					text: 'remove_circle',
					click: function(){
						_this.usedSort = null;
						_this.updateCurrentSort();
					}
				}));

		} else {
			$('#usedSorters').text("Momenteel niks gesorteerd");
		}

		this.productUpdater.updateProductList();
	}
}


class ProductUpdater{
	constructor(){
		this.createCallbacks();

		this.filterMenu = new FilterMenu($('#baseListFilter'), $('#categoryListFilter'), this);
		this.sortMenu = new SortMenu($('#baseListSorter'), $("#categoryListSorter"), this);
		
		let $urlCategory = $('#requestCategory');
		let attr = $urlCategory.attr('content');
		if (typeof attr !== typeof undefined && attr !== false){
			let category = JSON.parse($urlCategory.attr('content'));

			this.filterMenu.addCategory(category);
			this.filterMenu.updateUsedFilters();
		}
	}

	createCallbacks(){
		this.callbacks = {};
		this.callbacks.productsAndCategoriesReceivedEvents = [];
	}

	bindOnProductsAndCategoriesReceived(callback){
		this.callbacks.productsAndCategoriesReceivedEvents.push(callback);
	}

	runProductsAndCategoriesReceivedCallbacks(categories, products, other){
		for (let i = 0; i < this.callbacks.productsAndCategoriesReceivedEvents.length; i++){
			this.callbacks.productsAndCategoriesReceivedEvents[i](categories, products, other);
		}
	}
						
	updateProductList(){
		let _this = this;

		let parameters = {};
			parameters.filters = {};
			parameters.filters.properties = [];
			parameters.filters.categories = [];
			parameters.sort = null;

		for (let i = 0; i < this.filterMenu.usedFilterProperties.length; i++){
			var filterProperty = this.filterMenu.usedFilterProperties[i];

			var filterPropertyParameter = new FilterPropertyParameter(filterProperty.category['name'],
																	  filterProperty.property['name'],
																	  filterProperty.value,
																	  filterProperty.property['datatype']);
			parameters.filters.properties.push(filterPropertyParameter);
		}

		for (let i = 0; i < this.filterMenu.usedFilterCategories.length; i++){
			parameters.filters.categories.push(this.filterMenu.usedFilterCategories[i].name);
		}

		if (this.sortMenu.usedSort != null){
			parameters.sort = new SortPropertyParameter(this.sortMenu.usedSort.category['name'],
														this.sortMenu.usedSort.property['name'],
														this.sortMenu.usedSort.orderType);
		}

		let postHandler = new PostControl("selectedProducts", null, function(productsAndCategories){

			let products = productsAndCategories['products'];
			let categories = productsAndCategories['categories'];
			let other = productsAndCategories['other'];

			_this.runProductsAndCategoriesReceivedCallbacks(categories, products, other);		

			_this.filterMenu.updateCategories(categories);
			_this.filterMenu.updatePriceRange(other['priceRange']);
			_this.sortMenu.updateCategories(categories);
			//filterMenu.updatePriceRange(other['priceRange']);
		});
			
		parameters.filters = JSON.stringify(parameters.filters);
		parameters.sort = JSON.stringify(parameters.sort);
		postHandler.getAll("/selectedProductsWithCategories", parameters);
	}
}