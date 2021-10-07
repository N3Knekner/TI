function calculate5():void{
    let years: number = parseInt((<HTMLInputElement> document.getElementById("years")).value);

    let ps = document.getElementsByTagName("p");
    ps[0].innerHTML = (isBiggerThanEighteen(years)).toString();
}

function isBiggerThanEighteen(n:number):boolean{
    return n >= 18;
}
