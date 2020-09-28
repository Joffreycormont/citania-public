<template>
    <section class="main">
        <h2>Filtres</h2>
        <form class="UserFilter" action="">
            <input class="disabled" @keyup.enter="updateWithFilters" type="number" name="id" id="id" placeholder="ID">
            <input @keyup.enter="updateWithFilters" type="email" name="email" id="email" placeholder="Email">
            <input @keyup.enter="updateWithFilters" type="text" name="lastname" id="lastname" placeholder="Nom">
            <input @keyup.enter="updateWithFilters" type="text" name="firstname" id="firstname" placeholder="Prénom">
            <input @keyup.enter="updateWithFilters" type="number" name="age" id="age" placeholder="Age">
            <input @keyup.enter="updateWithFilters" type="text" name="job" id="job" placeholder="Métier">
            <button class="disabled" @click.prevent="updateWithFilters">filtrer</button>
        </form>

        <h2>Liste des utilisateurs :</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Age</th>
                    <th>Argent</th>
                    <th>Diamants</th>
                    <th>Métier</th>
                    <th>Inscription</th>
                    <th>edition</th>
                </tr>
            </thead>
            <tbody v-if="userList.length">
                    <tr @click="focus" v-for="user in pageOfItems" :key="user.id">
                        <td data-label="id"> <span class="id">{{ user.id }}</span></td>
                        <td data-label="email">{{ user.email }}</td>

                        <td data-label="roles" v-if="user.roles['0'] == 'ROLE_SUPERADMIN' "><span class="role dev">Développeur</span></td>
                        <td data-label="roles" v-else-if="user.roles['0'] == 'ROLE_ADMIN' "><span class="role admin">Administrateur</span></td>
                        <td data-label="roles" v-else-if="user.roles['0'] == 'ROLE_MODERATOR' "><span class="role modo">Modérateur</span></td>
                        <td data-label="roles" v-else-if="user.roles['0'] == 'ROLE_USER' "><span class="role user">Utilisateur</span></td>

                        <td data-label="Nom">{{ user.characters.lastname }}</td>
                        <td data-label="Prénom">{{ user.characters.firstname }}</td>
                        <td data-label="Age">{{ user.characters.age }}</td>
                        <td data-label="Argent">{{ user.characters.money }} €</td>
                        <td data-label="diamants">{{ user.characters.diamond }}</td>

                        <td data-label="Métier" v-if="user.characters.job != null">{{ user.characters.job.name }}</td>
                        <td data-label="Metier" v-else>Aucun</td>

                        <td data-label="inscription">{{ user.characters.createdAt | formatDate }}</td>
                        <td>
                            <a v-if="currentUserRole == 'ROLE_SUPERADMIN'" :href="'../../../jeu/mon_profil?_switch_user='+ user.email" title="Me connecter avec cet utilisateur"><img style="width: 25px;" src="../../../public/assets/Images/connectIcon.png" alt="connect user icon"></a>
                            <a v-if="user.roles['0'] == 'ROLE_MODERATOR' || user.roles['0'] == 'ROLE_USER' || currentUserRole == 'ROLE_SUPERADMIN'" class="pencilButton" :href="'utilisateur/'+ user.id" title="Editer l'utilisateur"><img style="width: 25px;" src="../../../public/assets/Images/pencil.png" alt="crayon edition icon"></a>
                        </td>
                    </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <p>Aucun résultat</p>
                </tr>
            </tbody>
        </table>
        <Jw-Pagination :items="userList" @changePage="onChangePage" :labels="customLabels"></Jw-Pagination>
    </section>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import JwPagination from 'jw-vue-pagination';

const userList = [];

export default {
    components: {JwPagination},
    filters: {
        formatDate (value) {
            if(value){
                return moment(String(value)).format('DD/MM/YYYY hh:mm');
            }
        }
    },
    data () {
        return{
            userList,
            customLabels: {
                first: '<<',
                last: '>>',
                previous: '<',
                next: '>'
            },
            pageOfItems: [],
            currentUserRole: '',
            axiosPending: false,       
        }
    },
    created() {

        this.currentUserRole = $('.modalClosed').attr('currentUserRole');

        axios
        .post('http://127.0.0.1:8000/api/getUserList')
        .then((response) => {
            this.userList = response.data.reverse();
        })
    },
    methods:{
        onChangePage(pageOfItems) 
        {
            // update page of items
            this.pageOfItems = pageOfItems;
        },
        focus (evt)
        {
            $(evt.currentTarget).parents('tbody').children('.focus').removeClass('focus');
            $(evt.currentTarget).addClass('focus');
        },
        updateWithFilters (evt)
        {
            let $evt = $(evt.currentTarget);

            let dataFilters = {
                'id': $evt.parents('form').find('#id').val(),
                'email': $evt.parents('form').find('#email').val(),
                'firstname': $evt.parents('form').find('#firstname').val(),
                'lastname': $evt.parents('form').find('#lastname').val(),
                'age': $evt.parents('form').find('#age').val(),
                'job': $evt.parents('form').find('#job').val(),
            };

            if(this.axiosPending == false){
                if(dataFilters.id.length == 0 && dataFilters.email.length == 0 && dataFilters.firstname.length == 0 && dataFilters.lastname.length == 0 
                    && dataFilters.age.length == 0 && dataFilters.job.length == 0){
                        this.axiosPending = true;

                        axios
                        .post('http://127.0.0.1:8000/api/getUserList')
                        .then((response) => {
                            this.axiosPending = false;
                            this.userList = response.data.reverse();
                        })
                    }else{
                        this.axiosPending = true;

                        axios.post('http://127.0.0.1:8000/api/getUserListWithFilters', 
                            dataFilters
                        )
                        .then((response) => {
                            this.axiosPending = false;
                            this.userList = response.data.reverse();
                        })
                    }
            }
        }
    },

}
</script>