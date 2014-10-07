//
//Jesse Osiecki 
//a2.js
//all of my jquery for a minesweeper game
//
//
//
//
//Model

//
//debug vars
var bomb_total=0;
var bombs_marked=0;
var score = 0;
//
var Board = function(){
}
/*
 * run setup to make a random board of r,c initialized randomly
 *
 * MUST RUN THIS BEFORE USING A BOARD
 */
Board.prototype.setup = function(r,c, difficulty){
    bomb_total = 0;
    this.diff = ( (difficulty < 0 || difficulty > 100) ? -0.5 : (100-difficulty) * .01 * -1); //Make sure that the diff is bounded
    console.debug("difficuly " + 1 + this.diff + " to " + 0 + this.diff);
    this.MaxR = r;
    this.MaxC = c;
    this.squares = [];
    for(var i=0; i < this.MaxR; i++){
        this.squares[i] = new Array();
        for(var j=0; j< this.MaxC; j++){
            var ran = Math.ceil(Math.random() + this.diff); //diff is a float where 0 <= diff < 1
            window.bomb_total += ran;
            var JQOBJECT = $(document).find("[data-row='" + i + "'][data-col='" + j + "']");
            JQOBJECT.val( i+j);
            this.squares[i][j] = new Board_Unit(ran, JQOBJECT); //initialize a new Board_unit in each part of the board array, with 0-1 random bomb
        }
    }
    console.debug("Bombs: " + bomb_total);
    //make the board_units aware of each other
    this.__populateAll(); 
    this.__checkAll();
}

/*
 *
 * insert()
 * inserts a new board_unit at the correct location in the array in Board.
 */
Board.prototype.insert = function(bunit, r, c){
   this.squares[r][c] = bunit;
}
/* 
 *
 * checkAll()
 * runs bomb check on all elements
 */
Board.prototype.__checkAll = function(){
    for(var i=0; i< this.MaxR; i++){
        for(var j=0; j<this.MaxC; j++){
            this.squares[i][j].checkNeighbors();
        }
    }
}
/*
 *
 * run populateNeighbor on all units
 * for the 8 around a spot on the board
 */
Board.prototype.__populateAll = function(){
    for(var i=0; i< this.MaxR; i++){
        for(var j=0; j<this.MaxC; j++){
            //assign neighbors
            console.debug("__populateAll i=" + i + "j=" + j);
            if(i+1 < this.MaxR && j+1 < this.MaxC){
                var neighbor = this.squares[i+1][j+1];
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i+1 + "j=" + j+1);
                console.debug("        isbomb =" + neighbor.isMine);
            }
            if(i+1 < this.MaxR){
                var neighbor = this.squares[i+1][j] ;
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i+1 + "j=" + j);
                console.debug("        isbomb =" + neighbor.isMine);
            }
            if(j-1 >= 0 && i+1 < this.MaxR){
                var neighbor = this.squares[i+1][j-1] ;
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i+1 + "j=" + j+"-1");
                console.debug("        isbomb =" + neighbor.isMine);
            }
            if( i >= 0 && j-1 >= 0 && i < this.MaxR && j-1 < this.MaxC){
                var neighbor = this.squares[i][j-1] ;
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i + "j=" + j+"-1");
                console.debug("        isbomb =" + neighbor.isMine);
            }
            if( i-1 >= 0 && j-1 >= 0){
                var neighbor = this.squares[i-1][j-1] ;
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i+"-1" + "j=" + j+"-1");
                console.debug("        isbomb =" + neighbor.isMine);
            }
            if( i-1 >= 0){
                var neighbor = this.squares[i-1][j] ;
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i+"-1" + "j=" + j);
                console.debug("        isbomb =" + neighbor.isMine);
            }
            if( i-1 >= 0 && j+1 < this.MaxC){
                var neighbor = this.squares[i-1][j+1] ;
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i+"-1" + "j=" + j+1);
                console.debug("        isbomb =" + neighbor.isMine);
            }
            if( j+1 < this.MaxC){
                var neighbor = this.squares[i][j+1] ;
                this.squares[i][j].populateNeighbor(neighbor); 
                console.debug("    populateNeighbor i=" + i + "j=" + j+1);
                console.debug("        isbomb =" + neighbor.isMine);
            }
        }
    }

}


////////////////////////////////
var Board_Unit = function(isMine, JQOBJECT){
    this.isMine = isMine;
    this.bombLoc = 0;
    this.adjacent_array = [];
    this.JQOBJECT = JQOBJECT;
    this.hasbeenclicked = 0;
    this.hasbeenmarked = 0;
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
        return 0;
    }
    return 1;
}

/*
 * checkNeighbors()
 *
 * do any of the neighbors have a mine? Return the value of how many are nearby
 * sets the value of this.bombloc appropriately
 * will also return the value (we store it to save runtime);
 */
Board_Unit.prototype.checkNeighbors = function(){
    this.bombLoc = 0;
    for(var i=0; i < this.adjacent_array.length; i++){
        if(this.adjacent_array[i].isMine > 0) this.bombLoc++;
    }
    return this.bombLoc;
}

