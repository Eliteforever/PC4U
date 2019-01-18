class PostControl {
	constructor(requestUrl, inputClass, getAllCallback) {
		this.requestUrl = requestUrl;
		this.inputClass = inputClass;
		this.getAllCallback = getAllCallback;
	}
	
	
	post (path, method) {
		method = method || "post"; // Set method to post by default if not specified.

		// The rest of this code assumes you are not using a library.
		// It can be made less wordy if you use one.
		let form = document.createElement("form");
		form.setAttribute("method", method);
		form.setAttribute("action", path);

		let params = {};
		let input = document.getElementsByClassName(this.inputClass);
		for(let i = 0; i < input.length; i++) {
			if(input[i].classList.contains("inputJSON")) {
				if(input[i].getAttribute('name') !== null) {
					params[input[i].getAttribute('name')] = JSON.parse(input[i].value);
				} else {
					let parsed = JSON.parse(input[i].value);
					for(var key in parsed) {
						params[key] = parsed[key];
					}
				}
			} else {
				params[input[i].getAttribute('name')] = input[i].value;
			}
		}
		
		for(var key in params) {
			if(params.hasOwnProperty(key)) {
				let hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);

				form.appendChild(hiddenField);
			}
		}

		document.body.appendChild(form);
		form.submit();
	}
	
	getAll (requestUrl, parameters, isGet) {
		let getAllCallback;
		if(requestUrl === undefined || requestUrl === null) {
			requestUrl = this.requestUrl;
		}
		if(typeof this.getAllCallback === 'function') {
			getAllCallback = this.getAllCallback;
		}
		
		if(isGet === undefined || isGet === null) {
			isGet = false;
		}
		
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				let jsonOut = JSON.parse(this.response);
				
				if(typeof getAllCallback === 'function') {
					getAllCallback(jsonOut);
				}
			}
		};
	
		if(!isGet) {
			let csrfToken = document.getElementById("csrf-token").content;
			var fd = new FormData();
			fd.append("_token", csrfToken );
			if (parameters != null){
				for (var key in parameters){
					fd.append(key, parameters[key]);
					console.log(parameters[key]);
				}
			}

			xhttp.open("POST", requestUrl, true);
			xhttp.send(fd);
		} else {
			xhttp.open("GET", requestUrl);
			xhttp.send();
		}
	}
	
	setRequestUrl (str) {
		this.requestUrl = str;
		return this;
	}
	
	setInputClass (str) {
		this.inputClass = str;
		return this;
	}
	
	setGetAllCallback (func) {
		this.getAllCallback = func;
		return this;
	}
}

function createHiddenElement(obj, className, id, name) {
	let elm;
	
	if(id !== undefined) {
		elm = document.getElementById(id);
		if(elm === null) {
			elm = document.createElement("input");
			elm.id = id;
		}
	} else {
		elm = document.createElement("input");
	}
	elm.type = "hidden";
	
	if(name !== undefined) {
		elm.name = name;
	}
	
	if(typeof obj === 'object') {
		elm.value = JSON.stringify(obj);
		elm.classList.add("inputJSON");
	} else {
		elm.value = obj;
	}
	
	if(typeof className === 'object') {
		for(let i = 0; i < className.length; i++) {
			elm.classList.add(className[i]);
		}
	} else {
		elm.classList.add(className);
	}
	document.head.append(elm);
}