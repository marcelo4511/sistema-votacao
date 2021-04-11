<template>
  <div>
     <div>
      <md-toolbar :md-elevation="1">
        <span class="md-title"><i class="fa fa-comments"></i> {{form.title}}</span>
      </md-toolbar>

      <md-list>
        <div class="md-layout-item md-layout md-gutter option">
          <div class="md-layout-item">
            <h4><i class="fa fa-arrow-right"></i> {{form.option1}}</h4>
          </div>
           <form class="md-layout-item md-size-15">
            <md-button class="md-raised md-black " @click.prevent="total1"><i class="fa fa-check-square"></i>Votar</md-button>
          </form>
          <div class="md-layout-item md-size-50">
            <h4>{{form.totaloption1}}</h4>
          </div>
        </div>

        <div class="md-layout-item md-layout md-gutter option">
          <div class="md-layout-item">
            <h4><i class="fa fa-arrow-right"></i> {{form.option2}}</h4>
          </div>
           <div class="md-layout-item md-size-15">
            <md-button class="md-raised md-black" @click="total2"><i class="fa fa-check-square"></i>Votar</md-button>
          </div>
          <div class="md-layout-item md-size-50">
            <h4>{{form.totaloption2}}</h4>
          </div>
        </div>

        <div class="md-layout-item md-layout md-gutter option">
          <div class="md-layout-item">
            <h4><i class="fa fa-arrow-right"></i> {{form.option3}}</h4>
          </div>
           <div class="md-layout-item md-size-15">
            <md-button class="md-raised md-black" @click="total3"><i class="fa fa-check-square"></i>Votar</md-button>
          </div>
          <div class="md-layout-item md-size-50">
            <h4>{{form.totaloption3}}</h4>
          </div>
        </div>
      </md-list>
    </div>
  </div>
</template>

<script>
import Api from '../../config/api'
export default {
  created(){
    this.getSurvey()
    this.getVote()
  },
  data(){
    return {
      form:{},
    }
  },
  methods:{
     getSurvey(){
        setInterval(function () {
          Api().get(`/survey/${this.$route.params.form}`).then(res => {
            this.form = res.data
          })
      }.bind(this),5000)
    },
    getVote(){
      Api().get(`/survey/${this.$route.params.form}`).then(res => {
        this.form = res.data
      })
    },
    total1(){
        Api().post(`surveytotal1/${this.$route.params.form}`,{
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
      Api().post(`surveytotal2/${this.$route.params.form}`,{
        totaloption1:this.form.totaloption2,
      })
      .then(res => {
        this.form = res.data.totaloption2
        this.$toasted.global.voteSuccess()
        return this.getSurvey()
      })
    },
    total3(){
      Api().post(`surveytotal3/${this.$route.params.form}`,{
        totaloption1:this.totaloption3,
      })
      .then(res => {
        this.form = res.data.totaloption3
        this.$toasted.global.voteSuccess()
        return this.getSurvey()
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