//Initialize the model
var board = new Board();
/////////////////////////////////////////
//
///View
$(document).ready(function () {
    //INIT
    var rows = this.getElementById('rows').value;
    var cols = this.getElementById('cols').value;
    var bsize = rows * cols;
    var diff = this.getElementById('diff').value;
    var setup = function(){
        window.score = 0;
        rows = document.getElementById('rows').value;
        cols = document.getElementById('cols').value;
        diff = document.getElementById('diff').value;
        if(rows >= 8 && cols >= 8 && rows <=30 && cols <= 40){
            //reset the board
            var element = document.getElementById("board");
            var parentnode = element.parentNode;
            var newgrid = document.createElement("table");
            newgrid.setAttribute("id", "board");
            newgrid.setAttribute("class", "board");
            parentnode.replaceChild(newgrid, element);
            drawboard(rows, cols);
            $("td").click(function(e) {                

                $(".bombsleft").text(window.bomb_total - window.bombs_marked);
                console.debug("bombs: " + window.bomb_total + "-" + window.bombs_marked);
                var r = $(this).attr("data-row");
                var c = $(this).attr("data-col");
                if (e.shiftKey) {
                    if( ! $(this).hasClass("marked") ){
                        board.squares[r][c].hasbeenmarked = 1;
                        $(this).addClass("marked");
                        $(this).text("M");
                        bombs_marked +=1;
                    }
                    else{
                        board.squares[r][c].hasbeenmarked = 0;
                        $(this).removeClass("marked");
                        $(this).text("");
                        bombs_marked -=1;
                    }
                }
                else if( ! $(this).hasClass("marked") && ! $(this).hasClass("clicked") ){
                    $(this).addClass("clicked"); 
                    board.squares[r][c].hasbeenclicked = 1;
                    if(board.squares[r][c].isMine){
                        $(this).text("X");
                        $(this).addClass("bomb");
                        alert("You have lost!");
                        window.location.reload();
                    }
                    else if(board.squares[r][c].bombLoc == 0){
                        window.score +=1;
                        $(".score").text(window.score);
                        traverseZeros(board.squares[r][c]); //just pass the correct board_unit   
                    }
                    else{
                        window.score +=1;
                        $(".score").text(window.score);
                        $(this).text(board.squares[r][c].bombLoc);
                    }
                }
                else if( $(this).hasClass("clicked") && ($(this).text() != "") ){
                    traverseQuickClick(board.squares[r][c]);// click on squares adjacent to marked
                }
                //HAVE WE WON?
                if(window.score == (bsize - window.bomb_total)){
                    //we won
                    alert("YOU WIN");
                    window.location.reload();
                }
            });
            //controller
            board = new Board();
            board.setup(rows,cols, diff); //tell the model to build
            $(".bombsleft").text(window.bomb_total - window.bombs_marked);
            console.debug("bombs: " + window.bomb_total + "-" + window.bombs_marked);
        }
        else{
            alert("Knock that shit off");
        }
    }
    //Do it!
    setup();
    //EVENTS
    $(".inputs").bind("change", setup);

    //reset
    $("#reset").bind("click", function(){
        window.location.reload();
    });
});

function drawboard(r, c){
    var board = document.getElementById("board");

    $(".bombsleft").text(window.bomb_total - window.bombs_marked);
    console.debug("bombs: " + window.bomb_total + "-" + window.bombs_marked);
    $(".score").text(window.score);
    for(var i = 0; i<r; i++){
        var tr = board.appendChild(document.createElement('tr'));

        for(var j = 0; j<c; j++){
            var tel = document.createElement('td');            
            tel.setAttribute("data-row", i);
            tel.setAttribute("data-col", j);
            var cell = board.appendChild(tel);
        }
    }
}
//
//
function traverseQuickClick(thissquare){
    //check self for Zero status
    if(thissquare.bombLoc != 0){
        var numJQmarked = 0;
        for(var i=0; i<thissquare.adjacent_array.length; i++){
            if(thissquare.adjacent_array[i].hasbeenmarked > 0){
                numJQmarked += 1;// we need to make sure that the # marked == bombLoc
            }
        }
        if( numJQmarked == thissquare.bombLoc) { //if num marked == num bombs nearby then we can continue
            for(var i=0; i<thissquare.adjacent_array.length; i++){
                if(thissquare.adjacent_array[i].hasbeenclicked == 0 && thissquare.adjacent_array[i].hasbeenmarked == 0){
                    thissquare.adjacent_array[i].JQOBJECT.trigger("click");
                }
            }
        }
    }
}
function traverseZeros(thissquare){
    //check self for Zero status
    if(thissquare.bombLoc == 0){
        for(var i=0; i<thissquare.adjacent_array.length; i++){
            if(thissquare.adjacent_array[i].hasbeenclicked == 0){
                //check all those around it for either, zero, or non-zero
                if(thissquare.adjacent_array[i].bombLoc == 0){
                    thissquare.adjacent_array[i].JQOBJECT.trigger("click");//we are zero, so clear it as if it was clicked
                    traverseZeros(thissquare.adjacent_array[i]);
                }
                else{
                ///there is no case of an adjacent bomb
                    thissquare.adjacent_array[i].JQOBJECT.trigger("click");//we are not a bomb, so clear it as if it was clicked
                }
            }
        }
    }
}
//

