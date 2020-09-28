<template>
    <div class="characterListTemplate">
        <h4 class="filterTitle">Filtrer ma recherche :</h4>
        <div class="filter">
            <form @submit.prevent="updateCharacterList" action="">
                <div>
                    <label for="characterName">Rechercher un joueur :</label>
                    <input type="text" name="characterName" id="characterName">
                </div>
                <div>
                    <label for="filter">Par filtre :</label>
                    <select name="filter" id="filter">
                        <option value="">--Sans filtre--</option>
                        <option value="coDESC">Connexion plus ancienne</option>
                        <option value="coASC">Connexion plus récente</option>
                        <option value="ageASC">Du plus jeune au plus vieux</option>
                        <option value="ageDESC">Du plus vieux au plus jeune</option>
                        <option value="nameASC">Prénom A-Z</option>
                        <option value="nameDESC">Prénom Z-A</option>
                        <option value="jobASC">Métier A-Z</option>
                        <option value="jobDESC">Métier Z-A</option>
                    </select>
                </div>

                <div>
                    <label for="job">Par métier :</label>
                    <select name="job" id="job">
                        <option value="">--Sans filtre--</option>
                        <option v-for="job in jobList" :key="job.id" :value="job.name">{{ job.name }}</option>
                    </select>
                </div>
                <button>Recherche</button>
            </form>
        </div>
        
        <div class="userContainer">
            <p v-if="pageOfItems.length == 0"> Aucun résultat pour cette recherche </p>
            <div v-for="character in pageOfItems" class="user" :key="character.id" data-aos="fade-up">
                <ul class="userList">

                    <div class="topCard">
                        <div class="left">
                            <div class="progressBar">
                                <div class="progressBar--full">
                                </div>
                            </div>
                            <p><strong>Level : 1/100</strong></p>
                            <p class="subLines">Novice</p>                        
                        </div>

                        <div class="right">
                            <h3><a class="profilLink" :href="`../jeu/profil/${character.id}/visite`">{{ character.firstname }} {{ character.lastname }}</a></h3>
                            <p><strong>{{ character.age }} ans</strong></p>
                            <p>{{ character.visitor }} visites</p>
                            <p class="subLines" v-if ="character.humor != null">{{ character.humor.name }}</p>
                            <p class="subLines" v-else>Sans humeur</p>
                        </div>
                    </div>

                    <div class="userjob">
                        <p class="userjob" v-if="character.job != null">
                            <img class="jobsLogo" :src="`../assets/Images/jobs/${ character.job.slug }.jpg`" alt="image métier">
                            <a class="link jobsLink" :href="`../jeu/boulot/visite/${character.id}`">{{ character.job.name }}</a>
                        </p>

                        <p v-else>
                            <img class="jobsLogo" style="width: 60px;" :src="`../assets/Images/jobs/default.jpg`" alt="image métier">
                            <span>Sans métier</span>
                        </p>

                    </div>

                    <div class="userfooter">
                        <p>Connexion :<strong> {{ character.user.isConnected | formatDate }}</strong></p>
                        <a @click.prevent="toggleTown" class="actionButton" href="">Actions</a>
                    </div>
                </ul>


            
                <div class="actionModal modalClosed">
                    <img @click="toggleOffTown" class="closeModal" :src="`../assets/Images/fermer.png`" alt="croix fermer">
                    <h2> Intéractions avec {{ character.firstname }} {{ character.lastname }}</h2>
                    <div class="actionContainer">
                        <h3>Actions sociales</h3>
                            
                        <div v-if="actionMessage != ''">
                            <div class="alertAction" :class="actionMessage[0]">
                                {{actionMessage[1]}}
                                <i class="closeAction" v-if="actionMessage != ''" @click="closeFlashAction">X</i>
                            </div>
                        </div>

                        <ul>
                            <li v-for="action in actionList" :key="action.id" :class="`${action.name}`">
                                <a ref="actionButton" @click.prevent="handle_function_call($event, action.name)" :class="`actionLink ${action.name}`" :userId="`${character.id}`" :actionId="`${action.id}`">
                                    <img :src="`../assets/Images/${action.name}.png`" :alt="`image ${action.name}`">
                                </a>
                            </li>                         
                        </ul>

                        <h3>Autres actions</h3>
                        <ul>
                            <li class="sendMessage">
                                <a :href="`http://127.0.0.1:8000/jeu/messagerie/discussion/with/${character.id}`" class="actionLink sendMessage"><img :src="`../assets/Images/emailIconLogin.jpg`" width="50px" alt="image message"></a>
                            </li>                  
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <Jw-Pagination :items="characterListTown" @changePage="onChangePage" :labels="customLabels"></Jw-Pagination>
    </div>
