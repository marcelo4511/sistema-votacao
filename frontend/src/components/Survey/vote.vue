<template>
  <div>
     <div>
      <md-toolbar :md-elevation="1">
        <span class="md-title"><i class="fa fa-comments"></i> {{form.title}}</span>
      </md-toolbar>

      <md-list>
        <md-item class="md-layout-item md-layout md-gutter option">
          <div class="md-layout-item">
            <h4><i class="fa fa-arrow-right"></i> {{form.option1}}</h4>
          </div>
           <form class="md-layout-item md-size-15">
            <md-button class="md-raised md-black " @click.prevent="total1"><i class="fa fa-check-square"></i>Votar</md-button>
          </form>
          <div class="md-layout-item md-size-50">
            <h4>{{form.totaloption1}}</h4>
          </div>
        </md-item>

        <md-item class="md-layout-item md-layout md-gutter option">
          <div class="md-layout-item">
            <h4><i class="fa fa-arrow-right"></i> {{form.option2}}</h4>
          </div>
           <div class="md-layout-item md-size-15">
            <md-button class="md-raised md-black" @click="total2"><i class="fa fa-check-square"></i>Votar</md-button>
          </div>
          <div class="md-layout-item md-size-50">
            <h4>{{form.totaloption2}}</h4>
          </div>
        </md-item>

        <md-item class="md-layout-item md-layout md-gutter option">
          <div class="md-layout-item">
            <h4><i class="fa fa-arrow-right"></i> {{form.option3}}</h4>
          </div>
           <div class="md-layout-item md-size-15">
            <md-button class="md-raised md-black" @click="total3"><i class="fa fa-check-square"></i>Votar</md-button>
          </div>
          <div class="md-layout-item md-size-50">
            <h4>{{form.totaloption3}}</h4>
          </div>
        </md-item>
      </md-list>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  created(){
    this.getSurvey()
  },
  data(){
    return {
      form:{},
    }
  },
  methods:{
     getSurvey(){
       axios.get(`http://localhost:8000/api/survey/${this.$route.params.form}`)
      .then(res => {
        this.form = res.data
        console.log(res.data)
      })
    },
    total1(){
      axios.post(`http://localhost:8000/api/surveytotal1/${this.$route.params.form}`,{
        totaloption1:this.form.totaloption1,
      })
      .then(res => {
        this.form = res.data.totaloption1 + 1
        this.$toasted.global.voteSuccess()
        this.form={}
        return this.getSurvey()
      })
    },
    total2(){
      axios.post(`http://localhost:8000/api/surveytotal2/${this.$route.params.form}`,{
        totaloption1:this.form.totaloption2,
      })
      .then(res => {
        
        this.form = res.data.totaloption2
        this.$toasted.global.voteSuccess()
        this.getSurvey()
      })
    },
    total3(){
      axios.post(`http://localhost:8000/api/surveytotal3/${this.$route.params.form}`,{
        totaloption1:this.totaloption3,
      })
      .then(res => {
        
        this.form = res.data.totaloption3
        this.$toasted.global.voteSuccess()
        this.getSurvey()
      })
    },
  }
}
</script>

<style>
  .option{
    display: flex;
    align-items: center;
    justify-content: flex-start;
    cursor:grab;
  }
</style>