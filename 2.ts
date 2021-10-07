function calculatePay():void{
    let payment: number = parseInt((<HTMLInputElement> document.getElementById("payment")).value);
    let per: number = parseInt((<HTMLInputElement> document.getElementById("per")).value);

    if(!payment || !per){return;}

    let ps = document.getElementsByTagName("p");
    ps[0].innerHTML = (payment * (per/100 + 1)).toString();
}