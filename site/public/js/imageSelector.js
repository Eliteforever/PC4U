// Handy function to check if an element contains a class name
function hasClass(element, className) {
    return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
}

// Handy function to remove children from given node.
// Offset may be used to only delete children after index = offset
function clearChildrenFromNode(node, offset = -1){

    if (offset > 0){
        if (node.childNodes.length > offset){
            let max = node.childNodes.length;
            for (let i = offset; i < max; i++){
                node.removeChild(node.childNodes[offset]);
            }
        }
    } else {
        while (node.firstChild) {
            node.removeChild(node.firstChild);
        }   
    }
}


/*  ImageSelectorHandler takes control of spawning ImageSelectors and linking them with existing form elements 
    It will try to find elements containing class name 'imageSelectorButton' and create an ImageSelector for each */
class ImageSelectorHandler{

    constructor(){
        this.createCallBacks();
        this.createImageSelectors();  
    }

    // Create and store ImageSelectors on every button location with class "imageSelectorButton".
    createImageSelectors(){
        let _this = this;

        // Find where the Image Selector buttons are placed
        this.imageSelectors = [];
        this.buttons = document.getElementsByClassName('imageSelectorButton');

        for (var i = 0; i < this.buttons.length; i++){

            let form = this.getFormElement(this.buttons[i]);

            let imageSelector = new ImageSelector(form);
            imageSelector.addCallback("onAcceptImage", function (args){
                _this.runCallback("onAcceptImage", args, this);
            });

            imageSelector.addCallback("onClearImage", function (args){
                _this.runCallback("onClearImage", args, this);
            });

            this.imageSelectors[i] = imageSelector;
        }
    }

    // Get the nearest form if there is any. Return form element or null.
    getFormElement(target){

        target = target.parentNode;

        while (true){
            if (target.nodeName == "FORM"){
                return target;
            } else if (target.nodeName == "BODY"){
                return null;
            }

            target = target.parentNode;
        }

        return target;
    }

    // Show ImageSelector depending on which button is pressed
    show(button){
        for (var i = 0; i < this.buttons.length; i++){
            if (button == this.buttons[i]){
                this.imageSelectors[i].show();
            }
        }        
    }

    // Create callback list
    createCallBacks(){
        this.callbacks = [];
    }

    // Add callback based on eventType with callback function
    addCallback(eventType, callback){
        if (!this.callbacks.hasOwnProperty(eventType)){
            this.callbacks[eventType] = [];
        }

        this.callbacks[eventType].push(callback);
    }

    // Run callback function with parameters arg & _this (_this is object type 'ImageSelector')
    runCallback(eventType, arg, _this){

        if (this.callbacks[eventType] != null){
            for (let i = 0; i < this.callbacks[eventType].length; i++){
                this.callbacks[eventType][i](arg, _this);
            }
        }
    }
}

/*  ImageSelector itself, the Big Bad Boy (BBB). The window itself with all its glory and power. 
    Use on your own risk! May contain bugs, security risks and other features.

    Mainly this class is self-driven. Configure it, run it, and leave it if you'd want to.
    

    The class requires the following things written in problem / answer method:
    Problem: Error about csrfToken and not being defined.
    Answer: Include {
    <meta id="csrf-token" content="{{ csrf_token() }}">
    } In the <head> or the most upward place in the html file. Just make sure it's above the <script> for imageSelector!

    Problem: The class will use classnames used for css. (Maybe javascript only in the future?)
    Answer: Don't forget to include the css file in the html! {
    <link rel="stylesheet" href="<?php echo asset('css/imageSelector.css')?>" type="text/css">
    }

    Problem: I get 500 Errors when interacting with the window.
    Answer: The problem probably lies on the server side. This error will mostly generate when non-expected data is received from the server.


    Description: 
    Once initialized, a window will spawn when the function show() is called.
    The window consists of 3 main sections: Folder section, image section and menu section.
    For ImageSelectors outside of a form, use the event 'onAcceptImage' to retrieve the selected image. */
class ImageSelector{

