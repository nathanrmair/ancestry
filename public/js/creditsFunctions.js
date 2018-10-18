
function init(creditsamount){
    var holder = document.getElementById("credit_holder");
    if(creditsamount==0){
        holder.className = "redholder";
    }
}

function highlight(){

    holder = document.getElementById('credits_dash');
    holder.className = holder.className + ' blueholder';
    holder.style.paddingLeft = '15%';
}

function buy(credits){
    document.getElementById('quantity').value = credits;
    getPrice();
}

function buttonDisableBuy() {
    document.body.style.cursor = "wait";
    document.getElementById("btn-credits").style.cursor = "wait";
    document.getElementById("btn-credits").disabled = true;
    document.getElementById('btn-package-80').removeAttribute("onclick");
    document.getElementById("btn-package-80").style.cursor = "wait";
    document.getElementById('btn-package-30').removeAttribute("onclick");
    document.getElementById("btn-package-30").style.cursor = "wait";
    document.getElementById('btn-package-50').removeAttribute("onclick");
    document.getElementById("btn-package-50").style.cursor = "wait";
    document.getElementById('btn-package-100').removeAttribute("onclick");
    document.getElementById("btn-package-100").style.cursor = "wait";

}

function buttonDisableWithdraw() {
    document.body.style.cursor = "wait";
    document.getElementById("btn-credits").style.cursor = "wait";
    document.getElementById("btn-credits").disabled = true;

}

function getPrice() {
    credits = document.getElementById('quantity').value;
    cost = document.getElementById('cost');
    if(credits<30&&credits>=25){
        cost.innerHTML = '25.00';
        showDeal(30);
    } else if(credits==30) {
        cost.innerHTML = '25.00';
        showPackageMessage();
    } else if(credits<50&&credits>=40){
        cost.innerHTML = '40.00';
        showDeal(50);
    } else if(credits==50) {
        cost.innerHTML = '40.00';
        showPackageMessage();
    } else if(credits<80&&credits>=60){
        cost.innerHTML = '60.00';
        showDeal(80);
    } else if(credits==80) {
        cost.innerHTML = '60.00';
        showPackageMessage();
    }else if(credits<100&&credits>=75){
        cost.innerHTML = '75.00';
        showDeal(100);
    } else if(credits==100) {
        cost.innerHTML = '75.00';
        showPackageMessage();
    } else if(credits==''){
        cost.innerHTML = '0';
    }
    else {
        cost.innerHTML = credits + '.00';
        hideDeal();
    }

}

function showDeal(credits){
    document.getElementById('deal').innerHTML = "Hint: You can buy " + credits + " credits for the same price!";
}

function hideDeal() {
    document.getElementById('deal').innerHTML = '';
}

function showPackageMessage(){
    document.getElementById('deal').innerHTML = 'Great! You chose a package!';
}
