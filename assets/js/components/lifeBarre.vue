<template>
        <div>
            <p>Vie <span>{{ characterInfos.life }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.life < 40, 
                    'barreInfo--medium' : characterInfos.life < 70 
                }"  
                :style="{width: characterInfos.life + '%' }"> 
                </div>
            </div>

            <p>Nourriture <span>{{ characterInfos.food }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.food < 40, 
                    'barreInfo--medium' : characterInfos.food < 70 
                }"  
                :style="{width: characterInfos.food + '%' }"> 
                </div>
            </div>

            <p>Hydratation <span>{{ characterInfos.water }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.water < 40, 
                    'barreInfo--medium' : characterInfos.water < 70 
                }"  
                :style="{width: characterInfos.water + '%' }"> 
                </div>
            </div>

            <p>Endurance Physique <span>{{ characterInfos.shape }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.shape < 40, 
                    'barreInfo--medium' : characterInfos.shape < 70 
                }"  
                :style="{width: characterInfos.shape + '%' }"> 
                </div>
            </div>

            <p>Propreté <span>{{ characterInfos.cleanliness }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.cleanliness < 40, 
                    'barreInfo--medium' : characterInfos.cleanliness < 70 
                }"  
                :style="{width: characterInfos.cleanliness + '%' }"> 
                </div>
            </div>

            <p>Urine <span>{{ characterInfos.urine }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.urine >= 50, 
                    'barreInfo--medium' : characterInfos.urine < 50 
                }"  
                :style="{width: characterInfos.urine + '%' }"> 
                </div>
            </div>

            <p>Selles <span>{{ characterInfos.stools }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.stools >= 50, 
                    'barreInfo--medium' : characterInfos.stools < 50 
                }"  
                :style="{width: characterInfos.stools + '%' }"> 
                </div>
            </div>

            <p>Poubelle <span>{{ characterInfos.waste }} kg</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--danger' : characterInfos.waste > 100, 
                    'barreInfo--hard' : characterInfos.waste >= 50, 
                    'barreInfo--medium' : characterInfos.waste < 50 
                }"  
                :style="{width: characterInfos.waste + '%' }"> 
                </div>
            </div>

            <p>Maladie <span>{{ characterInfos.sickness }} %</span></p>
            <div class="barre">
                <div class="barreInfo" :class="{ 
                    'barreInfo--hard' : characterInfos.sickness >= 50, 
                    'barreInfo--medium' : characterInfos.sickness < 50 
                }"  
                :style="{width: characterInfos.sickness + '%' }"> 
                </div>
            </div>
        </div>
</template>

<script>
import axios from 'axios';

export default {
      data () {
        return{
            characterInfos: "",        
        }
    },
    mounted (){
        let that = this;

        axios
        .post('http://127.0.0.1:8000/api/getCharacter')
        .then(function (response) {
            that.characterInfos =  response.data
        })
        
    },
    methods:{
        updateJauge: function(evt) {
            let that = this;

            axios
            .post('http://127.0.0.1:8000/api/getCharacter')
            .then(function (response) {
                that.characterInfos =  response.data
            })

                setTimeout(function(){ 
                    $('.barre').removeClass('fadeLeft');
                    $('.alertHouse').removeClass('modalClosed');
                }, 700);
            
        }
    },  
}
</script>

<style>

</style>
    
