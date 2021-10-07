function calculate6():void{
    let years1: number = parseInt((<HTMLInputElement> document.getElementById("years1")).value);
    let years2: number = parseInt((<HTMLInputElement> document.getElementById("years2")).value);

    let ps = document.getElementsByTagName("p");
    ps[0].innerHTML = isBigger(years1,years2) ? "1 é maior ou igual a 2" : "2 é maior que 1";
}

function isBigger(n:number,n2:number):boolean{
    return n >= n2;
}