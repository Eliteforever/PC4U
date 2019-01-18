// Handy function to check if an element contains a class name
function hasClass(element, className) {
    return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
}

// Handy function to remove children from given node.
// Offset may be used to only delete children after index = offset
function clearChildrenFromNode(node, offset = -1){

    if (offset > 0){
        if (node.childNodes.length > offset){
            for (let i = offset; i < node.childNodes.length + 1; i++){
                node.removeChild(node.childNodes[offset]);
            }
        }
    } else {
        while (node.firstChild) {
            node.removeChild(node.firstChild);
        }   
    }
}

function addClassesToNode(node, classList){
    for (let i = 0; i < classList.length; i++){
        node.classList.add(classList[i]);
    }
}

function addClassToNode(node, className){
    node.classList.add(className);
}

function emptyIfNullOrUndefined(str) {
	if(str === undefined || str === null) return '';
	return str;
}