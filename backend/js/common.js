function calculateBet(amount) {
        var currentBet = parseInt(document.getElementById("bet-amount").innerHTML.replace("$", ""));
        var newBet = currentBet + parseInt(amount);
        document.getElementById("bet-amount").innerHTML = '$' + newBet;
    }