</template>

<script>

import axios from 'axios';
import moment from 'moment';
import JwPagination from 'jw-vue-pagination';

const characterListTown = [];

export default {
    components: {JwPagination},
    filters: {
        formatDate (value) {
            if(value){
                moment.locale('en');
                return moment.unix(value, ["h:mm A"]).format('HH [h] mm');
            }
        }
    },
    data () {
        return{
            characterListTown,
            actionList: "",
            jobList: "",
            actionMessage: "",
            customLabels: {
                first: '<<',
                last: '>>',
                previous: '<',
                next: '>'
            },
            pageOfItems: [],
        }
    },
    created (){

         axios
            .get('http://127.0.0.1:8000/api/getActionList')
            .then ((response) => {
                let that = this;
                that.actionList = response.data;
            } )

         axios
            .get('http://127.0.0.1:8000/api/getJobList')
            .then ((response) => {
                let that = this;
                that.jobList = response.data;
            } )

        axios
            .get('http://127.0.0.1:8000/api/getCharacterListTown')
            .then ((response) => {
                let that = this;
                that.characterListTown = response.data;
            } )
    },
    methods:{
        updateCharacterList (evt){
            let $evt = $(evt.currentTarget);

            let dataFilters = {
                'characterName': $evt.find('#characterName').val(),
                'filter': $evt.find('#filter').val(),
                'jobName': $evt.find('#job').val(),
            };

            axios
                .post('http://127.0.0.1:8000/api/update/characterListTown',
                    dataFilters
                )
                .then ((response) => {
                    let that = this;
                    that.characterListTown = response.data;
            } )
        },
        onChangePage(pageOfItems) 
        {
            // update page of items
            this.pageOfItems = pageOfItems;
        },
        closeFlashMessage(){
            this.displayed = false; 
        },
        closeFlashAction(){
            this.actionMessage = ""
        },
        handle_function_call(evt, function_name) {

            let functionName = "do"+function_name;
            this[functionName](evt);
        },
        // Modal d'intéraction
        toggleTown (evt){

            $(evt.currentTarget).parents('div.userContainer').find('.actionModal').removeClass('fade');
            setTimeout(function(){ 
                $(evt.currentTarget).parents('div.userContainer').find('.actionModal').addClass('modalClosed')
             }, 500);
            

            $(evt.target).parents("div.user").removeAttr('data-aos')
            $(evt.target).parents("div.user").find('actionButton').addClass('disabled')

            $(evt.target).parents("div.user").children('.actionModal').removeClass('modalClosed');

            setTimeout(function(){ 
                $(evt.target).parents("div.user").children('.actionModal').addClass('fade');
             }, 100);
        },
        toggleOffTown (evt){
            $(evt.target).parents("div.user").children('.actionModal').removeClass('fade');

            setTimeout(function(){ 
                $(evt.target).parents('div.actionModal').addClass('modalClosed');
            }, 500);

        },
        dokisse (evt){
            $(evt.target).addClass('disabled')
            let dataButton = $(evt.currentTarget).attr('userId');
            let kisseActionId = $('.actionContainer li.kisse a').attr('actionId');

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
            let punchActionId = $('.actionContainer li.punch a').attr('actionId');

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
            let hugActionId = $('.actionContainer li.hug a').attr('actionId');
            
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
            let pinchActionId = $('.actionContainer li.pinch a').attr('actionId');
            
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
            let smileActionId = $('.actionContainer li.smile a').attr('actionId');
            
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
            let pulledHairActionId = $('.actionContainer li.pulledHair a').attr('actionId');
            
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

    }
}
</script>