    // Create the most basic data. Retrieve some necessary data from the html
    constructor(form = null){
        this.form = form;

        this.csrfToken = document.getElementById("csrf-token").content;

        this.createCallBacks();

        this.main = document.createElement("div");
        this.main.classList.add("imageSelectorContainer");

        this.window = document.createElement("div");
        this.window.classList.add("imageSelector");
        this.window.classList.add("row");

        this.imageInputElement = document.getElementById("fileInput");

        this.selectedImage = null;

        this.imageElements = [];

        // Creates the window element on given element. The <body> tag is preferred.
        this.createWindow(document.getElementsByTagName("BODY")[0]);

        // Cower in the bushes until you hear your name.
        this.hide();
    } 




    /* Main Window { */

    // Create main window elements
    createWindow(targetElement){
        let _this = this;

        // Create some bounding visuals
        this.createBackground();
        this.createBorders();

        // Create the basic window sections.
        this.createFolderSection(_this); // Left panel for folder selection.
        this.createImageSection(_this);  // Main panel where the images will be shown.
        this.createMenuSection();   // Menu section to the right to control the selector.

        this.createControls();

        this.getAllFoldersInDirectory("/");
        this.getAllFilesInDirectory("/");

        this.main.appendChild(this.window);
        targetElement.appendChild(this.main);
    }

    /* Main Window interactions */

    // Create controls
    createControls(){
        let _this = this;

        // Escape key
        document.onkeydown = function(e){
            if (e.keyCode == 27){
              _this.hide();  
            }            
        };
    }

    // interactive functions to control the ImageSelector
    show(elem){
        this.selectImageButtonLocation = elem;

        this.main.style.display = 'block'; 
    }

    hide(){
        this.main.style.display = 'none';
    }

    // Create callback list
    createCallBacks(){
        this.callbacks = [];
    }


    // Add callback on index 'eventType' with callback function
    addCallback(eventType, callback){
        if (!this.callbacks.hasOwnProperty(eventType)){
            this.callbacks[eventType] = [];
        }

        this.callbacks[eventType].push(callback);
    }

    // Run callback function on index 'eventType' with arg as arguments
    runCallback(eventType, arg){
        if (this.callbacks[eventType] != null){
            for (let i = 0; i < this.callbacks[eventType].length; i++){
                this.callbacks[eventType][i](arg);
            }
        }
    }




    /* Extra visuals */
    // Background dim
    createBackground(){
        this.background = {};
        this.background.shadow = {};
        this.background.shadow = document.createElement("div");

        this.background.shadow.classList.add("imageSelectorBackground");  
        this.main.appendChild(this.background.shadow);      
    }

    // Top border
    createBorders(){
        this.border = {};
        this.border.top = {};

        this.border.top = document.createElement("div");
        this.border.top.classList.add("imageSelectorHeader"); 
        this.window.appendChild(this.border.top);       
    }




    /* Menu section */
    // Create menu buttons
    createMenuSection(){

        let _this = this;
        let form = this.form;

        this.menu = document.createElement("div");
        this.menu.classList.add("imageSelectorMenu");

        this.menu.buttons = [];

        this.addMenuButton('closeButton', new ImageSelectorButton(this.createRoundButton("imageSelectorHeaderButton", "close", function(){
            _this.hide();
        })));

        this.addMenuButton('acceptButton', new ImageSelectorButton(this.createRoundButton("imageSelectorHeaderButton", "check",
        function(){

            let args = [];
            args["folder"] = _this.folderSelector.selected.folder;
            args["filename"] = _this.selectedImage;

            _this.runCallback("onAcceptImage", args);

            if (form != null){      
                _this.updateForm();
            }

            _this.hide();
        }), false));

        this.addMenuButton('uploadButton', new ImageSelectorButton(this.createRoundInputButtom("imageSelectorUploadButton", "file_upload")), true);

        this.addMenuButton('deleteImageButton', new ImageSelectorButton(this.createRoundButton("imageSelectorHeaderButton", "delete",
        function(){
            _this.fileDelete();
        }), false));

        this.addMenuButton('unSelectButton', new ImageSelectorButton(this.createRoundButton("imageSelectorHeaderButton", "backspace",
        function(){
            _this.clearSelection();

             _this.runCallback("onClearImage");

            if (form != null){      
                _this.updateForm();
            }

            _this.hide();
        }), false));

        this.window.appendChild(this.menu);       
    }

