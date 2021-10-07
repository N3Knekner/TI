function calculate():void{
    let total: number = parseInt((<HTMLInputElement> document.getElementById("total")).value);
    let white: number = parseInt((<HTMLInputElement> document.getElementById("white")).value);
    let Null: number = parseInt((<HTMLInputElement> document.getElementById("null")).value);
    let valid: number = parseInt((<HTMLInputElement> document.getElementById("valid")).value);

    //if(!total || !white || !Null || !valid){return;} Anti bug que buggou porque 0 tambem é false kk

    let ps = document.getElementsByTagName("p");
    ps[0].innerHTML = (white * 100 / total).toString();
    ps[1].innerHTML = (Null * 100 / total).toString();
    ps[2].innerHTML = (valid * 100 / total).toString();
}