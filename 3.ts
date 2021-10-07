function calculateNotes():void{
    let one: number = parseInt((<HTMLInputElement> document.getElementById("1")).value);
    let two: number = parseInt((<HTMLInputElement> document.getElementById("2")).value);
    let three: number = parseInt((<HTMLInputElement> document.getElementById("3")).value);

    let ps = document.getElementsByTagName("p");
    ps[0].innerHTML = ((one * 2 + two * 3 + three * 5) / 10).toString();
}