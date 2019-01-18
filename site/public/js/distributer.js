class Distributer{
	constructor(){
		this.columns = [];
	}

	addColumn(column, target){
		this.columns.push(column);
		target.append(column);
	}

	distribute(items){

		let itemCount = 0;
		let keepGoing = true;

		while (keepGoing){
			for (let i = 0; i < this.columns.length; i++){
				if (itemCount < items.length){
//					items[itemCount].style.visibility = "visible";
					this.columns[i].append(items[itemCount]);
					itemCount++;
				} else {
					keepGoing = false;
					break;
				}
			}
		}
	}

	debug(){
		console.log(this.columns);
	}

	clearColumns(){
		for (let i = 0; i < this.columns.length; i++){
			this.columns[i].empty();
		}
	}
}