    // Add menu button to the menu and store it in menu.button
    addMenuButton(name, button){
        this.menu.buttons[name] = button; 
        this.menu.appendChild(button.element);   
    }

    // Create a round materialize styled icon
    createRoundButton(className, icon, onclickCallback){
        var button = document.createElement("div");
        button.innerHTML = '<i class="material-icons">' + icon + '</i>';
        button.classList.add(className);
        button.classList.add("btn-floating");
        button.classList.add("btn-large");
        button.classList.add("waves-effect");
        button.classList.add("waves-light");  

        button.onclick = onclickCallback;

        return button;
    }

    // Create a round materialized styled icon including a file input
    createRoundInputButtom(className, icon){
        let _this = this;

        var buttonContainer = document.createElement("div");
        buttonContainer.classList.add("file-field");
        buttonContainer.classList.add("input-field");

        var button = document.createElement("div");
        var input = document.createElement("input");
        input.type = 'file';
        input.onchange = function(){
            _this.fileSubmit(input);
        };
        this.fileInput = input;

        button.innerHTML = '<i class="material-icons">' + icon + '</i>';
        buttonContainer.classList.add("roundUploadButton");
        buttonContainer.classList.add("roundUploadButtonInput");
        button.classList.add(className);
        button.classList.add("btn-floating");
        button.classList.add("btn-large");

        button.appendChild(input);

        buttonContainer.appendChild(button);

        return buttonContainer;        
    }




    /* Folder section */
    // Create folder selection section
    createFolderSection(_this){

        this.folderSelector = document.createElement("div");
        this.folderSelector.classList.add("imageSelectorFolderHierarchyMenu");
        this.folderSelector.classList.add("col");
        this.folderSelector.classList.add("s4");

        this.folderSelector.collection = document.createElement("ul");
        this.folderSelector.collection.classList.add("folderCollection");
        this.folderSelector.collection.classList.add("collection");
        this.folderSelector.collection.classList.add("with-header");

        this.folderSelector.header = document.createElement("li");
        this.folderSelector.header.classList.add("collection-header");
        this.folderSelector.header.classList.add("imageSelectionHeader");
        this.folderSelector.header.innerHTML = "<h4>Selecteer Map</h4>";    

        this.folderSelector.up = document.createElement("li");
        this.folderSelector.up.classList.add("collection-item");
        this.folderSelector.up.onclick = function() {
            _this.getFolderUp();

            _this.getAllFilesInDirectory(_this.folderSelector.selected['folder']);
            _this.getAllFoldersInDirectory(_this.folderSelector.selected['folder']);


        };
        this.setFolderPath();

        this.folderSelector.collection.appendChild(this.folderSelector.header);
        this.folderSelector.collection.appendChild(this.folderSelector.up); 

        this.folderSelector.selected = {};
        this.folderSelector.selected.folder = "/";

        this.folderSelector.appendChild(this.folderSelector.collection);
        this.window.appendChild(this.folderSelector);
    }

    /* Folder selection interaction */
    // Get path of parent folder of current selected folder
    getFolderUp(){
        if (this.folderSelector.selected != null){
            var path = this.folderSelector.selected['folder'];

            var splitPath = path.split("/");
            var newPath = "/";

            for (let i = 0; i < splitPath.length - 2; i++){
                if (splitPath[i] != ""){
                    newPath += (splitPath[i] + "/");
                }
            }

            this.folderSelector.selected['folder'] = newPath;

            return newPath;
        } else {
            return "/";
        }
    }

