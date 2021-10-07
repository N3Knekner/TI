function calculate7():void{
    let n: number = parseInt((<HTMLInputElement> document.getElementById("n")).value);

    let ps = document.getElementsByTagName("p");
    ps[0].innerHTML = (!isNegative(n)).toString();
}

function isNegative(n:number):boolean{
    return n < 0;
}
