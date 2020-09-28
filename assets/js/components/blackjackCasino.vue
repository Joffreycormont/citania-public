<template>
    <div class="back back--blackjack">
        <h2 class="title">Blackjack</h2>
        <div class="backgroundContainer">
            <div class="deckContainer">
                <div class="bankHandContainer" v-if="roundStarted">
                    <p>Main de la banque | total : <span v-if="bankCardsTotalValue == 0">caché</span> <span v-else>{{ bankCardsTotalValue }}</span></p>
                    <div class="cardContainer">
                        <div class="revealedCard" v-if="isRevealed">
                        </div>
                        <div class="hideCard">
                        </div>
                    </div>
                </div>
                <div class="playerHandContainer" v-if="roundStarted">
                    <p>Votre main</p>
                    <div class="cardContainer">

                    </div>
                </div>
            </div>
            <img class="tableBackground" src="../../../public/assets/Images/casino/backgroundBlackjack.png" alt="fond table blackjack">
            <button v-if ="!gameStarted" @click="startGame">Commencer une partie</button>
        </div>
        

        <div class="errors">
            <transition name="fadeUp" mode="out-in">
                <div :key="statusMessage" v-if="statusMessage != ''">
                    <p v-html="statusMessage"></p>
                </div>
            </transition>
        </div>
        

        <transition name="fadeUp">
            <div v-if="gameStarted" class="buttons">
                <form action="">
                    <p class="coins"><strong>Mise en jeu </strong>: {{ currentBet }} <span><i class="fas fa-coins"></i></span></p>
                    <div class="bet">
                        <p class="coins"> <strong>Mes jetons </strong>: {{ character.casinoCoins }} <span><i class="fas fa-coins"></i></span> </p>
                        <label  v-if="roundStarted == false" for="">Montant du pari</label>
                        <input  v-if="roundStarted == false" class="betvalue" type="number" min="0" required>
                        <button  v-if="roundStarted == false" @click.prevent="startRound">Parier <i class="fas fa-coins"></i></button>
                    </div>
                    <button class="newCard" @click.prevent="getCard('player')">Nouvelle carte</button>
                    <button class="stay" @click.prevent="stay">Rester</button>
                    <button class="doubleDown" @click.prevent="doubleDown">Doubler le pari</button>
                </form>
            </div>
        </transition>
    </div>
</template>

