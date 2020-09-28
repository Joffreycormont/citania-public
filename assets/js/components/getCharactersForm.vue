
<template>
    <div>
        <label for="character">Rechercher un joueur</label>
        <input class="searchAxiosInput" @keyup="searchCharacters" type="text" name="character" id="character">
        <div class="characterList">
            <ul v-for="character in charactersList" :key="character.id">
                <li>
                   <a :href="'http://127.0.0.1:8000/jeu/messagerie/discussion/with/'+character.id">{{ character.firstname }} {{ character.lastname }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data () {
        return{
            charactersList: "",
        }
    },
    methods:{
        searchCharacters: function(evt) {
            axios
            .post('http://127.0.0.1:8000/api/searchCharacters',
            {
                character: evt.target.value
            }
            )
            .then(response => (this.charactersList = response.data))
        }
    },

}
</script>