    // Output the folder path in the folder section.
    setFolderPath(folder){
        if (folder !== "/"){ // Don't show the arrow when selected folder is root
            this.folderSelector.up.innerHTML = '<div><div class="imageSelectorFolderUp secondary-content"><i class="material-icons">chevron_left</i></div>' + folder + '</div>';
        } else {
            this.folderSelector.up.innerHTML = '<div><div class="imageSelectorFolderUp secondary-content"><i class="material-icons">radio_button_unchecked</i></div>/</div>';
        }
    }

    getAllFoldersInDirectory(folder){
        let _this = this;

        clearChildrenFromNode(this.folderSelector.collection, 2);

        this.setFolderPath(folder);

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var folders = JSON.parse(this.responseText);

                console.log(_this.folderSelector.collection);

                for (var i = 0; i < folders.length; i++){
                    var folderElement = document.createElement("li");
                    folderElement.classList.add("collection-item");
                    folderElement.innerHTML = folders[i]['basename'];
                    folderElement.folderData = folders[i];

                    folderElement.onclick = function() {
                        _this.getAllFilesInDirectory(this.folderData['folder']);
                        _this.getAllFoldersInDirectory(this.folderData['folder']);

                        _this.folderSelector.selected = this.folderData;
                    };

                    _this.folderSelector.collection.appendChild(folderElement);

                }                 
            }
        };

        var requestUrl = "/getAllFoldersInFolder";

        var fd = new FormData();
        fd.append("folder", folder);
        fd.append("_token", this.csrfToken );

        xhttp.open("POST", requestUrl, true);
        xhttp.send(fd);    
    }




    /* Image Selection Section { */
    // Create image section
    createImageSection(_this){
        this.imagesViewer = document.createElement("div");
        this.imagesViewer.classList.add("imageSelectorImageViewer");
        this.imagesViewer.classList.add("col");
        this.imagesViewer.classList.add("s8");
        this.imagesViewer.classList.add("row");
        this.window.appendChild(this.imagesViewer);
    }

    // Refresh the image section, wiping the content and retrieving the images from the server. Maybe add an "reload only this card" function?
    refreshImageSection(){
        this.getAllFilesInDirectory();
    }

    // Get all images from the server and generate cards containing the images.
    // Output these cards on the section split by columns
    getAllFilesInDirectory(folder){
        
        let _this = this;
     
        clearChildrenFromNode(this.imagesViewer); 
        this.imageElements.length = 0;      

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var images = JSON.parse(this.responseText);
              
                let totalColumns = 3;
                let currentColumn = 0;
                let columns = [];

                for (var i = 0; i < totalColumns; i++){
                    var columnElement = document.createElement("div");
                    columnElement.classList.add("col");
                    columnElement.classList.add("l" + 12 / totalColumns);
                    columnElement.classList.add("s12");

                    _this.imagesViewer.appendChild(columnElement);

                    columns[i] = columnElement;
                }

                for (var i = 0; i < images.length; i++){

                    if (currentColumn >= totalColumns){
                        currentColumn = 0;
                    }

                    var cardElement = document.createElement("div");
                    cardElement.classList.add("card");
                    cardElement.cardData = images[i];
                    cardElement.onclick = function() {
                        _this.selectCard(this);
                    }

                    _this.imageElements.push(cardElement);
            
                    var imageCardElement = document.createElement("div");
                    imageCardElement.classList.add("card-image");

                    var cardContent = document.createElement("div");
                    cardContent.classList.add("card-content");
                    cardContent.innerHTML = "<p>" + images[i]['basename'] + "</p><p>" + images[i]['usedCount'] + ' keer gebruikt</p>';

                    var imageElement = document.createElement("img");
                    imageElement.setAttribute('src', images[i]['folder'] + 
                                         images[i]['basename']);

                    imageCardElement.appendChild(imageElement);
                    cardElement.appendChild(imageCardElement);
                    cardElement.appendChild(cardContent);
                    columns[currentColumn].appendChild(cardElement);

                    currentColumn++;
                }                
            }
        };

        var requestUrl = "/getAllImagesInFolder";

        var fd = new FormData();
        fd.append("folder", folder);
        fd.append("_token", this.csrfToken );

        xhttp.open("POST", requestUrl, true);
        xhttp.send(fd);    
    }



    /* Cards { */

    /* Interaction { */
    // Deselect all selected cards
    clearSelection(){
        if (this.selectedCard != null){
            this.selectedCard.classList.remove("cardOnClick"); 
        }

        this.selectedImage = null;      
    }

    // Select card and store image name
    selectCard(card){
        this.clearSelection();
        card.classList.add("cardOnClick");

        this.selectedImage = card.cardData['basename'];

        this.menu.buttons['acceptButton'].enable();
        this.menu.buttons['unSelectButton'].enable();

        if (card.cardData['usedCount'] > 0){
            this.menu.buttons['deleteImageButton'].disable();
        } else {
            this.menu.buttons['deleteImageButton'].enable();
        }

        this.selectedCard = card;
    }

    // Set input of name 'imageSelect' to image path value in this.form
    updateForm(){
        if (this.selectedImage != null){
            let data = {};
                data.folder = this.folderSelector.selected.folder;
                data.filename = this.selectedImage;

            let input = document.createElement("input");
                input.name = "imageSelect";
                input.type = "text";



            let found = false;
            for (var i = 0; i < this.form.children.length; i++) {

                let child = this.form.children[i];

                if (child.name == "imageSelect"){
                    child.setAttribute("value", JSON.stringify(data));
                    found = true;
                    break;
                }
            }         
            
            if (!found){
                input.setAttribute("value", JSON.stringify(data));
                this.form.appendChild(input);             
            }
        } else {
            for (var i = 0; i < this.form.children.length; i++) {

                let child = this.form.children[i];

                if (child.name == "imageSelect"){
                    this.form.removeChild(child);
                    break;
                }
            }  
        }
    }

    // Save the uploaded image to the server
    // Refresh the image section on current selected folder
    fileSubmit(){
        let _this = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                _this.getAllFilesInDirectory(_this.folderSelector.selected.folder);
            }
        };

        var requestUrl = "/imageSubmit";

        var fd = new FormData();
        fd.append("postImage", this.fileInput.files[0]);
        fd.append("_token", this.csrfToken );
        fd.append("folder", this.folderSelector.selected.folder);

        xhttp.open("POST", requestUrl, true);
        xhttp.send(fd);
    }

    // Delete the selected file saved on the server
    // Refresh the image section on current selected folder
    fileDelete(){
        let _this = this;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                _this.getAllFilesInDirectory(_this.folderSelector.selected.folder);
            }
        };

        var requestUrl = "/imageDelete";

        var fd = new FormData();
        fd.append("_token", this.csrfToken );
        fd.append("filename", this.selectedImage);        
        fd.append("folder", this.folderSelector.selected.folder);

        xhttp.open("POST", requestUrl, true);
        xhttp.send(fd);        
    }
}

/*  Image Selector Buttons, used for the right menu of the window.
    Adding on mouse hover effects (adding / removing class "pulse").
    Buttons are elements with materialize design.                 */
class ImageSelectorButton{
    constructor(element, enabled = true){
        this.element = element;
        this.enabled = enabled;

        if (!enabled){
            this.element.classList.add("disabled");
        }

        this.element.onmouseover = function(){
            if (hasClass(this, "roundUploadButtonInput")){
                this.childNodes[0].classList.add("pulse");
            } else {
                this.classList.add("pulse");
            }
        }

        this.element.onmouseleave = function(){
            if (hasClass(this, "roundUploadButtonInput")){
                this.childNodes[0].classList.remove("pulse");
            } else {
                this.classList.remove("pulse");
            }
        }
    }

    // Enable the button by removing the classname 'disabled'
    enable(){
        if (!this.enabled){
            this.element.classList.remove("disabled");
            this.enabled = true;
        }
    }

    // Disable the button by adding the classname 'disabled'
    disable(){
        if (this.enabled){
            this.element.classList.add("disabled");
            this.enabled = false;
        }
    }
}

var imageSelectorHandler = new ImageSelectorHandler();
