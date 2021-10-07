function calculateVolume():void{
    let radio: number = parseInt((<HTMLInputElement> document.getElementById("radio")).value);

    let ps = document.getElementsByTagName("p");
    ps[0].innerHTML = ((4 * Math.PI * (radio*radio*radio))/3).toString();
}
