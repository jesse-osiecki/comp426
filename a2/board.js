i
var Board_Unit = function(isMine){
    this.isMine = isMine;
    this.bombLoc = 0;
    this.adjacent_array = [];
}

/*
 * populateNeighbor()
 *
 * takes another Board_Unit as an arg, to add to a list of nodes nearby.
 * Should be done by board_setup
 *
 * return 1 on success, return 0 if full
 */
Board_Unit.prototype.populateNeighbor = function(neighbor) {
    if(this.adjacent_array.length < 8){
        this.adjacent_array.push(neighbor);
        return 1;
    }a
    return 0;
}

/*
 * checkNeighbors()
 *
 * do any of the neighbors have a mine? Return the value of how many are nearby
 * sets the value of this.bombloc appropriately
 * will also return the value (we store it to save runtime);
 */
Board_Unit.prototype.__checkNeighbors = function(element, index, array){
    if(element.isMine){
        this.bombLoc +=1;
    }
}
Board_Unit.prototype.checkNeighbors = function(){
    this.bombLoc = 0;
    this.adjacent_array.forEach(__checkNeighbors);
    return this.bombLoc;
}


