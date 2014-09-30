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
            bomb_total += ran;
            this.squares[i][j] = new Board_Unit(ran); //initialize a new Board_unit in each part of the board array, with 0-1 random bomb
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
            if(i+1 < this.MaxR && j+1 < this.MaxC){
                this.squares[i][j].populateNeighbor( this.squares[i+1][j+1] );//Bottom right
            }
            if(i+1 < this.MaxR) this.squares[i][j].populateNeighbor( this.squares[i+1][j] );//Bottom
            if(j-1 > 0 && i+1 < this.MaxR) this.squares[i][j].populateNeighbor( this.squares[i+1][j-1] );//Bottom left
            if( i > 0 && j-1 > 0 && i < this.MaxR && j-1 < this.MaxC) this.squares[i][j].populateNeighbor( this.squares[i][j-1] );//left

            if( i-1 > 0 && j-1 > 0) this.squares[i][j].populateNeighbor( this.squares[i-1][j-1] );//up left
            if( i-1 > 0) this.squares[i][j].populateNeighbor( this.squares[i-1][j] );//up
            if( i-1 > 0 && j+1 < this.MaxC) this.squares[i][j].populateNeighbor( this.squares[i-1][j+1] );//up right
            if( j+1 < this.MaxC) this.squares[i][j].populateNeighbor( this.squares[i][j+1] );//right
        }
    }

}


////////////////////////////////
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
    var score = 0;
    var rows = this.getElementById('rows').value;
    var cols = this.getElementById('cols').value;
    var diff = this.getElementById('diff').value;
    var setup = function(){
        score = 0;
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
                if (e.shiftKey) {
                    $(this).addClass("marked");
                    var r = $(this).attr("data-row");
                    var c = $(this).attr("data-col");
                    $(this).text("M");
                }
                else if( ! $(this).hasClass("marked")){
                    $(this).addClass("clicked"); 
                    var r = $(this).attr("data-row");
                    var c = $(this).attr("data-col");
                    if(board.squares[r][c].isMine){
                        $(this).text("X");
                        $(this).addClass("bomb");
                        alert("You have lost!");
                        window.location.reload();
                    }
                    else if(board.squares[r][c].bombLoc == 0){
                        score +=1;
                        $(".score").text(score);
                        $(this).text(board.squares[r][c].bombLoc);
                        //traverseZeros(board.squares, r, c, rows, cols);   
                    }
                    else{
                        score +=1;
                        $(".score").text(score);
                        $(this).text(board.squares[r][c].bombLoc);
                    }
                }
            });
            //controller
            board = new Board();
            board.setup(rows,cols, diff); //tell the model to build
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
//This funct blew up recursion in jscript. Not sure why but I am tired and the deadline is almost here. So everything will be less pretty.
//
//
//function traverseZeros(squares, r, c, rows, cols){
//    var thissquare = squares[r][c];
//    //check self for Zero status
//    if(thissquare.bombLoc == 0){
//        for(var i=r; i<rows; i++){
//            for(var j=c; j<cols; j++){
//                //check all those around it for either, zero, or non-zero
//                if(squares[i][j].bombLoc == 0){
//                    $("[data-row='" + i + "'] , [data-col='" + j + "']").trigger("click");//we are zero, so clear it as if it was clicked
//                    //traverseZeros(squares, i, j, rows, cols);//go on
//                }
//                else{
//                    $("[data-row='" + i + "'] , [data-col='" + j + "']").trigger("click");
//                }
//            }
//        }
//    }
//}
////

