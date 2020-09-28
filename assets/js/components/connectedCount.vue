
<template>
    <span>
        {{ connectedCount }}
    </span>
</template>

<script>
import axios from 'axios';

export default {
    data () {
        return{
            connectedCount: "",
        }
    },
    created (){
        axios
            .get('http://127.0.0.1:8000/api/connectedCount')
            .then(response => {
                this.connectedCount = response.data
                if( !Number.isInteger(response.data) ){
                    this.connectedCount = 0
                }
            } )
    },
    methods:{
        getCount: function() {
            axios
            .get('http://127.0.0.1:8000/api/connectedCount')
            .then(response => {
                this.connectedCount = response.data
                if( !Number.isInteger(response.data) ){
                    this.connectedCount = 0
                }
            } )
        }

    }
}
</script>