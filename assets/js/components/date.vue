<template>
    <div>
        <p>{{ todayDate }}</p>
    </div>
</template>

<script type="application/javascript">
export default {
    data () {
        return{
            todayDate: "",      
        }
    },
    created(){
        setInterval(this.getDate, 1000);
    },
    methods: {
        getDate: function (){
            let today = new Date();

            let day = today.getDate();
            let month = today.getMonth();
            let year = today.getFullYear();
            let hour = today.getHours();
            let minute = today.getMinutes();
            let second = today.getSeconds();


            if(day < 10 && String(day).length == 1){
                day = '0'+day;
            }

            if(month < 10 && String(month).length == 1){
                month = '0'+(month+1);
            }


            if(hour < 10 && String(hour).length == 1){
                hour = '0'+hour;
            }

            if(minute < 10 && String(minute).length == 1){
                minute = '0'+minute;
            }

            if(second < 10 && String(second).length === 1){
                second = '0'+second;
            }

            let date = day+'/'+month+'/'+year;

            let time = hour + ":" + minute + ":" + second;

            this.todayDate = date+'  '+time; 
        }
    }
}
</script>