<script>

    import axios from 'axios';

    function Shuffle(o) {

	for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
        return o;
    };

    export default {
        data () {
            return{
                statusMessage: "",
                character: "",
                gameStarted: false,
                roundStarted: false,
                ranks : ['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'],
                suits : ['clubs', 'diamonds', 'hearts', 'spades'],
                cards: [],
                decks: 6,
                playerHand : [],
                bankHand: [],
                entity: "",
                isRevealed: true,
                bankCardsTotalValue: 0,
                playerCardsTotalValue: 0,
                deadCardsAmount: 30,
                currentBet: 0,
            }
        },
        created (){
            let that = this;

            axios
            .post('http://127.0.0.1:8000/api/getCharacter')
            .then(function (response) {
                that.character =  response.data
            })
        },
        methods:{
            createCards (){

                for (let i = 0; i < this.decks; i++) {

                    for(let index in this.suits){

                        let currentRank = this.ranks;

                        for( let rankIndex in currentRank){

                            let cardValue = "";
                            // ici je détermine la valeur de la carte
                            if(!Number.isInteger(this.ranks[rankIndex])){

                                if(this.ranks[rankIndex] == 'J' || this.ranks[rankIndex] == 'Q' || this.ranks[rankIndex] == 'K'){
                                    cardValue = 10;
                                }else if (this.ranks[rankIndex] == 'A'){
                                    cardValue = [1,11];
                                }

                            } else {
                                cardValue = this.ranks[rankIndex];
                            }         

                            this.cards.push(
                                {
                                    "cardValue": cardValue,
                                    "suit": this.suits[index],
                                    "rank": this.ranks[rankIndex]
                                }
                            );

                        }
                    }
                }
                Shuffle(this.cards);
            },
            startGame (){
                //  On rajoute une partie dans la bbd pour le joueur
                this.gameStarted = !this.gameStarted;
                axios
                .post('http://127.0.0.1:8000/api/casino/addCasinoGamePlayed')
                .then(function (response) {})

                this.createCards();
                // Je brûle 5 cartes avant le début du jeu
                this.cards.splice(0, 5)

                this.statusMessage = "Faite votre pari !";
            },
            async startRound (evt){              
                // On lance le round dès que le pari est validé
                if(await this.bet(evt, 'starting') == true){
                    this.roundStarted = true;

                    if(await this.checkIfRoundStarted()){

                        // premier service des deux cartes pour la banque et le joueur
                        /*   
                        - Le joueur peut à partir de ce moment choisir d'effectuer une des actions qui lui sont proposés entre (stay, double down, hit(getCard)
                        - Suivant le résultat des actions faites par le joueur, soit il gagne et double sa mise, soit il perd.
                        */
                        for (let loopindex = 0; loopindex < 2; loopindex++) {
                            this.newCardTemplate("player");
                            this.newCardTemplate("bank");
                        }

                        this.countTotalCard('player');

                        if(this.playerCardsTotalValue == 21) {
                            this.statusMessage = "BlackJack ! Vous gagnez 1.5 fois votre mise";
                            this.gains(this.currentBet, true)
                            this.resetRound();
                        }

                        if(this.playerCardsTotalValue > 21) {
                            this.resetRound()
                        }
                    }
                }
            },
            countTotalCard (entity){

                if(entity == "player"){

                    if(this.playerCardsTotalValue == 0){
                        for (let currentCard of this.playerHand) {
                            //appel fonction verif AS
                            currentCard.cardValue = this.askValueAce(currentCard, entity);
                            this.playerCardsTotalValue = this.playerCardsTotalValue + parseFloat(currentCard.cardValue);
                        }

                    }else{
                        if(this.playerHand[this.playerHand.length - 1].rank == "A"){
                            let askValue = this.askValueAce(this.playerHand[this.playerHand.length - 1], entity);

                            this.playerCardsTotalValue = this.playerCardsTotalValue + parseFloat(askValue);
                        }else{
                            this.playerCardsTotalValue = this.playerCardsTotalValue + parseFloat(this.playerHand[this.playerHand.length - 1].cardValue);
                        }
                    }

                    this.statusMessage = "Total de vos cartes : "+this.playerCardsTotalValue;
                }else{

                    if(this.bankCardsTotalValue == 0){
                        for (let currentCard of this.bankHand) {
                            //appel fonction verif AS
                            currentCard.cardValue = this.askValueAce(currentCard, entity);
                            this.bankCardsTotalValue = this.bankCardsTotalValue + parseFloat(currentCard.cardValue);
                        }

                    }else{
                        if(this.bankHand[this.bankHand.length - 1].rank == "A"){
                            let askValue = this.askValueAce(this.bankHand[this.bankHand.length - 1], entity);

                            this.bankCardsTotalValue = this.bankCardsTotalValue + parseFloat(askValue);
                        }else{
                            this.bankCardsTotalValue = this.bankCardsTotalValue + parseFloat(this.bankHand[this.bankHand.length - 1].cardValue);
                        }
                    }
                }
            },
            newCardTemplate (entity){
                let card = this.cards.shift();
                if(entity == "player"){
                    this.playerHand.push(card);
                }else{
                    this.bankHand.push(card);
                }

                this.insertNewCardImage(card.suit, card.cardValue, card.rank, entity)
                
            },
            askValueAce (currentCard, entity){                
                if (entity == "player") {
                    if(!Number.isInteger(currentCard.cardValue)){
                        // cas carte AS - ouvrir une modale pour que le joueur choississe la valeur de la carte entre 1 et 11
                        let askValueAce = prompt('Tu as un AS, choisi la valeur de la carte entre 1 ou 11')

                        while (askValueAce != 1 && askValueAce != 11) {
                            askValueAce = prompt('Tu as un AS, choisi la valeur de la carte entre 1 ou 11');
                        }
                        return askValueAce;

                    } else {
                        return currentCard.cardValue;
                    }
                }else{
                    if(!Number.isInteger(currentCard.cardValue)){
                        return 11;
                    }else {
                        return currentCard.cardValue;
                    }
                }
            },
            insertNewCardImage (suit, value, rank, entity){

                if (entity == "player") {

                    let playerHandContainer = document.querySelector(".playerHandContainer div");
                    let img = document.createElement('img');
                    img.src = "../../assets/Images/casino/cards/"+suit+"/"+suit+rank+".png";
                    playerHandContainer.appendChild(img);

                }else{

                    if(this.bankHand[1] == undefined){

                        let hideCardContainer = document.querySelector(".bankHandContainer div.hideCard");
                        let img = document.createElement('img');
                        img.src = "../../assets/Images/casino/cards/hideSideCard.png";
                        hideCardContainer.appendChild(img); 


                        let revealedCardContainer = document.querySelector(".bankHandContainer div.revealedCard");
                        let imgBis = document.createElement('img');
                        imgBis.src = "../../assets/Images/casino/cards/"+suit+"/"+suit+rank+".png";
                        revealedCardContainer.appendChild(imgBis); 

                        revealedCardContainer.classList.add('hidden');
                        setTimeout(function(){ 
                            this.isRevealed = false;
                        }, 1500);
                        
                    }else{

                        let bankHandContainer = document.querySelector(".bankHandContainer div.cardContainer");
                        let img = document.createElement('img');
                        img.src = "../../assets/Images/casino/cards/"+suit+"/"+suit+rank+".png";
                        bankHandContainer.appendChild(img);   
                    }


                }      
            },
            checkIfRoundStarted () {
                if(this.roundStarted != false){
                    return true;
                }else{
                    this.statusMessage = "Vous devez valider votre pari avant"; 
                    return false;
                }
            },
            checkAllCardsAmount (){
                if(this.cards.length < this.deadCardsAmount){
                    this.resetRound();
                    this.statusMessage = "C'est la fin de cette partie, le paquet de carte est epuisé, la mise est remboursée, vous pouvez en relancer une nouvelle";
                    // pour le remboursement, même méthode que pour les gains
                    this.gains(this.currentBet);
                    this.gameStarted = false;
                    return true;
                }else{
                    return false;
                }
            },
            bet (evt, mode){
 
                if (mode == "starting") {
                    // On vérifie si il y'a valeur valide pour le pari
                    let betValue =  evt.target.parentNode.children[2].value;
                    if(this.character.casinoCoins - parseFloat(betValue) >= 0){

                        if(betValue < 2){
                            // message d'erreur
                            this.statusMessage = "Vous devez parier un minimum de 2 jetons";
                            return false;
                        }else{
                            this.currentBet = betValue;
                            // On modifie le compte des jetons du joueur
                            this.character.casinoCoins = this.character.casinoCoins - betValue;
                            this.statusMessage = "Pari pris en compte, partie en cours";

                            axios
                            .post('http://127.0.0.1:8000/api/casino/betCasino', {
                                betValue: betValue,
                            })
                            .then(function (response) {
                            })
                        }
                    }else{
                        this.statusMessage = "Tu n'as pas assez d'argent pour ce pari !";
                        return false;
                    }
                    return true;   

                }else{

                    if(this.character.casinoCoins - parseFloat(this.currentBet) < 0){
                        return false
                    }else{
                        // dans le cadre du double down
                        this.character.casinoCoins = this.character.casinoCoins - this.currentBet;
                        
                        axios
                        .post('http://127.0.0.1:8000/api/casino/betCasino', {
                            betValue: this.currentBet,
                        })
                        .then(function (response) {
                        })

                        this.currentBet = parseFloat(this.currentBet * 2);
                        return true;
                    }
                }

            },
            async doubleDown (){

                let that = this;

                if( await this.checkIfRoundStarted()){
                    // Double la mise globale du joueur en échange d'une seule carte supplémentaire aux deux initiales
                    if(await this.bet(null, "doubleDown") == true){
                        this.getCard("player");
                        setTimeout(function(){ 
                            that.stay();
                        }, 1500);
                    }else{
                        this.statusMessage = "Tu n'as pas assez d'argent pour doubler ton pari !";
                        setTimeout(function(){ 
                            that.statusMessage = "Total de vos cartes : "+that.playerCardsTotalValue;
                        }, 2000);
                    }

                }                
            },
            async stay (){
                if(await this.checkIfRoundStarted()){

                    /* Le joueur ne demande pas de carte supplémentaire donc la banque tire des cartes jusqu'a soit dépasser 21, soit égaler 21, soit égaler ou battre le joueur
                    En cas d'égalité, le joueur récupère la moitiè de sa mise.
                    En cas de bankrupt le joueur gagne deux fois la mise, en cas de résultat inférieur à la banque,il perd tous.
                    */
                   // on dévoile la carte caché de la banque et on compte le total des cartes
                    this.isRevealed = true;
                    setTimeout(function(){ 
                        document.querySelector('.revealedCard').classList.remove('hidden');
                        document.querySelector('.hideCard').classList.add('hidden');
                    }, 1000);
                    this.countTotalCard('bank');

                    let gains = this.currentBet * 2;

                    while (this.bankCardsTotalValue < 17) {
                        this.getCard('bank');
                    }

                    if (this.bankCardsTotalValue == 21 && this.bankCardsTotalValue > this.playerCardsTotalValue) {
                        this.statusMessage = "Score de la banque : "+this.bankCardsTotalValue+"<br> Ton score : "+this.playerCardsTotalValue+"<br>La banque à fait un meilleur score, tu perds cette manche";
                        this.resetRound(); 
                    }
                    if(this.bankCardsTotalValue > this.playerCardsTotalValue && this.bankCardsTotalValue < 21){
                        this.statusMessage = "Score de la banque : "+this.bankCardsTotalValue+"<br> Ton score : "+this.playerCardsTotalValue+"<br>La banque à fait un meilleur score, tu perds cette manche";
                        this.resetRound(); 
                    } else if (this.bankCardsTotalValue < this.playerCardsTotalValue){
                        // victoire du joueur, la banque saute
                        this.statusMessage = "Score de la banque : "+this.bankCardsTotalValue+"<br> Ton score : "+this.playerCardsTotalValue+"<br>Tu as gagné cette manche pour un total de "+gains+" jetons <i class='fas fa-coins'></i>";
                        this.gains(gains, false)
                        this.resetRound(); 
                    } else if (this.bankCardsTotalValue > 21){
                        this.statusMessage = "Score de la banque : "+this.bankCardsTotalValue+"<br> Ton score : "+this.playerCardsTotalValue+"<br>La banque saute ! Tu gagnes cette manche pour un total de "+gains+" jetons <i class='fas fa-coins'></i>";
                        this.gains(gains, false)
                        this.resetRound(); 
                    } else if (this.bankCardsTotalValue == this.playerCardsTotalValue) {
                        this.statusMessage = "Score de la banque : "+this.bankCardsTotalValue+"<br> Ton score : "+this.playerCardsTotalValue+"<br>Egalité avec la banque, tu récupères ta mise de base";
                        this.gains(this.currentBet, false)
                        this.resetRound(); 
                    }
 
                }
            },
            getCard (entity){
                /* Le joueur demande une nouvelle carte à la banque*/
                if(this.checkIfRoundStarted()){
                    if(!this.checkAllCardsAmount()){
                        if(entity == 'player'){
                            // on vérifie si le montant après la nouvelle carte ne dépasse pas les 21
                            // si ça dépasse, le joueur perd et on réinitialise pour le prochain round
                                this.newCardTemplate('player');
                                this.countTotalCard('player');                    
                                if(this.playerCardsTotalValue > 21){
                                    this.statusMessage = "oups... tu dépasses 21 avec un score de "+this.playerCardsTotalValue+", tu perds cette manche";
                                    this.resetRound();
                                } 
                        }else{
                            this.newCardTemplate('bank');
                            this.countTotalCard('bank'); 
                        }
                    }
                }
            },
            gains (amount, isBlackJack) {
                if(this.checkIfRoundStarted()){

                    axios
                    .post('http://127.0.0.1:8000/api/casino/blackjack/gains/'+isBlackJack,
                    { 
                        gainAmount: amount 
                    })
                    .then(function (response) {
                    })

                    if (isBlackJack == true) {
                        this.character.casinoCoins = parseFloat(this.character.casinoCoins) +  (parseFloat(amount) + parseFloat(amount * 1.5));
                    } else {
                        this.character.casinoCoins = parseFloat(this.character.casinoCoins) + parseFloat(amount); 
                    }
                }
            },
            async resetRound () {   
                if(await this.checkIfRoundStarted()){
                    let clearPlayerContainer = document.querySelector('.playerHandContainer .cardContainer');
                    clearPlayerContainer.innerHTML = "";

                    let clearBankContainer = document.querySelector('.bankHandContainer .cardContainer');
                    clearBankContainer.innerHTML = "";

                    let restoreHideDiv = document.createElement('div.hideCard');
                    let restoreRevealedDiv = document.createElement('div.revealedCard');

                    clearBankContainer.appendChild(restoreHideDiv);
                    clearBankContainer.appendChild(restoreRevealedDiv);

                    this.currentBet = 0;
                    this.playerCardsTotalValue = 0;
                    this.bankCardsTotalValue = 0;
                    this.playerHand = [];
                    this.bankHand = [];
                    this.roundStarted = false;
                }
            }
        }
    }

</script>