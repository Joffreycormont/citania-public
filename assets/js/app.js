import Vue from 'vue/dist/vue.js';
import date from './components/date.vue';
import connectedCount from './components/connectedCount.vue';
import getCharactersForm from './components/getCharactersForm.vue';
import stripebutton from './components/stripebutton.vue';
import lifeBarre from './components/lifeBarre.vue';
import userListAdmin from './components/userListAdmin.vue';
import characterListTown from './components/characterListTown.vue';
import blackjackCasino from './components/blackjackCasino.vue';
import infiniteSlideText from './components/infiniteSlideText.vue';
import axios from 'axios';
import _ from 'lodash'





new Vue ({
    delimiters: ['${', '}'],
    el: '#app',
    components:{ date, connectedCount, getCharactersForm, stripebutton, lifeBarre, userListAdmin, characterListTown, infiniteSlideText, blackjackCasino},
    data: {
        Humor:"",
        relationStatus: "",
        displayed: true,
        visible: false,
        actionMessage: "",
        flashMessage: "",
        currentObjectQuantity: "",
        successEat: true,
        menuModal: false,
        toggleBuyCoins: false,
    },
    created (){

        $('.PhoneMenu').removeClass('modalClosed');

        setTimeout(function(){ 
            setTimeout(function(){ 
                $('.alert').addClass('fadeIn');
            }, 20);
    
            setTimeout(function(){ 
                $('.alert').addClass('fadeLeft');
                }, 5000);
    
            setTimeout(function(){ 
                $('.alert').removeClass('fadeIn');
                }, 5050);
    
                setTimeout(function(){ 
                $('.alert').addClass('modalClosed');
                }, 5500);
        }, 1000);

        axios
        .post('http://127.0.0.1:8000/api/getHumor')
        .then(response => (this.Humor = response.data))

        axios
        .post('http://127.0.0.1:8000/api/getRelationStatus')
        .then(response => (this.relationStatus = response.data))         
        
    },
    mounted (){

    },
    methods:{
        switchMenuModal(evt) {
            this.menuModal = !this.menuModal;
        },
        // Modal d'intéraction
        toggle (evt){
            $(evt.target).parents("div.user").removeAttr('data-aos')
            $(evt.target).parents("div.user").children('.actionModal').removeClass('modalClosed');

            setTimeout(function(){ 
                $(evt.target).parents("div.user").children('.actionModal').addClass('fade');
             }, 100);
        },
        toggleOff (evt){
            $(evt.target).parents("div.user").children('.actionModal').removeClass('fade');
            setTimeout(function(){ 
                $(evt.target).parent().addClass('modalClosed');
            }, 500);

            if($(evt.target).parents("div.user").attr('page') == 'town'){
                setTimeout(function(){ 
                    $(evt.target).parents("div.user").attr('data-aos', 'fade-up')
                }, 600);
            }
        },
        //modal valid new job
        jobToggle(evt){
            $(evt.target).parents("div.askContainer").children('.modalClosed').removeClass('modalClosed');
        },
        jobToggleOff(evt){
            $(evt.target).parents("div.askContainer").children('.validNewJob').addClass('modalClosed');
        },
        openHouseModal (evt){
            $(evt.target).parents('div.house').find('.back--houseModal').addClass('modalClosed');
            $(evt.target).parents('div.modalContainer').children('.modalClosed').removeClass('modalClosed');
            //$(evt.target).parents('div.house').find('.furnitureLink').addClass('disabled');
        },
        closeHouseModal (evt){
            $(evt.target).parents('div.back--houseModal').addClass('modalClosed');
            $(evt.target).parents('div.house').find('.furnitureLink').removeClass('disabled');
        },
        toggleBuyCoin (){
            this.toggleBuyCoins = !this.toggleBuyCoins;
        },
        // actions
        dokisse (evt){

            $(evt.target).addClass('disabled')
            let dataButton = $(evt.currentTarget).attr('userId');
            let kisseActionId = $('.actionContainer li.kisse a').attr('kisseactionId');

            axios
            .post('http://127.0.0.1:8000/api/action/newKisse/for/'+dataButton,
            {
                kisseActionId : kisseActionId
            }
            )
            .then(response => (this.actionMessage = response.data ));

            let that = this

            setTimeout(function(){ 
                $(evt.target).removeClass('disabled')
            }, 2700);

        },
        dopunch (evt){

            $(evt.target).addClass('disabled')
            let dataButton = $(evt.currentTarget).attr('userId');
            let punchActionId = $('.actionContainer li.punch a').attr('punchactionId');

            axios
            .post('http://127.0.0.1:8000/api/action/newPunch/for/'+dataButton,
            {
                punchActionId : punchActionId
            }
            )
            .then(response => (this.actionMessage = response.data ));

            let that = this

            setTimeout(function(){ 
                $(evt.target).removeClass('disabled')
            }, 2700);

        },
        dohug (evt){
           
            $(evt.target).addClass('disabled')
            let dataButton = $(evt.currentTarget).attr('userId');
            let hugActionId = $('.actionContainer li.hug a').attr('hugactionId');
            
            axios
            .post('http://127.0.0.1:8000/api/action/newHug/for/'+dataButton,
            {
                hugActionId : hugActionId
            }
            )
            .then(response => (this.actionMessage = response.data ));

            let that = this

            setTimeout(function(){ 
                $(evt.target).removeClass('disabled')
            }, 2700);

        },
        dopinch (evt){
            
            $(evt.target).addClass('disabled')
            let dataButton = $(evt.currentTarget).attr('userId');
            let pinchActionId = $('.actionContainer li.pinch a').attr('pinchactionId');
            
            axios
            .post('http://127.0.0.1:8000/api/action/newPinch/for/'+dataButton,
            {
                pinchActionId : pinchActionId
            }
            )
            .then(response => (this.actionMessage = response.data ));

            let that = this

            setTimeout(function(){ 
                $(evt.target).removeClass('disabled')
            }, 2700);

        },
        dosmile (evt){
            
            $(evt.target).addClass('disabled')
            let dataButton = $(evt.currentTarget).attr('userId');
            let smileActionId = $('.actionContainer li.smile a').attr('smileactionId');
            
            axios
            .post('http://127.0.0.1:8000/api/action/newSmile/for/'+dataButton,
            {
                smileActionId : smileActionId
            }
            )
            .then(response => (this.actionMessage = response.data ));

            let that = this

            setTimeout(function(){ 
                $(evt.target).removeClass('disabled')
            }, 2700);

        },
        dopulledHair (evt){
            
            $(evt.target).addClass('disabled')
            let dataButton = $(evt.currentTarget).attr('userId');
            let pulledHairActionId = $('.actionContainer li.pulledHair a').attr('pulledHairactionId');
            
            axios
            .post('http://127.0.0.1:8000/api/action/newPulledHair/for/'+dataButton,
            {
                pulledHairActionId : pulledHairActionId
            }
            )
            .then(response => (this.actionMessage = response.data ));

            let that = this

            setTimeout(function(){ 
                $(evt.target).removeClass('disabled')
            }, 2700);


        },
        // section pour humour et situation familliale
        changeHumor (evt) {
            
            let humor = evt.target.value;
            let that = this;

            axios
            .post('http://127.0.0.1:8000/api/changeHumor', 
            {
                newHumor:  humor
            }
            ).then(function (response) {

                axios
                .post('http://127.0.0.1:8000/api/getHumor')
                .then((response) => {
                    that.Humor = response.data;
                })

            })
            .catch(function (error) {
                console.log(error);
            })
            
        },
        changeRelationStatus (evt){

            let relationStatusId = evt.target.value;

            let that = this;

            axios
            .post('http://127.0.0.1:8000/api/changeRelationStatus', 
            {
                newRelationStatus:  relationStatusId
            }
            ).then(function (response) {

                axios
                .post('http://127.0.0.1:8000/api/getRelationStatus')
                .then((response) => {
                    that.relationStatus = response.data;
                })

            })
            .catch(function (error) {
                console.log(error);
            })
        },
        //  Autre
        eat(evt){
            $(evt.target).find('.eatModal').removeClass('modalClosed');
        },
        validEat(evt){

            let quantityToEat = $(evt.currentTarget).parents('div.eatModal').find('.eatQuantity').val();

            console.log(quantityToEat);

            let that = this;
            let productId = $(evt.target).parents('div.characterObjects').data('product');

            $(evt.target).parents('div.modalContainer').find('.characterObjects').addClass('disabled')

            let quantity = parseInt($(evt.currentTarget).parents('div.characterObjects').find('.quantity').html());

            this.flashMessage = that.flashMessage;

            if(quantityToEat > quantity){
                that.flashMessage = "Tu n'a pas assez de produits pour en utiliser autant";
                that.successEat = false;
            }else{
                axios
                .post('http://127.0.0.1:8000/api/house/eat/'+productId+'/'+quantityToEat)
                .then(function (response) {
                    that.flashMessage = response.data
                    that.successEat = true;
                    if(that.flashMessage.length > 300){
                        that.flashMessage = "Vous êtes déconnectez, rafraichissez la page !";
                    }
                })
                .catch(function (error) {
                    that.flashMessage = "Vous êtes déconnectez, rafraichissez la page !"
                })

                that.currentObjectQuantity = parseInt($(evt.currentTarget).parents('div.characterObjects').find('.quantity').html()) - quantityToEat;
                $(evt.target).parents('div.characterObjects').find('.quantity').html(that.currentObjectQuantity)
            }

            $(evt.target).parents('div.characterObjects').find('.browser-screen-loading-content').removeClass('modalClosed');


            $('.alertHouse').addClass('modalClosed');
            $(evt.target).parents('div.eatModal').addClass('modalClosed');

            setTimeout(function(){ 

                that.$refs.lifebarre.updateJauge();
                
                setTimeout(function(){ 
                    $('.alertHouse').removeClass('fadeLeft');
                    $('.alertHouse').removeClass('modalClosed');
                }, 700);

                setTimeout(function(){ 
                    $('.alertHouse').addClass('fadeIn');
                }, 800);
        
                setTimeout(function(){ 
                    $('.alertHouse').addClass('fadeLeft');
                }, 2500);
        
                setTimeout(function(){ 
                    $('.alertHouse').removeClass('fadeIn');
                    $(evt.target).parents('div.modalContainer').find('.characterObjects').removeClass('disabled')
                    $(evt.target).parents('div.characterObjects').find('.browser-screen-loading-content').addClass('modalClosed');

                    if(that.currentObjectQuantity < 1 && that.successEat == true){
                        $(evt.target).parents('div.characterObjects').addClass('modalClosed');
                    }
                }, 2650);
            }, 1500);

        },
        closeEatReponseModal(evt){
            $(evt.target).parents('div.eatModal').addClass('modalClosed');
        },
        closeFlashMessage(){
            this.displayed = false; 
        },
        closeFlashAction(){
            this.actionMessage = ""
        },
        stopProfilMusic(evt){
            $(evt.currentTarget).parent().remove();
            $('#musicProfil').remove();
        }
    }

});



